<?php

/** @var string $name */
/** @var string $slug */
/** @var string[] $options */

/** @var string $fieldId */
$fieldId = 'spf-meta-' . $slug;

/** @var string $value The current value of the custom field. */
$currentValue = esc_attr(get_post_meta(get_post()->ID, $slug, true));

function selected($option, $currentValue)
{
    if ($option == $currentValue) {
        echo 'selected="selected"';
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
            <select name="<?= $fieldId; ?>">
                <?php foreach ($options as $option) : ?>
                    <option value="<?= strtolower($option); ?>" <?php selected($option, $currentValue); ?>><?= $option; ?></option>
                <?php endforeach; ?>
            </select>
        </td>
    </tr>
    </tbody>
</table>