<?php

namespace Xsanisty\Admin\Menu;

use Xsanisty\Admin\Contracts\MenuRendererInterface;

class MenuRenderer implements MenuRendererInterface
{
    protected $menu;

    /**
     * Render menu container into formatted html.
     *
     * @param  MenuContainer $menu MenuContainer object
     * @return string              html formatted string
     */
    public function render(MenuContainer $menu)
    {
        return $this->createHtml($menu);
    }

    protected function createHtml(MenuContainer $menu)
    {
        $format = '<li class="%s" id="%s"><a href="%s">%s  %s</a> %s </li>';
        $html   = ($menu->getLevel() == 0) ? '<ul class="sidebar">' : '<ul>';
        foreach ($menu->getItems() as $item) {
            $html .= sprintf(
                $format,
                $item->getAttribute('class'),
                $item->getAttribute('id'),
                $item->getAttribute('url'),
                $item->getAttribute('label'),
                ($item->getAttribute('icon')) ? '<span class="menu-icon glyphicon glyphicon-'.$item->getAttribute('icon').'"></span>' : '',
                $this->createHtml($item->getChildContainer())
            );
        }
        $html .= '</ul>';

        return $html;
    }
}
