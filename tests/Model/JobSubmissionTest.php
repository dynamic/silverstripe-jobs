<?php

namespace Dynamic\Jobs\Test;

use Dynamic\Jobs\Model\JobSubmission;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Security\Member;

/**
 * Class JobSubmission
 * @package Dynamic\Jobs\Tests
 */
class JobSubmissionTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = '../fixtures.yml';

    /**
     * Tests getName()
     */
    public function testGetName()
    {
        /** @var JobSubmission $object */
        $object = Injector::inst()->create(JobSubmission::class);
        $this->assertEquals('No Name', $object->getName());

        $object->FirstName = 'Raymond';
        $object->LastName = 'Luxury-Yacht';

        $this->assertEquals('Raymond Luxury-Yacht', $object->getName());
    }

    /**
     * Tests getTitle()
     */
    public function testGetTitle()
    {
        /** @var JobSubmission $object */
        $object = Injector::inst()->create(JobSubmission::class);
        $object->FirstName = 'Arthur';
        $object->LastName = 'Nudge';

        $this->assertEquals('Arthur Nudge', $object->getTitle());
    }

    /**
     * Tests getFrontEndFields()
     */
    public function testGetFrontEndFields()
    {
        /** @var JobSubmission $object */
        $object = Injector::inst()->create(JobSubmission::class);
        $fields = $object->getFrontEndFields();
        $this->assertInstanceOf(FieldList::class, $fields);
    }

    /**
     * Tests getRequiredFields()
     */
    public function testGetRequiredFields()
    {
        /** @var JobSubmission $object */
        $object = Injector::inst()->create(JobSubmission::class);
        $fields = $object->getRequiredFields();
        $this->assertInstanceOf(RequiredFields::class, $fields);
    }

    /**
     * Tests getCMSFields
     */
    public function testGetCMSFields()
    {
        /** @var JobSubmission $object */
        $object = Injector::inst()->create(JobSubmission::class);
        $fields = $object->getCMSFields();
        $this->assertInstanceOf(FieldList::class, $fields);
    }

    /**
     * Tests canCreate()
     */
    public function testCanCreate()
    {
        /** @var JobSubmission $object */
        $object = Injector::inst()->create(JobSubmission::class);

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
        /** @var JobSubmission $object */
        $object = Injector::inst()->create(JobSubmission::class);

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
        /** @var JobSubmission $object */
        $object = Injector::inst()->create(JobSubmission::class);

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
        /** @var JobSubmission $object */
        $object = Injector::inst()->create(JobSubmission::class);
        $manage = $this->objFromFixture(Member::class, 'Manager');
        $this->assertTrue($object->canView($manage));
    }
}
