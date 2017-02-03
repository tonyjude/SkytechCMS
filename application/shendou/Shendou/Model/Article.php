<?php
class Shendou_Model_Article extends Shendou_Model 
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
		unset($data['id']);
		$data['art_postdate'] = date('Y-m-d');
		$table = new Lamb_Db_Table('skytech_article', Lamb_Db_Table::INSERT_MODE);
		
		$db = $this->mApp->getDb();
		$sql = $table->set($data)->getInsertSql();
		$db->query($sql);
		
		$id = $db->lastInsertId();
		
		if (!$id) {
			return false;
		}
		
		/**
		 * 插入标签表 | 标签使用数增加
		 */
		if ($data['art_tag'] != '') {
			$tags = explode(',', $data['art_tag']);	
			
			foreach ($tags as $item) {
				$ret = $this->getTag($item);
				if (!$ret) {
					$tag_id = $this->setTag($item);
					if ($tag_id) {
						$this->insertTagRelation($tag_id, $id);
					}
				} else {
					$db->query('update sky_tag set tag_num=tag_num+1 where id=' . $ret['id']);
					$this->insertTagRelation($ret['id'], $id);
				}
			}
		}
		
		$this->setCateArticle($data['art_catalog_id'], $id);
		return $id;
	}
	
	
	/**
	 * 插入栏目文章关联表
	 */
	public function setCateArticle($cate_id, $article_id)
	{
		 $db  = $this->mApp->getDb();
		 $ret = $db->query('select cate_path from skytech_categories where id=' . $cate_id)->toArray();
		 $parent_ids = explode('@', $ret[0]['cate_path']);
		 foreach($parent_ids as $item) {
		 	$db->query("insert into skytech_categories_article (categorie_id, article_id) values ({$item}, {$article_id})");
		 }
	}
	
	public function get($id, $fields = '*')
	{
		if (Lamb_Utils::isInt($id, true)) {
			$sql = "select a.*, b.id as cate_id, cate_name from skytech_article as a, skytech_categories as b where a.art_catalog_id = b.id and a.id = :id";
			$aPrepareSource = array(
				':id' => array($id, PDO::PARAM_INT)
			);
		} else {
			$sql = "select {$fields} from skytech_article where art_title like :art_title";
			$aPrepareSource = array(
				':art_title' => array('%' . $id . '%', PDO::PARAM_STR)
			);
		}
				
		$ret = $this->mApp->getDb()->getNumDataPrepare($sql, $aPrepareSource, true);
		
		if ($ret['num'] != 1) {
			return null;
		}
		
		return $ret['data'];
	}

	public function getTag($tag_name)
	{
		$sql = 'select * from sky_tag where tag_name = :tag_name';
		$aPrepareSource = array(
			':tag_name' => array($tag_name, PDO::PARAM_STR)
		);
		
		$ret = $this->mApp->getDb()->getNumDataPrepare($sql, $aPrepareSource, true);
		
		if ($ret['num'] != 1) {
			return null;
		}
		
		return $ret['data'];
	}
	
	public function setTag($tag_name)
	{
		$sql = 'insert into sky_tag (tag_name) values (:tag_name)';
		$aPrepareSource = array(
			':tag_name' => array($tag_name, PDO::PARAM_STR)
		);
		
		$db = $this->mApp->getDb();
		$db->quickPrepare($sql, $aPrepareSource, true);
		
		return $db->lastInsertId();
	}
	
	public function insertTagRelation($tag_id, $article_id)
	{
		$sql = 'insert into sky_tag_relation (tag_id, article_id) values (:tag_id, :article_id)';
		$aPrepareSource = array(
			':tag_id' => array($tag_id, PDO::PARAM_INT),
			':article_id' => array($article_id, PDO::PARAM_INT)
		);
		
		$db = $this->mApp->getDb();
		$db->quickPrepare($sql, $aPrepareSource, true);
		
		return $db->lastInsertId();
	}

	public function deleteTagRelation($tag_id, $article_id)
	{
		$sql = 'delete from sky_tag_relation where tag_id = :tag_id and article_id = :article_id';
		return $this->mApp->getDb()->quickPrepare($sql, 
			array(
			':tag_id' => array($tag_id, PDO::PARAM_INT),
			':article_id' => array($article_id, PDO::PARAM_INT)
		), true);
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
		
		$db = $this->mApp->getDb();
		
		/**
		 * 修改标签表 | 修改标签使用数增加
		 * 如果标签不为空并且标签已经修改了
		 */
		if ($data['art_tag'] != '' && $data['art_tag'] != $ret['art_tag']) {
			$tags = explode(',', $data['art_tag']);	
			$old_tags = explode(',', $ret['art_tag']);	
			
			$new_temp = array_diff($tags, $old_tags); //获取新标签中新赠的元素
			$old_temp = array_diff($old_tags, $tags); //获取旧标签中删除的元素
			
			//删除旧标签关联表数据
			if (!empty($old_temp)) {
				foreach($old_temp as $item){
					$res = $this->getTag($item);
					if (!$res) {
						continue;
					}
					
					$db->query('update sky_tag set tag_num=tag_num-1 where id=' . $res['id']);
					$this->deleteTagRelation($res['id'], $id);
				}
			}
			
			//插入新标签关联表数据
			if (!empty($new_temp)) {
				foreach($new_temp as $item){
					$res = $this->getTag($item);
					if (!$res) {//如果没找到，就插入
						$tag_id = $this->setTag($item);
						if ($tag_id) {
							$this->insertTagRelation($tag_id, $id);
						}
					} else {
						$db->query('update sky_tag set tag_num=tag_num+1 where id=' . $res['id']);
						$this->insertTagRelation($res['id'], $id);
					}
				}
			}
		} 
		
		/**
		 * 修改文章所属的栏目
		 */
		if (isset($data['art_catalog_id']) && ($ret['art_catalog_id'] != $data['art_catalog_id'])) {
			$db->query("update skytech_categories_article set categorie_id={$data['art_catalog_id']} where categorie_id={$ret['art_catalog_id']} and article_id=$id");
			
			//删除原先的关联关系
			$db->query("delete from skytech_categories_article where article_id=$id");
			
			//添加新的关联关系
			$this->setCateArticle($data['art_catalog_id'], $id);
		}
		
		$table = new Lamb_Db_Table('skytech_article');
		$sql = $table->setOrGetWhere('id=' . $ret['id'])->set($data)->getUpdateSql();
		return $db->query($sql);  		
	}
	
	/**
	 * @param 对于栏目的删除涉及到递归删除其所有子栏目等情况，考虑进度暂时不做处理
	 * @return boolean
	 */
	public function delete($id)
	{		
		$db = $this->mApp->getDb();
		$sql = 'update skytech_article set art_status=0 where id = :id';
		$sql2 = 'delete from skytech_categories_article where article_id = :id';
		
		$db->quickPrepare($sql, array(':id' => array($id, PDO::PARAM_INT)), true);
		$db->quickPrepare($sql2, array(':id' => array($id, PDO::PARAM_INT)), true);
		
		return true;
	}
	
}