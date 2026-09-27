<?php
/**
 * Meta box engine and field registration.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns the meta box field registry (post type → boxes → fields).
 *
 * @return array<string, array<string, array<string, mixed>>>
 */
function llb_meta_box_config() {
	return array(
		'dienst'  => array(
			'llb_service_hero'     => array(
				'title'    => __( 'Service hero', 'll-bouwgroep' ),
				'context'  => 'normal',
				'priority' => 'high',
				'fields'   => array(
					array(
						'key'         => '_llb_hero_title',
						'type'        => 'text',
						'label'       => __( 'Hero title (H1)', 'll-bouwgroep' ),
						'description' => __( 'If empty, the service title is used.', 'll-bouwgroep' ),
					),
					array(
						'key'   => '_llb_hero_intro',
						'type'  => 'textarea',
						'label' => __( 'Hero intro', 'll-bouwgroep' ),
					),
				),
			),
			'llb_service_overview' => array(
				'title'    => __( 'Services overview page', 'll-bouwgroep' ),
				'context'  => 'normal',
				'priority' => 'high',
				'fields'   => array(
					array(
						'key'   => '_llb_overview_text',
						'type'  => 'textarea',
						'label' => __( 'Text on the Services overview page', 'll-bouwgroep' ),
					),
					array(
						'key'   => '_llb_overview_button',
						'type'  => 'text',
						'label' => __( 'Button text on the Services overview page', 'll-bouwgroep' ),
					),
				),
			),
			'llb_service_sections' => array(
				'title'    => __( 'Service sections', 'll-bouwgroep' ),
				'context'  => 'normal',
				'priority' => 'high',
				'fields'   => array(
					array(
						'key'    => '_llb_sections',
						'type'   => 'repeater',
						'label'  => __( 'Sections', 'll-bouwgroep' ),
						'fields' => array(
							array(
								'key'   => 'heading',
								'type'  => 'text',
								'label' => __( 'Heading (H2)', 'll-bouwgroep' ),
							),
							array(
								'key'   => 'text',
								'type'  => 'textarea',
								'label' => __( 'Text', 'll-bouwgroep' ),
							),
							array(
								'key'   => 'list',
								'type'  => 'lines',
								'label' => __( 'List items (one per line, optional)', 'll-bouwgroep' ),
							),
						),
					),
				),
			),
			'llb_service_steps'    => array(
				'title'    => __( 'Service steps', 'll-bouwgroep' ),
				'context'  => 'normal',
				'priority' => 'high',
				'fields'   => array(
					array(
						'key'   => '_llb_steps_heading',
						'type'  => 'text',
						'label' => __( 'Steps heading (H2)', 'll-bouwgroep' ),
					),
					array(
						'key'    => '_llb_steps',
						'type'   => 'repeater',
						'label'  => __( 'Steps', 'll-bouwgroep' ),
						'fields' => array(
							array(
								'key'   => 'title',
								'type'  => 'text',
								'label' => __( 'Step title (H3)', 'll-bouwgroep' ),
							),
							array(
								'key'   => 'text',
								'type'  => 'textarea',
								'label' => __( 'Text', 'll-bouwgroep' ),
							),
						),
					),
				),
			),
			'llb_service_cta'      => array(
				'title'    => __( 'Service call to action', 'll-bouwgroep' ),
				'context'  => 'normal',
				'priority' => 'high',
				'fields'   => array(
					array(
						'key'   => '_llb_cta_heading',
						'type'  => 'text',
						'label' => __( 'Heading (H2)', 'll-bouwgroep' ),
					),
					array(
						'key'   => '_llb_cta_text',
						'type'  => 'textarea',
						'label' => __( 'Text', 'll-bouwgroep' ),
					),
					array(
						'key'         => '_llb_cta_button',
						'type'        => 'text',
						'label'       => __( 'Button text', 'll-bouwgroep' ),
						'description' => __( 'The button links to the header button link (Customizer).', 'll-bouwgroep' ),
					),
				),
			),
		),
		'project' => array(
			'llb_project_details'  => array(
				'title'    => __( 'Project details', 'll-bouwgroep' ),
				'context'  => 'normal',
				'priority' => 'high',
				'fields'   => array(
					array(
						'key'   => '_llb_project_description',
						'type'  => 'textarea',
						'label' => __( 'About this project', 'll-bouwgroep' ),
					),
					array(
						'key'   => '_llb_project_work',
						'type'  => 'lines',
						'label' => __( 'Work carried out (one per line)', 'll-bouwgroep' ),
					),
					array(
						'key'   => '_llb_project_result',
						'type'  => 'textarea',
						'label' => __( 'The result', 'll-bouwgroep' ),
					),
				),
			),
			'llb_project_gallery'  => array(
				'title'    => __( 'Project gallery', 'll-bouwgroep' ),
				'context'  => 'normal',
				'priority' => 'high',
				'fields'   => array(
					array(
						'key'         => '_llb_project_gallery',
						'type'        => 'gallery',
						'label'       => __( 'Gallery images', 'll-bouwgroep' ),
						'description' => __( 'Used for the image slider when this project is featured.', 'll-bouwgroep' ),
					),
				),
			),
			'llb_project_featured' => array(
				'title'    => __( 'Featured project', 'll-bouwgroep' ),
				'context'  => 'side',
				'priority' => 'high',
				'fields'   => array(
					array(
						'key'         => '_llb_project_featured',
						'type'        => 'checkbox',
						'label'       => __( 'Featured project', 'll-bouwgroep' ),
						'description' => __( 'Shown as featured project with image slider.', 'll-bouwgroep' ),
					),
				),
			),
		),
	);
}

