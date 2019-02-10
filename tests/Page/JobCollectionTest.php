<?php

namespace Dynamic\Jobs\Test\Page;

use Dynamic\Jobs\Page\Job;
use Dynamic\Jobs\Page\JobCollection;
use SilverStripe\Core\Injector\Injector;
use \SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\FieldType\DBDatetime;
use SilverStripe\ORM\ValidationResult;

/**
 * Class JobCollectionTest
 * @package Dynamic\Jobs\Tests
 */
class JobCollectionTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = '../fixtures.yml';

    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        DBDatetime::clear_mock_now();
        parent::tearDown();
    }

    /**
     * Tests getCMSFields()
     */
    public function testGetCMSFields()
    {
        /** @var JobCollection $object */
        $object = Injector::inst()->create(JobCollection::class);
        $fields = $object->getCMSFields();
        $this->assertInstanceOf(FieldList::class, $fields);
    }

    /**
     * Tests validate()
     */
    public function testValidate()
    {
        /** @var JobCollection $object */
        $object = Injector::inst()->create(JobCollection::class);
        $valid = $object->validate();
        $this->assertInstanceOf(ValidationResult::class, $valid);
    }

    /**
     * Tests getPostedJobs()
     */
    public function testGetPostedJobs()
    {
        /** @var JobCollection $holder */
        $holder = $this->objFromFixture(JobCollection::class, 'default');

        /** @var Job $past */
        $past = $this->objFromFixture(Job::class, 'past');
        $past->write();
        /** @var Job $open */
        $open = $this->objFromFixture(Job::class, 'open');
        $open->write();
        /** @var Job $future */
        $future = $this->objFromFixture(Job::class, 'future');
        $future->write();

        DBDatetime::set_mock_now('2017-11-15');
        $jobCount = $holder->getPostedJobs()->count();
        $this->assertEquals(1, $jobCount);

        DBDatetime::set_mock_now('2017-11-29');
        $jobCount = $holder->getPostedJobs()->count();
        $this->assertEquals(2, $jobCount);

        DBDatetime::set_mock_now('2017-12-15');
        $jobCount = $holder->getPostedJobs()->count();
        $this->assertEquals(0, $jobCount);
    }
}
