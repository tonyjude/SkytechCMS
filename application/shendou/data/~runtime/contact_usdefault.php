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
      	
      	<div class="topic">
	      	<div><?php echo $data['topic_content'];?></div>
	      	
	      	<div class="row">
	      		<p class="col-md-12">Online Inquiry Please feel free to give your inquiry in the form below.We will reply you in 24 hours.
	      		</p>
      			<h6 class="tishi"></h6>
	      		<div class="forms_main col-md-12">
		      		<form method="post" id="button1">
	      				<div class="col-md-4">I am *</div>
	      				<div class="col-md-8"><input type="text" name="data[msg_name]" id="msg_name"></div>
                <div class="col-md-4">Company Name *</div>
                <div class="col-md-8"><input type="text" name="data[msg_company]" id="msg_company"></div>
                <div class="col-md-4">Product *</div>
                <div class="col-md-8"><input type="text" name="data[msg_product]" id="msg_product" ></div>
                <div class="col-md-4">Email *</div>
                <div class="col-md-8"><input type="text" name="data[msg_email]" id="msg_email"></div>
                <div class="col-md-4">Message *</div>
                <div class="col-md-8">
                    <textarea name="data[msg_comments]" id="msg_comments"></textarea>
                </div>
                
                <div class="col-md-4">Verification Code *</div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="safeCode"  maxlength="4" placeholder="Verification Code" />
                </div>
                <div class="col-md-2"> 
                	<img src="<?php echo $this->mRouter->urlEx('index', 'code', array('s' => 1));?>" height=20 width=80 onClick="this.src='/?s=index/code/s/'+(new Date()).getSeconds()" alt="看不清?请单击" style="cursor:pointer"/>
                </div>

                <div class="sub row">
                    <div class="col-md-12" >
	                    <input type="submit" name="submit" id="submit" value="Send Message">
                    </div>
                </div>
		      		</form>
	      		</div>
	      			
	      	</div>
	      	
	      	<div class="row">
	      		<div class="col-md-4 office">
	      			<h4>Shanghai Office </h4>
	      		</div>	
	      		<div class="col-md-4 address">
	      			<h4>Address </h4>
	      			<p>No. 1919 Zhongshan West Road, Shanghai, P.O Box 200235, PR China </p>
	      		</div>
	      		<div class="col-md-4">
	      			<h4>Contact </h4>
	      			<p>
	      				Nora Gao <br/>
								ng@vincit-gao.com <br/>
								Tel: + 86 2131116195 <br/>
								Fax: + 86 2131066625 <br/>
								Cell: + 86 18512100884 <br/>
							</p>
	      		</div>
	      	</div>	
	      	
	      </div>
	      
	      <?php include $this->mView->load("foot_bom");?>
    </div> <!-- /container -->
	  
		<?php include $this->mView->load("foot");?>
</body>
</html>