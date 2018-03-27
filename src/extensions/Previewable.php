<?php

namespace gorriecoe\Preview\Extensions;

use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataExtension;
use gorriecoe\Preview\View\Preview;

/**
 * Adds preview options to object.
 * This lets us inherit the options from the
 * page if not defined in the object itself.
 *
 * @package silverstripe-preview
 */
class Previewable extends DataExtension
{
    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'PreviewTitle' => 'Text',
        'PreviewSummary' => 'Text',
        'PreviewLabel' => 'Varchar(255)'
    ];

    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = [
        'PreviewImage' => Image::class
    ];

    /**
     * Define the default values for all the $db fields
     * @var array
     */
    private static $defaults = [
        'PreviewLabel' => 'Read more'
    ];

    /**
     * Update Fields
     * @return FieldList
     */
    public function updateCMSFields(FieldList $fields)
    {
        // Prevent field scaffolding from adding these fields.
        $fields->removeByName([
            'PreviewTitle',
            'PreviewImage',
            'PreviewSummary',
            'PreviewLabel'
        ]);

        $fields->addFieldsToTab(
            'Root.Preview',
            array(
                UploadField::create(
                    'PreviewImage',
                    _t(__CLASS__ . '.IMAGE', 'Image')
                ),
                TextField::create(
                    'PreviewTitle',
                    _t(__CLASS__ . '.TITLE', 'Title')
                ),
                TextareaField::create(
                    'PreviewSummary',
                    _t(__CLASS__ . '.SUMMARY', 'Summary')
                )
                ->setRows(3),
                TextField::create(
                    'PreviewLabel',
                    _t(__CLASS__ . '.LABEL', 'Label')
                )
            )
        );

        $fields->fieldByName('Root.Preview')->setTitle(_t(__CLASS__ . '.TABLABEL', 'Preview Content'));

        return $fields;
    }

    public function getPreview()
    {
        $config = $this->owner->config();
        $preview = Preview::create($this->owner)
            ->setImage($config->get('preview_image') ? : 'PreviewImage')
            ->setTitle($config->get('preview_title') ? : ['PreviewTitle','MenuTitle','Title'])
            ->setSummary($config->get('preview_summary') ? : ['PreviewSummary','Content'])
            ->setLabel($config->get('preview_label') ? : 'PreviewLabel');
        return $preview;
    }
}
