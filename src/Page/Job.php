<?php

namespace Dynamic\Jobs\Page;

use Dynamic\Jobs\Model\JobCategory;
use Dynamic\Jobs\Model\JobSection;
use Dynamic\Jobs\Model\JobSubmission;
use \Page;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\ListboxField;
use SilverStripe\Forms\TreeMultiselectField;
use SilverStripe\ORM\Search\SearchContext;
use SilverStripe\Security\Permission;
use SilverStripe\Security\PermissionProvider;
use Symbiote\GridFieldExtensions\GridFieldAddExistingSearchButton;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

/**
 * Class Job
 * @package Dynamic\Jobs\Model
 */
class Job extends Page implements PermissionProvider
{
    /**
     * @var string
     */
    private static $singular_name = 'Job';

    /**
     * @var string
     */
    private static $plural_name = 'Jobs';

    /**
     * @var string
     */
    private static $description = 'Job detail page allowing for application submissions';

    /**
     * @var string
     */
    private static $table_name = 'Dynamic_Job';

    /**
     * @var array
     */
    private static $db = [
        'PositionType' => "Enum(array('Full-time', 'Part-time', 'Freelance', 'Internship'))",
        'PostDate' => 'Date',
        'EndPostDate' => 'Date',
    ];

    /**
     * @var array
     */
    private static $has_many = [
        'Sections' => JobSection::class,
        'Submissions' => JobSubmission::class,
    ];

    /**
     * @var array
     */
    private static $many_many = [
        'Categories' => JobCategory::class,
    ];

    /**
     * @var array
     */
    private static $many_many_extraFields = [
        'Categories' => [
            'Sort' => 'Int',
        ],
    ];

    /**
     * @var array
     */
    private static $searchable_fields = [
        'Title',
        'Categories.ID' => [
            'title' => 'Category',
        ],
        'PositionType' => [
            'title' => 'Type',
        ],
    ];

    /**
     * @var string
     */
    private static $default_parent = JobCollection::class;

    /**
     * @var bool
     */
    private static $can_be_root = false;

    /**
     * @var bool
     */
    private static $show_in_sitetree = false;

    /**
     * @var array
     */
    private static $allowed_children = [];

    /**
     * @return SearchContext
     */
    public function getCustomSearchContext()
    {
        $fields = $this->scaffoldSearchFields([
            'restrictFields' => [
                'Title',
                'Categories.ID',
                'PositionType',
            ],
        ]);

        $filters = $this->defaultSearchFilters();

        return new SearchContext(
            $this->ClassName,
            $fields,
            $filters
        );
    }

    /**
     *
     */
    public function populateDefaults()
    {
        $this->PostDate = date('Y-m-d');

        parent::populateDefaults();
    }

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {
            $fields->dataFieldByName('Title')
                ->setTitle('Position Name');

            $fields->dataFieldByName('Content')
                ->setRows(10)
                ->setTitle('Introduction');

            $fields->addFieldsToTab('Root.Details', [
                DropdownField::create(
                    'PositionType',
                    'Position Type',
                    Job::singleton()->dbObject('PositionType')->enumValues()
                )->setEmptyString('--select--'),
                DateField::create('PostDate', 'Post Start Date')
                    ->setDescription('Date position should appear on website'),
                DateField::create('EndPostDate', 'Post End Date')
                    ->setDescription('Date position should be removed from website'),
            ]);

            if ($this->ID) {
                // categories
                $categoriesField = ListboxField::create(
                    'Categories',
                    'Categories',
                    JobCategory::get()->map()
                );

                $fields->addFieldsToTab('Root.Details', [
                    $categoriesField,
                ]);

                // sections
                $config = GridFieldConfig_RelationEditor::create();
                $config
                    ->addComponent(new GridFieldOrderableRows('Sort'))
                    ->addComponent(new GridFieldDeleteAction(false))
                    ->removeComponentsByType(GridFieldAddExistingAutocompleter::class)
                    ->removeComponentsByType(GridFieldDeleteAction::class);

                $sections = $this->Sections()->sort('Sort');
                $sectionsField = GridField::create('Sections', 'Sections', $sections, $config)
                    ->setDescription('ex: Requirements, Education, Duties, etc.');
                $fields->addFieldsToTab('Root.Main', [
                    $sectionsField,
                ]);

                // submissions
                $config = GridFieldConfig_RelationEditor::create();
                $config
                    ->addComponent(new GridFieldDeleteAction(false))
                    ->removeComponentsByType(GridFieldAddExistingAutocompleter::class)
                    ->removeComponentsByType(GridFieldDeleteAction::class);

                $submissions = $this->Submissions();
                $submissionsField = GridField::create('Submissions', 'Submissions', $submissions, $config);
                $fields->addFieldsToTab('Root.Submissions', [
                    $submissionsField,
                ]);
            }
        });

        return parent::getCMSFields();
    }

    /**
     * @return string
     */
    public function getApplyButton()
    {
        $apply = Controller::join_links(
            $this->Link(),
            'apply'
        );
        return $apply;
    }

    /**
     * @return mixed
     */
    public function getApplicationLink()
    {
        if ($this->parent()->Application()->ID != 0) {
            return $this->parent()->Application()->URL;
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function getCategoryList()
    {
        return $this->Categories()->sort('Sort');
    }

    /**
     * @return bool
     */
    public function getPrimaryCategory()
    {
        if ($this->Categories()->exists()) {
            return $this->Categories()->first();
        }
        return false;
    }

    /**
     * @return array
     */
    public function providePermissions()
    {
        return [
            'Job_EDIT' => 'Edit a Job',
            'Job_DELETE' => 'Delete a Job',
            'Job_CREATE' => 'Create a Job',
        ];
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
