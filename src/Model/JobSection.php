<?php

namespace Dynamic\Jobs\Model;

use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\ValidationResult;
use SilverStripe\Security\Permission;

class JobSection extends DataObject
{
    /**
     * @var string
     */
    private static $singular_name = 'Section';

    /**
     * @var string
     */
    private static $plural_name = 'Sections';

    /**
     * @var array
     */
    private static $db = array(
        'Name' => 'Varchar(255)',
        'Title' => 'Varchar(255)',
        'Content' => 'HTMLText',
        'Sort' => 'Int',
    );

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
    private static $summary_fields = array(
        'Name' => 'Name',
        'Title' => 'Title',
    );

    /**
     * @var array
     */
    private static $searchable_fields = array(
        'Name',
        'Title',
        'Content',
    );

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
        return Permission::check('Job_EDIT', 'any', $member);
    }

    /**
     * @param null $member
     *
     * @return bool|int
     */
    public function canDelete($member = null)
    {
        return Permission::check('Job_DELETE', 'any', $member);
    }

    /**
     * @param null $member
     *
     * @return bool|int
     */
    public function canCreate($member = null, $context = [])
    {
        return Permission::check('Job_CREATE', 'any', $member);
    }

    /**
     * @param null $member
     *
     * @return bool
     */
    public function canView($member = null)
    {
        return true;
    }
}
