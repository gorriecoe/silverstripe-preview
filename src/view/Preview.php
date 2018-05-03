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
     * @param DataObject $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
        return $this;
    }

    /**
     * @param array $value
     * @return Preview $this
     */
    public function setValue($field, $value = [], $owner)
    {
        if (!isset($this->fields[$field])) {
            $this->fields[$field] = [];
        }
        $this->fields[$field][] = [
            'fields' => is_array($value) ? $value : [$value],
            'owner' => $owner ? $owner : $this->owner
        ];
    }

    /**
     * @return String
     */
    public function getValue($field)
    {
        if (isset($this->fields[$field])) {
            foreach (array_reverse($this->fields[$field]) as $key => $fieldgroup) {
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
        }
    }

    /**
     * @param array $value
     * @return Preview $this
     */
    public function setImage($value = [], $owner = null)
    {
        $this->setValue('image', $value, $owner);
        return $this;
    }

    /**
     * @return Image
     */
    public function getImage()
    {
        return $this->getValue('image');
    }

    /**
     * @param array $value
     * @return Preview $this
     */
    public function setTitle($value = [], $owner = null)
    {
        $this->setValue('title', $value, $owner);
        return $this;
    }

    /**
     * @return String
     */
    public function getTitle()
    {
        return $this->getValue('title');
    }

    /**
     * @param array $value
     * @return Preview $this
     */
    public function setSummary($value = [], $owner = null)
    {
        $this->setValue('summary', $value, $owner);
        return $this;
    }

    /**
     * @return String
     */
    public function getSummary()
    {
        return $this->getValue('summary');
    }

    /**
     * @param array $value
     * @return Preview $this
     */
    public function setLabel($value = [], $owner = null)
    {
        $this->setValue('label', $value, $owner);
        return $this;
    }

    /**
     * @return String
     */
    public function getLabel()
    {
        return $this->getValue('label');
    }

    /**
     * @return String
     */
    public function getLinkURL()
    {
        return $this->owner->Link();
    }

    /**
     * @return String
     */
    public function getLink()
    {
        return $this->owner->Link();
    }
}
