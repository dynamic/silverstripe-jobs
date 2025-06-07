<?php

namespace Dynamic\Jobs\Test\Page;

use Dynamic\Jobs\Page\Job;
use Dynamic\Jobs\Page\JobCollection;
use SilverStripe\Assets\File;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\FieldList;
use SilverStripe\Security\Member;

/**
 * Class JobTest
 * @package Dynamic\Jobs\Tests
 */
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
        $object = \SilverStripe\Core\Injector\Injector::inst()->create(Job::class);
        $perms = $object->providePermissions();
        $this->assertIsArray($perms);
        $this->assertArrayHasKey('JOB_MANAGE', $perms);
        $this->assertEquals('Manage Jobs', $perms['JOB_MANAGE']['name']);
        $this->assertEquals('Jobs', $perms['JOB_MANAGE']['category']);
        $this->assertEquals('Access to add, edit and delete Jobs', $perms['JOB_MANAGE']['help']);
        $this->assertEquals(400, $perms['JOB_MANAGE']['sort']);
    }

    /**
     * Tests canCreate()
     */
    public function testCanCreate()
    {
        /** @var Job $object */
        $object = Injector::inst()->create(Job::class);

        $admin = $this->objFromFixture(Member::class, 'Admin');
        $manage = $this->objFromFixture(Member::class, 'Manager');
        $visitor = $this->objFromFixture(Member::class, 'Visitor');

        $this->assertTrue($object->canCreate($admin));
        $this->assertTrue($object->canCreate($manage));
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
        $manage = $this->objFromFixture(Member::class, 'Manager');
        $visitor = $this->objFromFixture(Member::class, 'Visitor');

        $this->assertTrue($object->canEdit($admin));
        $this->assertTrue($object->canEdit($manage));
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
        $manage = $this->objFromFixture(Member::class, 'Manager');
        $visitor = $this->objFromFixture(Member::class, 'Visitor');

        $this->assertTrue($object->canDelete($admin));
        $this->assertTrue($object->canDelete($manage));
        $this->assertFalse($object->canDelete($visitor));
    }

    /**
     * Tests canView()
     */
    public function testCanView()
    {
        /** @var Job $object */
        $object = Injector::inst()->create(Job::class);
        $manage = $this->objFromFixture(Member::class, 'Manager');
        $this->assertTrue($object->canView($manage));
    }
}
