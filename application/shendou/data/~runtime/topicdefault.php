<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title><?php echo $title;?></title>	
    <meta name="keywords" content="<?php echo $keywords;?>">
    <meta name="description" content="<?php echo $topic_description;?>">	
    
		<?php include $this->mView->load("header");?>
		
  </head>
  <body>
  	
  	<!--
      	作者：网站导航
      	时间：2016-07-15
      	描述：
      -->
  	<?php include $this->mView->load("navigation");?>
		<div class="container-fluid">
				<!--
        	作者：547911345@qq.com
        	时间：2016-07-15
        	描述：面包屑导航
       -->
      	
      	<div class="topic">
      		
	      	<p><?php echo $data['topic_content'];?></p>
      		
      	</div>
				
   </div> <!-- /container -->
  </body>
</html>