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
		<link rel="stylesheet" href="/themes/css/swiper-3.3.1.min.css" >
  </head>
  <body>	
  	<?php include $this->mView->load("code");?>
  	
		<!--
	  	Website navigation DATE: 2016-07-15
	  -->
	  <?php include $this->mView->load("navigation");?>
	   
	  
	  <div class="container-fluid">

	  	<div class="con-middle">
	  		<!--div class="con-middle-top">
	  				<h1>ACTIVE QUALITY MANAGEMENT</h1>
	  				<p>ORDERNOW！</p>
	  		</div-->
				
				<div class="con-middle-btm">
					<h1>WELCOME TO SHANGHAI VINCIT- GAO INDUSTRIAL CO., LTD!</h1>
					<p>We are your reliable choose in China</p>
				</div>
	  	</div>
	  
	  	<img src="/themes/images/middle.jpg"  style="width: 100%;" />
	  	
	  	<!-- Swiper -->
	  	<div class="_swiper">
		   	<div class="row">

					<div class="col-md-4">
							<div class="s1">
								<p>High Quality Products.</p>
							</div>
					</div>
					
		      <div class="col-md-4">
		      	<div class="s1">
			      	<p>Active Quality Management.</p>
		      	</div>
		      </div>
		      
		      <div class="col-md-4">
		      	<div class="s1">
		      		<p>Worldwide Logistic Support.</p>
		      	</div>
		   		</div>
		   		
		   	</div>
	  	</div>
	    <!-- Swiper -->
	    
	    <div class="banner-title">
	    	<p>PRODUCT</p>
	    </div>
	    <div class="product-show">
		    <div class="row">
		    	<?php Lamb_View_Tag_List::main(array(
				'sql' => 'select * from skytech_article where recommend=1',
				'include_union' => null,
				'prepare_source' => null,
				'is_page' => true,
				'page' => 1,
				'pagesize' => 8,
				'offset' => null,
				'limit' => null,
				'cache_callback' => null,
				'cache_time' => null,
				'cache_type' => null,
				'cache_id_suffix' => '',
				'is_empty_cache' => null,
				'id' => null,
				'empty_str' => '<p class="nodata">No records</p>',
				'auto_index_prev' => 0,
				'db_callback' => null,
				'show_result_callback' => create_function('$item,$index','return str_replace("#autoIndex#",$index,\'
		    	<div class="col-md-3 col-sm-6 col-xs-12">
		    			<a href="\'.(Lamb_Utils::objectCall(CALL_ROUTER, \'urlEx\', array(\'item\', \'\', array(\'art_title\' => $item[\'art_title\'], \'id\' => $item[\'id\'])))).\'" ><img src="\'.$item[\'art_image\'].\'"  /></a>
		    			<p><a href="\'.(Lamb_Utils::objectCall(CALL_ROUTER, \'urlEx\', array(\'item\', \'\', array(\'art_title\' => $item[\'art_title\'], \'id\' => $item[\'id\'])))).\'" >\'.$item[\'art_title\'].\'</a></p>
		    	</div>
		    	\');')
			))?>
		    </div>
	    </div>
	    
	    <?php include $this->mView->load("foot_bom");?>	
	  </div>	
		
		<?php include $this->mView->load("foot");?>	
  </body>
  
</html>