/**
 * Registers meta boxes from the config.
 *
 * @return void
 */
function llb_register_meta_boxes() {
	$config = llb_meta_box_config();

	foreach ( $config as $post_type => $boxes ) {
		foreach ( $boxes as $box_id => $box ) {
			add_meta_box(
				$box_id,
				$box['title'],
				'llb_render_meta_box',
				$post_type,
				isset( $box['context'] ) ? $box['context'] : 'normal',
				isset( $box['priority'] ) ? $box['priority'] : 'high',
				array(
					'post_type' => $post_type,
					'box_id'    => $box_id,
				)
			);
		}
	}
}
add_action( 'add_meta_boxes', 'llb_register_meta_boxes' );

/**
 * Renders a meta box from the config.
 *
 * @param WP_Post $post    Current post.
 * @param array   $metabox Meta box args.
 * @return void
 */
function llb_render_meta_box( $post, $metabox ) {
	$post_type = $metabox['args']['post_type'];
	$box_id    = $metabox['args']['box_id'];
	$config    = llb_meta_box_config();

	if ( empty( $config[ $post_type ][ $box_id ] ) ) {
		return;
	}

	$box = $config[ $post_type ][ $box_id ];

	static $nonce_printed = array();
	if ( empty( $nonce_printed[ $post_type ] ) ) {
		wp_nonce_field( 'llb_save_meta_' . $post_type, 'llb_meta_nonce_' . $post_type );
		$nonce_printed[ $post_type ] = true;
	}

	echo '<div class="llb-meta-box">';
	foreach ( $box['fields'] as $field ) {
		llb_render_meta_field( $post->ID, $field );
	}
	echo '</div>';
}

/**
 * Renders a single meta field.
 *
 * @param int   $post_id Post ID.
 * @param array $field   Field config.
 * @param array $args    Optional. name_prefix, value override for repeater rows.
 * @return void
 */
