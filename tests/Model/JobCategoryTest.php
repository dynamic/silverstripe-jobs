<?php

namespace Dynamic\Jobs\Test;

use Dynamic\Jobs\Model\JobCategory;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\FieldList;
use SilverStripe\Security\Member;

/**
 * Class JobCategoryTest
 * @package Dynamic\Jobs\Tests
 */
class JobCategoryTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = '../fixtures.yml';

    /**
     * Tests getCMSFields
     */
    public function testGetCMSFields()
    {
        /** @var JobCategory $object */
        $object = $this->objFromFixture(JobCategory::class, 'one');
        $fields = $object->getCMSFields();
        $this->assertInstanceOf(FieldList::class, $fields);
    }

    /**
     * Tests canCreate()
     */
    public function testCanCreate()
    {
        /** @var JobCategory $object */
        $object = Injector::inst()->create(JobCategory::class);

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
        /** @var JobCategory $object */
        $object = Injector::inst()->create(JobCategory::class);

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
        /** @var JobCategory $object */
        $object = Injector::inst()->create(JobCategory::class);

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
        /** @var JobCategory $object */
        $object = Injector::inst()->create(JobCategory::class);
        $this->assertTrue($object->canView());
    }
}
