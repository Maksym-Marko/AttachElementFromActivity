jQuery(document).ready(function($) {

	$( document ).on( 'submit', '.mx-attach_form, .mx-detach_form', function( e ){

		e.preventDefault();

		var type_attach = $( this ).attr( 'data-attach' );

		var id_item = parseInt( $( this ).find( 'input[name="id_item"]' ).val() );

		var data = {
			'action': 'attach-element',
			'nonce': ajax_object.nonce,
			'type_attach': type_attach,
			'id_item': id_item
		};

		jQuery.post( ajax_object.ajax_url, data, function( response ) {

			if( data.type_attach === 'attach' ){

				// create wrapper
				if( $( '#attachItemActivityWrap' ).find( '.mx-attach_item_activity' ).length === 0 ){					

					$( '#attachItemActivityWrap' ).append( '<ul class="mx-attach_item_activity"></ul>' );

				}				

				// add new element
				$( '#activity-' + data.id_item ).animate( { opacity: 0 }, 500, function(){

					var activity_item = $( this );

					$( this ).remove();
					
					$( '.mx-attach_item_activity' ).append( activity_item );

					$( this ).animate( { opacity: 1 }, 500 );

				} );

			} else if( data.type_attach === 'detach' ){

				$( '#activity-' + data.id_item ).animate( { opacity: 0 }, 500, function(){

					$( this ).remove();

					if( $( '.mx-attach_item_activity' ).children( 'li' ).length === 0 ){

						$( '#attachItemActivityWrap' ).empty();

					}

				} );

			}

		});

	} );	

});