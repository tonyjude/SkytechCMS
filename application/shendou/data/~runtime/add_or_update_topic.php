<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>添加/修改专题</title>

		<meta name="description" content="Common form elements and layouts" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" />
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
		
		<style type="text/css">
			#loading{
				background-color: white;
			    width: 120px;
			    height: 20px;
			    top: 25px;
			    position: absolute;
			    _position: absolute;
			    text-align: center;
			    border: 1px solid #ccc;
			    z-index: 2000;
			    display: none; 
			}
		</style>
		
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

						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="/skytech_admin.php">Home</a>
							</li>
													
							<li>
								<a href="/skytech_admin.php?s=topic/index">专题管理</a>
							</li>
							
							<li class="active">添加专题</li>
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
								
								<form class="form-horizontal" action="" method="post" id="form_topic">
									<!-- #section:elements.form -->
									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" >名称 </label>

										<div class="col-sm-10">
											<input <?php if (isset($info['topic_name'])) {echo "readonly=true";} ?> type="text" name="data[topic_name]" value="<?php echo isset($info['topic_name']) ? $info['topic_name'] : ''; ?>"　  id="topic_name" placeholder="必填" class="col-xs-10 col-sm-5">
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" >标题 </label>

										<div class="col-sm-10">
											<input type="text" name="data[topic_title]"  value="<?php echo isset($info['topic_title']) ? $info['topic_title'] : ''; ?>"　id="topic_title" class="col-xs-10 col-sm-5">
										</div>
									</div>
									
																
									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right">内容 </label>

										<div class="tabbable col-sm-9">
											<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
												<li class="active">
													<a data-toggle="tab" href="#home4" aria-expanded="true">正文</a>
												</li>

												<li class="">
													<a data-toggle="tab" href="#profile4" aria-expanded="false">选项一</a>
												</li>

												<li class="">
													<a data-toggle="tab" href="#dropdown14" aria-expanded="false">选项二</a>
												</li>
											</ul>
											<div class="tab-content">
												<div id="home4" class="tab-pane active">
													<div><script id="editor" name="data[topic_content]"  type="text/plain"><?php echo isset($info['topic_content']) ? $info['topic_content'] : ''; ?></script><input type="radio"  id="draft" />草稿箱</div>
												</div>

												<div id="profile4" class="tab-pane">
													<div><script id="editor2" name="data[topic_content_option1]" type="text/plain"><?php echo isset($info['topic_content_option1']) ? $info['topic_content_option1'] : ''; ?></script></div>
												</div>

												<div id="dropdown14" class="tab-pane">
													<div><script id="editor3"  name="data[topic_content_option2]" type="text/plain"><?php echo isset($info['topic_content_option2']) ? $info['topic_content_option2'] : ''; ?></script></div>
												</div>
											</div>
										</div>	
									</div>
									
									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" >缩略图</label>

										<div class="col-sm-10">
											<input type="text" style="width:320px" name="data[topic_img]" id="topic_img_input" value="<?php echo isset($info['topic_img']) ? $info['topic_img'] : ''; ?>"　class="col-xs-10 col-sm-5">
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right">上传缩略图</label>
										<div class="col-sm-10">
											<img id="topic_img_src" src="<?php echo isset($info['topic_img'])  && $info['topic_img'] != '' ? $info['topic_img'] : '/images/nopic.jpg'; ?>" class="atitcle-img"/>
											
											<input id="fileupload" class="upload_if" type="file" name="upfile">
											<p style="display: inline-block;">*图片大小不能超过<?php echo $this->mSiteCfg['webInfo']['upload']['maxSize']/1024; ?>KB</p>
											<div id="loading">
												<span class="bar"><img src="/images/loading.gif" /></span>
												<span class="percent">0%</span>
									    	</div>
									    	
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right">SEO标题</label>

										<div class="col-sm-10">
											<input type="text" name="data[topic_seo_title]" value="<?php echo isset($info['topic_seo_title']) ? $info['topic_seo_title'] : ''; ?>"　id="topic_seo_title"  class="col-xs-10 col-sm-5">
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right">关键词</label>

										<div class="col-sm-10">
											<input type="text" name="data[topic_keywords]"  value="<?php echo isset($info['topic_keywords']) ? $info['topic_keywords'] : ''; ?>"　id="topic_keywords" class="col-xs-10 col-sm-5">
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right">描述</label>
										<div class="col-sm-10">	
											<textarea class="col-xs-10 col-sm-5" name="data[topic_description]" id="topic_description" ><?php echo isset($info['topic_description']) ? $info['topic_description'] : ''; ?></textarea>
										</div>	
									</div>
									
									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right">模板</label>
										<div class="col-sm-10">
											<input type="text" style="width: 150px;"  name="data[topic_templte]" value="<?php echo isset($info['topic_templte']) ? $info['topic_templte'] : ''; ?>"　 class="col-xs-10 col-sm-5">
										</div>	
									</div>
									
									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right">更新时间</label>
										<div class="col-sm-10">
											<input type="text" style="width: 150px;"  name="data[topic_postdate]" id="topic_postdate" value="<?php echo isset($info['topic_postdate']) ? $info['topic_postdate'] : ''; ?>"　 class="col-xs-10 col-sm-5">
										</div>	
									</div>
									
									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right">	浏览次数 </label>
										<div class="col-sm-10">
											<input type="text" name="data[topic_readcount]" style="width: 150px;" value="<?php echo isset($info['topic_readcount']) ? $info['topic_readcount'] : ''; ?>"　class="col-xs-10 col-sm-5">
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right">	作　者 </label>

										<div class="col-sm-10">
											<input type="text" name="data[topic_author]" style="width: 150px;" value="<?php echo isset($info['topic_author']) ? $info['topic_author'] : ''; ?>"　class="col-xs-10 col-sm-5">
										</div>
									</div>
									
									<input type="hidden" name="data[id]" value="<?php echo isset($id) ? $id : ''; ?>" />
				
									<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info" id="topic_submit" type="submit">
												<i class="ace-icon fa fa-check bigger-110"></i>
												提 交
											</button>

											&nbsp; &nbsp; &nbsp;
											<button class="btn" onClick="javascript:history.go(-1);">
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
			
			<iframe style="display: none" frameBorder=0 marginheight="0" name="opFrame" marginwidth="0" id="content_1" src="about:blank"></iframe>
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

		<!--[if lte IE 8]>
		  <script src="assets/js/excanvas.js"></script>
		<![endif]-->

		<script src="assets/js/bootbox.js"></script>

		<!-- ace scripts -->
		<script src="assets/js/ace/elements.scroller.js"></script>
		<script src="assets/js/ace/elements.colorpicker.js"></script>
		
		<script src="assets/js/ace/ace.js"></script>
	
		<script src="assets/js/ace/ace.sidebar.js"></script>
		<script src="assets/js/ace/ace.submenu-hover.js"></script>
	
		<script src="assets/js/ace/ace.settings.js"></script>
		<script src="assets/js/ace/ace.settings-rtl.js"></script>
		<script src="assets/js/ace/ace.settings-skin.js"></script>
		
		<script src="ueditor/ueditor.config.js"></script>
		<script src="ueditor/ueditor.all.min.js"></script>
		<script src="ueditor/lang/zh-cn/zh-cn.js"></script>
		
		<script src="laydate/laydate.js"></script>
		
		<script src="js/jquery.form.js"></script>
		<script src="js/config.js"></script>
		<script src="js/index.js"></script>
		
		<script>
			var ue = UE.getEditor('editor');
			var ue2 = UE.getEditor('editor2');
			var ue3 = UE.getEditor('editor3');
			
			laydate({
	            elem: '#topic_postdate'
	        });
	        
	        $(function () {
				var percent = $('.percent');
			
				$("#fileupload").wrap("<form id='myupload' action='<?php echo $this->mRouter->urlEx('upload', 'upload');?>' method='post' enctype='multipart/form-data'></form>");
			    $("#fileupload").change(function(){
					$("#myupload").ajaxSubmit({
						dataType:  'json',
						beforeSend: function() {
							$("#loading").show();
			        		var percentVal = '0%';
			        		percent.html(percentVal);
			    		},
			    		uploadProgress: function(event, position, total, percentComplete) {
			        		var percentVal = percentComplete + '%';
			        		percent.html(percentVal);
			    		},
						success: function(data) {
							if (data.s == 0) {
								T.index.tips(data.err_str);
								$("#loading").hide();
								return false;
							}
							var img = '/' + data.err_str;
							$("#loading").hide();
							$('#topic_img_input').val(img);
							$('#topic_img_src').attr('src', img);
						},
						error:function(xhr){
							T.index.tips('上传失败...');
						}
					});
				});
			});
		</script>

	</body>
</html>
