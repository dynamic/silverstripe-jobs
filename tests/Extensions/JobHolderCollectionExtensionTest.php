<?php

namespace Dynamic\Jobs\Tests\Extensions;

use Dynamic\Jobs\Model\Job;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\FieldType\DBDatetime;

/**
 * Class JobHolderCollectionExtensionTest
 * @package Dynamic\Jobs\Tests\Extensions
 */
class JobHolderCollectionExtensionTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = '../fixtures.yml';

    /**
     * @var array
     */
    protected static $extra_dataobjects = [
        JobHolderCollectionExtensionTest_Object::class,
    ];

    /**
     * Tests updateCollectionFilters()
     */
    public function testUpdateCollectionFilters()
    {
        /** @var JobHolderCollectionExtensionTest_Object $object */
        $object = Injector::inst()->create(JobHolderCollectionExtensionTest_Object::class);
        $object->write();
        $filter = [];
        $newFilter = $object->getCollectionFilters($filter);

        $this->assertArrayHasKey('ParentID', $newFilter);
    }

    /**
     * Tests updateCollectionForm()
     */
    public function testUpdateCollectionForm()
    {
        /** @var JobHolderCollectionExtensionTest_Object $object */
        $object = Injector::inst()->create(JobHolderCollectionExtensionTest_Object::class);

        $fields = new FieldList(
            DropdownField::create('Categories__ID')
        );

        $form = new Form(null, 'Form', $fields, new FieldList());
        $newForm = $object->getCollectionForm($form);

        $this->assertInstanceOf(Form::class, $newForm);
    }

    /**
     * Tests updateCollectionItems()
     */
    public function testUpdateCollectionItems()
    {
        /** @var JobHolderCollectionExtensionTest_Object $object */
        $object = Injector::inst()->create(JobHolderCollectionExtensionTest_Object::class);

        /** @var Job $past */
        $past = $this->objFromFixture(Job::class, 'past');
        $past->write();
        /** @var Job $open */
        $open = $this->objFromFixture(Job::class, 'open');
        $open->write();
        /** @var Job $future */
        $future = $this->objFromFixture(Job::class, 'future');
        $future->write();

        $list = new ArrayList([
            $past,
            $open,
            $future,
        ]);

        DBDatetime::set_mock_now('2017-11-15');
        $newList = $object->getCollectionItems($list);
        $this->assertInstanceOf(ArrayList::class, $newList);
        $this->assertEquals(1, $newList->count());

        DBDatetime::set_mock_now('2017-11-29');
        $newList = $object->getCollectionItems($list);
        $this->assertEquals(2, $newList->count());
    }
}
