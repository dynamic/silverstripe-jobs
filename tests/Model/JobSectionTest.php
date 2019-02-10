<?php

namespace Dynamic\Jobs\Test;

use Dynamic\Jobs\Model\JobSection;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\ValidationResult;
use SilverStripe\Security\Member;

/**
 * Class JobSectionTest
 * @package Dynamic\Jobs\Tests
 */
class JobSectionTest extends SapphireTest
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
        /** @var JobSection $object */
        $object = Injector::inst()->create(JobSection::class);
        $fields = $object->getCMSFields();
        $this->assertInstanceOf(FieldList::class, $fields);
    }

    /**
     * Tests validate()
     */
    public function testValidate()
    {
        /** @var JobSection $object */
        $object = Injector::inst()->create(JobSection::class);
        $valid = $object->validate();

        $this->assertInstanceOf(ValidationResult::class, $valid);
        $this->assertFalse($valid->isValid());
        $this->assertContains('Name is required before you can save', $valid->getMessages()[0]);

        $object->Title = 'title';
        $object->Name = 'name';
        $object->write();
        $valid = $object->validate();

        $this->assertInstanceOf(ValidationResult::class, $valid);
        $this->assertTrue($valid->isValid());
    }

    /**
     * Tests canCreate()
     */
    public function testCanCreate()
    {
        /** @var JobSection $object */
        $object = Injector::inst()->create(JobSection::class);

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
        /** @var JobSection $object */
        $object = Injector::inst()->create(JobSection::class);

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
        /** @var JobSection $object */
        $object = Injector::inst()->create(JobSection::class);

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
        /** @var JobSection $object */
        $object = Injector::inst()->create(JobSection::class);
        $this->assertTrue($object->canView());
    }
}