function llb_render_meta_field( $post_id, $field, $args = array() ) {
	$type  = $field['type'];
	$key   = $field['key'];
	$label = isset( $field['label'] ) ? $field['label'] : '';
	$desc  = isset( $field['description'] ) ? $field['description'] : '';

	$name_prefix = isset( $args['name_prefix'] ) ? $args['name_prefix'] : '';
	$name        = $name_prefix ? $name_prefix . '[' . $key . ']' : $key;

	if ( array_key_exists( 'value', $args ) ) {
		$value = $args['value'];
	} else {
		$value = llb_get_meta( $post_id, $key );
	}

	$id_attr = 'llb-field-' . sanitize_html_class( str_replace( array( '[', ']' ), array( '-', '' ), $name ) );

	echo '<div class="llb-meta-field llb-meta-field--' . esc_attr( $type ) . '">';

	if ( 'checkbox' !== $type && 'repeater' !== $type && '' !== $label ) {
		echo '<label class="llb-meta-label" for="' . esc_attr( $id_attr ) . '">' . esc_html( $label ) . '</label>';
	}

	switch ( $type ) {
		case 'text':
		case 'url':
			$input_type = ( 'url' === $type ) ? 'url' : 'text';
			printf(
				'<input type="%1$s" class="widefat" id="%2$s" name="%3$s" value="%4$s" />',
				esc_attr( $input_type ),
				esc_attr( $id_attr ),
				esc_attr( $name ),
				esc_attr( (string) $value )
			);
			break;

		case 'textarea':
		case 'lines':
			printf(
				'<textarea class="widefat" id="%1$s" name="%2$s" rows="4">%3$s</textarea>',
				esc_attr( $id_attr ),
				esc_attr( $name ),
				esc_textarea( (string) $value )
			);
			break;

		case 'checkbox':
			printf(
				'<label class="llb-meta-checkbox"><input type="checkbox" id="%1$s" name="%2$s" value="1" %3$s /> %4$s</label>',
				esc_attr( $id_attr ),
				esc_attr( $name ),
				checked( (string) $value, '1', false ),
				esc_html( $label )
			);
			break;

		case 'select':
			$options = isset( $field['options'] ) && is_array( $field['options'] ) ? $field['options'] : array();
			echo '<select class="widefat" id="' . esc_attr( $id_attr ) . '" name="' . esc_attr( $name ) . '">';
			foreach ( $options as $opt_value => $opt_label ) {
				printf(
					'<option value="%1$s" %2$s>%3$s</option>',
					esc_attr( (string) $opt_value ),
					selected( (string) $value, (string) $opt_value, false ),
					esc_html( (string) $opt_label )
				);
			}
			echo '</select>';
			break;

		case 'image':
			llb_render_image_field( $name, $id_attr, (int) $value );
			break;

		case 'gallery':
			$ids = is_array( $value ) ? $value : array();
			llb_render_gallery_field( $name, $id_attr, $ids );
			break;

		case 'repeater':
			$subfields = isset( $field['fields'] ) && is_array( $field['fields'] ) ? $field['fields'] : array();
			$rows      = is_array( $value ) ? $value : array();
			llb_render_repeater_field( $name, $id_attr, $label, $subfields, $rows );
			break;
	}

	if ( '' !== $desc ) {
		echo '<p class="description">' . esc_html( $desc ) . '</p>';
	}

	echo '</div>';
}

/**
 * Renders an image picker field.
 *
 * @param string $name    Input name.
 * @param string $id_attr Element ID.
 * @param int    $image_id Attachment ID.
 * @return void
 */
function llb_render_image_field( $name, $id_attr, $image_id ) {
	$preview = $image_id ? wp_get_attachment_image( $image_id, 'thumbnail', false, array( 'class' => 'llb-meta-thumb' ) ) : '';

	echo '<div class="llb-meta-image" data-llb-image>';
	echo '<div class="llb-meta-image__preview">' . $preview . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- wp_get_attachment_image().
	printf(
		'<input type="hidden" id="%1$s" name="%2$s" value="%3$s" class="llb-meta-image__input" />',
		esc_attr( $id_attr ),
		esc_attr( $name ),
		esc_attr( (string) $image_id )
	);
	echo '<p class="llb-meta-image__actions">';
	echo '<button type="button" class="button llb-meta-image__select">' . esc_html__( 'Select image', 'll-bouwgroep' ) . '</button> ';
	echo '<button type="button" class="button llb-meta-image__remove"' . ( $image_id ? '' : ' hidden' ) . '>' . esc_html__( 'Remove', 'll-bouwgroep' ) . '</button>';
	echo '</p>';
	echo '</div>';
}

