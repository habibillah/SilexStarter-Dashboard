<?php

namespace SilexStarter\Admin\Menu;

class MenuItem
{
    /**
     * Menu attributes as listed in the $fields.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Addittional attribute container.
     *
     * @var array
     */
    protected $metaAttributes = [];

    /**
     * Available fields, if user try to set attribute not listed in this fields, it will be discarded.
     *
     * @var array
     */
    protected static $fields = ['url', 'label', 'icon', 'class', 'id', 'name', 'title', 'permission'];

    /**
     * The children menu container.
     *
     * @var null|SilexStarter\Admin\Menu\ChildMenuContainer
     */
    protected $childContainer;

    /**
     * Is menu active.
     *
     * @var bool
     */
    protected $active = false;

    /**
     * Current menu level.
     *
     * @var int
     */
    protected $level = 0;

    public function __construct(array $attributes)
    {
        foreach (static::$fields as $field) {
            $this->attributes[$field] = (isset($attributes[$field])) ? $attributes[$field] : null;
        }

        if (isset($attributes['meta'])) {
            $this->metaAttributes = $attributes['meta'];
        }

        $this->childContainer = new ChildMenuContainer($this);
        $this->childContainer->setLevel($this->level + 1);
    }

    /**
     * Set the menu attributes.
     *
     * @param string $name  the attribute name
     * @param string $value the attribute value
     */
    public function setAttribute($name, $value)
    {
        if (in_array($name, static::$fields)) {
            $this->attributes[$name] = $value;
        }
    }

    /**
     * Get the attibute value.
     *
     * @param string $name the attribute name
     *
     * @return mixed the attribute value
     */
    public function getAttribute($name)
    {
        if (in_array($name, static::$fields)) {
            return $this->attributes[$name];
        }
    }

    /**
     * Get meta attribute of the current menu.
     *
     * @param  string $name the meta attribute name
     *
     * @return mixed
     */
    public function getMetaAttribute($name = null)
    {
        if (is_null($name)) {
            return $this->metaAttributes;
        }

        if (isset($this->metaAttributes[$name])) {
            return $this->metaAttributes[$name];
        }
    }

    /**
     * Set meta attribute of the current menu.
     *
     * @param string $name  attribute name
     * @param mixed  $value attribute value
     */
    public function setMetaAttribute($name, $value)
    {
        $this->metaAttributes[$name] = $value;
    }

    /**
     * Check if the menu is active.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Set the active state of the menu.
     *
     * @param bool $active
     */
    public function setActive($active = true)
    {
        $this->active = $active;
    }

    /**
     * Check if the current item has active children, or grand children.
     *
     * @return boolean
     */
    public function hasActiveChildren(MenuItem $item = null)
    {
        $hasActiveItem = $this->childContainer->hasActiveItem();

        if (!$hasActiveItem) {
            $items = $this->childContainer->getItems();
            foreach ($items as $item) {
                $hasActiveItem = $hasActiveItem || $item->hasActiveChildren();
            }
        }

        return $hasActiveItem;
    }

    /**
     * Check if current item has children.
     *
     * @return boolean
     */
    public function hasChildren()
    {
        return $this->childContainer->hasItem();
    }

    /**
     * Create new MenuItem instance inside the child menu container.
     *
     * @param string $name       menu item name
     * @param array  $attributes menu item attributes
     *
     * @return  MenuItem
     */
    public function addChildren($name, array $attributes)
    {
        return $this->childContainer->createItem($name, $attributes);
    }

    /**
     * Get the Children menu container object *deprecated*.
     *
     * @return ChildMenuContainer
     */
    public function getChildContainer()
    {
        return $this->childContainer;
    }

    /**
     * Get child item if name is specified, else return the container
     *
     * @param  string $name                 menu item name
     * @return MenuItem|ChildMenuContainer  menu item or menu item container
     */
    public function getChildren($name = null)
    {
        if (!$name) {
            return $this->childContainer;
        } else {
            return $this->childContainer->getItem($name);
        }
    }

    /**
     * Get current level of the menu.
     *
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set the current level of item
     *
     * @param int $level The current level of menu item
     */
    public function setLevel($level)
    {
        $this->level = $level;
        $this->childContainer->setLevel($level + 1);
    }

    /**
     * The attribute getter
     *
     * @param  string $name attribute name
     *
     * @return mixed        attribute value
     */
    public function __get($name)
    {
        if ($name === 'meta') {
            return $this->getMetaAttribute();
        }

        return $this->getAttribute($name);
    }

    /**
     * The attribute setter
     *
     * @param string $name  attribute name
     * @param mixed  $value attribute value
     */
    public function __set($name, $value)
    {
        return $this->setAttribute($name, $value);
    }
}
