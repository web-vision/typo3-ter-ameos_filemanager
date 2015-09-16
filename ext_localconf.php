<?php
if (!defined('TYPO3_MODE')) { die ('Access denied.'); }

// plugin
TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin('Ameos.' . $_EXTKEY, 'fe_filemanager', array('FileManager' => 'index, formFolder, formFile, createFolder, createFile, search, list, detail, deleteFolder, deleteFile'), array('FileManager' => 'index, formFolder, formFile, createFolder, createFile, search, list, detail, deleteFolder, deleteFile'));
TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin('Ameos.' . $_EXTKEY, 'fe_filemanager_export', array('Export' => 'index,exportDownloads'), array('Export' => 'index, exportDownloads'));
TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin('Ameos.' . $_EXTKEY, 'fe_filemanager_search', array('Search' => 'index'), array('Search' => 'index'));

// xclass
$TYPO3_CONF_VARS['SYS']['Objects']['TYPO3\\CMS\\Filelist\\FileList'] = array('className' => 'Ameos\\AmeosFilemanager\\XClass\\FileList');