/**
 * Renders a gallery picker field.
 *
 * @param string $name Input name.
 * @param string $id_attr Element ID.
 * @param array  $ids  Attachment IDs.
 * @return void
 */
function llb_render_gallery_field( $name, $id_attr, $ids ) {
	echo '<div class="llb-meta-gallery" data-llb-gallery data-name="' . esc_attr( $name ) . '">';
	echo '<ul class="llb-meta-gallery__list" id="' . esc_attr( $id_attr ) . '">';

	foreach ( $ids as $attachment_id ) {
		$attachment_id = absint( $attachment_id );
		if ( ! $attachment_id ) {
			continue;
		}
		$thumb = wp_get_attachment_image( $attachment_id, 'thumbnail', false, array( 'class' => 'llb-meta-thumb' ) );
		echo '<li class="llb-meta-gallery__item" draggable="true" data-id="' . esc_attr( (string) $attachment_id ) . '">';
		echo $thumb; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		printf(
			'<input type="hidden" name="%1$s[]" value="%2$s" />',
			esc_attr( $name ),
			esc_attr( (string) $attachment_id )
		);
		echo '<button type="button" class="button-link llb-meta-gallery__remove" aria-label="' . esc_attr__( 'Remove image', 'll-bouwgroep' ) . '">&times;</button>';
		echo '</li>';
	}

	echo '</ul>';
	echo '<p><button type="button" class="button llb-meta-gallery__add">' . esc_html__( 'Add images', 'll-bouwgroep' ) . '</button></p>';
	echo '</div>';
}

/**
 * Renders a repeater field.
 *
 * @param string $name      Input name.
 * @param string $id_attr   Element ID.
 * @param string $label     Field label.
 * @param array  $subfields Sub field configs.
 * @param array  $rows      Saved rows.
 * @return void
 */
function llb_render_repeater_field( $name, $id_attr, $label, $subfields, $rows ) {
	echo '<div class="llb-meta-repeater" data-llb-repeater data-name="' . esc_attr( $name ) . '">';

	if ( '' !== $label ) {
		echo '<p class="llb-meta-label">' . esc_html( $label ) . '</p>';
	}

	echo '<div class="llb-meta-repeater__rows" id="' . esc_attr( $id_attr ) . '">';

	if ( empty( $rows ) ) {
		$rows = array( array() );
	}

	foreach ( $rows as $index => $row ) {
		llb_render_repeater_row( $name, $index, $subfields, is_array( $row ) ? $row : array() );
	}

	echo '</div>';

	// Template for new rows (JS).
	echo '<template class="llb-meta-repeater__template">';
	llb_render_repeater_row( $name, '__INDEX__', $subfields, array() );
	echo '</template>';

	echo '<p><button type="button" class="button llb-meta-repeater__add">' . esc_html__( 'Add row', 'll-bouwgroep' ) . '</button></p>';
	echo '</div>';
}

/**
 * Renders one repeater row.
 *
 * @param string $name      Parent field name.
 * @param mixed  $index     Row index or placeholder.
 * @param array  $subfields Sub fields.
 * @param array  $row       Row values.
 * @return void
 */
