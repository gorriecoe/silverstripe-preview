<?php

namespace gorriecoe\Preview\Extensions;

use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataExtension;

/**
 * Adds preview options to object.
 * This lets us inherit the options from the
 * page if not defined in the object itself.
 *
 * @package silverstripe-preview
 */
class PreviewDefaultFields extends DataExtension
{
    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'PreviewTitle' => 'Text',
        'PreviewContent' => 'Text',
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
     * Relationship version ownership
     * @var array
     */
    private static $owns = [
        'PreviewImage'
    ];

    /**
     * Define the default values for all the $db fields
     * @var array
     */
    private static $defaults = [
        'PreviewLabel' => 'Read more'
    ];

    private static $preview_data = [
        'Image' => 'PreviewImage',
        'Title' => [
            'PreviewTitle',
            'MenuTitle',
            'Title'
        ],
        'Content' => [
            'PreviewContent.Plain',
            'Content.Plain'
        ],
        'Label' => 'PreviewLabel',
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
            'PreviewContent',
            'PreviewLabel'
        ]);

        $fields->addFieldsToTab(
            'Root.Summary',
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
                    'PreviewContent',
                    _t(__CLASS__ . '.CONTENT', 'Content')
                )
                ->setRows(3),
                TextField::create(
                    'PreviewLabel',
                    _t(__CLASS__ . '.LABEL', 'Label')
                )
            )
        );

        $fields->fieldByName('Root.Summary')->setTitle(_t(__CLASS__ . '.TABLABEL', 'Summary'));

        return $fields;
    }
}
