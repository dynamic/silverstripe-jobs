<?php

namespace Dynamic\Jobs\Page;

use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\File;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\TextField;
use SilverStripe\Lumberjack\Model\Lumberjack;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\FieldType\DBDatetime;
use SilverStripe\ORM\ValidationResult;

/**
 * Class JobCollection
 *
 * @property string $Message
 * @property string $FromAddress
 * @property string $EmailRecipient
 * @property string $EmailSubject
 * @property int $PageSize
 * @property int $HeaderImageID
 * @property int $ApplicationID
 * @method HeaderImage HeaderImage()
 * @method File Application()
 * @mixin Lumberjack
 * @mixin HeaderImageExtension
 */
class JobCollection extends \Page
{
    /**
     * @var string
     */
    private static $singular_name = "Job Holder";

    /**
     * @var string
     */
    private static $plural_name = "Job Holders";

    /**
     * @var string
     */
    private static $description = 'Display a list of available jobs';

    /**
     * @var string
     */
    private static $table_name = 'Dynamic_JobCollection';

    /**
     * @var array
     */
    private static $db = [
        'Message' => 'HTMLText',
        'FromAddress' => 'Varchar(255)',
        'EmailRecipient' => 'Varchar(255)',
        'EmailSubject' => 'Varchar(255)',
        'PageSize' => 'Int',
    ];

    /**
     * @var array
     */
    private static $has_one = [
        'Application' => File::class,
    ];

    /**
     * @var array
     */
    private static $extensions = [
        Lumberjack::class,
    ];

    /**
     * @var string
     */
    private static $default_child = Job::class;

    /**
     * @var array
     */
    private static $allowed_children = [
        Job::class,
    ];

    /**
     * @var array
     */
    private static $defaults = [
        'PageSize' => 10
    ];

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {
            $app = new UploadField('Application', 'Application Form');
            $app
                ->setDescription('optional - include application file to print and complete manually')
                ->setFolderName('Uploads/JobApplications')
                ->setIsMultiUpload(false)
                ->setAllowedFileCategories('document');
            $fields->addFieldToTab('Root.ApplicationFile', $app);

            $fields->addFieldsToTab('Root.Notifications', [
                EmailField::create('FromAddress', 'From Email'),
                EmailField::create('EmailRecipient', 'Recipient Email'),
                TextField::create('EmailSubject', 'Subject Line'),
                HTMLEditorField::create('Message', 'Message')
                    ->setRows(10)
                    ->setDescription('will display after a successful application submission.'),
            ]);

            $fields->addFieldsToTab('Root.Settings', [
                TextField::create('PageSize', 'Page Size')
                    ->setDescription('Number of jobs to display per page.'),
            ]);
        });

        return parent::getCMSFields();
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
            ]);

        $this->extend('updatePostedJobs', $jobs);

        return $jobs;
    }

    /**
     * @return string
     */
    public function getLumberjackTitle()
    {
        return 'Jobs';
    }
}
