<?php

namespace theantichris\WpPluginFramework;

/**
 * Class SubMenuPage
 *
 * A class for adding and removing a sub menu page from the WordPress Dashboard. Extends Page.
 *
 * @package theantichris\WpPluginFramework
 *
 * @since 0.1.0
 */
class SubMenuPage extends Page {
	/**
	 * Adds the page to WordPress.
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */
	public function addPage() {
		add_submenu_page( $this->parentSlug, $this->pageTitle, $this->pageTitle, $this->capability, $this->pageSlug, array( $this, 'displayPage' ) );
	}

	/**
	 * Removes a page from WordPress.
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */
	public function removePage() {
		remove_submenu_page( $this->parentSlug, $this->pageSlug );
	}
}