<?php
class Shendou_Model_Navigation extends Shendou_Model 
{
	
	public function __construct()
    {   
        parent::__construct();
	}
		
	/**
	 * @param array $data
	 * @return int
	 */
	public function add($data)
	{
		$sql = 'insert into skytech_cate_navigation (cate_name, cate_url, cate_parent_id, cate_sort, cate_seo_title, cate_keywords, cate_description) values (:cate_name, :cate_url, :cate_parent_id, :cate_sort, :cate_seo_title, :cate_keywords, :cate_description )';
		$aPrepareSource = array(
			':cate_name'   => array($data['cate_name'], PDO::PARAM_STR),
			':cate_url'   => array($data['cate_url'], PDO::PARAM_STR),
			':cate_parent_id'   => array($data['cate_parent_id'], PDO::PARAM_INT),
			':cate_sort'   => array($data['cate_sort'], PDO::PARAM_INT),
			':cate_seo_title'   => array($data['cate_seo_title'], PDO::PARAM_STR),
			':cate_keywords'   => array($data['cate_keywords'], PDO::PARAM_STR),
			':cate_description'   => array($data['cate_description'], PDO::PARAM_STR)
		);
		
		$db = $this->mApp->getDb();
		if (!$db->quickPrepare($sql, $aPrepareSource, true)) {
			return 0;
		}
		
		$id = $db->lastInsertId();
		if (!$id) {
			return false;
		}
		
		if ($data['cate_parent_id'] == 0) {
			$cate_path = $id . '@';
		} else {
			$path = $db->query('select cate_path from skytech_cate_navigation where id=' . $data['cate_parent_id'])->toArray();
			$cate_path = $path[0]['cate_path'] . $id . '@';
 		}
		
		$cate_level = substr_count($cate_path, '@');
		$flag = $db->query("update skytech_cate_navigation set cate_path = '$cate_path', cate_level = $cate_level where id=$id");
		
		
		return $flag;

	}
	
	public function get($id)
	{
		if (Lamb_Utils::isInt($id, true)) {
			$sql = 'select * from skytech_cate_navigation where id = :id';
			$aPrepareSource = array(
				':id' => array($id, PDO::PARAM_INT)
			);
		} else {
			$sql = 'select * from skytech_cate_navigation where cate_name = :cate_name';
			$aPrepareSource = array(
				':cate_name' => array($id, PDO::PARAM_STR)
			);
		}
				
		$ret = $this->mApp->getDb()->getNumDataPrepare($sql, $aPrepareSource, true);
		
		if ($ret['num'] != 1) {
			return null;
		}
		
		return $ret['data'];
	}
	
	
	
	/**
	 * @param array $data
	 * @param string $val
	 * @return int
	 */
	public function update($id, array $data)
	{
		unset($data['id']);
		if(!($ret = $this->get($id))){
			return 0;
		}
		
		$table = new Lamb_Db_Table('skytech_cate_navigation');
		return $table->setOrGetWhere('id=' . $ret['id'])
			  		 ->set($data)
					 ->execute();  		
	}
	
	/**
	 * @param 对于栏目的删除涉及到递归删除其所有子栏目等情况，考虑进度暂时不做处理
	 * @return boolean
	 */
	public function delete($id)
	{		
		$db = $this->mApp->getDb();
		$sql = 'delete from skytech_cate_navigation where id = :id';
		
		return $db->quickPrepare($sql, array(':id' => array($id, PDO::PARAM_INT)), true);
	}
	
	
}