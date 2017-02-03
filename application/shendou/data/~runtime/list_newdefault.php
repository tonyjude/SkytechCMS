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
  			
				<?php include $this->mView->load("navigationBanner");?>

				<div class="news">
	      	<div class="row">
		      	<?php Lamb_View_Tag_List::main(array(
				'sql' => ''.$sql.'',
				'include_union' => null,
				'prepare_source' => null,
				'is_page' => true,
				'page' => $page,
				'pagesize' => $pagesize,
				'offset' => null,
				'limit' => null,
				'cache_callback' => null,
				'cache_time' => null,
				'cache_type' => null,
				'cache_id_suffix' => '',
				'is_empty_cache' => null,
				'id' => 'list',
				'empty_str' => '<p class="nodata">No records</p>',
				'auto_index_prev' => 0,
				'db_callback' => null,
				'show_result_callback' => create_function('$item,$index','return str_replace("#autoIndex#",$index,\'
		      	<div class="col-md-12">
	      			
	      			<div class="row">
		      			<div class="col-md-2">
			      			<div class="date">
			      		   	<span>\'.(substr($item[\'art_postdate\'], 8, 4)).\'</span>
			      		   	<p>\'.(substr($item[\'art_postdate\'], 0, 7)).\'</p>		      				
			      			</div>
		      			</div>
				      	
				      	<div class="col-md-10">
				     			<h3><a href="\'.($item[\'recommend\'] == 3 ? $item[\'art_url\'] : Lamb_Utils::objectCall(CALL_ROUTER, \'urlEx\', array(\'item\', \'index\', array(\'id\' => $item[\'id\'], \'art_title\' => $item[\'art_title\'])))).\'">\'.$item[\'art_title\'].\'</a></h3>
					      	<p>\'.$item[\'art_excerpt\'].\'</p>
				      	</div>
							</div>
							
	      		</div>
	      		\');')
			))?>
	      	</div>
      	
	      	<div class="row">
						<?php Lamb_View_Tag_Page::page(array(
			'page_num'		=>	5,
			'page_style'	=>	1,
			'listid'		=>	'list',
			'page_start_html'=>	'
						<div class="col-xs-12" style="text-align: center;">
							<div class="dataTables_paginate paging_simple_numbers" id="sample-table-2_paginate">
								<ul class="pagination">
									<li class="paginate_button previous" aria-controls="sample-table-2" tabindex="0" id="sample_previous"><a href="'.$prevPageUrl.'">Previous</a></li>
	
									',
			'page_end_html'	=>	'
	
	
									<li class="paginate_button next" aria-controls="sample-table-2" tabindex="0" id="sample_next"><a href="'.$nextPageUrl.'">Next</a></li>
								</ul>
							</div>
						</div>
						',
			'more_html'		=>	'',
			'focus_html'	=>	'<li class="paginate_button active" aria-controls="sample-table-2" tabindex="0"><a>#page#</a></li>',
			'nofocus_html'	=>	'<li><a href="'.$pageUrl.'">#page#</a></li>',
			'max_page_count' => 0,
			'page' => null,
			'pagesize' => null,
			'data_num' => null
		))?>
					</div>
				</div>
      
      <?php include $this->mView->load("foot_bom");?>	
    </div> <!-- /container -->
	  
		<?php include $this->mView->load("foot");?>
  </body>
</html>