<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>文章列表</title>

		<meta name="description" content="Drag &amp; drop hierarchical list" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" />
		<link rel="stylesheet" href="assets/css/font-awesome.css" />
		
		<!-- my css -->
		<link rel="stylesheet" href="css/index.css" />
		
		<!-- ace styles -->
		<link rel="stylesheet" href="assets/css/ace.css" class="ace-main-stylesheet" id="main-ace-style" />
		
		<link rel="stylesheet" href="assets/css/jquery-confirm.css" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="assets/css/ace-part2.css" class="ace-main-stylesheet" />
		<![endif]-->

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="assets/css/ace-ie.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->
		<script src="assets/js/ace-extra.js"></script>

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="assets/js/html5shiv.js"></script>
		<script src="assets/js/respond.js"></script>
		<![endif]-->
	</head>

	<body class="no-skin">
		<!-- #section:basics/navbar.layout -->
		<?php include $this->mView->load("head");?>

		<!-- /section:basics/navbar.layout -->
		<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<!-- #section:basics/sidebar -->
			<div id="sidebar" class="sidebar responsive">
				
				<?php include $this->mView->load("menu");?>
					
				<!-- /.nav-list -->

				<!-- #section:basics/sidebar.layout.minimize -->
				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>

				<!-- /section:basics/sidebar.layout.minimize -->
				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
				</script>
			</div>

			<!-- /section:basics/sidebar -->
			<div class="main-content">
				<div class="main-content-inner">
					<!-- #section:basics/content.breadcrumbs -->
					<div class="breadcrumbs" id="breadcrumbs">

						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="#">Home</a>
							</li>

							<li class="active">文章列表</li>
						</ul><!-- /.breadcrumb -->

						<!-- /section:basics/content.searchbox -->
					</div>

					<!-- /section:basics/content.breadcrumbs -->
					<div class="page-content">
						<!-- #section:settings.box -->
						
						<?php include $this->mView->load("setbox");?>		
							
						<!-- /.ace-settings-container -->

						<!-- /section:settings.box -->
						<div class="page-header-h1">
							
						</div><!-- /.page-header -->
						
						<div class="row">
							<div class="col-xs-12">
								<h3 class="header smaller lighter blue">文章列表</h3>
								<h5 style="float: right">
									<a href="<?php  echo $this->mSiteCfg['dynamic_url']['article_add_or_update'] . ($cid != '' && $cname != '' ?  '/cid/' . $cid . '/cname/' . $cname : ''); ?>">
									<span class="glyphicon glyphicon-plus">添加文章</span>
									</a>
								</h5>
								<form method="post" class="form-search-1" action="<?php echo $this->mRouter->urlEx($this->C, $this->A);?>" name="search">
									<div class="input-group input-search" >
										<input type="text" name="keywords" value="<?php echo $keywords;?>" placeholder="请输入关键词">
										<select name="q">
											<option value="">属性</option>
											<option value="0" <?php echo $sels[0];?>>默认</option>
											<option value="1" <?php echo $sels[1];?>>推荐</option>
											<option value="2" <?php echo $sels[2];?>>特荐</option>
											<option value="3" <?php echo $sels[3];?>>跳转</option>
										</select>
										<button type="submit" class="btn btn-purple btn-sm" style="margin-left:10px;margin-bottom:2px;">
											<span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
											搜索
										</button>
									</div>
								</form>
								<!-- <div class="dataTables_borderWrap"> -->
								<div>
									<table id="sample-table-2" class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
												<th class="center">
													<label class="position-relative">
														全选<input type="checkbox" id="art_select" class="ace" />
														<span class="lbl"></span>
													</label>
													<span id="del_all" class="glyphicon glyphicon-trash"></span>
												</th>
												<th>编号</th>
												<th>文章标题</th>
												<th>属性</th>
												<th width="100">
													<i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>更新时间
												</th>
												<th>栏目</th>
												<th>发布人</th>
												<th>操作</th>
											</tr>
										</thead>

										<tbody>
										<?php Lamb_View_Tag_List::main(array(
				'sql' => ''.$sql.'',
				'include_union' => null,
				'prepare_source' => $aPrepareSource,
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
				'empty_str' => '<tr class="tr ct"><td colspan="10">暂无记录</td></tr>',
				'auto_index_prev' => 0,
				'db_callback' => null,
				'show_result_callback' => create_function('$item,$index','return str_replace("#autoIndex#",$index,\'

											<tr>
												<td class="center">
													<label class="position-relative">
														<input type="checkbox" id=\'.$item[\'id\'].\' name="chk_list" class="ace select-ace" />
														<span class="lbl"></span>
													</label>
												</td>
												<td>
													<a href="#">\'.$item[\'id\'].\'</a>
												</td>
												<td>\'.$item[\'art_title\'].\'</td>
												<td>\'.($item[\'recommend\'] == 1 ? \'推荐\' : ($item[\'recommend\'] == 2 ? \'特荐\' : ($item[\'recommend\'] == 3 ? \'跳转\' : \'默认\'))).\'</td>
												<td>\'.$item[\'art_postdate\'].\'</td>
												<td>\'.$item[\'cate_name\'].\'</td>												
												<td>\'.$item[\'art_author\'].\'</td>
												<td>
													<div class="hidden-sm hidden-xs action-buttons">
														<a class="blue" href="\'.(Lamb_Utils::objectCall(CALL_ROUTER, \'urlEx\', array(\''.$this->C.'\', \'addOrUpdate\', array(\'aid\' => $item[\'id\'], \'cid\' => '.$cid.', \'cname\' => $item[\'cate_name\'])))).\'" title="详情">
															<i class="ace-icon fa fa-pencil bigger-130"></i>
														</a>
														<a class="red article-del" aid=\'.$item[\'id\'].\' title="删除">
															<i class="ace-icon fa fa-trash-o bigger-130"></i>
														</a>
														<a class="green article-view" aid=\'.$item[\'id\'].\' title="预览">
															<i class="ace-icon fa fa-link bigger-130"></i>
														</a>
													</div>
												</td>
											</tr>

										\');')
			))?>

										</tbody>
									</table>
									<div class="row">
										<?php Lamb_View_Tag_Page::page(array(
			'page_num'		=>	5,
			'page_style'	=>	1,
			'listid'		=>	'list',
			'page_start_html'=>	'
										<div class="col-xs-6">
											<div class="dataTables_info" id="sample-table-2_info" role="status" aria-live="polite">共#num#条数据 <input type="text" id="total_page" style="display: none" value="#pageCount#" /></div>
										</div>
										<div class="col-xs-6">
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
			'nofocus_html'	=>	'<li><a href="'.$pageUrl.'/p/#page#">#page#</a></li>',
			'max_page_count' => 0,
			'page' => null,
			'pagesize' => null,
			'data_num' => null
		))?>
									</div>
								</div>
							</div>
						</div>

						
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			<?php include $this->mView->load("footer");?>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->
            

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script type="text/javascript">
			window.jQuery || document.write("<script src='//cdn.bootcss.com/jquery/1.11.3/jquery.min.js'>"+"<"+"/script>");
		</script>

		<!-- <![endif]-->

		<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='assets/js/jquery1x.js'>"+"<"+"/script>");
</script>
<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.js'>"+"<"+"/script>");
		</script>
		<script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

		<!-- ace scripts -->
		<script src="assets/js/ace/elements.scroller.js"></script>
		<script src="assets/js/ace/elements.colorpicker.js"></script>
		
		<script src="assets/js/ace/ace.js"></script>
		<script src="assets/js/ace/ace.ajax-content.js"></script>
	
		<script src="assets/js/ace/ace.sidebar.js"></script>
		<script src="assets/js/ace/ace.submenu-hover.js"></script>
	
		<script src="assets/js/ace/ace.settings.js"></script>
		<script src="assets/js/ace/ace.settings-rtl.js"></script>
		<script src="assets/js/ace/ace.settings-skin.js"></script>
		
		<script src="assets/js/jquery-confirm.js"></script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($){
				$('[data-rel="tooltip"]').tooltip();
			});
		</script>
		
		<script src="js/config.js"></script>
		<script src="js/index.js"></script>
		<script>
			T.index.page(<?php echo $page;?>);
		</script>
	</body>
</html>
