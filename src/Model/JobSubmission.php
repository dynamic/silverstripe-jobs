<?php

namespace Dynamic\Jobs\Model;

use Dynamic\Jobs\Admin\JobAdmin;
use Dynamic\Jobs\Forms\SimpleHtmlEditorField;
use Dynamic\Jobs\Page\Job;
use SilverStripe\Assets\File;
use SilverStripe\Control\Controller;
use SilverStripe\Control\Director;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FileField;
use SilverStripe\Forms\ReadonlyField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Permission;

/**
 * Class JobSubmission
 *
 * @property string $LinkedIn
 * @property string $Portfolio
 * @property bool $LocationAgreement
 * @property string $FirstName
 * @property string $LastName
 * @property string $Email
 * @property string $Phone
 * @property string $Available
 * @property string $Content
 * @property int $JobID
 * @property int $ResumeID
 * @method Job Job()
 * @method File Resume()
 * @mixin JobSubmissionDataExtension
 */
class JobSubmission extends DataObject
{
    /**
     * @var string
     */
    private static $table_name = 'Dynamic_JobSubmission';

    /**
     * @var array
     */
    private static $db = [
        'FirstName' => 'Varchar(255)',
        'LastName' => 'Varchar(255)',
        'Email' => 'Varchar(255)',
        'Phone' => 'Varchar(255)',
        'Available' => 'Date',
        'Content' => 'HTMLText',
    ];

    /**
     * @var array
     */
    private static $has_one = [
        'Job' => Job::class,
        'Resume' => File::class,
    ];

    /**
     * @var string
     */
    private static $default_sort = 'Created DESC';

    /**
     * @var array
     */
    private static $summary_fields = [
        'FirstName',
        'LastName',
        'Email',
        'Phone',
        'Job.Title',
        'Created.Nice',
    ];

    /**
     * @var array
     */
    private static $searchable_fields = [
        'FirstName',
        'LastName',
        'JobID',
        'Email',
        'Phone',
        'Content',
    ];

    /**
     * @param bool $includerelations
     * @return array
     */
    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);

        $labels['Name'] = _t(__CLASS__ . '.NameLabel', 'Applicant');
        $labels['Job.Title'] = _t(__CLASS__ . '.JobLabel', 'Job');
        $labels['Job.ID'] = _t(__CLASS__ . '.JobLabel', 'Job');
        $labels['Created'] = _t(__CLASS__ . '.CreatedLabel', 'Application Date');
        $labels['Created.Nice'] = _t(__CLASS__ . '.CreatedLabel', 'Application Date');
        $labels['FirstName'] = _t(__CLASS__ . '.FirstNameLabel', 'First');
        $labels['LastName'] = _t(__CLASS__ . '.LastNameLabel', 'Last');
        $labels['Email'] = _t(__CLASS__ . '.EmailLabel', 'Email');
        $labels['Phone'] = _t(__CLASS__ . '.PhoneLabel', 'Phone');
        $labels['Available'] = _t(__CLASS__ . '.AvailableLabel', 'Date Available');
        $labels['Resume'] = _t(__CLASS__ . '.ResumeLabel', 'Resume');
        $labels['Content'] = _t(__CLASS__ . '.ContentLabel', 'Cover Letter');

        return $labels;
    }

    /**
     * @return string
     */
    public function getName()
    {
        if ($this->FirstName) {
            return $this->FirstName . ' ' . $this->LastName;
        } else {
            return 'No Name';
        }
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->getName();
    }

    /**
     * @return RequiredFields
     */
    public function getRequiredFields()
    {
        return new RequiredFields([
            'FirstName',
            'LastName',
            'Email',
            'Phone',
            'Resume',
        ]);
    }

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            $fields->removeByName([
                'JobID',
            ]);

            $fields->insertBefore(
                ReadonlyField::create('JobTitle', $this->fieldLabel('Job.Title'), $this->Job()->getTitle()),
                'Content'
            );

            $fields->insertBefore(
                ReadonlyField::create(
                    'Created',
                    $this->fieldLabel('Created'),
                    $this->dbObject('Created')->FormatFromSettings()
                ),
                'Content'
            );

            $resume = $fields->dataFieldByName('Resume')
                ->setFolderName('Uploads/Resumes');
            $fields->insertBefore($resume, 'Content');
        });

        return parent::getCMSFields();
    }

    public function getEditLink()
    {
        $link = Controller::join_links(
            Director::absoluteBaseURL(),
            singleton(JobAdmin::class)->Link(),
            'Dynamic-Jobs-Model-JobSubmission/EditForm/field/Dynamic-Jobs-Model-JobSubmission/item/' .
                $this->ID . '/edit'
        );

        return $link;
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
    public function canCreate($member = null, $contect = [])
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
