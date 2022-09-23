<?php

namespace Newageerp\SfReactTemplates\CoreTemplates\Buttons;

use Newageerp\SfReactTemplates\CoreTemplates\Modal\Menu;
use Newageerp\SfReactTemplates\Template\Template;

class ToolbarButtonWithMenu extends Template
{
    protected MainButton $button;
    protected Menu $menu;

    public function __construct(MainButton $button, Menu $menu)
    {
        $this->button = $button;
        $this->menu = $menu;
    }

    public function getProps(): array
    {
        return [
            'button' => $this->getButton()->toArray(),
            'menu' => $this->getMenu()->toArray(),
        ];
    }

    public function getTemplateName(): string
    {
        return 'buttons.toolbar-button-with-menu';
    }


    /**
     * Get the value of button
     *
     * @return MainButton
     */
    public function getButton(): MainButton
    {
        return $this->button;
    }

    /**
     * Set the value of button
     *
     * @param MainButton $button
     *
     * @return self
     */
    public function setButton(MainButton $button): self
    {
        $this->button = $button;

        return $this;
    }

    /**
     * Get the value of menu
     *
     * @return Menu
     */
    public function getMenu(): Menu
    {
        return $this->menu;
    }

    /**
     * Set the value of menu
     *
     * @param Menu $menu
     *
     * @return self
     */
    public function setMenu(Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
    }
}
