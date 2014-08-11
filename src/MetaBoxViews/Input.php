<?php

/** @var string $name */
/** @var string $slug */
/** @var string $attributes */

/** @var string $fieldId */
$fieldId = 'spf-meta-' . $slug;

/** @var string $value The current value of the custom field. */
$value = esc_attr(get_post_meta(get_post()->ID, $slug, true));

?>

<table class="form-table">
    <tbody>
    <tr>
        <th scope="row">
            <label for="<?= $fieldId; ?>"><?= $name; ?>: </label>
        </th>
        <td>
            <input type="<?= $type; ?>" name="<?= $fieldId; ?>" <?= $attributes; ?> value="<?= $value; ?>"/>
        </td>
    </tr>
    </tbody>
</table>
