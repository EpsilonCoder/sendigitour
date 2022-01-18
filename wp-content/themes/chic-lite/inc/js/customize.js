jQuery(document).ready(function($) {

	/* Move widgets to general settings panel */
	wp.customize.section( 'sidebar-widgets-featured-area' ).panel( 'general_settings' );
    wp.customize.section( 'sidebar-widgets-featured-area' ).priority( '15' ); 

});

( function( api ) {

	// Extends our custom "example-1" section.
	api.sectionConstructor['chic-lite-pro-section'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );