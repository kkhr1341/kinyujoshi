<?php
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.7
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2015 Fuel Development Team
 * @link       http://fuelphp.com
 */

/**
 * NOTICE:
 *
 * If you need to make modifications to the default configuration, copy
 * this file to your app/config folder, and make them in there.
 *
 * This will allow you to upgrade fuel without losing your custom config.
 */

return array(

	/**
	 * link_multiple_providers
	 *
	 * Can multiple providers be attached to one user account
	 */
	'link_multiple_providers' => true,

	/**
	 * auto_registration
	 *
	 * If true, a login via a provider will automatically create a dummy
	 * local user account with a random password, if a nickname and an
	 * email address is present
	 */
	'auto_registration' => false,

	/**
	 * default_group
	 *
	 * Group id to be assigned to newly created users
	 */
	'default_group' => 1,

	/**
	 * debug
	 *
	 * Uncomment if you would like to view debug messages
	 */
	'debug' => false,

	/**
	 * A random string used for signing of auth response.
	 *
	 * You HAVE to set this value in your application config file!
	 */
	'security_salt' => 'aer09gua0nnIhh',

	/**
	 * Higher value, better security, slower hashing;
	 * Lower value, lower security, faster hashing.
	 */
	'security_iteration' => 300,

	/**
	 * Time limit for valid $auth response, starting from $auth response generation to validation.
	 */
	'security_timeout' => '2 minutes',

	/**
	 * Strategy
	 * Refer to individual strategy's documentation on configuration requirements.
	 */
	'Strategy' => array(

	
		'Facebook' => array(
			'app_id' => '831295686992946',
			'app_secret' => '72bb81535e1c4b2c94fb50c18e6aabfb',
			'scope' => 'email'
		),

		'Google' => array(
      'client_id' => '672413732514-85gg5ji4np1gqd2eftg813q4nn2s67ck.apps.googleusercontent.com',
      'client_secret' => 'NLdR8jm7AS-8NkwP9Gdm29oY',
      //'redirect_uri' => 'http://local.kinyu-joshi.jp/',
      //'scope' => 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email',
     	'scope' => 'email'
     ),
	

	 ),
);
