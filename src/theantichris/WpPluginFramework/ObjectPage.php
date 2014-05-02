<?php

namespace theantichris\WpPluginFramework;

/**
 * Class ObjectPage
 *
 * A class for adding a top level WordPress page and adding it to the menu on the object level.
 *
 * @package theantichris\WpPluginFramework
 *
 * @since 0.1.0
 */
class ObjectPage extends Page {
	/**
	 * Add the page to WordPress.
	 *
	 * @since 4.0.0
	 *
	 * @return void
	 */
	public function addPage() {
		add_object_page( $this->pageTitle, $this->pageTitle, $this->capability, $this->pageSlug, array( $this, 'displayPage' ), $this->menuIcon );
	}
}