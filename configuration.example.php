<?php
/***************************************
       Configuration Instructions       

1. Determine which shortcodes you want to support and list them in $dt_shortcodes.

	In the example configuration, we define two shortcodes: phone and city.
	These would be used in a post by typing [phone] and [city]
	'phone' and 'city' are only provided as examples. Use whatever shortcodes you prefer.
	
2. Determine what parameters you want to support. Enter in first level of $dt_params

	In the example configuration, we have one parameter configured: user
	This means we'd expect a URL like:
		http://yoursite.com/?user=xyz
		(ignore xyz for now, this will be discussed in step 3)
	
	It would also work on a specific page:
		http://yoursite.com/specific-page/?user=xyz
	
	It doesn't even have to be the first parameter:
		http://yoursite.com/?other_param=abc&user=xyz
	
	You can configure multiple parameters:
	$dt_params = array(
		'user'	=> array( //first level
			... second and third levels snipped ...
		),
		'color'	=> array( //first level
			... second and third levels snipped ...
		),
		'id'	=> array( //first level
			... second and third levels snipped ...
		),
		'' => array( // this is our default if no param/value match
			'default' => array(
				'phone' => '414-555-1212',
				'city'  => 'Somewhere',				
			),			
		),
	);
	If you have more than one parameter configured, list them in priority from top to bottom.
	If more than one appears on the URL at the same time, the topmost one will win (not first in URL)
	For example, using the mutiple param config above:
		http://yoursite.com/?other_param=abc&id=123&user=xyz
		'user' would be checked before 'id' because it appears higher in the config
	
	There's also an empty parameter shown as ''. This is the default config and is discussed in step 4.

3. 	For each parameter defined in step 2, you can configure the values to be matched in the second level

	In the example configuration, we support two values for the 'user' param: joel and scott
	We would match either URL:
		http://yoursite.com/?user=joel
		http://yoursite.com/?user=scott
		
	This URL would *not* match the config, meaning the default config is used instead
		http://yoursite.com/?user=ricardo
	
	If you have multiple parameters configured in step 2, they don't need to have the same values configured.
	This is a perfectly valid config:
	$dt_params = array(
		'user'	=> array( //first level
			'joel'  => array(
				... third level snipped ...
			),
			'scott' => array(
				... third level snipped ...
			) 
		),
		'color'	=> array( //first level
			'blue'  => array(
				... third level snipped ...
			),
			'green' => array(
				... third level snipped ...
			)
		),
		'' => array( // this is our default if no param/value match
			'default' => array(
				'phone' => '414-555-1212',
				'city'  => 'Somewhere',				
			),			
		),
	);
	
	If a URL has multiple parameters, and the value for the first param doesn't match,
	it will continue on to the next, and so on . . .
	Example: http://yoursite.com/?user=rasmus&color=green
	 This will match the color/green configuration, not the user configuration.
	 Even though 'user' is higher priority, there is no value of 'rasmus' configured, so it keeps trying to match
	 and it finds color=green instead. The shortcode values defined in the third level under color/green will be used.
	
4. Each configuration should conclude with an empty parameter containing only one value: default.
	It is used when no other configuration is matched.
	
5. Configure the shortcode values to substitue for every param/value combination.
	This is done in the third level of the configuration block. You should provide a value
	for EACH shortcode defined in $dt_shortcodes.

***************************************/

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