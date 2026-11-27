<?php
/**
 * Villa tag: a short optional label (e.g. "Opening year") set per villa.
 *
 * Each language version of a villa is its own post, so the tag is typed in
 * the language of that version (EN / FR / IT). Left empty, nothing shows.
 * Displayed on the villa card, the map popup (villas list) and the villa hero.
 */

add_action( 'acf/init', function () {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) return;

	acf_add_local_field_group( [
		'key'      => 'group_villa_tag',
		'title'    => 'Villa tag',
		'fields'   => [
			[
				'key'          => 'field_villa_tag',
				'label'        => 'Tag',
				'name'         => 'villa_tag',
				'type'         => 'text',
				'maxlength'    => 40,
				'placeholder'  => 'e.g. Opening year',
				'instructions' => 'Short label shown on the villa card, the map and the top of the villa page. Write it in this page\'s language. Leave empty for no tag.',
			],
		],
		'location' => [ [ [
			'param'    => 'post_type',
			'operator' => '==',
			'value'    => 'villa',
		] ] ],
		'position'        => 'side',
		'label_placement' => 'top',
	] );
} );

/** The tag text for a villa, or '' when none is set. */
function plh_villa_tag( $post_id = null ) {
	if ( ! function_exists( 'get_field' ) ) return '';
	$tag = get_field( 'villa_tag', $post_id ?: get_the_ID() );
	return is_string( $tag ) ? trim( $tag ) : '';
}
