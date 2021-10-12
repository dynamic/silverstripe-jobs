<?php

namespace Dynamic\Jobs\Element;

use DNADesign\Elemental\Models\BaseElement;
use Dynamic\Jobs\Model\JobCategory;
use Dynamic\Jobs\Page\Job;
use Dynamic\Jobs\Page\JobCollection;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\FieldType\DBDatetime;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\ORM\FieldType\DBHTMLText;

if (!class_exists(BaseElement::class)) {
    return;
}

/**
 * Class ElementJobListings
 * @package Dynamic\Jobs\Element
 *
 * @property int $Limit
 * @property string $Content
 *
 * @property int $JobCollectionID
 * @property int $CategoryID
 * @method JobCollection Blog()
 * @method JobCategory Category()
 */
class ElementJobListings extends BaseElement
{
    /**
     * @var string
     */
    private static $icon = 'font-icon-menu-campaigns';

    /**
     * @var string
     */
    private static $table_name = 'ElementJobPosts';

    /**
     * @var array
     */
    private static $db = [
        'Limit' => 'Int',
        'Content' => 'HTMLText',
    ];

    /**
     * @var array
     */
    private static $has_one = [
        'JobCollection' => JobCollection::class,
        'Category' => JobCategory::class,
    ];

    /**
     * @var string[]
     */
    private static $many_many = [
        'Jobs' => Job::class,
    ];

    /**
     * @var array
     */
    private static $defaults = [
        'Limit' => 3,
    ];

    /**
     * @var bool
     */
    private static $inline_editable = false;

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            $fields->dataFieldByName('Content')
                ->setRows(8);

            $fields->dataFieldByName('Limit')
                ->setTitle(_t(__CLASS__ . 'LimitLabel', 'Posts to show'));

            $fields->insertBefore(
                'Limit',
                $fields->dataFieldByName('JobCollectionID')
                    ->setTitle(_t(__CLASS__ . 'JobCollectionLabel', 'Jobs Listing Page'))
                    ->setEmptyString('')
            );

            $fields->insertAfter(
                'BlogID',
                DropdownField::create('CategoryID', _t(
                    __CLASS__ . 'CategoryLabel',
                    'Category'
                ))
                    ->setHasEmptyDefault(true)
                    ->setEmptyString('')
            );
        });

        return parent::getCMSFields();
    }

    /**
     * @return ArrayList|DataList
     */
    public function getPostsList()
    {
        $jobs = Job::get()
            ->filter([
                'PostDate:LessThanOrEqual' => DBDatetime::now(),
                'EndPostDate:GreaterThanOrEqual' => DBDatetime::now(),
            ]);

        /** Specific parent to pull from */
        if ($this->JobCollectionID) {
            $jobs = $jobs->filter('ParentID', $this->JobCollectionID);
        }

        /** Specific category to pull from */
        if ($this->CategoryID) {
            $jobs = $jobs->filter('Categories.ID', [$this->CategoryID]);
        }

        $this->extend('updateGetPostsList', $posts);

        return $jobs->count()
            ? $jobs->sort('PostDate DESC')
            : ArrayList::create();
    }


    /**
     * @return DBHTMLText
     */
    public function getSummary()
    {
        $count = $this->getPostsList()->count();
        $label = _t(
            Job::class . '.PLURALS',
            'A Job Posting|{count} Job Postings',
            ['count' => $count]
        );
        return DBField::create_field('HTMLText', $label)->Summary(20);
    }

    /**
     * @return array
     */
    protected function provideBlockSchema()
    {
        $blockSchema = parent::provideBlockSchema();
        $blockSchema['content'] = $this->getSummary();
        return $blockSchema;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Job Posts');
    }
}
