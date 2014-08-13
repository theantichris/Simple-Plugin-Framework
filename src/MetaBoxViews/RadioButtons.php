<?php

/** @var string $name */
/** @var string $slug */
/** @var string[] $values */

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
            <?php foreach ($values as $value) : ?>
                <?php $checked = ($value == $currentValue) ? 'checked="checked"' : ''; ?>
                <input type="radio" name="<?= $fieldId; ?>" value="<?= $value; ?>" <?= $checked; ?>/> <?= $value; ?>
            <?php endforeach; ?>
        </td>
    </tr>
    </tbody>
</table>