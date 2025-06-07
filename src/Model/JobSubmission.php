<?php

namespace Dynamic\Jobs\Model;

use Dynamic\Jobs\Page\Job;
use SilverStripe\Assets\File;
use Dynamic\Jobs\Admin\JobAdmin;
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FileField;
use SilverStripe\Forms\TextField;
use SilverStripe\Control\Director;
use SilverStripe\Forms\EmailField;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\ReadonlyField;
use SilverStripe\Security\Permission;
use SilverStripe\Forms\RequiredFields;
use HudhaifaS\Forms\FrontendRichTextField;
use Dynamic\Jobs\Forms\SimpleHtmlEditorField;

/**
 * Class JobSubmission
 *
 * @property string $LinkedIn
 * @property string $Portfolio
 * @property string $City
 * @property string $State
 * @property string $PostalCode
 * @property bool $LocationAgreement
 * @property bool $Qualified
 * @property bool $SendQuestionnaire
 * @property string $QuestionnaireResults
 * @property bool $QuestionnaireCompleted
 * @property bool $FirstInterviewInvite
 * @property bool $SecondInterviewInvite
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
 * @method DataList|JobNote[] Notes()
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
     * @param null $params
     * @return FieldList
     */
    public function getFrontEndFields($params = null)
    {
        // Resume Upload
        $ResumeField = FileField::create('Resume')->setTitle('Resume');
        $ResumeField->getValidator()->setAllowedExtensions([
            'pdf',
            'doc',
            'docx',
        ]);
        $ResumeField->setFolderName('Uploads/Resumes');
        $ResumeField->setRelationAutoSetting(false);
        $ResumeField->setAttribute('required', true);

        $fields = FieldList::create(
            TextField::create('FirstName', 'First Name')
                ->setAttribute('required', true),
            TextField::create('LastName', 'Last Name')
                ->setAttribute('required', true),
            EmailField::create('Email')
                ->setAttribute('required', true),
            TextField::create('Phone')
                ->setAttribute('required', true),
            DateField::create('Available', 'Date Available'),
            $ResumeField,
            FrontendRichTextField::create('Content', 'Cover Letter')
        );

        $this->extend('updateFrontEndFields', $fields);

        return $fields;
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
                'Content',
                ReadonlyField::create('JobTitle', $this->fieldLabel('Job.Title'), $this->Job()->getTitle())
            );

            $fields->insertBefore(
                'Content',
                ReadonlyField::create(
                    'Created',
                    $this->fieldLabel('Created'),
                    $this->dbObject('Created')->FormatFromSettings()
                )
            );

            $resume = $fields->dataFieldByName('Resume')
                ->setFolderName('Uploads/Resumes');
            $fields->insertBefore('Content', $resume);
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
