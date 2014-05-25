<?php

namespace theantichris\WpPluginFramework;

/**
 * Class SettingsField
 * @package theantichris\WpPluginFramework
 * @since 1.2.0
 */
class SettingsField
{
    /** @var  string */
    private $id;
    /** @var  string */
    private $title;
    /** @var  mixed[] */
    private $args;
    /** @var  string */
    private $callback; // TODO: Display function handled by the View parameter.
    /** @var  string */
    private $page; // TODO: Will be supplied in the settings object.
    /** @var  string */
    private $section; // TODO: Will be supplied in the settings object.
} 