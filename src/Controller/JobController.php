<?php

namespace Dynamic\Jobs\Page;

use Dynamic\Jobs\Model\JobSubmission;
use PageController;
use SilverStripe\Control\Controller;
use Psr\Log\LoggerInterface;
use SilverStripe\Control\Email\Email;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FileField;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\ReadonlyField;
use SilverStripe\Forms\Validation\RequiredFieldsValidator;
use SilverStripe\Model\ArrayData;
use SilverStripe\Model\ModelDataCustomised;

/**
 * Class JobController
 *
 * @property Job $dataRecord
 * @method Job data()
 * @mixin Job
 * @mixin JobControllerExtension
 */
class JobController extends PageController
{
    /**
     * @var array
     */
    private static $allowed_actions = [
        'apply',
        'JobApp',
        'complete',
    ];

    /**
     * @return ModelDataCustomised
     */
    public function apply()
    {
        $Form = $this->JobApp();

        $Form->Fields()->insertBefore(
            'FirstName',
            ReadonlyField::create(
                'PositionName',
                'Position',
                $this->getTitle()
            )
        );
        $Form->Fields()->push(HiddenField::create('JobID', 'JobID', $this->ID));

        $page = $this->customise([
            'Form' => $Form,
        ]);

        return $page;
    }

    /**
     * @return Form
     */
    public function JobApp()
    {
        $App = singleton(JobSubmission::class);

        $fields = $App->getFrontEndFields();

        $actions = FieldList::create(
            new FormAction('doApply', 'Apply')
        );

        $required = RequiredFieldsValidator::create([
            'FirstName',
            'LastName',
            'Email',
            'Phone',
            'Resume',
        ]);

        $this->extend('updateJobAppForm', $fields, $actions, $required);

        return Form::create($this, "JobApp", $fields, $actions, $required);
    }

    /**
     * @param $data
     * @param $form
     */
    public function doApply(array $data, Form $form)
    {
        $entry = new JobSubmission();
        $form->saveInto($entry);

        $entry->JobID = $this->ID;

        // adds relation to uploaded file
        /** @var FileField $fileField */
        $fileField = $form->Fields()->fieldByName('Resume');
        if ($fileField !== null) {
            $file = $fileField->getUpload()->getFile();
            if ($file !== null && $file->exists()) {
                $file->ShowInSearch = 0;
                $file->write();
                $entry->ResumeID = $file->ID;
            }
        }

        if ($entry->write()) {
            $to = $this->parent()->EmailRecipient ?? '';
            $from = $this->parent()->FromAddress ?? '';
            $subject = $this->parent()->EmailSubject ?? '';
            $body = $this->parent()->Message ?? '';

            $email = new Email($from, $to, $subject, $body);
            $email
                ->setHTMLTemplate('Dynamic\Jobs\Email\JobSubmission')
                ->setData(new ArrayData(array(
                    'Submission' => JobSubmission::get()->byID($entry->ID),
                    'Configuration' => $this->parent(),
                )));

            if ($to) {
                $email->send();
            } else {
                Injector::inst()->get(LoggerInterface::class)->warning(
                    'Job application saved without a notification: the job holder has no EmailRecipient.',
                    ['submission' => $entry->ID, 'job' => $this->ID]
                );
            }

            $this->redirect(Controller::join_links($this->Link(), 'complete'));
        }
    }

    /**
     * @return ModelDataCustomised
     */
    public function complete()
    {
        return $this->customise([]);
    }
}
