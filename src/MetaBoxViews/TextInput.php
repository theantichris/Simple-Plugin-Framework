<?php

/** @var string $name */
/** @var string $slug */

/** @var string $fieldId */
$fieldId = 'spf-meta-' . $slug;

/** @var string $value The current value of the custom field. */
$value = esc_attr(get_post_meta(get_post()->ID, $slug, true));

?>

<div>
    <label for="<?= $fieldId; ?>"><?= $name; ?>:
        <input type="text" name="<?= $fieldId; ?>" value="<?= $value; ?>"/></label>
</div>
