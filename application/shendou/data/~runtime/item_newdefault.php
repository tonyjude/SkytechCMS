<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title><?php echo $title;?></title>	
    <meta name="keywords" content="<?php echo $keywords;?>">
    <meta name="description" content="<?php echo $description;?>">		
    
		<?php include $this->mView->load("header");?>
		
  </head>
  <body>	
 
  	<?php include $this->mView->load("code");?>
  	
  	<!--
      	author:547911345@qq.com
      	date: 2016-07-15
      -->
  	<?php include $this->mView->load("navigation");?>
		<div class="container-fluid">
				<!--
        	author:547911345@qq.com
        	date: 2016-07-15
        	describe:Bread crumbs navigation
        -->
			  <?php include $this->mView->load("navigationBanner");?>
      	
      	<div class="news">
      		
      		<h1><?php echo $data['art_title'];?></h1>
	      	<div class="content"><?php echo $data['art_content'];?></div>     	
	      	
	      	<div class="page">
	      		
	      		<?php if (!empty($Previous)) { ?>
	      		<p><a href="<?php echo $this->mRouter->urlEx('item', '', array('id' => $Previous[0]['id'], 'art_title' => $Previous[0]['art_title'])); ?>">Previous: <?php echo $Previous[0]['art_title']?></a></p>
	      		<?php } ?>
	      		
	      		<?php if (!empty($Next)) { ?>
	      		<p><a href="<?php echo $this->mRouter->urlEx('item', '', array('id' => $Next[0]['id'], 'art_title' => $Next[0]['art_title'])); ?>">Next: <?php echo $Next[0]['art_title']?></a></p>
	      		<?php } ?>
	      			
	      	</div>
	      
      	</div>
      	
      	<?php include $this->mView->load("foot_bom");?>
    </div> <!-- /container -->
	  
		<?php include $this->mView->load("foot");?>
  </body>
</html>