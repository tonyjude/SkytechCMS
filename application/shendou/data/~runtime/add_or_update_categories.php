<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>添加/修改栏目</title>

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
							<li class="active">添加栏目</li>
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
								
								<form class="form-horizontal" id="add_or_update_categories" action="" method="post">
									<!-- #section:elements.form -->
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right">栏目名称 </label>

										<div class="col-sm-9">
											<input type="text" name="data[cate_name]" maxlength="100" value="<?php echo isset($cate_info) ? $cate_info['cate_name'] : ''; ?>"　id="cate_name" class="col-xs-10 col-sm-5">
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="cate_url">文件保存目录 </label>

										<div class="col-sm-9">
											
											<input type="text" name="data[cate_url]"　id="cate_url"  placeholder="可选，默认栏目拼音" value="<?php echo isset($cate_info) ? $cate_info['cate_url'] : ''; ?>" class="col-xs-10 col-sm-5">
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right">SEO标题</label>

										<div class="col-sm-9">
											<input type="text" name="data[cate_seo_title]" value="<?php echo isset($cate_info) ? $cate_info['cate_seo_title'] : ''; ?>"　 id="cate_seo_title" placeholder="可选" maxlength="250" class="col-xs-10 col-sm-5">
										</div>
									</div>
									
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right">栏目关键字</label>

										<div class="col-sm-9">
											<input type="text" name="data[cate_keywords]" value="<?php echo isset($cate_info) ? $cate_info['cate_keywords'] : ''; ?>"　 id="cate_keywords" placeholder="可选"  maxlength="250" class="col-xs-10 col-sm-5">
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="cate_list_template">列表模板 </label>

										<div class="col-sm-9">
											<input type="text" name="data[cate_list_template]" maxlength="50" value="<?php echo isset($cate_info) ? $cate_info['cate_list_template'] : 'list'; ?>"　id="cate_list_template" class="col-xs-10 col-sm-5">
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="cate_article_templte">文章模板 </label>

										<div class="col-sm-9">
											<input type="text" name="data[cate_article_templte]" maxlength="50" value="<?php echo isset($cate_info) ? $cate_info['cate_article_templte'] : 'item'; ?>"　id="cate_article_templte"  class="col-xs-10 col-sm-5">
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="cate_topic_templte">专题模板 </label>

										<div class="col-sm-9">
											<input type="text" name="data[cate_topic_templte]" maxlength="50" value="<?php echo isset($cate_info) ? $cate_info['cate_topic_templte'] : 'topic'; ?>"　id="cate_topic_templte"  class="col-xs-10 col-sm-5">
										</div>
									</div>
								
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right">栏目描述</label>
										<div class="col-sm-9">	
											<textarea class="col-xs-10 col-sm-5" name="data[cate_description]" id="cate_description" placeholder="可选"><?php echo isset($cate_info) ? $cate_info['cate_description'] : ''; ?></textarea>
										</div>		
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right">栏目排序（越小越靠前）</label>

										<div class="col-sm-9">
											<input type="text" name="data[cate_sort]"　id="cate_sort"  placeholder="50" value="<?php echo isset($cate_info) ? $cate_info['cate_sort'] : '50'; ?>" class="col-xs-10 col-sm-5">
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right">是否为专题</label>
										<div class="col-sm-9">	
											<input <?php echo isset($cate_info['cate_is_topic']) && $cate_info['cate_is_topic'] ? 'checked' : ''; ?> style="width: 20px;height: 18px;margin-top: 10px;" type="checkbox" name="data[cate_is_topic]" />
										</div>	
									</div>	
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right">是否隐藏栏目</label>
										<div class="col-sm-9">	
											<input <?php echo isset($cate_info['cate_status']) && !$cate_info['cate_status'] ? 'checked' : ''; ?> style="width: 20px;height: 18px;margin-top: 10px;" type="checkbox" name="data[cate_status]" />
										</div>	
									</div>						
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right">继承选项</label>
										<div class="col-sm-9">	
											<input style="width: 20px;height: 18px;margin-top: 10px;" type="checkbox" name="upnext" id="upnext" />同时更改下级栏目的内容类型、模板风格等属性
										</div>	
									</div>
									
									<input type="hidden" name="cate_parent_id" value="<?php echo $id;?>"/>
									<input type="hidden" name="data[id]" value="<?php echo $cate_id;?>"/>
									<input type="hidden" name="data[cate_parent_id]" value="<?php echo isset($cate_info['cate_parent_id']) ? $cate_info['cate_parent_id'] : 0; ?>"/>

									<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info" type="submit">
												<i class="ace-icon fa fa-check bigger-110"></i>
												提 交
											</button>

											&nbsp; &nbsp; &nbsp;
											<button class="btn"type="button" onClick="javascript:history.go(-1);">
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
