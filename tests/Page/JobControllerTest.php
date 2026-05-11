<?php

namespace Dynamic\Jobs\Test\Page;

use Dynamic\Jobs\Page\Job;
use Dynamic\Jobs\Page\JobController;
use Dynamic\Jobs\Page\JobCollection;
use SilverStripe\Control\HTTPResponse;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Dev\FunctionalTest;
use SilverStripe\Forms\Form;

/**
 * Class JobControllerTest
 * @package Dynamic\Jobs\Tests
 */
class JobControllerTest extends FunctionalTest
{
    /**
     * @var string
     */
    protected static $fixture_file = '../fixtures.yml';

    /**
     * @var bool
     */
    protected static $use_draft_site = true;

    /**
     * Tests apply()
     */
    public function testApply()
    {
        /** @var Job $object */
        $object = $this->objFromFixture(Job::class, 'one');
        $object->publishSingle();
        $parent = $object->Parent();
        if ($parent && $parent->exists()) {
            $parent->publishSingle();
        }
        $link = $object->Link('apply');

        $page = $this->get($link);
        $this->assertInstanceOf(HttpResponse::class, $page);
        $this->assertEquals(200, $page->getStatusCode());
    }

    /**
     * Tests JobApp()
     */
    public function testJobApp()
    {
        /** @var JobController $object */
        $object = Injector::inst()->create(JobController::class);
        $form = $object->JobApp();

        $this->assertInstanceOf(Form::class, $form);
    }

    /**
     * Tests doApply()
     */
    public function testDoApply()
    {
        $this->autoFollowRedirection = false;
        $this->clearEmails();

        $collection = $this->objFromFixture(JobCollection::class, 'default');
        $collection->publishSingle();
        /** @var Job $object */
        $object = $this->objFromFixture(Job::class, 'open');
        $object->publishSingle();

        $this->get($object->Link('apply'));
        $page = $this->post($object->Link('JobApp'), [
            'FirstName' => 'Eric',
            'LastName' => 'Praline',
            'Email' => 'eric.praline@gmail.com',
            'Phone' => '444-555-6666',
            'Resume' => null,
        ]);

        // $this->assertEmailSent('test@core-jobs.com');

        $this->assertInstanceOf(HttpResponse::class, $page);
        $this->assertEquals(302, $page->getStatusCode());

        $this->clearEmails();
    }

    /**
     * Tests complete()
     */
    public function testComplete()
    {
        /** @var Job $object */
        $object = $this->objFromFixture(Job::class, 'open');
        $object->publishSingle();
        $parent = $object->Parent();
        if ($parent && $parent->exists()) {
            $parent->publishSingle();
        }
        $page = $this->get($object->Link('complete'));

        $this->assertInstanceOf(HttpResponse::class, $page);
        $this->assertEquals(200, $page->getStatusCode());
    }
}
