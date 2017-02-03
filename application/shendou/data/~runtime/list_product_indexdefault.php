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

  			<div class="product">
	      	<div class="row">
		      	
		      	<div class="col-sm-6">
		      			<a title="Rubber Hose" href="<?php echo $this->mRouter->urlEx($this->C, '', array('id' => 4)); ?>">
	        		   		<img class="product-img" src="/themes/images/round1.jpg" />
	        		  </a>	
		      			<h3 class="t"><a title="Rubber Hose" href="<?php echo $this->mRouter->urlEx($this->C, '', array('id' => 4)); ?>">Rubber Hose</a></h3>
	      		</div>
	      		
	      		<div class="col-sm-6">
		      			<a title="HDPE Pipe" href="<?php echo $this->mRouter->urlEx($this->C, '', array('id' => 5)); ?>">
	        		   		<img class="product-img" src="/themes/images/round2.jpg" />
	        		  </a>	
		      			<h3 class="t"><a title="HDPE Pipe" href="<?php echo $this->mRouter->urlEx($this->C, '', array('id' => 5)); ?>">HDPE Pipe</a></h3>
	      		</div>
	      		
	      		<div class="col-sm-6">
		      			<a title="Steel Pipe" href="<?php echo $this->mRouter->urlEx($this->C, '', array('id' => 6)); ?>">
	        		   		<img class="product-img" src="/themes/images/round3.jpg" />
	        		  </a>	
		      			<h3 class="t"><a title="Steel Pipe" href="<?php echo $this->mRouter->urlEx($this->C, '', array('id' => 6)); ?>">Steel Pipe</a></h3>
	      		</div>
	      		
	      		<div class="col-sm-6">
		      			<a title="TSHD & CSD Equipment" href="<?php echo $this->mRouter->urlEx($this->C, '', array('id' => 8)); ?>">
	        		   		<img class="product-img" src="/themes/images/round4.jpg" />
	        		  </a>	
		      			<h3 class="t"><a title="TSHD & CSD Equipment" href="<?php echo $this->mRouter->urlEx($this->C, '', array('id' => 8)); ?>">TSHD & CSD Equipment</a></h3>
	      		</div>
	      	</div>
      	
	  
      </div>
      
      <?php include $this->mView->load("foot_bom");?>	
    </div> <!-- /container -->
	  
		<?php include $this->mView->load("foot");?>
  </body>
</html>