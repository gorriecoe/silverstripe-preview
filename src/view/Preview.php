<?php

namespace gorriecoe\Preview\View;

use SilverStripe\View\ViewableData;

/**
 * Preview
 *
 * @package silverstripe-preview
 */
class Preview extends ViewableData
{
    protected $owner = null;

    protected $fields = [];

    public function __construct($owner)
    {
        $this->owner = $owner;
        parent::__construct($owner);
    }

    /**
     * @param array $value
     */
    public function __set($name, $value = [])
    {
        if ($name == 'Owner') {
            $this->owner = $value;
            return $this;
        }
        if (!isset($this->fields[$name])) {
            $this->fields[$name] = [];
        }
        $this->fields[$name][] = [
            'fields' => is_array($value) ? $value : [$value],
            'owner' => $this->owner
        ];
    }

    /**
     * @return Mixed
     */
    public function __get($name)
    {
        if (in_array($name, ['Link', 'LinkURL'])) {
            return $this->owner->Link();
        }
        if (isset($this->fields[$name])) {
            foreach (array_reverse($this->fields[$name]) as $key => $fieldgroup) {
                if (isset($fieldgroup['fields'])) {
                    foreach ($fieldgroup['fields'] as $fieldgroupKey => $fieldgroupValue) {
                        if ($value = $fieldgroup['owner']->relField($fieldgroupValue)) {
                            if (is_object($value)) {
                                if ($value->exists()) {
                                    return $value;
                                }
                            } else {
                                return $value;
                            }
                        }
                    }
                }
            }
        } else {
            return $this->owner->getField($name);
        }
    }
}
