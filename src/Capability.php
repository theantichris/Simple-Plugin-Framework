<?php

namespace theantichris\WpPluginFramework;

/**
 * Class Capability
 *
 * An enum of all valid WordPress capabilities.
 * @link http://codex.wordpress.org/Roles_and_Capabilities#Capabilities
 *
 * @package theantichris\WpPluginFramework
 * @since 3.0.0
 */
abstract class Capability
{
    const switch_themes          = 'switch_themes';
    const edit_themes            = 'edit_themes';
    const edit_theme_options     = 'edit_theme_options';
    const install_themes         = 'install_themes';
    const activate_plugins       = 'activate_plugins';
    const edit_plugins           = 'edit_plugins';
    const install_plugins        = 'install_plugins';
    const edit_users             = 'edit_users';
    const edit_files             = 'edit_files';
    const manage_options         = 'manage_options';
    const moderate_comments      = 'moderate_comments';
    const manage_categories      = 'manage_categories';
    const manage_links           = 'manage_links';
    const upload_files           = 'upload_files';
    const import                 = 'import';
    const unfiltered_html        = 'unfiltered_html';
    const edit_posts             = 'edit_posts';
    const edit_others_posts      = 'edit_others_posts';
    const edit_published_posts   = 'edit_published_posts';
    const publish_posts          = 'publish_posts';
    const edit_pages             = 'edit_pages';
    const read                   = 'read';
    const read_posts             = 'read_posts';
    const publish_pages          = 'publish_pages';
    const edit_others_pages      = 'edit_others_pages';
    const edit_published_pages   = 'edit_published_pages';
    const delete_pages           = 'delete_pages';
    const delete_others_pages    = 'delete_others_pages';
    const delete_published_pages = 'delete_published_pages';
    const delete_posts           = 'delete_posts';
    const delete_others_posts    = 'delete_others_posts';
    const delete_published_posts = 'delete_published_posts';
    const delete_private_posts   = 'delete_private_posts';
    const edit_private_posts     = 'edit_private_posts';
    const read_private_posts     = 'read_private_posts';
    const delete_private_pages   = 'delete_private_pages';
    const edit_private_pages     = 'edit_private_pages';
    const read_private_pages     = 'read_private_pages';
    const delete_users           = 'delete_users';
    const create_users           = 'create_users';
    const unfiltered_upload      = 'unfiltered_upload';
    const edit_dashboard         = 'edit_dashboard';
    const update_plugins         = 'update_plugins';
    const delete_plugins         = 'delete_plugins';
    const update_themes          = 'update_themes';
    const update_core            = 'update_core';
    const list_users             = 'list_users';
    const remove_users           = 'remove_users';
    const add_users              = 'add_users';
    const promote_users          = 'promote_users';
    const delete_themes          = 'delete_themes';
    const export                 = 'export';
    const edit_comment           = 'edit_comment';
    const manage_network         = 'manage_network';
    const manage_sites           = 'manage_sites';
    const manage_network_users   = 'manage_network_users';
    const manage_network_themes  = 'manage_network_themes';
    const manage_network_options = 'manage_network_options';

    /**
     * Checks if a given value is a valid member of the fake enum.
     *
     * @since 3.0.0
     *
     * @param string $value
     * @return bool
     */
    public static function isValid($value)
    {
        return defined("self::{$value}");
    }
}