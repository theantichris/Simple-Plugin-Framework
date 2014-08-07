<?php

/** @var string $name */
/** @var string $slug */

/** @var string $fieldName */
$fieldName = 'spf-meta-' . $slug;

/** @var string $value The current value of the custom field. */
$value = esc_attr(get_post_meta(get_post()->ID, $slug, true));

?>

<input type="text" name="<?= $fieldName; ?>" id="<?= $fieldName; ?>" value="<?= $value; ?>"/>
