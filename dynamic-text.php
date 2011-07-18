<?php
/*
Plugin Name: Dynamic Text
Plugin URI: https://github.com/joelclermont/wp-dynamic-text
Description: This plugin allows you to show dynamic text blocks (as shortcodes) based on a query string value or cookie
Author: Joel Clermont
Version: 0.1
Author URI: http://joelclermont.com/
License: MIT

Copyright (C) 2011 by Joel Clermont

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
*/

if ( ! class_exists( 'DynamicText' ) ) {
class DynamicText
{
	// these are the short codes that will be
	// handled by this plugin
	protected $_shortcodes = array(
		'phone',
		'city',
	);

	// main configuration data
	// maps parameters to values to shortcode substitutions
	//
	// first level = param names
	// second level = possible values for param (including a default)
	// third level = for this param/value, specify a value for each shortcode in $_textblocks
	//
	// TODO: move this into a more sane data structure
	protected $_params = array(
		'user'	=> array(
			'joel'    => array(
				'phone' => 'aaa-bbb-cccc',
				'city'  => 'Grafton',
			),
			'scott'   => array(
				'phone' => 'xxx-yyy-zzzz',
				'city'  => 'Brookfield',				
			),
		),
		'' => array( // this is our default if no param/value match
			'default' => array(
				'phone' => '414-555-1212',
				'city'  => 'Somewhere',				
			),			
		),
	 );

	private $_paramName;
	private $_paramValue;
	
	// initialize our shortcodes
	// and set internal state based on the environment
	public function __construct()
	{
		$this->register_shortcodes();
		$this->set_param();
	}
	
	// loop over each shortcode and register it with WP
	// all codes will call the same get_text() function
	private function register_shortcodes()
	{
		foreach ( $this->_shortcodes as $code ) {
			add_shortcode( $code, array( $this, 'get_text' ) );
		}
	}

	// loop through all the possible parameters
	// first one found wins! (and gets a cookie)
	private function set_param()
	{
		foreach ( $this->_params as $param => $config ) {
			$this->find_param( $param );
			if ( '' != $this->_paramName ) {
				// we found a match, stop looking
				break;
			}
		}
		// at this point, we either found a match or are using the default
		// save to a cookie for subsequent requests
		$this->clear_previous_cookies();
		setcookie( 'dynamictext'.$this->_paramName, $this->_paramValue, time() + 60 * 60 * 24 * 365 );
	}
	
	// try to find a configuration for the parameter
	// first check query string, then cookie
	// key and value have to match config to be valid
	private function find_param( $paramName )
	{
		if ( array_key_exists( $paramName, $_GET ) && array_key_exists( $_GET[$paramName], $this->_params[$paramName] ) ) {
			//first check if the param exists in the URL
			$this->_paramName  = $paramName;
			$this->_paramValue = $_GET[$paramName];
		} else if ( array_key_exists( 'dynamictext'.$paramName, $_COOKIE ) && array_key_exists( $_COOKIE['dynamictext'.$paramName], $this->_params[$paramName] ) ) {
			//next check for a cookie
			$this->_paramName  = $paramName;
			$this->_paramValue = $_COOKIE['dynamictext'.$paramName];
		} else {
			//fall back to default
			$this->_paramName  = '';
			$this->_paramValue = 'default';
		}
	}
	
	// clear any existing cookies set by this plugin
	// for example, when a query string overrides an existing cookie
	private function clear_previous_cookies()
	{
		foreach ( $_COOKIE as $key => $val ) {
			if ( 'dynamictext' == substr( $key, 0, 11 ) ) {
				//delete cookie by setting expiration in the past
				setcookie( $key, '', time() - 3600 );
			}
		}
	}
	
	// this function handles the shortcode for WP
	// more info: http://codex.wordpress.org/Shortcode_API
	public function get_text( $attributes, $content = null, $code = '' )
	{
	    return $this->_params[$this->_paramName][$this->_paramValue][$code];
	}
}
}
// initialize our plugin
$dynamicTextPlugin = new DynamicText();