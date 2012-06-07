/**
 * JavaScript file for Element: Toggler (MooTools 1.2 compatible)
 * Adds slide in and out functionality to elements based on an elements value
 *
 * @package     NoNumber! Elements
 * @version     2.0.0
 *
 * @author      Peter van Westen <peter@nonumber.nl>
 * @link        http://www.nonumber.nl
 * @copyright   Copyright (C) 2010 NoNumber! All Rights Reserved
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

window.addEvent( 'domready', function() {
	if ( !nnTogglerSet ) {
		// Only do stuff if tabber_nav is found
		if ( document.getElements( '.nntoggler' ).length ) {
			nnTogglerSet = new nnToggler();
		} else {
			// Try again 2 seconds later, because IE sometimes can't see object immediatly
			(function() {
				if ( document.getElements( '.nntoggler' ).length ) {
					nnTogglerSet = new nnToggler();
				}
			}).delay( 2000 );
		}
	}
});

function nnVersionIsNewer( number1, number2 )
{
	if ( ( number1+'' ).indexOf( '.' ) !== -1 ) {
		number1 = number1.split( '.' );
		number1 = ( number1[0] * 1000000 ) + ( number1[1] * 1000 ) + ( number1[2] * 1 );
	}
	if ( ( number2+'' ).indexOf( '.' ) !== -1 ) {
		number2 = number2.split( '.' );
		number2 = ( number2[0] * 1000000 ) + ( number2[1] * 1000 ) + ( number2[2] * 1 );
	}
	return ( number1 < number2 );
}

if ( typeof( nn_toggler_version ) == 'undefined' || nnVersionIsNewer( nn_toggler_version, '2.0.0' ) ) {
	// version number of the script
	// to prevent this from overwriting newer versions if other extensions include the script too
	var nn_toggler_version = '2.0.0';

	// prevent init from running more than once
	if ( typeof( window['nnTogglerSet'] ) == "undefined" ) {
		var nnTogglerSet = null;
	}

	var nnToggler = new Class({
		togglers: {}, // holds all the toggle areas
		elements: {}, // holds all the elements with the toggle areas they effect
		overlay: null, // holds all the overlay object
		form_elements: null, // holds the admin form elements
		div_elements: null, // holds the div elements

		initialize: function()
		{
			var self = this;

			this.togglers = document.getElements( '.nntoggler' );
			if ( !this.togglers.length ) {
				return;
			}

			nnScripts.overlay.open( 0.2 );

			( function() {
				self.form_elements = document.getElements( 'input, select' );
				self.initTogglers();
			} ).delay( 500 );
		},

		initTogglers: function( id )
		{
			var self = this;

			var new_togglers = {};
			var i = 0;


			// make parent tds have no padding
			this.togglers.each( function( toggler ) {
				if ( toggler.getParent().get('tag') == 'td' ) {
					toggler.getParent().setStyle( 'padding', '0' );
				}
				if ( toggler.id ) {
					i++;
					toggler.elements = {};
					toggler.fx = {};
					toggler.nofx = toggler.hasClass( 'nntoggler_nofx' );
					toggler.overlay = ( toggler.hasClass( 'nntoggler_overlay' ) ) ;
					toggler.mode = ( toggler.hasClass( 'nntoggler_horizontal' ) ) ? 'horizontal' : 'vertical';
					toggler.method = ( toggler.hasClass( 'nntoggler_and' ) ) ? 'and' : 'or';
					toggler.casesensitive = ( toggler.hasClass( 'nntoggler_casesensitive' ) ) ;
					toggler.ids = toggler.id.split( '___' );
					new_togglers[toggler.id] = toggler;
				}
			});

			this.togglers = new_togglers;

			// add effects
			$each( this.togglers, function( toggler ) {
				if ( toggler.nofx ) {
					toggler.fx.slide = new Fx.Slide( toggler, { 'duration' : 1, 'mode' : toggler.mode, onComplete: function() { self.completeSlide( toggler ); } } );
				} else {
					toggler.fx.slide = new Fx.Slide( toggler, { 'duration' : 500, 'mode' : toggler.mode, onStart: function() { self.startSlide( toggler ); }, onComplete: function() { self.completeSlide( toggler ); } } );
					toggler.fx.fade = new Fx.Morph( toggler, { 'duration' : 500 } );
				}
			});

			// set elements
			$each( this.togglers, function( toggler ) {
				for ( var i = 1; i < toggler.ids.length; i++ ) {
					keyval = toggler.ids[i].split( '.' );

					if ( keyval.length < 2 ) {
						keyval[1] = 1;
					}
					if ( typeof( self.elements[keyval[0]] ) == "undefined" ) {
						self.elements[keyval[0]] = {};
						self.elements[keyval[0]].togglers = [];
						self.elements[keyval[0]].overlay = 0;
					}
					if ( toggler.overlay ) {
						self.elements[keyval[0]].overlay = 1;
					}

					self.elements[keyval[0]].togglers.include( toggler.id );

					if ( typeof( toggler.elements[keyval[0]] ) == "undefined" ) {
						toggler.elements[keyval[0]] = [];
					}
					toggler.elements[keyval[0]].include( keyval[1] );
				}
			});

			this.setElementsAction();

			// open togglers by value
			$each( this.togglers, function( toggler ) {
				var show = self.isShow( toggler.id );
				if ( !show ) {
					toggler.fx.slide.hide();
					if ( !toggler.nofx ) {
						toggler.setStyle( 'opacity', 0 );
					}
				}
				toggler.setStyle( 'visibility', 'visible' );
			});

			this.div_elements = document.getElements( 'div.col div' );
			// set all divs in the form to auto height
			this.autoHeightDivs();
			( function() {
				self.autoHeightDivs();
				( function() { self.hideOverlay(); } ).delay( 250 );
			} ).delay( 500 );
		},

		showOverlay: function()
		{
			nnScripts.overlay.open( 0.2 );
		},

		hideOverlay: function()
		{
			nnScripts.overlay.close();
		},


		startSlide: function( toggler )
		{
			this.autoHeightDivs();
		},

		completeSlide: function( toggler )
		{
			var self = this;

			this.autoHeightDivs();
			if( toggler.overlay ) {
				( function() {
					self.hideOverlay();
					window.setStyle( 'cursor', '' );
				} ).delay( 250 );
			}
		},

		autoHeightDivs: function()
		{
			// set all divs in the form to auto height
			this.div_elements.each( function( el ) {
				if (	el.getStyle( 'height' ) != '0px'
					&&	!el.hasClass( 'input' )
					&&	!el.hasClass( 'textarea_handle' )
					// GK elements
					&&	el.id.indexOf( 'gk_' ) === -1
					&&	el.className.indexOf( 'gk_' ) === -1
					&&	el.className.indexOf( 'switcher-' ) === -1
				) {
					el.setStyle( 'height', 'auto' );
				}
			} );
		},

		toggle: function( el_name )
		{
			var self = this;
			if ( typeof( this.elements[el_name] ) != "undefined" ) {
				el = this.elements[el_name];
				var del = 0;
				if( el.overlay ) {
					this.showOverlay();
					del = 250;
				}
				( function() {
					for ( var i = 0; i < self.elements[el_name].togglers.length; i++ ) {
						self.togglebyid( self.elements[el_name].togglers[i] );
					}
				 } ).delay( del );
				if( el.overlay ) {
					//this.hideOverlay();
				}
			}

		},

		togglebyid: function( id )
		{
			if ( typeof( this.togglers[id] ) == "undefined" ) {
				return;
			}

			var toggler = this.togglers[id];

			var show = this.isShow( id );

			toggler.fx.slide.stop();
			if ( toggler.nofx ) {
				if( show ) {
					toggler.fx.slide.show();
				} else {
					toggler.fx.slide.hide();
				}
				this.autoHeightDivs();
			} else {
				toggler.fx.fade.stop();
				if( show ) {
					toggler.fx.slide.slideIn();
					( function(){ toggler.fx.fade.start( { 'opacity' : 1 } ) } ).delay( 250 );
				} else {
					toggler.fx.slide.slideOut();
					toggler.fx.fade.start( { 'opacity' : 0 } );
				}
			}
		},

		isShow: function( id )
		{
			toggler = this.togglers[id];

			var show = ( toggler.method == 'and' );

			for ( id in toggler.elements ) {
				vals = toggler.elements[id];
				var values = this.get_values( id );
				if ( values != null && values.length && ( ( vals == '*' && values != '' ) || nnScripts.in_array( vals, values, toggler.casesensitive ) ) ) {
					if ( toggler.method == 'or' ) {
						show = 1;
						break;
					}
				} else {
					if ( toggler.method == 'and' ) {
						show = 0;
						break;
					}
				}
			}

			return show;
		},

		get_values: function( element_name )
		{
			if ( typeof( this.elements[element_name] ) == undefined ) {
				return null;
			}

			var element = this.elements[element_name];

			var values = new Array();
			// get value
			if ( element.elements ) {
				switch ( element.type ) {
					case 'radio':
					case 'checkbox':
						for ( var i = 0; i < element.elements.length; i++ ) {
							if ( element.elements[i].checked ) {
								values.push( element.elements[i].value );
							}
						}
						break;
					default:
						if ( element.elements.length > 1 ) {
							for ( var i = 0; i < element.elements.length; i++ ) {
								if ( element.elements[i].checked ) {
									values.push( element.elements[i].value );
								}
							}
						} else {
							values.push( element.elements[0].value );
						}
						break;
				}
			}
			return values;
		},

		setElementsAction : function()
		{
			var self = this;
			var el_name = '';
			this.form_elements.each( function( el ) {
				el.el_name = el.name.replace( '[]', '' ).replace( /(?:params|advancedparams)\[(.*?)\]/g, '\$1' );

				if ( typeof( self.elements[el.el_name] ) != "undefined" ) {
					if ( typeof( self.elements[el.el_name].elements ) == "undefined" ) {
						self.elements[el.el_name].elements = [];
					}

					if ( typeof( self.elements[el.el_name].type ) == "undefined" ) {
						if ( el.get('tag') == 'select' ) {
							self.elements[el.el_name].type = 'select';
						} else {
							self.elements[el.el_name].type = el.type;
						}
					}
					func = function( event ) { self.toggle( el.el_name ); };

					switch ( self.elements[el.el_name].type ) {
						case 'radio':
						case 'checkbox':
							el.addEvent( 'click', func );
							el.addEvent( 'keyup', func );
							break;
						case 'select':
						case 'select-one':
						case 'text':
							el.addEvent( 'change', func );
							el.addEvent( 'keyup', func );
							break;
						default:
							el.addEvent( 'change', func );
							break;
					}

					self.elements[el.el_name].elements.include( el );
				}
			});
		}
	});
}