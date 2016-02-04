<?php

/** @var string $name */
/** @var string $slug */
/** @var string[] $options */
/** @var bool $displayBlock */

/** @var string $fieldId */
$fieldId = 'spf-meta-' . $slug;

/** @var string $value The current value of the custom field. */
$currentValue = esc_attr( get_post_meta( get_post()->ID, $slug, true ) );

?>

<table class="form-table">
	<tbody>
	<tr>
		<th scope="row">
			<label for="<?= $fieldId; ?>"><?= $name; ?>: </label>
		</th>
		<td>
			<?php foreach ( $options as $option ) : ?>
				<?php $checked = ( $option['value'] == $currentValue ) ? 'checked="checked"' : ''; ?>
				<?php if ( $displayBlock ): ?>
					<div>
				<?php endif; ?>

				<input type="radio" name="<?= $fieldId; ?>" value="<?= $option['value']; ?>" <?= $checked; ?>/> <?= $option['display']; ?>

				<?php if ( $displayBlock ): ?>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
		</td>
	</tr>
	</tbody>
</table>