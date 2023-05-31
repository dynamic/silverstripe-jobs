<?php

namespace Dynamic\Jobs\Model;

use Dynamic\Jobs\Page\Job;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\ValidationResult;
use SilverStripe\Security\Permission;

/**
 * Class JobSection
 *
 * @property string $Name
 * @property string $Title
 * @property string $Content
 * @property int $Sort
 * @property int $JobID
 * @method Job Job()
 */
class JobSection extends DataObject
{
    /**
     * @var string
     */
    private static $table_name = 'Dynamic_JobSection';

    /**
     * @var array
     */
    private static $db = [
        'Name' => 'Varchar(255)',
        'Title' => 'Varchar(255)',
        'Content' => 'HTMLText',
        'Sort' => 'Int',
    ];

    /**
     * @var array
     */
    private static $has_one = [
        'Job' => Job::class,
    ];

    /**
     * @var string
     */
    private static $default_sort = 'Sort';

    /**
     * @var array
     */
    private static $summary_fields = [
        'Name' => 'Name',
        'Title' => 'Title',
    ];

    /**
     * @var array
     */
    private static $searchable_fields = [
        'Name',
        'Title',
        'Content',
    ];

    /**
     * @param bool $includerelations
     * @return array
     */
    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);

        $labels['Name'] = _t(__CLASS__ . '.NameLabel', 'Name');
        $labels['Title'] = _t(__CLASS__ . '.TitleLabel', 'Title');

        return $labels;
    }

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'Sort',
            'JobID',
        ]);

        $fields->dataFieldByName('Name')->setDescription('For internal reference only');

        return $fields;
    }

    /**
     * @return ValidationResult
     */
    public function validate()
    {
        $result = parent::validate();

        if (!$this->Name) {
            $result->addError('Name is required before you can save');
        }

        return $result;
    }

    /**
     * @param null $member
     *
     * @return bool|int
     */
    public function canEdit($member = null)
    {
        return Permission::check('JOB_MANAGE', 'any', $member);
    }

    /**
     * @param null $member
     *
     * @return bool|int
     */
    public function canDelete($member = null)
    {
        return Permission::check('JOB_MANAGE', 'any', $member);
    }

    /**
     * @param null $member
     *
     * @return bool|int
     */
    public function canCreate($member = null, $context = [])
    {
        return Permission::check('JOB_MANAGE', 'any', $member);
    }

    /**
     * @param null $member
     *
     * @return bool
     */
    public function canView($member = null)
    {
        return Permission::check('JOB_MANAGE', 'any', $member);
    }
}
