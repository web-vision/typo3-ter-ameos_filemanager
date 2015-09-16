<?php
if (!defined ('TYPO3_MODE'))    die ('Access denied.');

$TCA["tx_ameosfilemanager_domain_model_filecategory"] = array(
    "ctrl" => $TCA["tx_ameosfilemanager_domain_model_filecategory"]["ctrl"],
    "interface" => array(
        "showRecordFieldList" => "title,"
    ),
    "feInterface" => $TCA["tx_ameosfilemanager_domain_model_filecategory"]["feInterface"],
    "columns" => array(
        'hidden' => array (        
            'exclude' => 1,
            'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
            'config'  => array (
                'type'    => 'check',
                'default' => '0'
            )
        ),
        'crdate' => array(
            "exclude" => 0, 
            "label" => "LLL:EXT:lang/locallang_general.xml:LGL.crdate",
            "config" => array(
                "type" => "input",
            )
        ),
        'title' => array(
            'exclude' => 0,
            'label' => "LLL:EXT:ameos_filemanager/Resources/Private/Language/locallang_db.xml:tx_ameosfilemanager_domain_model_filecategory.title",
            'config' => array(
                'type' => 'input',
            )
        )
    ),

    "types" => array(
        "0" => array("showitem" => "title,")
    ),
    "palettes" => array(
        "1" => array("showitem" => "")
    )
);
?>