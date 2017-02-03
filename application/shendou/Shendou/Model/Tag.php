<?php
class Shendou_Model_Tag extends Shendou_Model 
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
		$table = new Lamb_Db_Table('sky_tag', Lamb_Db_Table::INSERT_MODE);
		return $table->set($data)->execute();
	}
	
	public function get($id)
	{
		if (Lamb_Utils::isInt($id, true)) {
			$sql = 'select * from sky_tag where id = :id';
			$aPrepareSource = array(
				':id' => array($id, PDO::PARAM_INT)
			);
		} else {
			$sql = 'SELECT sa.* FROM skytech_article as sa, sky_tag_relation as str, sky_tag as st WHERE str.tag_id = st.id and sa.id = str.article_id and st.tag_name=:tag_name';
			$aPrepareSource = array(
				':tag_name' => array($id, PDO::PARAM_STR)
			);
		}
				
		return $this->mApp->getDb()->quickPrepare($sql, $aPrepareSource)->toArray();
	}
	
	public function getTagRelation($articleId)
	{
		$sql = 'SELECT st.tag_name FROM sky_tag_relation as str, sky_tag as st where str.tag_id = st.id and str.article_id = :article_id';
		
		$aPrepareSource = array(
			':article_id' => array($articleId, PDO::PARAM_INT)
		);
		
		return $this->mApp->getDb()->quickPrepare($sql, $aPrepareSource)->toArray();
	}
	
	
	/**
	 * @param array $data
	 * @param string $val
	 * @return int
	 */
	public function update($id, array $data)
	{
		unset($data['id']);
		$table = new Lamb_Db_Table('sky_tag');
		return $table->setOrGetWhere('id=' . $id)->set($data)->execute();
	}
	
	/**
	 * @param string $val
	 * @return boolean
	 */
	public function delete($id)
	{
		$sql = 'delete from sky_tag where id = :id';
		return $this->mApp->getDb()->quickPrepare($sql, array(':id' => array($id, PDO::PARAM_INT)), true);
	}
	
	
}