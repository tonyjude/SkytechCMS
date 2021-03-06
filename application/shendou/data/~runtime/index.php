<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Dashboard - Skytech CMS</title>

		<meta name="description" content="overview &amp; stats" />
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
						<script type="text/javascript">
							try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
						</script>

						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="#">Home</a>
							</li>
							<li class="active">数据中心</li>
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
						<div class="page-header">
							<h1>
								数据中心
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									overview 
								</small>
							</h1>
						</div>
						
						<div class="row">
							<div class="col-xs-12">
								<div class="alert alert-block alert-success">
									<button type="button" class="close" data-dismiss="alert">
										<i class="ace-icon fa fa-times"></i>
									</button>

									<i class="ace-icon fa fa-check green"></i>

									欢迎使用
									<strong class="green">
										Skytech CMS
										<small>(v1.0)</small>
									</strong>
									网站管理系统
									&nbsp;&nbsp;&nbsp;&nbsp;
									<span>
									<?php
										$now = date('H');
										if ($now > 4 && $now < 12) {
											$msg = '上午好！';
										} else if ($now > 12 && $now < 18) {
											$msg = '下午好！';
										} else if ($now > 18 && $now < 23) {
											$msg = '晚上好！';
										} else {
											$msg = '夜深了，请注意休息！';
										}
										
										echo  $_SESSION['__admin_username__']  .  $msg;
									?>
									</span>
								</div>
								
								<div class="row">
									<div class="col-sm-7">
										<div class="widget-box">
											<h4 class="smaller lighter green">
												<i class="ace-icon fa fa-rss orange"></i>
												系统基本信息										
											</h4>
											
											<table id="sample-table-1" class="table table-striped table-bordered table-hover">
												<tbody>
													<tr>
														<td>PHP版本</td>
														<td><?php echo phpversion();?></td>
													</tr>
													<tr>
														<td>GD版本</td>
														<td>
															<?php
																$info = gd_info();
																if (empty($info)) {
																	echo '<span style="color:red">不支持GD库</span>';
																}else{
																	echo $info['GD Version'];
																}
															?>
														</td>
													</tr>
													<tr>
														<td>上传最大文件</td>
														<td>400KB</td>
													</tr>
													<tr>
														<td>软件版本名称</td>
														<td>Skytech CMS V1.0</td>
													</tr>
												</tbody>
											</table>	
										</div>
									</div>	
									
									<div class="col-sm-5">
										<div class="widget-box">
											<h4 class="widget-title lighter green">
												<i class="ace-icon fa fa-signal"></i>
												信息统计
											</h4>

											<table id="sample-table-1" class="table table-striped table-bordered table-hover">
												<tbody>
													<tr>
														<td>文章数</td>
														<td><?php echo $aNum[0]['num'];?></td>
													</tr>
													<tr>
														<td>专题数</td>
														<td><?php echo $tNum[0]['num'];?></td>
													</tr>
													<tr>
														<td>会员数</td>
														<td>0</td>
													</tr>
													<tr>
														<td>评论数</td>
														<td>0</td>
													</tr>
												</tbody>
											</table>	
												
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-sm-12">
										<div class="widget-box">
											<h4 class="smaller lighter green">
												<i class="ace-icon fa fa-list"></i>
												最新文章
											</h4>

											<ul id="tasks" class="item-list ui-sortable">
												<?php if (empty($alist)) { ?>
													<li class="item-default clearfix ui-sortable-handle">
														<label class="inline">
															<span class="lbl">暂无文章</span>
														</label>
													</li>
												<?php }else{ foreach($alist as $item) { ?>
													<li class="item-default clearfix ui-sortable-handle">
														<label class="inline">
															<a href="/skytech_admin.php?s=article/addOrUpdate/aid/<?php echo $item['id'];?>"><span class="lbl"><?php echo $item['art_title'];?></span></a>
														</label>
														<div class="inline pull-right"><?php echo $item['art_postdate'];?></div>
													</li>
												<?php } }?>
												
											</ul>
										</div>
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

		<!-- page specific plugin scripts -->

		<!--[if lte IE 8]>
		  <script src="assets/js/excanvas.js"></script>
		<![endif]-->
	
		<!-- ace scripts -->
		<script src="assets/js/ace/ace.js"></script>
	
		<script src="assets/js/ace/ace.sidebar.js"></script>
		<script src="assets/js/ace/ace.submenu-hover.js"></script>
	
		<script src="assets/js/ace/ace.settings.js"></script>
		<script src="assets/js/ace/ace.settings-rtl.js"></script>
		<script src="assets/js/ace/ace.settings-skin.js"></script>
		<script src="assets/js/jquery-confirm.js"></script>

		<script src="js/config.js"></script>
		<script src="js/index.js"></script>
		
	</body>
</html>
