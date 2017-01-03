<?php

namespace Xsanisty\Admin\Menu;

class ChildMenuContainer extends MenuContainer
{
    /**
     * Parent Item
     *
     * @var Xsanisty\Admin\Menu\MenuItem
     */
    protected $parent;

    /**
     * Build the child container object.
     *
     * @param MenuItem $parent parent item
     */
    public function __construct(MenuItem $parent)
    {
        $this->parent = $parent;
    }

    /**
     * Add new MenuItem object into container item lists.
     *
     * @param Xsanisty\Admin\Menu\MenuItem $menu MenuItem object
     */
    public function addItem(MenuItem $menu, array $options = [])
    {
        parent::addItem($menu, $options);
        $menu->setLevel($this->level);
    }
}
