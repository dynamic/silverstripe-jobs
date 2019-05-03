<?php

namespace Dynamic\Jobs\Model;

use Dynamic\Jobs\Page\Job;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Permission;

/**
 * Class JobCategory
 * @package Dynamic\Jobs\Model
 */
class JobCategory extends DataObject
{
    /**
     * @var string
     */
    private static $table_name = 'Dynamic_JobCategory';

    /**
     * @var array
     */
    private static $db = [
        'Name' => 'Varchar(255)',
        'Title' => 'Varchar(255)',
    ];

    /**
     * @var array
     */
    private static $belongs_many_many = [
        'Jobs' => Job::class,
    ];

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
        $labels['Jobs'] = _t(Job::class . '.PLURALNAME', 'Jobs');

        return $labels;
    }

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->dataFieldByName('Name')
            ->setDescription(_t(
                __CLASS__ . '.NameDescription',
                'For internal reference only'
            ));

        if ($this->ID) {
            $fields->dataFieldByName('Jobs')->getConfig()
                ->removeComponentsByType(GridFieldAddNewButton::class);
        }

        return $fields;
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
