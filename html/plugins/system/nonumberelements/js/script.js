/**
 * Main JavaScript file
 *
 * @package     NoNumber! Elements
 * @version     2.0.0
 *
 * @author      Peter van Westen <peter@nonumber.nl>
 * @link        http://www.nonumber.nl
 * @copyright   Copyright (C) 2010 NoNumber! All Rights Reserved
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

var scripts = document.getElementsByTagName("script");
var nn_script_root = scripts[scripts.length-1].src.replace( 'script.js', '' );

window.addEvent( 'domready', function() {
	if ( !nnScriptsSet ) {
		nnScriptsSet = 1;
		nnScripts = new nnScripts();
	}
});

function nnScriptsVersionIsNewer( number1, number2 )
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

if ( typeof( nn_scripts_version ) == 'undefined' || nnScriptsVersionIsNewer( nn_scripts_version, '2.0.0' ) ) {
	// version number of the script
	// to prevent this from overwriting newer versions if other extensions include the script too
	var nn_scripts_version = '2.0.0';

	// prevent init from running more than once
	if ( typeof( window['nnScriptsSet'] ) == "undefined" ) {
		var nnScriptsSet = null;
	}

	var nnScripts = new Class({
		initialize: function()
		{
			var self = this;

			var client = this._getClient();
			this.overlay = new Element( 'div', {
				id: 'NN_overlay',
				styles: {
					backgroundColor: 'black',
					position: 'fixed',
					left: 0,
					top: 0,
					width: '100%',
					height: '100%',
					zIndex: 5000
				}
			} );

			if ( client.isIE && !client.isIE7 ) {
				this.overlay.style.position = 'absolute';
				this.overlay.style.height = this._getDocHeight() + 'px';
				this._fixTop();
				window.addEvent( 'scroll', function(){ self._fixTop(); } );
			}

			this.overlay.fxing = 0;
			this.overlay.fx = this.overlay.effect( 'opacity', {
				duration: 200,
				wait: false,
				onComplete: function() { self.overlay.fxing = 0; }
			}).set(0);

			this.overlay_text = new Element( 'span', {
				id: 'NN_overlay_text'
			} );
			this.overlay_text_dots = new Element( 'marquee', {
				id: 'NN_overlay_text_dots',
				behavior: 'scroll',
				direction: 'right',
				styles: {
					display: 'inline-block',
					width: '30px',
					verticalAlign: 'baseline'
				}
			} ).setHTML( '...' );
			this.overlay_subtext = new Element( 'div', {
				id: 'NN_overlay_subtext',
				styles: {
					color: '#CCCCCC',
					fontSize: '20px',
					fontStyle: 'italic'
				}
			} );

			this.overlay_text_container = new Element( 'div', {
				id: 'NN_overlay_text_container',
				styles: {
					position: 'fixed',
					top: '40%',
					width: '100%',
					textAlign: 'center',
					color: '#FFFFFF',
					fontSize: '30px',
					fontFamily: 'Georgia, Times New Roman, serif',
					zIndex: 5001
				}
			} ).adopt( this.overlay_text ).adopt( this.overlay_text_dots ).adopt( this.overlay_subtext );
			this.overlay.adopt( this.overlay_text_container );

			this.overlay_close = new Element( 'div', {
				id: 'NN_overlay_close',
				styles: {
					cursor: 'pointer',
					background: 'transparent url( '+nn_script_root+'../images/close.png) no-repeat center center',
					position: 'fixed',
					right: '5px',
					top: '5px',
					width: '64px',
					height: '64px',
					zIndex: 5002
				}
			} ).addEvent( 'click', function(){ self.overlay.fx.start(0); } );
			this.overlay.adopt( this.overlay_close );

			$(document.body).adopt( this.overlay );

			this.overlay.open = function( opacity, text, subtext )
			{
				if ( !opacity ) {
					self.overlay.close();
				} else {
					self.overlay.setStyle( 'cursor', 'wait' );
					if ( !text ) {
						text = '';
					}
					if ( !subtext ) {
						subtext = '';
					}
					self.overlay_text.setText( text );
					self.overlay_subtext.setText( subtext );
					self.overlay.fx.start( opacity );
				}
			}
			this.overlay.close = function()
			{
				self.overlay.fx.start( 0 );
				( function() { self.overlay.setStyle( 'cursor', '' );self.overlay_text.setText( '' );self.overlay_subtext.setText( '' ); } ).delay( 200 );
			}
		},

		loadxml: function( url, succes, fail, query )
		{
			this.loadajax( url, succes, fail, query );
		},

		loadajax: function( url, succes, fail, query )
		{
			if ( url.substr( 0, 4 ) == 'http' || url.substr( 0, 4 ) == 'www.' ) {
				url = url.replace( 'http://', '' );
				url = 'index.php?nn_qp=1&url='+escape( url );
			}

			var myXHR = new XHR( {
				onSuccess: function( data ) {
					if ( succes ) {
						eval( succes+';' );
					}
				},
				onFailure: function( data ) {
					if ( fail ) {
						eval( fail+';' );
					}
				}
			} ).send( url, query );
		},

		displayVersion: function( ext, data )
		{
			if ( !data ) {
				return;
			}

			data = data.split( '|' );

			var current_version = data[0];
			var new_version = data[1];
			var hasnew = data[2];

			if ( hasnew == 1 ) {
				el = $( 'nonumber_newversionnumber_'+ext );
				if ( el ) {
					el.setText( new_version );
				}
				el = $( 'nonumber_version_'+ext );
				if ( el ) {
					el.setStyle( 'display', 'block' );
					( function() { $each( $$( 'div.jpane-slider' ), function( el ) {
						if ( el.getStyle( 'height' ) != '0px' ) {
							el.setStyle( 'height', 'auto' );
						}
					}); } ).delay( 100 );
				}
			}
		},

		displayLicense: function( ext, state )
		{
			if ( !state ) {
				state = 'fail';
			}

			el = $( 'nonumber_license_'+ext+'_'+state );
			if ( el ) {
				el.setStyle( 'display', 'block' );
				( function() { $each( $$( 'div.jpane-slider' ), function( el ) {
					if ( el.getStyle( 'height' ) != '0px' ) {
						el.setStyle( 'height', 'auto' );
					}
				}); } ).delay( 100 );
			}
		},

		in_array : function( needle, haystack, casesensitive )
		{
			if( {}.toString.call(needle).slice(8, -1) != 'Array' ) {
				arr = new Array();
				arr[0] = needle;
				needle = arr;
			}
			if( {}.toString.call(haystack).slice(8, -1) != 'Array' ) {
				arr = new Array();
				arr[0] = haystack;
				haystack = arr;
			}

			for ( var h = 0; h < haystack.length; h++ ) {
				for ( var n = 0; n < needle.length; n++ ) {
					if ( casesensitive ) {
						if ( haystack[h] == needle[n] ) {
							return true;
						}
					} else {
						if ( haystack[h].toLowerCase() == needle[n].toLowerCase() ) {
							return true;
						}
					}
				}
			}
			return false;
		},

		_getClient : function()
		{
			var ua = navigator.userAgent.toLowerCase();
			var client = {
				isStrict: document.compatMode == "CSS1Compat",
				isOpera: ua.indexOf("opera") > -1,
				isIE: ua.indexOf("msie") > -1,
				isIE7: ua.indexOf("msie 7") > -1,
				isSafari: /webkit|khtml/.test(ua),
				isWindows: ua.indexOf("windows") != -1 || ua.indexOf("win32") != -1,
				isMac: ua.indexOf("macintosh") != -1 || ua.indexOf("mac os x") != -1,
				isLinux: ua.indexOf("linux") != -1
			};
			return client;
		},

		_getDocHeight : function()
		{
			var client = this._getClient();
			var h = window.innerHeight;
			var mode = document.compatMode;
			if ((mode || client.isIE) && !client.isOpera) {
				h = client.isStrict ? document.documentElement.clientHeight: document.body.clientHeight
			}
			return h;
		},

		_fixTop : function()
		{
			this.overlay.style.top = document.documentElement.scrollTop + 'px';
		}
	});
}

window.addEvent( 'domready', function() {
	// correct td widths
	$$( '.paramlist_key' ).each( function( td ) {
		td.setStyle( 'width', 140 ).setStyle( 'vertical-align', 'top' );
	});
	$$( '.paramlist_value' ).each( function( td ) {
		if ( td.getAttribute( 'colspan' ) == 2 ) {
			td.setStyle( 'width', 140 );
		}
	});

	if ( $( 'nn_param_preloader' ) ) {
		$( 'nn_param_preloader' ).setStyles({
			visibility: 'hidden'
		});
		( function() {
			$( 'nn_param_preloader_container' ).innerHTML = '';
			$( 'nn_param_preloader' ).setStyles({
				visibility: 'visible'
			}).injectInside( $( 'nn_param_preloader_container' ) );
		} ).delay(2000);
	}
});

function NoNumberElementsHideTD( id )
{
	var div = document.getElementById(id);
	div.parentNode.style.padding=0;
	div.parentNode.style.height=0;
	div.parentNode.style.border=0;

	div.parentNode.parentNode.style.display='none';
}

function NoNumberElementsChangeView( val )
{
	document.getElementById( 'paramsview_state'+val).click();
	$( document.getElementById( 'view_state_div' ) ).removeClass( 'view_state_0' ).removeClass( 'view_state_1' ).removeClass( 'view_state_2' ).addClass( 'view_state_'+val);
}

function NoNumberElementsCheckAll( checkbox, classname )
{
	checkbox.checked = !( NoNumberElementsAllChecked( classname ) );
	$$( 'input.'+classname).each( function( el ) {
		el.checked = checkbox.checked;
	});
}

function NoNumberElementsAllChecked( classname )
{
	var allchecked = 1;
	$$( 'input.'+classname).each( function( el ) {
		if ( !el.checked ) {
			allchecked = 0;
			return;
		}
	});
	return allchecked;
}