<?php

/** @var string $name */
/** @var string $slug */
/** @var string[] $options */

/** @var string $fieldId */
$fieldId = 'spf-meta-' . $slug;

/** @var string $value The current value of the custom field. */
$currentValue = esc_attr(get_post_meta(get_post()->ID, $slug, true));

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
                    <?php $selected = ($option == $currentValue) ? 'selected="selected"' : ''; ?>
                    <option value="<?= $option; ?>" <?= $selected; ?>><?= $option; ?></option>
                <?php endforeach; ?>
            </select>
        </td>
    </tr>
    </tbody>
</table>