<?php
if (!defined ('TYPO3_MODE'))    die ('Access denied.');

return array (
    'tx_ameosfilemanager_domain_model_folder' => array(
        'exclude' => 0,
        'label' => 'Folder',
        'config' => array(
            'type' => 'select',
            'size' => 5,
            'maxitems' => 1,
            'foreign_table' => 'tx_ameosfilemanager_domain_model_folder',
            'foreign_table_where' => 'ORDER BY tx_ameosfilemanager_domain_model_folder.title'
        )
    ),
);