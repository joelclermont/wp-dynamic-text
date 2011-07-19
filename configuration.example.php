<?php
// these are the short codes that will be
// handled by this plugin
$dt_shortcodes = array(
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
$dt_params = array(
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