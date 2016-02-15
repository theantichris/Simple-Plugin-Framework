<?php

/** @var string $name */
/** @var string $slug */
/** @var string[] $options */

/** @var string $fieldId */
$fieldId = 'spf-meta-' . $slug;
$datalistId = $fieldId.'-datalist';

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
            <input list="<?= $datalistId  ?>" name="<?= $fieldId; ?>" value="<?= $value; ?>"/>
			<datalist id="<?= $datalistId; ?>">
				<?php foreach ($options as $option) : ?>
					<option value="<?= $option; ?>"><?= $option; ?></option>
				<?php endforeach; ?>
			</datalist>
		</td>
    </tr>
    </tbody>
</table>
