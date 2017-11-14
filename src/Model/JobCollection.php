<?php

namespace Dynamic\Jobs\Model;

use \Page;

use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\File;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\FieldType\DBDatetime;
use SilverStripe\ORM\ValidationResult;

class JobCollection extends Page
{
    /**
     * @var string
     */
    private static $singular_name = "Job Collection";

    /**
     * @var string
     */
    private static $plural_name = "Job Collection";

    /**
     * @var string
     */
    private static $description = 'Display a list of available jobs';

    /**
     * @var array
     */
    private static $db = array(
        'Message' => 'HTMLText',
        'FromAddress' => 'Varchar(255)',
        'EmailRecipient' => 'Varchar(255)',
        'EmailSubject' => 'Varchar(255)'
    );

    /**
     * @var array
     */
    private static $has_one = array(
        'Application' => File::class
    );

    /**
     * @var string
     */
    private static $default_child = Job::class;

    /**
     * @var array
     */
    private static $allowed_children = array(
        Job::class
    );

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $app = new UploadField('Application', 'Application Form');
        $app->allowedExtensions = array('pdf','PDF');
        $fields->addFieldToTab('Root.ApplicationFile', $app);

        $fields->addFieldsToTab('Root.Configuration', array(
            EmailField::create('FromAddress', 'Submission From Address'),
            EmailField::create('EmailRecipient', 'Submission Recipient'),
            TextField::create('EmailSubject', 'Submission Email Subject Line'),
            HTMLEditorField::create('Message', 'Submission Message'),
        ));

        return $fields;
    }

    /**
     * @return ValidationResult
     */
    public function validate()
    {

        $result = parent::validate();
        // TODO - this bugs out and won't create the page if it is in
        /*
                if(!$this->EmailRecipient) {
                    $result->addError('Please enter Email Recipient before saving.');
                }

                if(!$this->EmailSubject) {
                    $result->addError('Please enter Email Subject before saving.');
                }
                */
        return $result;
    }

    /**
     * @return DataList
     */
    public function getPostedJobs()
    {
        $jobs = Job::get()
            ->filter([
                'PostDate:LessThanOrEqual' => DBDatetime::now(),
                'EndPostDate:GreaterThanOrEqual' => DBDatetime::now(),
            ])
            ->sort('PostDate DESC');
        return $jobs;
    }
}
