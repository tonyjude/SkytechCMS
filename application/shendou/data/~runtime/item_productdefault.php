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
			      		Tag:
			      		<?php echo $tags;?>
			      	</p>
			      	
			      	 <form method="post" id="button1">
					        <input type="text" name="data[msg_name]" id="msg_name" placeholder="Name *" class="name">
					        <input type="text" name="data[msg_email]" id="msg_email" placeholder="Email *" class="name">
					        <textarea name="data[msg_comments]" id="msg_comments" placeholder="Message *"></textarea>
					
						<input  name="data[project_id]" type="hidden" value="0" /> 	
						<input id="msg_subject" name="data[msg_subject]" type="hidden" value="" /> 
						<input id="msg_source_page" name="data[msg_source_page]" type="hidden" value="" />
						
					        <input type="submit" name="submit" value="Submit" class='coolbg' />
					        &nbsp;&nbsp;
					        <input type="reset" name="reset" value="Reset" class='coolbg' />
					    </form>


		      	</div>
						
					</div>

		      <?php include $this->mView->load("foot_bom");?>
	    </div> <!-- /container -->
	  
		<?php include $this->mView->load("foot");?>

  </body>
</html>