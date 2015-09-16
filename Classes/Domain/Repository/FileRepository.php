<?php

namespace Ameos\AmeosFilemanager\Domain\Repository;

class FileRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	protected $defaultOrderings = array(
		'tstamp' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
	);

	/**
	 * Initialization
	 */
	public function initializeObject() {
		$querySettings = $this->createQuery()->getQuerySettings();
		$querySettings->setRespectStoragePage(FALSE);
        $this->setDefaultQuerySettings($querySettings);
	}

	public function findFilesForFolder($folder) {
		if(empty($folder)) {
			return $this->findAll();
		}
		
		$fields = 'sys_file.uid'; 
		$from = 'sys_file, sys_file_metadata';
		$where = "sys_file_metadata.file = sys_file.uid AND sys_file_metadata.folder_uid = ".$folder;
		
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
			$fields, 
			$from, 
			$where
		);
		$uid = array();
		foreach($res as $r){
			$uid[] = $r['uid'];
		}
		
		$query = $this->createQuery();
		if(!empty($uid)){
			$query->matching($query->in('uid', $uid));
		}
		else{
			return array();
		}
		return $query->execute();
	}

	/**
	 * Return all filter by search criterias
	 * @param array $criterias criterias
	 */
	public function findBySearchCriterias($criterias) {
		if(!is_array($criterias) || empty($criterias)) {
			return $this->findAll();
		}
		
		$fields = 'distinct sys_file.uid'; 
		$from = 'sys_file_metadata INNER JOIN sys_file  ON sys_file_metadata.file=sys_file.uid LEFT JOIN sys_category_record_mm ON sys_file_metadata.uid = sys_category_record_mm.uid_foreign LEFT JOIN sys_category ON sys_category_record_mm.uid_local = sys_category.uid';
		$where = "";
		if(isset($criterias['keyword']) && $criterias['keyword'] !== '') {
			$where .= "(sys_category_record_mm.tablenames LIKE 'sys_file_metadata' OR sys_category_record_mm.tablenames IS NULL) 
				AND (
					sys_file_metadata.title LIKE '%".$criterias['keyword']."%' 
				     OR sys_file_metadata.description LIKE '%".$criterias['keyword']."%' 
				     OR sys_file_metadata.keywords LIKE '%".$criterias['keyword']."%' 
				     OR sys_file.name LIKE '%".$criterias['keyword']."%' 
				     OR sys_category.title LIKE '%".$criterias['keyword']."%' 
				)";
		}
		
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
			$fields, 
			$from, 
			$where
		);
		$uid = array();
		foreach($res as $r){
			$uid[] = $r['uid'];
		}
		
		$query = $this->createQuery();
		if(!empty($uid)){
			$query->matching($query->in('uid', $uid));
		}
		else{
			return array();
		}
		return $query->execute();
	}

	public function findAuthorizedFiles($user, $minDatetime = 0) {
		$query = $this->createQuery();

		$fields       = 'distinct sys_file.uid, sys_file_metadata.folder_uid';
		$tables       = 'sys_file_metadata, sys_file';		
		$orderBy      = 'sys_file_metadata.datetime DESC';
		$whereClauses = array();
		$whereClauses[] = 'sys_file_metadata.file = sys_file.uid';
		$whereClauses[] = 'sys_file_metadata.datetime >= ' . (int)$minDatetime;
		$whereClauses[] = '(
			sys_file_metadata.fe_user_id = ' . $user['uid'] . ' OR
			sys_file_metadata.no_read_access = 0
		)';

		$query->statement($GLOBALS['TYPO3_DB']->SELECTquery($fields, $tables, implode(' AND ', $whereClauses), '', $orderBy));
		return $query->execute();
	}

	public function findAll() {

		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
			'distinct sys_file.uid', 
			'sys_file_metadata INNER JOIN sys_file ON sys_file_metadata.file=sys_file.uid', 
			'',
			''
		);
		
		$uid = array();
		foreach($res as $r){
			$uid[] = $r['uid'];
		}
		
		$query = $this->createQuery();
		$query->matching($query->in('uid', $uid));
		return $query->execute();
	}

	public function findByUid($fileUid,$writeRight=false) {
		if(empty($fileUid)) {
			return 0;
		}
		if($writeRight) {
			$column = 'fe_group_write';
		}
		else {
			$column = 'fe_group_read';	
		}
		$userGroups = $GLOBALS['TSFE']->gr_list;

		$query = $this->createQuery();		
		$where = 'sys_file.uid = ' . $fileUid;
		$where .= " AND (( 
			sys_file_metadata.".$column."='' 
			OR sys_file_metadata.".$column." IS NULL 
			OR sys_file_metadata.".$column."='0' ";
		foreach (explode(',', $userGroups) as $userGroup) {
			$where .= "OR FIND_IN_SET('".$userGroup."',sys_file_metadata.".$column.") ";
		}
		if($GLOBALS['TSFE']->fe_user->user) {
			$where .= ') OR sys_file_metadata.fe_user_id = '.$GLOBALS['TSFE']->fe_user->user['uid'] . ')';	
		}
		else {
			$where .= '))';
		}
		
		$query->statement
		(	'	SELECT distinct sys_file.uid, sys_file_metadata.folder_uid 
				FROM sys_file_metadata
				INNER JOIN sys_file 
				ON sys_file_metadata.file=sys_file.uid
				WHERE '.$where.'
				ORDER BY sys_file_metadata.datetime DESC 
			',
			array()
		);
		
        $res = $query->execute()->getFirst();
		return $res;
	}
}