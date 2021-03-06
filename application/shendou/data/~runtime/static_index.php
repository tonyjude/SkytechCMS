<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>生成更新</title>

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

							<li class="active">生成更新</li>
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
								<h3 class="header smaller lighter blue">生成更新</h3>
								<!-- <div class="dataTables_borderWrap"> -->
								<form name="sqlForm" method="get">
									<div class="clearfix static">
										<input type="hidden" name="opac" value="run"/>
										<label class="l">生成选项:</label>
										<select class="cate-select form-control" name="ac" onchange="ac_onchange(this)">
											<option value="index2">首页</option>
											<option value="topictask">专题</option>
											<option value="item">内容页</option>
											<option value="listtask">列表页</option>
											<option value="list">按栏目生成列表</option>
										</select>
										<div name="hide_choice" style="display:none">
											<select class="cate-select-level form-control" name="id">
												<option value="0">请选择栏目分类</option>
												<?php foreach($cates as $item) {?>
												<option value="<?php echo $item['id']; ?>">
													<?php echo $item['cate_name']; ?>
												</option>
												<?php } ?>
											</select>
										</div>
										
										每页处理数目 : <input style="width: 100px;" type="number" name="psi" size="5" value="100"/>  
										休眠时间 : <input style="width: 100px;" type="number" name="is" size="5" value="2"/> 秒
										只生成前 : <input style="width: 100px;" type="number" name="limit" value="" size="5"/> 个  
									</div>
							
									<div class="static static-page hide_choice" name="hide_choice" style="display:none">
										<label class="l">更新时间:</label>从 
										<input type="text" name="sd" id="sd" value="<?php echo $sdate;?>"/> 到 
										<input type="text" name="ed" id="ed" value="<?php echo $edate;?>"/> 
									</div>
								
									<input onclick="form_onclick()" type="button" value="开始生成" class="formbtn"/>
								</form>
							</div>

							<iframe width="100%" height="100%" frameBorder=0 marginheight="0" name="opFrame" marginwidth="0" id="content_1" src="about:blank"></iframe>
						
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
		
		<script src="assets/js/bootbox.js"></script>
		<script src="laydate/laydate.js"></script>
		
		<script src="js/config.js"></script>
		<script src="js/index.js"></script>
		
		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($){
				$('[data-rel="tooltip"]').tooltip();
			});
			
			;!function(){
				laydate({elem: '#sd',  format: 'YYYY-MM-DD hh:mm'});
				laydate({elem: '#ed',  format: 'YYYY-MM-DD hh:mm'});
			}();
			
			
			function ac_onchange(obj)
			{
				var val = obj.options[obj.selectedIndex].value,
					hide_choices = document.getElementsByName('hide_choice');
				if (val == 'item') {
					hide_choices[1].style.display = '';
				} else {
					hide_choices[1].style.display = 'none';
				}
				
				if (val == 'list') {
					hide_choices[0].style.display = '';
				} else {
					hide_choices[0].style.display = 'none';
				}	
			}
			
			function form_onclick()
			{
				var url = '?s=static//' + Router.bindFormCore(document.sqlForm);
				$('#content_1').attr('src', url);
			}

		</script>
		
		
	</body>
</html>
