<?php

/** @var string $name */
/** @var string $slug */

$slug = 'spf-meta-' . $slug;

/** @var string $value The current value of the custom field. */
$value = esc_attr(get_post_meta(get_post()->ID, $slug, true));

?>

<label for="<?= $slug; ?>"><?= $name; ?></label>
<input type="text" name="<?= $slug; ?>" id="<?= $slug; ?>" placeholder="<?= $default; ?>" value="<?= $value; ?>"/>
