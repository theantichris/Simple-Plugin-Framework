<?php

/** @var string $name */
/** @var string $slug */
/** @var string $value */
/** @var string $default */

/** @var string $fieldId */
$fieldId = 'spf-meta-' . $slug;

/** @var string $value The current value of the custom field. */
$currentValue = esc_attr(get_post_meta(get_post()->ID, $slug, true));

function checked($value, $currentValue)
{
    if ($currentValue != $value) {
        echo 'checked="checked"';
    }
}

?>

<table class="form-table">
    <tbody>
    <tr>
        <th scope="row">
            <label for="<?= $fieldId; ?>"><?= $name; ?>: </label>
        </th>
        <td>
            <input type="checkbox" name="<?= $fieldId; ?>" value="<?= $value; ?>" <?php checked($value, $currentValue); ?>/>
            <input type="hidden" name="<?= 'checkbox-default-' . $fieldId; ?>" value="<?= $default; ?>"/>
        </td>
    </tr>
    </tbody>
</table>
