/**
 * Core Design Login Module for Joomla! 1.5
 * Based on Joomla! OpenID Core script
 */

/**
 * JOpenID javascript behavior
 *
 * Used for switching between normal and openid login forms
 *
 * @package		Joomla
 * @since		1.5
 * @version     1.0
 */
var Cd_JOpenID = new Class({

	state    : false,
	link     : null,
	switcher : null,

	initialize: function()
	{
	
		//Create dynamic elements
		var div_element = new Element('div', { 'styles' : {'clear': 'both'} });
		div_element.inject($('cd_login_form_login').getElement('fieldset'));
		
		var switcher = new Element('a', { 'styles': {'cursor': 'pointer'},'id': 'openid-link'});
		switcher.inject($('cd_login_form_login').getElement('fieldset'));
		
		var link = new Element('a', { 'styles': {'display' : 'block', 'font-size' : 'xx-small', 'font-style' : 'italic'}, 'href' : 'http://openid.net', 'target' : '_blank'});
		link.inject($('cd_login_form_login').getElement('fieldset'));
	

		//Initialise members
		this.switcher = switcher;
		this.link     = link;
		this.state    = Cookie.get('login-openid');
		this.length   = $('form-login-password').getSize().size.y;

		this.switchID(this.state, 0);

		this.switcher.addEvent('click', (function(event) {
			this.state = this.state ^ 1;
			this.switchID(this.state, 300);
			Cookie.set('login-openid', this.state);
		}).bind(this));
	},

	switchID : function(state, time)
	{
		var password = $('modlgn_passwd');
		var username = $('modlgn_username');

		if(state == 0)
		{
			username.removeClass('system-openid');
			username.removeProperty('style');
			
			var text = JLanguage.LOGIN_WITH_OPENID;
			password.disabled = 0;
		}
		else
		{
			username.addClass('system-openid');
			username.setStyle('background-image', 'url(http://openid.net/login-bg.gif)');
			
			var text = JLanguage.NORMAL_LOGIN;
			password.disabled = 1;
			
		}
		
		if (state == 0) {
			password.effect('opacity', {duration: time}).start(0.2, 1);
		} else {
			password.effect('opacity', {duration: time}).start(state, 0.2);
		}
		
		this.switcher.setHTML(text);
		this.link.setHTML(JLanguage.WHAT_IS_OPENID);
	}
});

document.cd_openid = null;

window.addEvent('domready', function(){
		
	  if (typeof cd_modlogin != 'undefined' && cd_modlogin == 1) {
	  	var cd_openid = new Cd_JOpenID();
	  	document.cd_openid = cd_openid;
	  };
});
