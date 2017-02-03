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
				  <div class="nav-bread"><?php echo $breadNavigation;?></div>

					<div class="row">
		      	
		      	<div class="col-md-3 col-md-offset-1 nav-left nav-left-item">
		      		<?php include $this->mView->load("left_nav");?>
		      	</div>
		      	
		      	<div class="col-md-6 product-content">
		      		
			      	<h1><?php echo $data['art_title'];?></h1>
			      	<p><?php echo $data['art_content'];?></p>
			      	
			      	<p>
			      		<?php echo $tags;?>
			      	</p>
			      	
		      	</div>
						
					</div>

		      <?php include $this->mView->load("foot_bom");?>
	    </div> <!-- /container -->
	  
		<?php include $this->mView->load("foot");?>

  </body>
</html>