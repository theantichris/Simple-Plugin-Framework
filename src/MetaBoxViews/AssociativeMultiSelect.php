<?php

/** @var string $name */
/** @var string $slug */
/** @var string[] $options */

/** @var string $fieldId */
$fieldId = 'spf-multi-meta-' . $slug;

/** @var string $value The current value of the custom field. */
$currentValue = get_post_meta(get_post()->ID, $slug, true);
$currentValue = json_decode($currentValue);
?>

<table class="form-table">
    <tbody>
    <tr>
        <th scope="row">
            <label for="<?= $fieldId; ?>"><?= $name; ?>: </label>
        </th>
        <td>
            <select multiple name="<?= $fieldId; ?>[]">
                <?php if (is_array($options)) { foreach ($options as $option=>$description) : ?>
                    <?php $selected = (in_array($option,$currentValue)) ? 'selected="selected"' : ''; ?>
                    <option value="<?= $option; ?>" <?= $selected; ?>><?= $description; ?></option>
                <?php endforeach; } ?>
            </select>
        </td>
    </tr>
    </tbody>
</table>
