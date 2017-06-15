<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>留言板</title>

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

							<li class="active">留言板管理</li>
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
						<div class="page-header-h1">
							
						</div><!-- /.page-header -->
						
						<div class="row">
							<div class="col-xs-12">
								<h3 class="header smaller lighter blue">留言详情</h3>

								<!-- <div class="dataTables_borderWrap"> -->
								<div>
									<table id="sample-table-2" class="table table-striped table-bordered table-hover">
										<tbody>
											
											<tr>
												<td>名字:</td>
												<td><?php echo $info['msg_name'];?></td>
											</tr>
											
											<tr>
												<td>Company：</td>
												<td><?php echo $info['msg_company'];?></td>
											</tr>
											
											<tr>
												<td>Subject：</td>
												<td><?php echo $info['msg_subject'];?></td>
											</tr>
											
											<tr>
												<td>页面来源：</td>
												<td><?php echo $info['msg_source_page'];?></td>
											</tr>
											
											<tr>
												<td>Email:</td>
												<td><?php echo $info['msg_email'];?></td>
											</tr>
											
											<tr>
												<td>Phone:</td>
												<td><?php echo $info['msg_phone'];?></td>
											</tr>
											
											<tr>
												<td>Tel:</td>
												<td><?php echo $info['msg_tel'];?></td>
											</tr>
											
											<tr>
												<td>Address:</td>
												<td><?php echo $info['msg_address'];?></td>
											</tr>
											
											<tr>
												<td>Comments:</td>
												<td><textarea  rows="5" cols="60" ><?php echo $info['msg_comments'];?></textarea></td>
											</tr>
											<tr>
												<td  colspan="2"><button id='back'>返回</button></td>
											</tr>
										</tbody>
									</table>
	
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

			$('#back').on('click', function(){
				window.history.go(-1);
			});
		
			
		</script>
		
		<script src="js/config.js"></script>
		<script src="js/index.js"></script>
	</body>
</html>
