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
  		<!--
      	author:547911345@qq.com
      	date: 2016-07-15
      -->
  	<?php include $this->mView->load("navigation");?>
	
		<div class="container-fluid">

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
				'empty_str' => 'no data',
				'auto_index_prev' => 0,
				'db_callback' => null,
				'show_result_callback' => create_function('$item,$index','return str_replace("#autoIndex#",$index,\'
	      	<div class="col-md-12">
	      			 <h1><a href="\'.(Lamb_Utils::objectCall(CALL_ROUTER, \'urlEx\', array(\'item\', \'index\', array(\'art_title\' => $item[\'art_title\'])))).\'">\'.$item[\'art_title\'].\'</a></h1>
        		   <h6>\'.$item[\'art_postdate\'].\'</h6>
				       <p>
				           \'.$item[\'art_excerpt\'].\'
				       </p>
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
					<div class="col-xs-12">
						<div class="dataTables_paginate paging_simple_numbers" id="sample-table-2_paginate">
							<ul class="pagination">
								<li class="paginate_button previous" aria-controls="sample-table-2" tabindex="0" id="sample_previous"><a href="'.$prevPageUrl.'">上一页</a></li>

								',
			'page_end_html'	=>	'


								<li class="paginate_button next" aria-controls="sample-table-2" tabindex="0" id="sample_next"><a href="'.$nextPageUrl.'">下一页</a></li>
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
      	
   </div> <!-- /container -->
  </body>
</html>