<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>批量添加栏目</title>

		<meta name="description" content="Common form elements and layouts" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="assets/css/bootstrap.css" />
		<link rel="stylesheet" href="assets/css/font-awesome.css" />
		
		<!-- my css -->
		<link rel="stylesheet" href="css/index.css" />

		<!-- text fonts -->
		<link rel="stylesheet" href="assets/css/ace-fonts.css" />
		
		
		<!-- ace styles -->
		<link rel="stylesheet" href="assets/css/ace.css" class="ace-main-stylesheet" id="main-ace-style" />

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
						<script type="text/javascript">
							try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
						</script>

						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="/skytech_admin.php">Home</a>
							</li>
							<li>
								<a href="/skytech_admin.php?s=categories/index">栏目管理</a>
							</li>
							<li class="active">批量添加栏目</li>
						</ul><!-- /.breadcrumb -->

						<!-- #section:basics/content.searchbox -->
						<div class="nav-search" id="nav-search">
							<form class="form-search">
								<span class="input-icon">
									<input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
									<i class="ace-icon fa fa-search nav-search-icon"></i>
								</span>
							</form>
						</div><!-- /.nav-search -->

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
								
								<form class="form-horizontal" id="add_batch_categories" action="" method="post">
										
									<!-- #section:elements.form -->
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right">隶属栏目</label>
										<div class="col-sm-9">	
											<select name="cate_parent_id" style="width:240px">
												<option value="0">选择所属目录...</option>
												<?php echo $cates;?>
											</select>
											<label>（默认为顶级栏目）</label>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right">列表模板 </label>

										<div class="col-sm-9">
											<input type="text" name="cate_list_template" value="list" maxlength="50" class="col-xs-10 col-sm-5">
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right">文章模板 </label>

										<div class="col-sm-9">
											<input type="text" name="cate_article_templte" value="item" maxlength="50" class="col-xs-10 col-sm-5">
										</div>
									</div>
								
									<div class="form-group">
										
										<div class="col-sm-10 col-sm-offset-2">
											<table class="batch-add-cate" id="batch_table">
												<tr>
													<td>排序</td>
													<td>栏目名称</td>
													<td><input type="button" value="添加" id="batch_add"/></td>
												</tr>
												<tr>
													<td><input type="text" name="data[1][cate_sort]" value="1" /></td>
													<td><input type="text" class="cate-name" name="data[1][cate_name]" /> </td>
													<td><input type="button" disabled="disabled" value="删除" /></td>
												</tr>	
												<tr>
													<td><input type="text" name="data[2][cate_sort]" value="2" /></td>
													<td><input type="text" class="cate-name" name="data[2][cate_name]" /> </td>
													<td><input type="button"  class="cate-del" value="删除" /></td>
												</tr>
												
												<tr>
													<td><input type="text" name="data[3][cate_sort]" value="3" /></td>
													<td><input type="text" class="cate-name" name="data[3][cate_name]" /> </td>
													<td><input type="button"  class="cate-del" value="删除" /></td>
												</tr>
												
												<tr>
													<td><input type="text" name="data[4][cate_sort]" value="4" /></td>
													<td><input type="text" class="cate-name" name="data[4][cate_name]" /> </td>
													<td><input type="button"  class="cate-del" value="删除" /></td>
												</tr>
												
												<tr>
													<td><input type="text" name="data[5][cate_sort]" value="5" /></td>
													<td><input type="text" class="cate-name" name="data[5][cate_name]" /> </td>
													<td><input type="button"  class="cate-del" value="删除" /></td>
												</tr>
												
												<tr>
													<td><input type="text" name="data[6][cate_sort]" value="6" /></td>
													<td><input type="text" class="cate-name" name="data[6][cate_name]" /> </td>
													<td><input type="button"  class="cate-del" value="删除" /></td>
												</tr>
												
												<tr>
													<td><input type="text" name="data[7][cate_sort]" value="7" /></td>
													<td><input type="text" class="cate-name" name="data[7][cate_name]" /> </td>
													<td><input type="button"  class="cate-del" value="删除" /></td>
												</tr>
												
												<tr>
													<td><input type="text" name="data[8][cate_sort]" value="8" /></td>
													<td><input type="text" class="cate-name" name="data[8][cate_name]" /> </td>
													<td><input type="button" class="cate-del" value="删除" /></td>
												</tr>
												
											</table>
										</div>

									</div>	
									
									<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info" id="cate_submit" type="submit">
												<i class="ace-icon fa fa-check bigger-110"></i>
												提 交
											</button>

											&nbsp; &nbsp; &nbsp;
											<button class="btn" type="button" onClick="javascript:history.go(-1);">
												<i class="ace-icon fa fa-undo bigger-110"></i>
												返 回
											</button>
											
										</div>
									</div>
									
								</form>
								
								
							</div><!-- /.col -->
						</div><!-- /.row -->
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

		<!-- page specific plugin scripts -->
		<script src="assets/js/jquery.nestable.js"></script>

		<!-- ace scripts -->
		<script src="assets/js/ace/elements.scroller.js"></script>
		<script src="assets/js/ace/elements.colorpicker.js"></script>
		
		<script src="assets/js/ace/ace.js"></script>
	
		<script src="assets/js/ace/ace.sidebar.js"></script>
		<script src="assets/js/ace/ace.submenu-hover.js"></script>
	
		<script src="assets/js/ace/ace.settings.js"></script>
		<script src="assets/js/ace/ace.settings-rtl.js"></script>
		<script src="assets/js/ace/ace.settings-skin.js"></script>
		
		<script src="assets/js/jquery-confirm.js"></script>
		<script src="assets/js/bootbox.js"></script>
		
		<script src="js/config.js"></script>
		<script src="js/index.js"></script>

	</body>
</html>
