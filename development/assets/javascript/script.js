var $basement_shortcodes_panel_overlay = $( '#basement_shortcodes_panel_overlay' ),
	$basement_shortcodes_panel = $( '#basement_shortcodes_panel' ),
	$basement_shortcode_panel_button = $( '.basement_shortcode_panel_button' ),
	$basement_shortcode_panel_shortcode_wrapper = $('.basement_shortcode_panel_shortcode_wrapper'),
	$basement_shortcodes_open_button = $( '.basement_shortcodes_panel_open_button'),
	basement_active_editor;

$( '.basement_shortcodes_back_button' ).click( function() {
	var parent = $( this ).parents( '.basement_settings_panel_section' );
		section = parent.data( 'section' );
		$( '.basement_shortcode_panel_shortcode_wrapper' ).hide();
		$( '.basement_settings_panel_section.active[data-section="' + section + '"]' ).find( '.basement_shortcode_panel_button' ).show();
	return false;
});

$.each( $( '.wp-editor-wrap' ), function( index, wrap ) {
	if ( $( wrap ).hasClass( 'html-active' ) ) {
		$( wrap ).find( '.basement_shortcodes_panel_open_button' ).hide();
	}
} );

$( '.wp-switch-editor.switch-tmce' ).click( function() { 
	$( this ).parents( '.wp-editor-tools' ).find( '.basement_shortcodes_panel_open_button' ).show();
});

$( '.wp-switch-editor.switch-html' ).click( function() { 
	$( this ).parents( '.wp-editor-tools' ).find( '.basement_shortcodes_panel_open_button' ).hide();
});

$basement_shortcodes_open_button.click( function() {
	$( 'body' ).addClass( 'modal-open' );
	$basement_shortcodes_panel_overlay.show();
	$('.basement_settings_page').trigger('basement_content_changed');
	basement_active_editor = tinyMCE.activeEditor;
	return false;
});

$basement_shortcodes_panel_overlay.click( function( e ) {
	if ( $( e.target ).attr( 'id' ) !== 'basement_shortcodes_panel_overlay' ) {
		return true;
	}
	$( 'body' ).removeClass( 'modal-open' );
	$basement_shortcodes_panel_overlay.hide();
});

$basement_shortcode_panel_button.click(function() {
	$basement_shortcode_panel_button.hide();
	var $basement_shortcode_panel_shortcode_form = $basement_shortcode_panel_shortcode_wrapper.filter('[data-name="' + $(this).data('name') + '"]');
	$basement_shortcode_panel_shortcode_form.show();
	basement_shortcodes_build_preview( $basement_shortcode_panel_shortcode_form );
});

$basement_shortcodes_panel.find('.basement_settings_panel_menu_item a').click(function() {
	$basement_shortcode_panel_shortcode_wrapper.hide();
	$basement_shortcode_panel_button.show();
});

