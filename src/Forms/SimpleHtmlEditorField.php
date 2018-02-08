<?php

namespace Dynamic\Jobs\Forms;

use SilverStripe\Forms\TextareaField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\View\Requirements;

/**
 * Class SimpleHtmlEditorField
 *
 * Originally from https://github.com/unclecheese/silverstripe-bootstrap-forms
 * Should be replaced when/if bootstrap forms updates
 */
class SimpleHtmlEditorField extends TextareaField
{
    /**
     * @var string The default buttons to show on the editor
     */
    public static $default_buttons = "bold,italic,bullist,link,formatselect";

    /**
     * @var string The default formats to show in the format dropdown
     */
    public static $default_blockformats = "p,h3,h4";

    /**
     * Sets the buttons for this HTML editor
     *
     * @param string $buttons The buttons to show
     *
     * @return SimpleHtmlEditorField
     */
    public function setButtons($buttons)
    {
        return $this->setAttribute('data-buttons', $buttons);
    }

    /**
     * Sets the available block formats for this HTML Editor
     *
     * @param string $formats The formats to show
     *
     * @return SimpleHtmlEditorField
     */
    public function setBlockFormats($formats)
    {
        return $this->setAttribute('data-blockformats', $formats);
    }

    /**
     * Sets the default CSS for the editor, i.e. for typography
     *
     * @param string $css The path to the CSS document
     *
     * @return SimpleHtmlEditorField
     */
    public function setCSS($css)
    {
        return $this->setAttribute('data-css', $css);
    }

    /**
     * Builds the form field, includes JavaScript, and sets defaults
     *
     * @param array $attributes The attributes to include on the form field
     *
     * @return DBHTMLText
     */
    public function FieldHolder($attributes = [])
    {
        Requirements::javascript("silverstripe/admin: thirdparty/jquery/jquery.min.js");
        Requirements::javascript("silverstripe/admin: thirdparty/tinymce/jquery.tinymce.min.js");
        Requirements::javascript("silverstripe/admin: thirdparty/tinymce/tinymce.min.js");
        Requirements::javascript("dynamic/silverstripe-jobs: javascript/simple_HTML_editor.js");

        if (!$this->getAttribute('data-buttons')) {
            $this->setButtons(self::$default_buttons);
        }
        if (!$this->getAttribute('data-blockformats')) {
            $this->setBlockFormats(self::$default_blockformats);
        }
        $this->addExtraClass('wysiwyg');

        return parent::FieldHolder($attributes);
    }
}