function llb_render_repeater_row( $name, $index, $subfields, $row ) {
	echo '<div class="llb-meta-repeater__row" data-llb-repeater-row>';
	echo '<div class="llb-meta-repeater__row-actions">';
	echo '<button type="button" class="button-link llb-meta-repeater__up">' . esc_html__( 'Move up', 'll-bouwgroep' ) . '</button> ';
	echo '<button type="button" class="button-link llb-meta-repeater__down">' . esc_html__( 'Move down', 'll-bouwgroep' ) . '</button> ';
	echo '<button type="button" class="button-link-delete llb-meta-repeater__remove">' . esc_html__( 'Remove row', 'll-bouwgroep' ) . '</button>';
	echo '</div>';

	foreach ( $subfields as $subfield ) {
		$sub_key = $subfield['key'];
		$value   = isset( $row[ $sub_key ] ) ? $row[ $sub_key ] : ( 'checkbox' === $subfield['type'] ? '' : '' );

		llb_render_meta_field(
			0,
			$subfield,
			array(
				'name_prefix' => $name . '[' . $index . ']',
				'value'       => $value,
			)
		);
	}

	echo '</div>';
}

/**
 * Saves meta boxes for the configured post types.
 *
 * @param int $post_id Post ID.
 * @return void
 */
function llb_save_meta_boxes( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}

	$post_type = get_post_type( $post_id );
	$config    = llb_meta_box_config();

	if ( ! $post_type || empty( $config[ $post_type ] ) ) {
		return;
	}

	$nonce_key = 'llb_meta_nonce_' . $post_type;
	if ( empty( $_POST[ $nonce_key ] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST[ $nonce_key ] ) ), 'llb_save_meta_' . $post_type ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$fields = llb_meta_box_fields_flat( $post_type );

	foreach ( $fields as $field ) {
		$key  = $field['key'];
		$type = $field['type'];

		if ( 'checkbox' === $type ) {
			$raw = isset( $_POST[ $key ] ) ? wp_unslash( $_POST[ $key ] ) : '';
		} elseif ( in_array( $type, array( 'gallery', 'repeater' ), true ) ) {
			$raw = isset( $_POST[ $key ] ) ? wp_unslash( $_POST[ $key ] ) : array();
		} elseif ( ! isset( $_POST[ $key ] ) ) {
			continue;
		} else {
			$raw = wp_unslash( $_POST[ $key ] );
		}

		$sanitized = llb_sanitize_meta_value( $raw, $field );
		update_post_meta( $post_id, $key, $sanitized );
	}
}
add_action( 'save_post', 'llb_save_meta_boxes' );

/**
 * Flattens top-level fields for a post type (not repeater subfields alone).
 *
 * @param string $post_type Post type.
 * @return array<int, array<string, mixed>>
 */
function llb_meta_box_fields_flat( $post_type ) {
	$config = llb_meta_box_config();
	$fields = array();

	if ( empty( $config[ $post_type ] ) ) {
		return $fields;
	}

	foreach ( $config[ $post_type ] as $box ) {
		foreach ( $box['fields'] as $field ) {
			$fields[] = $field;
		}
	}

	return $fields;
}

/**
 * Finds a top-level field config by meta key.
 *
 * @param string $key Meta key.
 * @return array<string, mixed>|null
 */
function llb_meta_field_by_key( $key ) {
	$config = llb_meta_box_config();

	foreach ( $config as $boxes ) {
		foreach ( $boxes as $box ) {
			foreach ( $box['fields'] as $field ) {
				if ( $field['key'] === $key ) {
					return $field;
				}
			}
		}
	}

	return null;
}

/**
 * Sanitizes a meta value by field type.
 *
 * @param mixed $value Raw value.
 * @param array $field Field config.
 * @return mixed
 */
