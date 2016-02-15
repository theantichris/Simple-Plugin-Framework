<?php
/**
 * Created by IntelliJ IDEA.
 * User: emanuele
 * Date: 22/11/15
 * Time: 18:30
 */

namespace theantichris\SPF;

class MetaBox_Extended extends MetaBox
{
	function __construct($name, $postTypes, $viewFile, $viewData = array())
	{
		parent::__construct($name, $postTypes, $viewFile, $viewData);
		add_action('save_post', array($this, 'saveMetaBox_Extended'));
	}

	public static function MultiSelectInput($name, $slug, $options)
	{
		$viewData = array(
			'name'    => $name,
			'slug'    => $slug,
			'options' => $options,
		);

		View::render(__DIR__ . '/MetaBoxViews/MultiSelect.php', $viewData);
	}

	public static function AssociativeSelectInput($name, $slug, $options)
	{
		$viewData = array(
			'name'    => $name,
			'slug'    => $slug,
			'options' => $options,
		);

		View::render(__DIR__ . '/MetaBoxViews/AssociativeSelect.php', $viewData);
	}

	public static function AssociativeMultiSelectInput($name, $slug, $options)
	{
		$viewData = array(
			'name'    => $name,
			'slug'    => $slug,
			'options' => $options,
		);

		View::render(__DIR__ . '/MetaBoxViews/AssociativeMultiSelect.php', $viewData);
	}

	public static function AutoCompleteInput($name, $slug, $options)
	{
		$viewData = array(
			'name'    => $name,
			'slug'    => $slug,
			'options' => $options,
		);

		View::render(__DIR__ . '/MetaBoxViews/AutoCompleteInput.php', $viewData);
	}

	public static function AssociativeAutoCompleteInput($name, $slug, $options)
	{
		$viewData = array(
			'name'    => $name,
			'slug'    => $slug,
			'options' => $options,
		);

		View::render(__DIR__ . '/MetaBoxViews/AssociativeAutoCompleteInput.php', $viewData);
	}

	public static function ConstrainedNumberInput($name, $slug, $min='', $max='', $value='')
	{
		$viewData = array(
			'name'       => $name,
			'slug'       => $slug,
			'attributes' => ' min="' . $min . '"' . ' max="' . $max . '"' . ' value="' . $value . '"',
		);

		View::render(__DIR__ . '/MetaBoxViews/ConstrainedNumber.php', $viewData);
	}

	public function saveMetaBox_Extended($postId)
	{
		foreach ($_POST as $key => $value)
		{
			if ( strpos( $key, 'spf-multi-meta-' ) !== false ) {
				$key = str_replace( 'spf-multi-meta-', '', $key );
				update_post_meta( $postId, $key, json_encode($value) );
			}
		}
	}
}