function basement_build_shortcode( builder, preview ) {
	builder.data('content', '');
	builder.data('params', '');

	if (builder.find('input, select, textarea').length) {
		var collective_params = {};
		$.each(builder.find( 'input, select, textarea' ), function(index, input) {
			var value = '', 
				key = $( input ).data('key'), 
				checked = false,
				type = $( input ).attr( 'type' ),
				param_type = $( input ).data( 'type' ),
				name = $( input ).attr( 'name' ),
				may_by_empty = $( input ).data('may-be-empty') ;
			if ( param_type === 'content' ) {
				if ( type == 'radio' ) {
					builder.data(
						'content', 
						$( input ).parents( '.basement_shortcodes_panel_block' )
									.find('input[name="' + $( input ).attr( 'name' ) + '"]:checked')
									.val() 
					);
				} else {
					builder.data('content', $( input ).val() );
				}
			} else if ( param_type === 'text' || 'color' === param_type || 'select' === param_type ) {
				if ( ( $( input ).data('key') && $( input ).val() ) || !may_by_empty ) {
					builder.data('params', builder.data('params') + ' ' + $( input ).data('key') + '="' + $( input ).val() + '"');
				}
			} else if ( param_type === 'radio') {
				if ( $( input ).is( ':checked' ) ) {
					value = $( input ).val();
					if ( ( key && value ) && ( !may_by_empty || value !== "0" ) ) {
						builder.data('params', builder.data('params') + ' ' + key + '="' + value + '"');
					}
				}
			} else if ( 'check' === param_type ) {
				if ( $( input ).is( ':checked' ) ) {
					if ( collective_params[ key ] === undefined ) {
						collective_params[ key ] = [];
					}
					collective_params[ key ].push( $( input ).val() );
				}

			} else if ( 'toggler' === param_type ) {
				checked = $( input ).parents( '.basement_shortcodes_panel_block' )
									.find('input[name="' + $( input ).attr( 'name' ) + '"]:checked')
									.first();
				if (checked.length) {
					builder.data( 'params', builder.data('params') + ' ' + key );
				}
			}
		});

		$.each( collective_params, function( param_key, param_values ) {
			if ( param_values.length ) {
				builder.data('params', builder.data('params') + ' ' + param_key + '="' + param_values.join() + '"');
			}
		});
		
	}



	var output = '[' + builder.data( 'tag' );
	if (builder.data('params').length) {
		output += builder.data('params');
	}
	var editor_selection = '';
	if ( builder.data( 'shortcode-enclosing' ) === 1 ) {
		if ( preview ) {
			editor_selection = basement_active_editor.selection.getContent({ 'format' : 'text' });
		} else {
			editor_selection = basement_active_editor.selection.getContent({ 'format' : 'html' });
		}
		if ( preview && editor_selection.length ) {
			editor_selection = '...';
		}
	}
	var content = builder.data('content');
	if ( ( content_wrap = builder.data( 'wrap' ) ) ) {
		content = '<' + content_wrap + '>' + content + '</' + content_wrap + '>'; 
	}
	output += ']' + content + editor_selection;
	if ( builder.data( 'shortcode-enclosing' ) === 1) {
		output += '[/' + builder.data( 'tag' ) + ']';
	}
	return output;
}

function basement_shortcodes_build_preview( builder ) {
	builder.find('.basement_shortcode_builder_button').find( 'span' ).text( basement_build_shortcode( builder, true ) );
}

$('.basement_shortcodes_panel_block').on('change keyup', 'input, textarea', function() {
	var builder = $(this).parents('.basement_shortcode_panel_shortcode_wrapper');
	basement_shortcodes_build_preview(builder);
});

$('.basement_shortcodes_panel_block').on('change', 'select', function() {
	var builder = $(this).parents('.basement_shortcode_panel_shortcode_wrapper');
	basement_shortcodes_build_preview(builder);
});

$('.basement_shortcodes_panel_block').on( 'basement_colorpicker_changed', function() {
	var builder = $(this).parents('.basement_shortcode_panel_shortcode_wrapper');
	basement_shortcodes_build_preview(builder);
});

$('.menu a').first().click();

$('.default-icons input').change(function() {
	$('#' + $(this).parents('.default-icons').data('target')).val($(this).val()).change();
});

if ( $( ".sortable-contaner" ).length && $.fn.sortable ) {
	$( ".sortable-contaner" ).sortable({
		placeholder: "basement_sortable_drop_area",
		update: function (e, ui) {
			basement_shortcodes_build_preview($(ui.item).parents( '.basement_shortcode_panel_shortcode_wrapper' ) );
		}
	});
}

$('.basement_shortcode_builder_button').click(function() {
	basement_active_editor.execCommand('mceInsertContent', false, basement_build_shortcode( $( this ).parent( '.basement_shortcode_panel_shortcode_wrapper' ) ) );
	$( 'body' ).removeClass( 'modal-open' );
	$basement_shortcodes_panel_overlay.hide();
});
