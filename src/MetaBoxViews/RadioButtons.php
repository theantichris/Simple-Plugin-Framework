<?php

/** @var string $name */
/** @var string $slug */
/** @var string[] $values */

/** @var string $fieldId */
$fieldId = 'spf-meta-' . $slug;

/** @var string $value The current value of the custom field. */
$currentValue = esc_attr(get_post_meta(get_post()->ID, $slug, true));

if ($value == $currentValue) {
    $checked = 'checked="checked"';
} else {
    $checked = '';
}

?>

<table class="form-table">
    <tbody>
    <tr>
        <th scope="row">
            <label for="<?= $fieldId; ?>"><?= $name; ?>: </label>
        </th>
        <td>
            <?php foreach ($values as $value) : ?>
                <input type="radio" name="<?= $fieldId; ?>" value="<?= $value; ?>" <?= $checked; ?>/>
            <?php endforeach; ?>
        </td>
    </tr>
    </tbody>
</table>