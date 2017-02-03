<?php
class Shendou_Model_Createtable extends Shendou_Model 
{
	
	public function __construct()
    {   
        parent::__construct();
	}
		
	function createFromFile($sqlPath,$delimiter = '(;\n)|((;\r\n))|(;\r)',$prefix = '',$commenter = array('#','--'))
    {
        //判断文件是否存在
        if(!file_exists($sqlPath))
            return false;

        $handle = fopen($sqlPath,'rb');   

        $sqlStr = fread($handle,filesize($sqlPath));

        //通过sql语法的语句分割符进行分割
        $segment = explode(";",trim($sqlStr));

        //var_dump($segment);

        //去掉注释和多余的空行
        foreach($segment as & $statement) {
            $sentence = explode("\n",$statement);

            $newStatement = array();

            foreach($sentence as $subSentence)
            {
                if('' != trim($subSentence))
                {
                    //判断是会否是注释
                    $isComment = false;
                    foreach($commenter as $comer)
                    {
                        if(preg_match("/^".$comer."/",trim($subSentence)))
                        {
                            $isComment = true;
                            break;
                        }
                    }
                    //如果不是注释，则认为是sql语句
                    if(!$isComment)
                        $newStatement[] = $subSentence;                   
                }
            }

            $statement = $newStatement;
        }
        //对表名加前缀
        if('' != $prefix){

            //只有表名在第一行出现时才有效 例如 CREATE TABLE talbeName
            $regxTable = "^[/`/'/\"]{0,1}[/_a-zA-Z]+[/_a-zA-Z0-9]*[/`/'/\"]{0,1}$";//处理表名的正则表达式
            $regxLeftWall = "^[/`/'/\"]{1}";

            $sqlFlagTree = array(
                    "CREATE" => array(
                            "TABLE" => array(
                                    "$regxTable" => 0
                                )
                        ),
                    "INSERT" => array(
                            "INTO" => array(
                                "$regxTable" => 0
                            )
                        )

                    );

            foreach($segment as &$statement) {
            	
                $tokens = split(" ",$statement[0]);

                $tableName = array();
                $this->findTableName($sqlFlagTree,$tokens,0,$tableName);

                if(empty($tableName['leftWall'])) {
                    $newTableName = $prefix.$tableName['name'];
                } else {
                    $newTableName = $tableName['leftWall'].$prefix.substr($tableName['name'],1);
                }

                $statement[0] = str_replace($tableName['name'],$newTableName,$statement[0]);
            }

        }       
		
		

        //组合sql语句
        foreach($segment as &$statement)
        {
            $newStmt = '';
            foreach($statement as $sentence)
            {
                $newStmt = $newStmt.trim($sentence)."\n";
            }

            $statement = $newStmt;
        }

		//Lamb_Debuger::debug($segment);
		
       return  self::saveByQuery($segment);
    }

    private function saveByQuery($sqlArray)
    {
   		$db = $this->mApp->getDb();
		$db->beginTransaction(); 
		
        foreach($sqlArray as $sql) {
          try{
          	   if (!$sql || $sql == '') {
          	   		continue;
          	   }
	           $db->exec($sql);
           }catch(PDOException $e){
           		$db->rollBack(); 
				return false;
           }
        }
		
		$db->commit(); 
		return true;
    }

    private function findTableName($sqlFlagTree,$tokens,$tokensKey=0,&$tableName = array())
    {
        $regxLeftWall = "/^[/`/'/\"]{1}/";

        if(count($tokens) <= $tokensKey)
            return false;       

        if('' == trim($tokens[$tokensKey])) {
            return self::findTableName($sqlFlagTree,$tokens,$tokensKey+1,$tableName);
        } else {
            foreach($sqlFlagTree as $flag => $v) {   
                if(preg_match($flag,$tokens[$tokensKey])) {
                    if(0 == $v) {
                        $tableName['name'] = $tokens[$tokensKey];

                        if(preg_match($regxLeftWall,$tableName['name']))  {
                            $tableName['leftWall'] = $tableName['name']{0};
                        }
							
                        return true;
                    } 

	                return self::findTableName($v,$tokens,$tokensKey+1,$tableName);                    	
                }
            }
        }

        return false;
    }
	
}