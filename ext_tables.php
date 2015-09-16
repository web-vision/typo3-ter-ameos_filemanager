<?php
use TYPO3\CMS\Core\Utility\GeneralUtility;
if (!defined('TYPO3_MODE')) { die ('Access denied.'); }

// register plugin
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin('Ameos.' . $_EXTKEY, 'fe_filemanager', 'Frontend File Manager');
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin('Ameos.' . $_EXTKEY, 'fe_filemanager_export', 'Frontend File Manager - Export plugin');
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin('Ameos.' . $_EXTKEY, 'fe_filemanager_search', 'Frontend File Manager - Search form plugin');

// TCA
$TCA["tx_ameosfilemanager_domain_model_folder"] = Array (
    "ctrl" => Array (
        'title' => 'LLL:EXT:ameos_filemanager/Resources/Private/Language/locallang_db.xml:tx_ameosfilemanager_domain_model_folder',
        'label' => 'title', 
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete'            => 'deleted',
        'enablecolumns' => array (
            'disabled' => 'hidden',
            'fe_group' => 'fe_group_read'
        ),
        "default_sortby" => "ORDER BY crdate",
        "dynamicConfigFile" => t3lib_extMgm::extPath($_EXTKEY)."Configuration/Tca/Folder.php",
        "iconfile" => t3lib_extMgm::extRelPath($_EXTKEY)."ext_icon.gif",
        "searchFields" => "title, description, keywords",
        "rootLevel" => 1,
        "security" => array(
            "ignoreRootLevelRestriction" => 1,
            "ignoreWebMountRestriction" => 1,
        ),
        
    ),
    "feInterface" => Array (
        "fe_admin_fieldList" => "title,description,keywords,fe_groups_access,file,folders,",
    )
);

$TCA["tx_ameosfilemanager_domain_model_filedownload"] = Array (
    "ctrl" => Array (
        'title' => 'LLL:EXT:ameos_filemanager/Resources/Private/Language/locallang_db.xml:tx_ameosfilemanager_domain_model_filedownload',
        'label' => 'file', 
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete'            => 'deleted',
        'enablecolumns'     => array (
            'disabled' => 'hidden'
        ),
        "default_sortby" => "ORDER BY crdate",
        "dynamicConfigFile" => t3lib_extMgm::extPath($_EXTKEY)."Configuration/Tca/Filedownload.php",
        "iconfile" => t3lib_extMgm::extRelPath($_EXTKEY)."ext_icon.gif",
        "searchFields" => "file",
    ),
    "feInterface" => Array (
        "fe_admin_fieldList" => "file,crdate,cruser_id,",
    )
);

// Categorization
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::makeCategorizable(
        'ameos_filemanager',
        'tx_ameosfilemanager_domain_model_folder',
        // Do not use the default field name ("categories"), which is already used
        // Also do not use a field name containing "categories" (see http://forum.typo3.org/index.php/t/199595/)
        'cats',
        array(
                'exclude' => FALSE,
        )
);

// Added columns 
$additionalColumnsMetadata = include(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('ameos_filemanager') . 'Configuration/Tca/Metadata.php');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('sys_file_metadata', $additionalColumnsMetadata);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('sys_file_metadata', '--div--;LLL:EXT:ameos_filemanager/Resources/Private/Language/locallang_db.xml:tx_ameosfilemanager,datetime,no_read_access,fe_group_read, no_write_access,fe_group_write,keywords,fe_user_id,');

//Flexform

$TCA['tt_content']['types']['list']['subtypes_excludelist']['ameosfilemanager_fe_filemanager'] = 'layout,select_key,recursive';
$TCA['tt_content']['types']['list']['subtypes_addlist']['ameosfilemanager_fe_filemanager']     = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('ameosfilemanager_fe_filemanager', 'FILE:EXT:'. $_EXTKEY . '/Configuration/FlexForms/filemanager.xml');

$TCA['tt_content']['types']['list']['subtypes_excludelist']['ameosfilemanager_fe_filemanager_export'] = 'layout,select_key,recursive';
$TCA['tt_content']['types']['list']['subtypes_addlist']['ameosfilemanager_fe_filemanager_export']     = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('ameosfilemanager_fe_filemanager_export', 'FILE:EXT:'. $_EXTKEY . '/Configuration/FlexForms/export.xml');

$TCA['tt_content']['types']['list']['subtypes_excludelist']['ameosfilemanager_fe_filemanager_search'] = 'layout,select_key,recursive';
$TCA['tt_content']['types']['list']['subtypes_addlist']['ameosfilemanager_fe_filemanager_search']     = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('ameosfilemanager_fe_filemanager_search', 'FILE:EXT:'. $_EXTKEY . '/Configuration/FlexForms/search.xml');

// Typoscript
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/Typoscript/', 'Ameos file manager');

if (TYPO3_MODE == 'BE') {

    // wizicon
    $TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['Ameos\\AmeosFilemanager\\Wizicon\\Filemanager'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Classes/Wizicon/Filemanager.php';


    //Slots

    $dispatcher = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager')->get('TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher');
        
    /*
     * FOLDERS SLOTS
     */

    $dispatcher->connect(
        'TYPO3\\CMS\\Core\\Resource\\ResourceStorage', 'postFolderRename',
        'Ameos\\AmeosFilemanager\\Slots\\Slot', 'postFolderRename'
    );

    $dispatcher->connect(
        'TYPO3\\CMS\\Core\\Resource\\ResourceStorage', 'postFolderAdd',
        'Ameos\\AmeosFilemanager\\Slots\\Slot', 'postFolderAdd'
    );

    $dispatcher->connect(
        'TYPO3\\CMS\\Core\\Resource\\ResourceStorage', 'postFolderMove',
        'Ameos\\AmeosFilemanager\\Slots\\Slot', 'postFolderMove'
    );

    $dispatcher->connect(
        'TYPO3\\CMS\\Core\\Resource\\ResourceStorage', 'postFolderCopy',
        'Ameos\\AmeosFilemanager\\Slots\\Slot', 'postFolderCopy'
    );

    $dispatcher->connect(
        'TYPO3\\CMS\\Core\\Resource\\ResourceStorage', 'postFolderDelete',
        'Ameos\\AmeosFilemanager\\Slots\\Slot', 'postFolderDelete'
    );

    /*
     * FILES SLOTS
     */

    $dispatcher->connect(
        'TYPO3\\CMS\\Core\\Resource\\ResourceStorage', 'postFileAdd',
        'Ameos\\AmeosFilemanager\\Slots\\Slot', 'postFileAdd'
    );

    $dispatcher->connect(
        'TYPO3\\CMS\\Core\\Resource\\ResourceStorage', 'postFileCopy',
        'Ameos\\AmeosFilemanager\\Slots\\Slot', 'postFileCopy'
    );

    $dispatcher->connect(
        'TYPO3\\CMS\\Core\\Resource\\ResourceStorage', 'postFileMove',
        'Ameos\\AmeosFilemanager\\Slots\\Slot', 'postFileMove'
    );

}

?>
