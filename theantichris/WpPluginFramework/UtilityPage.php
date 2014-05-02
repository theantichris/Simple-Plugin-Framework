<?php

namespace theantichris\WpPluginFramework;

/**
 * Class UtilityPage
 *
 * A class for adding a top level page to the WordPress Dashboard at the utility level.
 *
 * @package theantichris\WpPluginFramework
 *
 * @since 0.1.0
 */
class UtilityPage extends Page {
	/**
	 * Add the page to WordPress.
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */
	public function addPage() {
		add_utility_page( $this->pageTitle, $this->pageTitle, $this->capability, $this->pageSlug, array( $this, 'displayPage' ), $this->menuIcon );
	}
}