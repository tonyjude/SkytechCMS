<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>专题列表</title>

		<meta name="description" content="Drag &amp; drop hierarchical list" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" />
		<link rel="stylesheet" href="assets/css/font-awesome.css" />

		<!-- page specific plugin styles -->
		
		<!-- my css -->
		<link rel="stylesheet" href="css/index.css" />
		
		

		<!-- text fonts -->
		<link rel="stylesheet" href="assets/css/ace-fonts.css" />

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
								<a href="/skytech_admin.php">Home</a>
							</li>

							<li class="active">专题管理</li>
						</ul><!-- /.breadcrumb -->
						<!-- /section:basics/content.searchbox -->
					</div>

					<!-- /section:basics/content.breadcrumbs -->
					<div class="page-content">
						<!-- #section:settings.box -->
						
						<?php include $this->mView->load("setbox");?>		
							
						<!-- /.ace-settings-container -->

						<!-- /section:settings.box -->
						
						<div class="row">
							<div class="col-xs-12">
								<h3 class="header smaller lighter blue">专题列表</h3>
								<!--h5 style="float: left">
									<a href="<?php echo $this->mSiteCfg['dynamic_url']['topic_addOrUpdate']; ?>">
									<span class="glyphicon glyphicon-plus">添加专题</span>
									</a>
								</h5-->
								<!-- <div class="dataTables_borderWrap"> -->
								<div>
									<table id="sample-table-2" class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
												<th>编号</th>
												<th>名称</th>
												<th>标题</th>
												<th>
													<i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
													日期
												</th>
												<th class="hidden-480">状态</th>
												<th>操作</th>
											</tr>
										</thead>

										<tbody>
										<?php Lamb_View_Tag_List::main(array(
				'sql' => ''.$sql.'',
				'include_union' => null,
				'prepare_source' => null,
				'is_page' => true,
				'page' => $page,
				'pagesize' => 30,
				'offset' => null,
				'limit' => null,
				'cache_callback' => null,
				'cache_time' => null,
				'cache_type' => null,
				'cache_id_suffix' => '',
				'is_empty_cache' => null,
				'id' => 'list',
				'empty_str' => '<tr class="tr ct"><td colspan="6">暂无记录</td></tr>',
				'auto_index_prev' => 0,
				'db_callback' => null,
				'show_result_callback' => create_function('$item,$index','return str_replace("#autoIndex#",$index,\'

											<tr>
												<td>
													<a href="#">\'.$item[\'id\'].\'</a>
												</td>
												<td>\'.$item[\'topic_name\'].\'</td>
												<td>\'.$item[\'topic_title\'].\'</td>
												<td>2016-05-12</td>
												<td class="hidden-480">
													<span class="label label-sm label-success">正常</span>
												</td>

												<td>
													<div class="hidden-sm hidden-xs action-buttons">
														<a class="blue" href="\'.(Lamb_Utils::objectCall(CALL_ROUTER, \'urlEx\', array(\''.$this->C.'\', \'addOrUpdate\', array(\'id\' => $item[\'id\'])))).\'">
															<i class="ace-icon fa fa-pencil bigger-130"></i>
														</a>

														<a class="red topic-del" id=\'.$item[\'id\'].\' title="删除">
															<i class="ace-icon fa fa-trash-o bigger-130"></i>
														</a>
														<a class="green topic-view" path=\\\'\'.$item[\'topic_url\'].\'\\\' title="预览">
															<i class="ace-icon fa fa-link bigger-130"></i>
														</a>
													</div>

													<div class="hidden-md hidden-lg">
														<div class="inline position-relative">
															<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
																<i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
															</button>

															<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
																<li>
																	<a href="#" class="tooltip-info" data-rel="tooltip" title="View">
																		<span class="blue">
																			<i class="ace-icon fa fa-pencil bigger-120"></i>
																		</span>
																	</a>
																</li>

																<li>
																	<a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
																		<span class="green">
																			<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
																		</span>
																	</a>
																</li>

																<li>
																	<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
																		<span class="red">
																			<i class="ace-icon fa fa-trash-o bigger-120"></i>
																		</span>
																	</a>
																</li>
															</ul>
														</div>
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
			window.jQuery || document.write("<script src='assets/js/jquery.js'>"+"<"+"/script>");
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

		<!-- page specific plugin scripts -->
		<script src="assets/js/jquery.nestable.js"></script>

		
		<!-- page specific plugin scripts -->
		<script src="assets/js/fuelux/fuelux.tree.js"></script>

		<!-- ace scripts -->
		<script src="assets/js/ace/elements.scroller.js"></script>
		<script src="assets/js/ace/elements.colorpicker.js"></script>
		<script src="assets/js/ace/elements.fileinput.js"></script>
		<script src="assets/js/ace/elements.typeahead.js"></script>
		<script src="assets/js/ace/elements.wysiwyg.js"></script>
		<script src="assets/js/ace/elements.spinner.js"></script>
		<script src="assets/js/ace/elements.treeview.js"></script>
		<script src="assets/js/ace/elements.wizard.js"></script>
		<script src="assets/js/ace/elements.aside.js"></script>
		<script src="assets/js/ace/ace.js"></script>
		<script src="assets/js/ace/ace.ajax-content.js"></script>
		
		<script src="assets/js/ace/ace.sidebar.js"></script>
		<script src="assets/js/ace/ace.sidebar-scroll-1.js"></script>
		<script src="assets/js/ace/ace.submenu-hover.js"></script>
		<script src="assets/js/ace/ace.widget-box.js"></script>
		<script src="assets/js/ace/ace.settings.js"></script>
		<script src="assets/js/ace/ace.settings-rtl.js"></script>
		<script src="assets/js/ace/ace.settings-skin.js"></script>
		<script src="assets/js/jquery-confirm.js"></script>
	

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($){
			/*
				var oTable1 = $('#sample-table-2').dataTable( {
					bAutoWidth: false,
					"aoColumns": [
					  { "bSortable": false },
					  null, null,null, null, null,
					  { "bSortable": false }
					],
					"aaSorting": [],
			    } );
			    */
				
				$('[data-rel="tooltip"]').tooltip();
	
			});

			var sample_previous = $('#sample_previous');
			var sample_next = $('#sample_next');
			var total_page  = $('#total_page').val();
			if (<?php echo $page;?> == 1) {
				sample_previous.addClass('disabled');
			}

			if (<?php echo $page;?> == total_page) {
				sample_next.addClass('disabled');
			}

		</script>
		
		<script src="js/config.js"></script>
		<script src="js/index.js"></script>
	</body>
</html>
