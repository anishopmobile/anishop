<?php
/**
 * Quantity input with stepper buttons.
 *
 * Provides $type, $input_name, $input_value, $max_value, $min_value, $step, $pattern, $inputmode, $placeholder, $classes.
 *
 * @package Anishop
 */

defined( 'ABSPATH' ) || exit;

if ( ! isset( $type ) ) {
	$type = 'text';
}

if ( null === $input_value ) {
	$input_value = 1;
}

$anishop_max = ( 0 < $max_value ) ? $max_value : '';
?>
<div class="quantity anishop-qty">
	<button type="button" class="qty-btn qty-plus" aria-label="<?php esc_attr_e( 'افزایش', 'anishop' ); ?>">+</button>
	<input
		type="<?php echo esc_attr( $type ); ?>"
		<?php echo ( ! empty( $classes ) ) ? 'class="' . esc_attr( join( ' ', (array) $classes ) ) . '"' : ''; ?>
		name="<?php echo esc_attr( $input_name ); ?>"
		value="<?php echo esc_attr( $input_value ); ?>"
		title="<?php echo esc_attr_x( 'تعداد', 'Product quantity input title', 'anishop' ); ?>"
		size="4"
		min="<?php echo esc_attr( $min_value ); ?>"
		max="<?php echo esc_attr( $anishop_max ); ?>"
		<?php if ( $step && 'any' !== $step ) : ?>
			step="<?php echo esc_attr( $step ); ?>"
		<?php endif; ?>
		placeholder="<?php echo esc_attr( $placeholder ?? '' ); ?>"
		inputmode="<?php echo esc_attr( $inputmode ?? 'numeric' ); ?>"
		autocomplete="off"
	>
	<button type="button" class="qty-btn qty-minus" aria-label="<?php esc_attr_e( 'کاهش', 'anishop' ); ?>">−</button>
</div>
