( function( $ ) {
	"use strict";

	$(document).on('click', '.ashe-notice .button-primary', function( e ) {

		if ( 'install-activate' === $(this).data('action') && ! $( this ).hasClass('init') ) {
			var $self = $(this),
				$href = $self.attr('href');

			if ( 'true' === $self.data('freemius') ) {
				$href.replace('wpr-addons','wpr-templates-kit')
			}

			$self.addClass('init');

			$self.text('Installing Templates Kit...');

			var elementorData = {
				'action' : 'ashe_install_activate_elementor',
				'nonce' : ashe_localize.elementor_nonce
			};

			// Send Request.
			$.post( ashe_localize.ajax_url, elementorData, function( response ) {

				if ( response.success ) {
					console.log('elementor installed');

					// Both Plugins Installed
					if ( true === response.data.plugins_updated ) {
						setTimeout(function() {
							$self.text('Redirecting to Templates Kit page...');

							setTimeout( function() {
								window.location = $href;
							}, 1000 );
						}, 500);

						console.log('royal addons installed');

						return false;
					}

					var royalAddonsData = {
						'action' : 'ashe_install_activate_royal_addons',
						'nonce' : ashe_localize.royal_addons_nonce
					};

					$.post( ashe_localize.ajax_url, royalAddonsData, function( response ) {
						if ( response.success ) {
							console.log('royal addons installed');

							setTimeout(function() {
								$self.text('Redirecting to Templates Kit page...');

								setTimeout( function() {
									window.location = $href;
								}, 1000 );
							}, 500);
						}
					});

				}

			} ).fail( function( xhr, textStatus, e ) {
				$(this).parent().after( `<div class="plugin-activation-warning">${ashe_localize.failed_message}</div>` );
			} );

			e.preventDefault();
		}
	} );

} )( jQuery );
