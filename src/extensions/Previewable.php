<?php

namespace gorriecoe\Preview\Extensions;

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
    protected $preview_data_defaults = [
        'Title' => [
            'MenuTitle',
            'Title'
        ],
        'Content' => 'Content'
    ];

    public function getPreview()
    {
        $config = $this->owner->config();
        $preview = Preview::create($this->owner);
        $data = $config->get('preview_data') ? : $this->preview_data_defaults;
        foreach ($data as $key => $fields) {
            $preview->{$key} = $fields;
        }
        return $preview;
    }
}
