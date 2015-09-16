<?php
if (!defined ('TYPO3_MODE'))    die ('Access denied.');


return array(
    'fe_group_read' => array(
        'exclude' => 1,
        'label' => 'LLL:EXT:ameos_filemanager/Resources/Private/Language/locallang_db.xml:tx_ameosfilemanager_domain_model_file.fe_groups_read',
        'config' => array(
            'type' => 'select',
            'size' => 5,
            'maxitems' => 20,
            'items' => array(
                array(
                    'LLL:EXT:lang/locallang_general.xlf:LGL.any_login',
                    -2
                ),
                array(
                    'LLL:EXT:lang/locallang_general.xlf:LGL.usergroups',
                    '--div--'
                )
            ),
            'exclusiveKeys' => '-1,-2',
            'foreign_table' => 'fe_groups',
            'foreign_table_where' => 'ORDER BY fe_groups.title'
        )
    ),
    "keywords" => array(      
            "exclude" => 0,   
            "label" => "LLL:EXT:ameos_filemanager/Resources/Private/Language/locallang_db.xml:tx_ameosfilemanager_domain_model_folder.keywords",     
            "config" => array(
                "type" => "text", 
                "cols" => "15",
                "rows" => "5", 
                "eval" => "trim", 
            )
        ),
    'fe_group_write' => array(
        'exclude' => 1,
        'label' => 'LLL:EXT:ameos_filemanager/Resources/Private/Language/locallang_db.xml:tx_ameosfilemanager_domain_model_file.fe_groups_write',
        'config' => array(
            'type' => 'select',
            'size' => 5,
            'maxitems' => 20,
            'items' => array(
                array(
                    'LLL:EXT:lang/locallang_general.xlf:LGL.any_login',
                    -2
                ),
                array(
                    'LLL:EXT:lang/locallang_general.xlf:LGL.usergroups',
                    '--div--'
                )
            ),
            'exclusiveKeys' => '-1,-2',
            'foreign_table' => 'fe_groups',
            'foreign_table_where' => 'ORDER BY fe_groups.title'
        )
    ),
    "no_read_access" => array(
        "exclude" => 0, 
        "label" => "LLL:EXT:ameos_filemanager/Resources/Private/Language/locallang_db.xml:tx_ameosfilemanager_domain_model_file.no_read_access",
        "config" => array(
            "type" => "check",
            "default" => "0",
        )
    ),
    "no_write_access" => array(
        "exclude" => 0, 
        "label" => "LLL:EXT:ameos_filemanager/Resources/Private/Language/locallang_db.xml:tx_ameosfilemanager_domain_model_file.no_write_access",
        "config" => array(
            "type" => "check",
            "default" => "0",
        )
    ),
    'fe_user_id' => array(
        'exclude' => 0,
        'label' => "LLL:EXT:ameos_filemanager/Resources/Private/Language/locallang_db.xml:tx_ameosfilemanager_domain_model_file.fe_user_id",
        'config' => array(
            'type' => 'select',
            'maxitems' => 1,
            'items' => array(
                array(
                    '',
                    0
                ),
            ),
            'size' => 1,
            'foreign_table' => 'fe_users',
        )
    ),
    'folder_uid' => array(
        'exclude' => 0,
        'label' => "LLL:EXT:ameos_filemanager/Resources/Private/Language/locallang_db.xml:tx_ameosfilemanager_domain_model_file.folder_uid",
        'config' => array(
            'type' => 'select',
            'maxitems' => 1,
            'items' => array(
                array(
                    '',
                    0
                ),
            ),
            'size' => 1,
            'foreign_table' => 'tx_ameosfilemanager_domain_model_folder',
        )
    ),
    "datetime" => array(
        "exclude" => 0, 
        "label" => "LLL:EXT:ameos_filemanager/Resources/Private/Language/locallang_db.xml:tx_ameosfilemanager_domain_model_file.datetime",
        'config' => array(
                'type' => 'input',
                'size' => '8',
                'max' => '20',
                'eval' => 'datetime',
                'checkbox' => '0',
                'default' => '0',
            )
    ),
);