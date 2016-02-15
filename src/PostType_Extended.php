<?php
/**
 * Created by IntelliJ IDEA.
 * User: emanuele
 * Date: 01/12/15
 * Time: 10:26
 */

namespace theantichris\SPF;


class PostType_Extended extends PostType
{
	/** @var string[] An array of labels for this post type. */
	private $labels;
	/** @var string A short descriptive summary of what the post type is. */
	private $description;
	/** @var bool Whether a post type is intended to be used publicly either via the admin interface or by front-end users. */
	private $public = true;
	/** @var int The position in the menu order the post type should appear. */
	private $menuPosition;
	/** @var  string The url to the icon to be used for this menu or the name of the icon from the iconfont */
	private $menuIcon;
	/** @var string[] Capabilities to set for the post type. */
	/** @var string[]|bool $supports Registers support of certain features for a given post type. */
	private $supports = array('title', 'editor');

	function __construct($name, $slug)
	{
		$this->name   = $name;
		$this->slug   = $slug;
		$this->labels = $this->setLabels();

		add_action('init', array($this, 'registerPostType'));
	}

	/**
	 * Sets up the labels for the post type..
	 *
	 * @since 3.0.0
	 *
	 * @return string[]
	 */
	private function setLabels()
	{
		$singular = Helper::makeSingular($this->name);

		$textDomain = parent::$textDomain;

		$labels = array(
			'name'               => __($this->name, $textDomain),
			'singular_name'      => __($singular, $textDomain),
			'add_new'            => __('Add New', $textDomain),
			'add_new_item'       => __('Add New ' . $singular, $textDomain),
			'edit_item'          => __('Edit ' . $singular, $textDomain),
			'new_item'           => __('New ' . $singular, $textDomain),
			'all_items'          => __('All ' . $this->name, $textDomain),
			'view_item'          => __('View ' . $singular, $textDomain),
			'search_items'       => __('Search ' . $this->name, $textDomain),
			'not_found'          => __('No ' . strtolower($this->name) . ' found.', $textDomain),
			'not_found_in_trash' => __('No ' . strtolower($this->name) . ' found in Trash.', $textDomain),
			'parent_item_colon'  => '',
			'menu_name'          => __($this->name, $textDomain)
		);

		return $labels;
	}

	/**
	 * Calls the WordPress function register_post_type() if the post type does not already exist.
	 * This function should not be called directly. It is only public so WordPress can call it.
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */
	/**
	 * Sets $capabilities if all capabilities are valid.
	 *
	 * @since 3.0.0
	 *
	 * @param string[] $capabilities An array of the capabilities for this post type.
	 * @return PostType
	 */
	public function setSupports($supports)
	{
		if ($supports === true) {
			wp_die(__("The supports option must be an array or false", parent::$textDomain));
		}

		$this->supports = $supports;

		return $this;
	}

	public function setCapabilities($capabilities)
	{
		return wp_die(__("Setting capabilities for PostType_Extended objects is forbidden"), parent::$textDomain);
	}

	public function registerPostType()
	{
		if (!post_type_exists($this->getSlug())) {
			$arguments = array(
				'labels'        => $this->labels,
				'description'   => $this->description,
				'public'        => $this->public,
				'menu_position' => $this->menuPosition,
				'menu_icon'     => $this->menuIcon,
				'capability_type'  => $this->getSlug(),
				'supports'      => $this->supports,
				'map_meta_cap'  => true
			);

			register_post_type($this->getSlug(), $arguments);
		}
	}
}
