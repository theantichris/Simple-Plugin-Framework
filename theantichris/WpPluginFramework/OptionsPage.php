<?php

namespace theantichris\WpPluginFramework;

/**
 * Class OptionsPage
 *
 * A class for adding an options page to the WordPress Dashboard. Extends Page.
 *
 * @package theantichris\WpPluginFramework
 *
 * @since 0.1.0
 */
class OptionsPage extends Page
{
    /**
     * Add the page to WordPress.
     *
     * @since 0.1.0
     *
     * @return void
     */
    public function addPage()
    {
        add_options_page($this->title, $this->title, $this->capability, $this->getSlug(), array($this, 'display'));
    }
}