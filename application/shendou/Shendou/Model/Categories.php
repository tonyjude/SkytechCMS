<?php
class Shendou_Model_Categories extends Shendou_Model 
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
		unset($data['cate_id']);
		$table = new Lamb_Db_Table('skytech_categories', Lamb_Db_Table::INSERT_MODE);
		
		$db = $this->mApp->getDb();
		$sql = $table->set($data)->getInsertSql();
		$db->query($sql);
		
		$id = $db->lastInsertId();
		if (!$id) {
			return -1;
		}
		
		if (isset($data['cate_is_topic']) && $data['cate_is_topic']) {
			$cate_topic_templte = $data['cate_topic_templte'] != '' ? $data['cate_topic_templte'] : 'topic';
			$date = date('Y-m-d');
			$flag = $db->query("insert into skytech_topic (id, topic_name, topic_postdate, topic_url, topic_templte) values ($id, '{$data['cate_name']}', '{$date}', '{$data['cate_url']}', '{$cate_topic_templte}' )");
			if(!$flag){
				return -2;
			}
		}

		if ($data['cate_parent_id'] == 0) {
			$cate_path = $id . '@';
		} else {
			$path = $db->query('select cate_path from skytech_categories where id=' . $data['cate_parent_id'])->toArray();
			$cate_path = $path[0]['cate_path'] . $id . '@';
 		}
		
		$cate_level = substr_count($cate_path, '@');
		$flag = $db->query("update skytech_categories set cate_path = '$cate_path', cate_level = $cate_level where id=$id");
		if ($flag) {
			return 1;
		}
		return 0;
	}
	
	public function get($id, $fields = '*')
	{
		if (Lamb_Utils::isInt($id, true)) {
			$sql = "select {$fields} from skytech_categories where id = :id";
			$aPrepareSource = array(
				':id' => array($id, PDO::PARAM_INT)
			);
		} else {
			$sql = "select {$fields} from skytech_categories where 	cate_name = :cate_name";
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
	
	public function getByIds(array $ids)
	{
		$ids = implode(',', $ids);
		$sql = 'select id,cate_name,cate_is_topic from skytech_categories where id in (' . $ids . ')';
		$ret = $this->mApp->getDb()->query($sql)->toArray();
		return $ret;
	}
	
	
	/**
	 * @param string $val
	 * @param array $data
	 * @param bollen $upnext 是否修改
	 * @return int
	 */
	public function update($id, array $data, $isUpdateTopic=false)
	{
		unset($data['id']);
		if(!($ret = $this->get($id))){
			return 0;
		}

		//如果要把栏目修改成专题
		if ($data['cate_is_topic']) {
			$db = $this->mApp->getDb();
			$cate_topic_templte = $data['cate_topic_templte'] != '' ? $data['cate_topic_templte'] : 'topic';
			$date = date('Y-m-d');
			$res = $db->query("select id,topic_templte from skytech_topic where id={$id}")->toArray();

			if (empty($res)) {
				$db->query("insert into skytech_topic (id, topic_name, topic_postdate, topic_url, topic_templte) values ($id, '{$ret['cate_name']}', '{$date}', '{$ret['cate_url']}', '{$cate_topic_templte}')");
			} else {
				$db->query("update skytech_topic set topic_templte='{$cate_topic_templte}', topic_name='{$data['cate_name']}'  where id={$id}");
			}
		}

		if ($isUpdateTopic) {
		   unset($data['cate_is_topic']);	
		}
		
		$table = new Lamb_Db_Table('skytech_categories');
		return $table->setOrGetWhere('id=' . $ret['id'])
			  		 ->set($data)
					 ->execute();  		
	}
	
	
	/**
	 *  递归修改栏目信息
	 *  @param int $id 栏目id
	 *  @param array $data
	 */
	public function updateSubCateInfo($id, array $data)
	{
		$temp = array(
		     'cate_is_topic' => $data['cate_is_topic'],
		     'cate_list_template' =>  $data['cate_list_template'],
		     'cate_article_templte'  => $data['cate_article_templte'],
		     'cate_topic_templte' => $data['cate_topic_templte']
		);
     	
		$ret = $this->mApp->getDb()->query("select * from skytech_categories where cate_parent_id={$id}")->toArray();
		if (!empty($ret)) {
			foreach ($ret as $item) {
				$this->update($item['id'], $temp, true);
				$this->updateSubCateInfo($item['id'], $temp);
			}
		}

		return true;
	}

	
	/**
	 * @param 对于栏目的删除涉及到递归删除其所有子栏目等情况，考虑进度暂时不做处理
	 * @return boolean
	 */
	public function delete($id)
	{		
		$db = $this->mApp->getDb();
		$sql = 'delete from skytech_categories where id = :id';
		
		return $db->quickPrepare($sql, array(':id' => array($id, PDO::PARAM_INT)), true);
	}
	
	
}