function llb_sanitize_meta_value( $value, $field ) {
	$type = $field['type'];

	switch ( $type ) {
		case 'text':
			return sanitize_text_field( is_string( $value ) ? $value : '' );

		case 'textarea':
		case 'lines':
			return sanitize_textarea_field( is_string( $value ) ? $value : '' );

		case 'url':
			return esc_url_raw( is_string( $value ) ? $value : '' );

		case 'checkbox':
			return ( '1' === (string) $value || true === $value || 1 === $value ) ? '1' : '';

		case 'select':
			$options = isset( $field['options'] ) && is_array( $field['options'] ) ? $field['options'] : array();
			$value   = is_string( $value ) ? $value : '';
			return array_key_exists( $value, $options ) ? $value : '';

		case 'image':
			return absint( $value );

		case 'gallery':
			if ( ! is_array( $value ) ) {
				return array();
			}
			$ids = array_map( 'absint', $value );
			$ids = array_values( array_filter( $ids ) );
			return $ids;

		case 'repeater':
			if ( ! is_array( $value ) ) {
				return array();
			}
			$subfields = isset( $field['fields'] ) && is_array( $field['fields'] ) ? $field['fields'] : array();
			$rows      = array();

			foreach ( $value as $row ) {
				if ( ! is_array( $row ) ) {
					continue;
				}
				$clean_row  = array();
				$has_content = false;

				foreach ( $subfields as $subfield ) {
					$sub_key = $subfield['key'];
					$raw     = isset( $row[ $sub_key ] ) ? $row[ $sub_key ] : ( 'checkbox' === $subfield['type'] ? '' : '' );
					$clean   = llb_sanitize_meta_value( $raw, $subfield );
					$clean_row[ $sub_key ] = $clean;

					if ( llb_meta_value_has_content( $clean, $subfield['type'] ) ) {
						$has_content = true;
					}
				}

				if ( $has_content ) {
					$rows[] = $clean_row;
				}
			}

			return array_values( $rows );
	}

	return '';
}

/**
 * Whether a sanitized value counts as non-empty content.
 *
 * @param mixed  $value Value.
 * @param string $type  Field type.
 * @return bool
 */
function llb_meta_value_has_content( $value, $type ) {
	if ( 'checkbox' === $type ) {
		return '1' === (string) $value;
	}
	if ( is_array( $value ) ) {
		return ! empty( $value );
	}
	return '' !== trim( (string) $value );
}

/**
 * Enqueues admin meta assets on dienst/project edit screens.
 *
 * @param string $hook_suffix Current admin page.
 * @return void
 */
function llb_enqueue_admin_meta_assets( $hook_suffix ) {
	if ( ! in_array( $hook_suffix, array( 'post.php', 'post-new.php' ), true ) ) {
		return;
	}

	$screen = get_current_screen();
	if ( ! $screen || ! in_array( $screen->post_type, array( 'dienst', 'project' ), true ) ) {
		return;
	}

	wp_enqueue_media();

	$css = LLB_DIR . '/assets/css/admin-meta.css';
	$js  = LLB_DIR . '/assets/js/admin-meta.js';

	wp_enqueue_style(
		'llb-admin-meta',
		LLB_URI . '/assets/css/admin-meta.css',
		array(),
		file_exists( $css ) ? (string) filemtime( $css ) : LLB_VERSION
	);

	wp_enqueue_script(
		'llb-admin-meta',
		LLB_URI . '/assets/js/admin-meta.js',
		array(),
		file_exists( $js ) ? (string) filemtime( $js ) : LLB_VERSION,
		true
	);
}
add_action( 'admin_enqueue_scripts', 'llb_enqueue_admin_meta_assets' );

/**
 * Adds a Featured column to the Projects list table.
 *
 * @param array<string, string> $columns Columns.
 * @return array<string, string>
 */
function llb_project_featured_column( $columns ) {
	$columns['llb_featured'] = __( 'Featured', 'll-bouwgroep' );
	return $columns;
}
add_filter( 'manage_project_posts_columns', 'llb_project_featured_column' );

/**
 * Renders the Featured column value.
 *
 * @param string $column  Column key.
 * @param int    $post_id Post ID.
 * @return void
 */
function llb_project_featured_column_content( $column, $post_id ) {
	if ( 'llb_featured' !== $column ) {
		return;
	}

	if ( '1' === (string) llb_get_meta( $post_id, '_llb_project_featured' ) ) {
		echo '<span aria-label="' . esc_attr__( 'Featured', 'll-bouwgroep' ) . '">★</span>';
	} else {
		echo '—';
	}
}
add_action( 'manage_project_posts_custom_column', 'llb_project_featured_column_content', 10, 2 );
