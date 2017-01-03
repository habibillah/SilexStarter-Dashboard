<?php

namespace SilexStarter\Admin\Menu;

use Exception;

class MenuManager
{
    /**
     * A list of MenuContainer object.
     *
     * @var array of SilexStarter\Admin\Menu\MenuContainer
     */
    protected $menuContainers = [];

    /**
     * Create new MenuContainer object and assign to menu container lists.
     *
     * @param string $name MenuContainer name
     *
     * @return SilexStarter\Admin\Menu\MenuContainer
     */
    public function create($name)
    {
        $this->menuContainers[$name] = new MenuContainer($name);

        return $this->menuContainers[$name];
    }

    public function createFromArray(array $menu) {

    }

    /**
     * Get MenuContainer object based on it's name.
     *
     * @param string $name MenuContainer name
     *
     * @return SilexStarter\Admin\Menu\MenuContainer
     */
    public function get($name)
    {
        if (isset($this->menuContainers[$name])) {
            return $this->menuContainers[$name];
        }

        throw new Exception("Can not find menu with name: $name");

    }

    /**
     * Render specified MenuContainer.
     *
     * @param string $name MenuContainer name
     *
     * @return string
     */
    public function render($name)
    {
        return $this->get($name)->render();
    }
}
