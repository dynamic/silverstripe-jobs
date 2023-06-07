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
use SilverStripe\ORM\HasManyList;
use SilverStripe\ORM\ManyManyList;
use SilverStripe\ORM\Search\SearchContext;
use SilverStripe\Security\Permission;
use SilverStripe\Security\PermissionProvider;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

/**
 * Class Job
 *
 * @property string $PositionLocation
 * @property string $PositionType
 * @property string $PostDate
 * @property string $EndPostDate
 * @property int $HeaderImageID
 * @method HeaderImage HeaderImage()
 * @method DataList|JobSection[] Sections()
 * @method DataList|JobSubmission[] Submissions()
 * @method ManyManyList|JobCategory[] Categories()
 * @mixin HeaderImageExtension
 * @mixin JobDataExtension
 */
class Job extends Page implements PermissionProvider
{
    /**
     * @var string
     */
    private static $table_name = 'Dynamic_Job';

    /**
     * @var string
     */
    private static $singular_name = 'Job';

    /**
     * @var string
     */
    private static $plural_name = 'Jobs';

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
     * @var string
     */
    private static $default_sort = '"PostDate" DESC, "LastEdited" DESC';

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
     * @param bool $includerelations
     * @return array
     */
    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);

        $labels['Title'] = _t(__CLASS__ . '.TitleLabel', 'Position Name');
        $labels['Content'] = _t(__CLASS__ . '.ContentLabel', 'Introduction');
        $labels['PositionType'] = _t(__CLASS__ . '.PositionTypeLabel', 'Position Type');
        $labels['PostDate'] = _t(__CLASS__ . '.PostDateLabel', 'Post Start Date');
        $labels['EndPostDate'] = _t(__CLASS__ . '.EndPostDateLabel', 'Post End Date');
        $labels['Details'] =  _t(__CLASS__ . '.DetailsTab', "Details");
        $labels['Submissions'] = _t(__CLASS__ . '.SubmissionsTab', 'Submissions');
        //$labels['Categories'] = _t(JobCategory::class . '.SlideType', 'Image or Video');

        return $labels;
    }

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {
            $fields->dataFieldByName('Content')
                ->setTitle($this->fieldLabel('Content'))
                ->setRows(10);

            $fields->addFieldsToTab('Root.' . $this->fieldLabel('Details'), [
                DropdownField::create(
                    'PositionType',
                    $this->fieldLabel('PositionType'),
                    Job::singleton()->dbObject('PositionType')->enumValues()
                )->setEmptyString('--select--'),
                DateField::create('PostDate', $this->fieldLabel('PostDate'))
                    ->setDescription(_t(
                        __CLASS__ . '.PostDateDescription',
                        'Date position should appear on website'
                    )),
                DateField::create('EndPostDate', $this->fieldLabel('EndPostDate'))
                    ->setDescription(_t(
                        __CLASS__ . '.EndPostDateDescription',
                        'Date position should be removed from website'
                    )),
            ]);

            if ($this->ID) {
                // categories
                $categoriesField = ListboxField::create(
                    'Categories',
                    _t(JobCategory::class . '.PLURALNAME', 'Categories'),
                    JobCategory::get()->map()
                );

                $fields->addFieldsToTab('Root.' . $this->fieldLabel('Details'), [
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
                $sectionsField = GridField::create(
                    'Sections',
                    _t(JobSection::class . '.PLURALNAME', 'Sections'),
                    $sections,
                    $config
                )
                    ->setDescription(_t(
                        __CLASS__ . '.SectionsDescription',
                        'ex: Requirements, Education, Duties, etc.'
                    ));

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
                $submissionsField = GridField::create(
                    'Submissions',
                    _t(JobSubmission::class . '.PLURALNAME', 'Submissions'),
                    $submissions,
                    $config
                )
                ;
                $fields->addFieldsToTab('Root.' . $this->fieldLabel('Submissions'), [
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
            'JOB_MANAGE' => [
                'name' => _t(
                    __CLASS__ . '.JOB_MANAGE',
                    'Manage Jobs'
                ),
                'category' => _t(
                    __CLASS__ . '.JOB_MANAGE_CATEGORY',
                    'Jobs'
                ),
                'help' => _t(
                    __CLASS__ . '.JOB_MANAGE_HELP',
                    'Access to add, edit and delete Jobs'
                ),
                'sort' => 400,
            ],
        ];
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
}
