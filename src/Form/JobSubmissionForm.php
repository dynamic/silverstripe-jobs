<?php

namespace Dynamic\Jobs\Form;

use Dynamic\Jobs\Forms\SimpleHtmlEditorField;
use SilverStripe\Control\RequestHandler;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FileField;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\Validator;

class JobSubmissionForm extends Form
{
    /**
     * @param RequestHandler|null $controller
     * @param $name
     * @param FieldList|null $fields
     * @param FieldList|null $actions
     * @param Validator|null $validator
     */
    public function __construct(
        RequestHandler $controller = null,
        $name = self::DEFAULT_NAME,
        FieldList $fields = null,
        FieldList $actions = null,
        Validator $validator = null
    )
    {
        $ResumeField = FileField::create('Resume')
            ->setTitle('Resume');
        $ResumeField->getValidator()->setAllowedExtensions([
            'pdf',
            'doc',
            'docx',
        ]);
        $ResumeField->setFolderName('Uploads/Resumes');
        $ResumeField->setRelationAutoSetting(false);
        $ResumeField->setAttribute('required', true);

        $fields = FieldList::create(
            TextField::create('FirstName', 'First Name')
                ->setAttribute('required', true),
            TextField::create('LastName', 'Last Name')
                ->setAttribute('required', true),
            EmailField::create('Email')
                ->setAttribute('required', true),
            TextField::create('Phone')
                ->setAttribute('required', true),
            DateField::create('Available', 'Date Available'),
            $ResumeField,
            SimpleHtmlEditorField::create('Content', 'Cover Letter')
        );

        parent::__construct($controller, $name, $fields, $actions, $validator);
    }
}
