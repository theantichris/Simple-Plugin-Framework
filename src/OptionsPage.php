<?php

namespace theantichris\SPF;

/**
 * Class OptionsPage
 *
 * A class for adding a sub menu page to the Settings menu.
 *
 * @package theantichris\SPF
 *
 * @since 0.1.0
 */
class OptionsPage extends Page
{
    /**
     * Calls the WordPress add_options_page() function.
     * Should not be called directly. It is only public so WordPress can call it.
     * @link http://codex.wordpress.org/Function_Reference/add_options_page
     *
     * @since 0.1.0
     *
     * @return void
     */
    public function addPage()
    {
        $name = $this->getName();
        add_options_page($name, $name, $this->capability, $this->getSlug(), array($this, 'display'));
    }
}