<?php

namespace Dynamic\Jobs\Tests;

use Dynamic\Jobs\Model\Job;
use Dynamic\Jobs\Model\JobCollection;
use SilverStripe\Assets\File;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\FieldList;
use SilverStripe\Security\Member;

class JobTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = '../fixtures.yml';

    /**
     * Tests populateDefaults()
     */
    public function testPopulateDefaults()
    {
        /** @var Job $object */
        $object = Injector::inst()->create(Job::class);
        $object->populateDefaults();
        $this->assertEquals(date('Y-m-d'), $object->PostDate);
    }

    /**
     * Tests getCMSFields()
     */
    public function testGetCMSFields()
    {
        /** @var Job $object */
        $object = $this->objFromFixture(Job::class, 'one');
        $fields = $object->getCMSFields();
        $this->assertInstanceOf(FieldList::class, $fields);
    }

    /**
     * Tests getApplyButton()
     */
    public function testGetApplyButton()
    {
        /** @var Job $object */
        $object = Injector::inst()->create(Job::class);
        $this->assertStringEndsWith('apply', $object->getApplyButton());
    }

    /**
     * Tests getApplicationLink()
     */
    public function testGetApplicationLink()
    {
        /** @var Job $object */
        $object = $this->objFromFixture(Job::class, 'one');
        /** @var JobCollection $parent */
        $parent = $this->objFromFixture(JobCollection::class, 'default');

        $object->ParentID = $parent->ID;
        $object->write();

        $this->assertFalse($object->getApplicationLink());

        // TODO - fix this part
        /** @var File $file */
        $file = $this->objFromFixture(File::class, 'File');

        $parent->ApplicationID = $file->ID;
        $parent->write();

        // print_r($file->ID);
        // print_r($object->parent()->Application()->ID);

        // $this->assertEquals($file->URL, $object->getApplicationLink());
    }

    /**
     * Tests providePermissions()
     */
    public function testProvidePermissions()
    {
        /** @var Job $object */
        $object = Injector::inst()->create(Job::class);
        $perms = array(
            'Job_EDIT' => 'Edit a Job',
            'Job_DELETE' => 'Delete a Job',
            'Job_CREATE' => 'Create a Job',
        );
        $this->assertEquals($perms, $object->providePermissions());
    }

    /**
     * Tests canCreate()
     */
    public function testCanCreate()
    {
        /** @var Job $object */
        $object = Injector::inst()->create(Job::class);

        $admin = $this->objFromFixture(Member::class, 'Admin');
        $create = $this->objFromFixture(Member::class, 'Create');
        $edit = $this->objFromFixture(Member::class, 'Edit');
        $delete = $this->objFromFixture(Member::class, 'Delete');
        $visitor = $this->objFromFixture(Member::class, 'Visitor');

        $this->assertTrue($object->canCreate($admin));
        $this->assertTrue($object->canCreate($create));
        $this->assertFalse($object->canCreate($edit));
        $this->assertFalse($object->canCreate($delete));
        $this->assertFalse($object->canCreate($visitor));
    }

    /**
     * Tests canEdit()
     */
    public function testCanEdit()
    {
        /** @var Job $object */
        $object = Injector::inst()->create(Job::class);

        $admin = $this->objFromFixture(Member::class, 'Admin');
        $create = $this->objFromFixture(Member::class, 'Create');
        $edit = $this->objFromFixture(Member::class, 'Edit');
        $delete = $this->objFromFixture(Member::class, 'Delete');
        $visitor = $this->objFromFixture(Member::class, 'Visitor');

        $this->assertTrue($object->canEdit($admin));
        $this->assertFalse($object->canEdit($create));
        $this->assertTrue($object->canEdit($edit));
        $this->assertFalse($object->canEdit($delete));
        $this->assertFalse($object->canEdit($visitor));
    }

    /**
     * Tests canDelete()
     */
    public function testCanDelete()
    {
        /** @var Job $object */
        $object = Injector::inst()->create(Job::class);

        $admin = $this->objFromFixture(Member::class, 'Admin');
        $create = $this->objFromFixture(Member::class, 'Create');
        $edit = $this->objFromFixture(Member::class, 'Edit');
        $delete = $this->objFromFixture(Member::class, 'Delete');
        $visitor = $this->objFromFixture(Member::class, 'Visitor');

        $this->assertTrue($object->canDelete($admin));
        $this->assertFalse($object->canDelete($create));
        $this->assertFalse($object->canDelete($edit));
        $this->assertTrue($object->canDelete($delete));
        $this->assertFalse($object->canDelete($visitor));
    }

    /**
     * Tests canView()
     */
    public function testCanView()
    {
        /** @var Job $object */
        $object = Injector::inst()->create(Job::class);
        $this->assertTrue($object->canView());
    }
}
