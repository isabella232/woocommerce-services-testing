/**
 * External dependencies
 */
var jsdom = require( 'jsdom' ).jsdom,
	assign = require( 'lodash/assign' );

/**
 * Module variables
 */
var defaultFeatures = {
	XMLHttpRequest: true
};

module.exports = function( markup, features ) {
	features = assign( {}, defaultFeatures, features );

	global.document = jsdom( markup, {
		url: 'http://example.com/',
		features: {
			FetchExternalResources: false,
			ProcessExternalResources: false
		}
	} );
	global.window = document.defaultView;
	global.navigator = window.navigator;
	global.Element = window.Element;
	global.history = window.history;

	if ( features.XMLHttpRequest ) {
		global.XMLHttpRequest = window.XMLHttpRequest;
	}
};