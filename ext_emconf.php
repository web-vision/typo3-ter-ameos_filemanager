<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "ameos_filemanager".
 *
 * Auto generated 09-09-2015 11:49
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
	'title' => 'File manager',
	'description' => 'This will allow you to fully handle file upload in FE context',
	'category' => 'plugin',
	'version' => '1.0.0',
	'state' => 'beta',
	'uploadfolder' => false,
	'createDirs' => '',
	'clearcacheonload' => false,
	'author' => 'Pierre Henrion',
	'author_email' => 'pierre@ameos.com',
	'author_company' => 'Ameos',
	'constraints' => 
	array (
		'depends' => 
		array (
			'typo3' => '6.2.0-7.99.99',
			'php' => '5.4.1-5.6.99',
		),
		'conflicts' => 
		array (
		),
		'suggests' => 
		array (
		),
	),
);

