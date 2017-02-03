(function($) {		
	//登录
	var form_login = $('#form_login');
	form_login.on('submit', function(e){
		
		var user_name = $(e.target.username).val();
		var user_pass = $(e.target.password).val();
		
		if (user_name == '' || user_name.length == 0) {
			T.index.tips('请输入用户名！');
			return false;
		}
		
		if (user_pass == '' || user_pass.length == 0) {
			T.index.tips('请输入密码！');
			return false;
		}

		$.ajax({
			type : 'POST',
			data : form_login.serialize(),
			url  : g_aCfg.dynamic_url.login,
			dataType: 'json',
			success : function(data){
				if (data.s == 1) {
					window.location.href = data.d.url;	
					return true;
				}
				
				T.index.tips(data.err_str);
				return false;
			}
		});
		
		return false;
	});
	
	//注册
	var form_register = $('#form_register');
	form_register.on('submit', function(e){
		
		var email = $(e.target.email).val();
		var user_name = $(e.target.username).val();
		var user_pass = $(e.target.password).val();
		var user_repass = $(e.target.repassword).val();
		var code = $(e.target.code).val();
		
		if (email == '' || email.length == 0) {
			T.index.tips('请输入邮箱！');
			return false;
		}
		
		if (!/\w+@\w+\.\w+/.test(email)) {
			T.index.tips('请输入正确的邮箱！');
			return false;
		}
		
		if (code == '' || code.length == 0) {
			T.index.tips('请输入邀请码！');
			return false;
		}
		
		if (user_name == '' || user_name.length == 0) {
			T.index.tips('请输入用户名！');
			return false;
		}
		
		if (user_pass == '' || user_pass.length == 0) {
			T.index.tips('请输入密码！');
			return false;
		}
		
		if (user_repass == '' || user_repass.length == 0) {
			T.index.tips('请输入确认密码！');
			return false;
		}
		
		if (user_repass != user_pass) {
			T.index.tips('确认密码不一致！');
			return false;
		}

		$.ajax({
			type : 'POST',
			data : form_register.serialize(),
			url  : g_aCfg.dynamic_url.rigister,
			dataType: 'json',
			success : function(data){
				if (data.s == 1) {
					window.location.href = data.d.url;		
					return true;
				}
				
				T.index.tips(data.err_str);
				return false;
				
			}
		});
		
		return false;
	});
	
	
	//添加/修改栏目
	var form_categories = $('#add_or_update_categories');
	form_categories.on('submit', function(e){
		var _target = $(e.target);
		
		var cate_name = $(_target.find('input').get(0));
		var cate_seo_title = $(_target.find('input').get(1));
		var cate_keywords = $(_target.find('input').get(2));
		var cate_description = $(_target.find('input').get(3));
		
		if (cate_name.val() == '' || cate_name.val().length == 0) {
			T.index.tips('请输入栏目名称！');
			return false;
		}
		
		if (cate_name.val().length > 100) {
			T.index.tips('栏目名称长度不能超过100！');
			return false;
		}
		
		if (cate_seo_title.val().length >250) {
			T.index.tips('seo标题长度不能超过250！');
			return false;
		}
		
		if (cate_keywords.val().length > 250) {
			T.index.tips('栏目关键字长度不能超过250！');
			return false;
		}
		
		if (cate_description.val().length > 500) {
			T.index.tips('栏目描述长度不能超过500！');
			return false;
		}

		$.ajax({
			type : 'POST',
			data : form_categories.serialize(),
			url  : g_aCfg.dynamic_url.categories_add_or_update,
			dataType: 'json',
			success : function(data){
				if (data.s == 1) {
					window.location.href = 	g_aCfg.dynamic_url.categories_index;
					return true;
				}
				
				T.index.tips(data.err_str);
				return false;
				
			}
		});
		
		return false;
	});

	$('#add_batch_categories').on('submit', function(e){
		$('#cate_submit').attr("disabled","true");
	});
	
	//批量添加栏目
	$('#batch_add').on('click', function(){
		var batch_table = $('#batch_table');
		var len = batch_table.find("tr").size()
		
		if (len > 50) {
			T.index.tips('批量添加栏目个数不能超过50！');
			return false;
		}
			
		var _tr = $('<tr></tr>'),
			td_sort = $('<td></td>'),
			td_name = $('<td></td>'),
			td_del  = $('<td></td>');
		
		var input_sort = $('<input>'),
			input_name = $('<input>'),
			input_del = $('<input>');
			
		input_sort.attr("type", "text");
		input_sort.attr("name", "data["+ len +"][cate_sort]");
		input_sort.attr("value", "50");
		td_sort.append(input_sort);
		
		input_name.attr("type", "text");
		input_name.attr("class", "cate-name");
		input_name.attr("name", "data["+ len +"][cate_name]");
		td_name.append(input_name);
		
		input_del.attr("type", "button");
		input_del.attr("value", "删除");
		td_del.append(input_del);
		
		_tr.append(td_sort);
		_tr.append(td_name);
		_tr.append(td_del);
		
		td_del.on('click', function(){
			$(this).parent().remove();
		});
		
		batch_table.append(_tr);		
	});
	
	//删除批量添加
	$(".cate-del").each(function(i, obj){
		$(obj).on('click', function(){
			$($(this).parent()).parent().remove();
		});
	});
	
	
	//添加/修改菜单
	var form_nav = $('#add_or_update_nav');
	form_nav.on('submit', function(e){
		var _target = $(e.target);
		
		var cate_name = $(_target.find('input').get(0));
		var cate_seo_title = $(_target.find('input').get(2));
		var cate_keywords = $(_target.find('input').get(3));
		var cate_description = $(_target.find('textarea').get(0));
		
		if (cate_name.val() == '' || cate_name.val().length == 0) {
			T.index.tips('请输入菜单名称！');
			return false;
		}
		
		if (cate_name.val().length > 100) {
			T.index.tips('菜单名称长度不能超过100！');
			return false;
		}

		if (cate_seo_title.val().length >250) {
			T.index.tips('菜单seo标题长度不能超过250！');
			return false;
		}
		
		if (cate_keywords.val().length > 250) {
			T.index.tips('菜单关键字长度不能超过250！');
			return false;
		}
		
		if (cate_description.val().length > 500) {
			T.index.tips('菜单描述长度不能超过500！');
			return false;
		}
		
		$.ajax({
			type : 'POST',
			data : form_nav.serialize(),
			url  : g_aCfg.dynamic_url.navigation_addOrUpdate,
			dataType: 'json',
			success : function(data){
				if (data.s == 1) {
					window.location.href = g_aCfg.dynamic_url.navigation_index;
					return true;
				}
				
				T.index.tips(data.err_str);
				return false;
			}
		});
		
		return false;
	});
	
	
	//添加/修改文章
	var form_article = $('#form_article');
	form_article.on('submit', function(e){
		var art_title = $('#art_title').val();
		
		if (art_title == '' || art_title.length == 0) {
			T.index.tips('请输入文章标题！');
			return false;
		}
		
		if ($('#art_catalog_id').val() == 0) {
			T.index.tips('请输入文章主栏目！');
			return false;
		}
		
		$('#article_submit').attr("disabled","true");

		var content = UE.getEditor('editor').getContent();
		$("#description").val(content);
		
		var cid = e.target.cid.value;
		var cname = e.target.cname.value;
		
		$.ajax({
			type : 'POST',
			data : form_article.serialize(),
			url  : g_aCfg.dynamic_url.article_add_update,
			dataType: 'json',
			success : function(data){
				if (data.s == 1) {
					$('#content_1').attr('src', data.d.url);
					//window.history.go(-1);
					window.location.href = g_aCfg.dynamic_url.article_index + '/cid/' + cid + '/cname/' + cname;
					return true;
				}
				
				T.index.tips(data.err_str);
				return false;
			}
		});		
		
		return false;
	});
	
	
	//添加/修改专题
	var form_topic = $('#form_topic');
	form_topic.on('submit', function(e){
		var _target = $(e.target);
		var topic_name = $(_target.find('input').get(0));
		
		if (topic_name.val() == '' || topic_name.val().length == 0) {
			T.index.tips('请输入专题名称！');
			return false;
		}
		
		if (topic_name.val().length > 200) {
			T.index.tips('专题名称长度不能超过200！');
			return false;
		}
		
		$('#topic_submit').attr("disabled","true");
		
		$.ajax({
			type : 'POST',
			data : form_topic.serialize(),
			url  : g_aCfg.dynamic_url.topic_add_update,
			dataType: 'json',
			success : function(data){
				if (data.s == 1) {
					$('#content_1').attr('src', data.d.url);
					window.location.href = g_aCfg.dynamic_url.topic_index;
					return true;
				}
				
				T.index.tips(data.err_str);
				return false;
			}
		});		
		
		return false;
	});
	
	//修改网站信息
	/*
	var form_custmer = $('#form_custmer');
	form_custmer.on('submit', function(e){
		
		$.ajax({
			type : 'POST',
			data : form_custmer.serialize(),
			url  : g_aCfg.dynamic_url.custmer_info_update,
			dataType: 'json',
			success : function(data){
				if (data.s == 1) {
					T.index.tips(data.err_str);
					return true;
				}
				
				T.index.tips(data.err_str);
				return false;
			}
		});
		
		return false;
	});
	*/
	
	//修改网站信息
	var form_custmer_config = $('#form_custmer_config');
	form_custmer_config.on('submit', function(e){
		
		$.ajax({
			type : 'POST',
			data : form_custmer_config.serialize(),
			url  : g_aCfg.dynamic_url.custmer_config,
			dataType: 'json',
			success : function(data){
				if (data.s == 1) {
					T.index.tips(data.err_str);
					return true;
				}
				
				T.index.tips(data.err_str);
				return false;
			}
		});
		
		return false;
	});
	
	//添加/修改用户
	var form_user = $('#form_user');
	form_user.on('submit', function(e){
		
		var _target = $(e.target);
		var user_name = $(_target.find('input').get(0));
		var user_pass = $(_target.find('input').get(1));
		
		if (user_name.val() == '' || user_name.val().length == 0) {
			T.index.tips('请输入用户名！');
			return false;
		}
		
		if (user_pass.val() == '' || user_pass.val().length == 0) {
			T.index.tips('请输入密码！');
			return false;
		}
		
		if (user_name.val().length > 100) {
			T.index.tips('用户名长度不能超过100！');
			return false;
		}
		
		if (user_pass.val().length >100) {
			T.index.tips('密码长度不能超过100！');
			return false;
		}

		$.ajax({
			type : 'POST',
			data : form_user.serialize(),
			url  : g_aCfg.dynamic_url.user_add_or_update,
			dataType: 'json',
			success : function(data){
				if (data.s == 1) {
					window.location.href = g_aCfg.dynamic_url.user_index;
					return true;
				}
				
				T.index.tips(data.err_str);
				return false;
				
			}
		});
		
		return false;
	});
	
	
	//修改企业信息
	var form_company = $('#form_company');
	form_company.on('submit', function(e){
		
		var content = UE.getEditor('editor').getContent();
		$("#description").val(content);
	
		$.ajax({
			type : 'POST',
			data : form_company.serialize(),
			url  : g_aCfg.dynamic_url.company_info_update,
			dataType: 'json',
			success : function(data){
				if (data.s == 1) {
					T.index.tips(data.err_str);
					return true;
				}
				
				T.index.tips(data.err_str);
				return false;
			}
		});
		
		return false;
	});
	
	//修改媒体链接
	var form_flinks = $('#form_flinks');
	form_flinks.on('submit', function(e){
		
		$.ajax({
			type : 'POST',
			data : form_flinks.serialize(),
			url  : g_aCfg.dynamic_url.flinks_add_update,
			dataType: 'json',
			success : function(data){
				if (data.s == 1) {
					//T.index.tips(data.err_str);
					window.location.href = g_aCfg.dynamic_url.flinks;
					return true;
				}
				
				T.index.tips(data.err_str);
				return false;
			}
		});
		
		return false;
	});
	
	$("#draft").on('click', function(){
		var local_content = UE.getEditor('editor').execCommand( "getlocaldata" );
		UE.getEditor('editor').setContent(local_content);
	});
		
	
	//管理员修改网站信息
	/*
	var form_custmer_client = $('#form_custmer_client');
	form_custmer_client.on('submit', function(e){
		
		$.ajax({
			type : 'POST',
			data : form_custmer_client.serialize(),
			url  : g_aCfg.dynamic_url.custmer_info_update,
			dataType: 'json',
			success : function(data){
				if (data.s == 1) {
					T.index.tips(data.err_str);
					return true;
				}
				
				T.index.tips(data.err_str);
				return false;
			}
		});
		
		return false;	
	});
	
	*/

	//跳转到添加子栏目
	$('.add_sub_catag').each(function(i, obj){
		
		$(obj).on('click', function(e){
			var id = $(e.target).parent().parent().attr('id');
			window.location.href = g_aCfg.dynamic_url.categories_add_or_update + '/id/' + id;
		});
		
	});
	
	//跳转到添加子菜单
	$('.add_sub_menu').each(function(i, obj){
		
		$(obj).on('click', function(e){
			var id = $(e.target).parent().parent().attr('id');
			window.location.href = g_aCfg.dynamic_url.navigation_addOrUpdate + '/id/' + id;
		});
		
	});
	
	//删除栏目
	$('.del_catag').each(function(i, obj){
		
		$(obj).on('click', function(e){
					
            $.confirm({
                title: 'Confirm!',
                content: '<h4>确认删除该栏目!</h4>',
                confirm: function () {
                   	var id = $(e.target).parent().parent().attr('id');
					window.location.href = g_aCfg.dynamic_url.categories_delete + '/id/' + id;
                }
            });
			
		});
	});
	
	//删除菜单
	$('.del_menu').each(function(i, obj){
		
		$(obj).on('click', function(e){
					
            $.confirm({
                title: 'Confirm!',
                content: '<h4>确认删除该菜单!</h4>',
                confirm: function () {
                   	var id = $(e.target).parent().parent().attr('id');
					window.location.href = g_aCfg.dynamic_url.navigation_delete + '/id/' + id;
                }
            });

		});
		
	});
	
	//删除文章
	$('.article-del').each(function(i, obj){
		
		$(obj).on('click', function(e){
					
            $.confirm({
                title: 'Confirm!',
                content: '<h4>确认删除该文章!</h4>',
                confirm: function () {
                    var aid = $(e.target).parent().attr('aid');
					$.ajax({
						type : 'get',
						url  :  g_aCfg.dynamic_url.article_delete + '/aid/' + aid,
						dataType: 'json',
						success : function(data){
							if (data.s == 1) {
								window.location.reload();
								return true;
							}
							T.index.tips('系统错误！');
							return false;
						}
					});	
                }
            });

		});
		
	});
	
	//删除专题
	$('.topic-del').each(function(i, obj){
		
		$(obj).on('click', function(e){
					
            $.confirm({
                title: 'Confirm!',
                content: '<h4>确认删除该专题!</h4>',
                confirm: function () {
                   	var id = $(e.target).parent().attr('id');
					window.location.href = g_aCfg.dynamic_url.topic_delete + '/id/' + id;
                	
                	$.ajax({
						type : 'get',
						url  :  g_aCfg.dynamic_url.topic_delete + '/id/' + id,
						dataType: 'json',
						success : function(data){
							if (data.s == 1) {
								window.location.reload();
								return true;
							}
							T.index.tips('系统错误！');
							return false;
						}
					});
					
                }
            });

		});
		
	});
	
	//预览文章
	$('.article-view').each(function(i, obj){
		$(obj).on('click', function(e){	
           var id = $(e.target).parent().attr('aid');
		   window.open(g_aCfg.root +  'index.php?s=item/index/id/' + id);
       });
		
	});
	
	//预览专题
	$('.topic-view').each(function(i, obj){
		$(obj).on('click', function(e){	
           var path = $(e.target).parent().attr('path');
		   window.open(path + 'index.html');
       });
		
	});
	
	//模板编辑
	var template = $('#template');
	template.on('submit', function(e){
		
		$.ajax({
			type : 'POST',
			data : {'content' : $(e.target.content).val(), 'path' : $(e.target.path).val()},
			url  : g_aCfg.dynamic_url.template,
			dataType: 'json',
			success : function(data){
				if (data.s == 1) {
					T.index.tips(data.err_str);
					return true;
				}
				
				T.index.tips(data.err_str);
				return false;
			}
		});
		
		return false;
	});
	
	//删除留言
	$('.del_msg').each(function(i, obj){
		
		$(obj).on('click', function(e){
					
            $.confirm({
                title: 'Confirm!',
                content: '<h4>确认删除该留言!</h4>',
                confirm: function () {
                   	var id = $(e.target).parent().attr('id');
                   	
                   	$.ajax({
						type : 'get',
						url  :  g_aCfg.dynamic_url.msgboard_delete + '/id/' + id,
						dataType: 'json',
						success : function(data){
							if (data.s == 1) {
								window.location.reload();
								return true;
							}
							T.index.tips('系统错误！');
							return false;
						}
					});
                }
            });

		});
		
	});
	
	//修改留言状态 是否公开
	$('.is_public').each(function(i, obj){
		$(obj).on('click', function(e){
			var id = $(e.target).attr('id');	
			var is_p  = $(e.target).attr('is_p');
			window.location.href = g_aCfg.dynamic_url.msgboard_update + '/id/' + id + '/is_p/' + is_p;			
		});
	});
	
	//留言全选删除	
	$('#select').click(function(e){
		
		var is_c = e.target.checked;
		var del_all = $('#del_all');
		is_c ? del_all.show() : del_all.hide();
		var isChecked = $(this).prop("checked");
    	$("input[name='chk_list']").prop("checked", isChecked);
		
		del_all.on('click', function(){
			
			var ids = '';
			$('.select-ace').each(function(i, obj){
				if ($(obj).prop("checked")) {
					ids = ids + $(obj).attr('id') + ','; 
				}
			});
		
			if (ids != '') {
				$.confirm({
	                title: 'Confirm!',
	                content: '<h4>确认删除选中留言!</h4>',
	                confirm: function () {
						$.ajax({
							type : 'get',
							url  :  g_aCfg.dynamic_url.msgboard_delete + '/id/' + ids,
							dataType: 'json',
							success : function(data){
								if (data.s == 1) {
									window.location.reload();
									return true;
								}
								
								T.index.tips('系统错误！');
								return false;
							}
						});
	                }
	           });  
			}
		});
	});
	
	
	//删除媒体链接
	$('.flinsk-del').each(function(i, obj){
		
		$(obj).on('click', function(e){
					
            $.confirm({
                title: 'Confirm!',
                content: '<h4>确认删除该链接!</h4>',
                confirm: function () {
                   	var id = $(e.target).parent().attr('fid');
                   	
                   	$.ajax({
						type : 'get',
						url  :  g_aCfg.dynamic_url.flinks_delete + '/id/' + id,
						dataType: 'json',
						success : function(data){
							if (data.s == 1) {
								window.location.reload();
								return true;
							}
							T.index.tips('系统错误！');
							return false;
						}
					});
                }
            });

		});
		
	});
	
	//文章全选删除	
	$('#art_select').click(function(e){
		
		var is_c = e.target.checked;
		var del_all = $('#del_all');
		is_c ? del_all.show() : del_all.hide();
		var isChecked = $(this).prop("checked");
    	$("input[name='chk_list']").prop("checked", isChecked);
		
		del_all.on('click', function(){
			
			var ids = '';
			$('.select-ace').each(function(i, obj){
				if ($(obj).prop("checked")) {
					ids = ids + $(obj).attr('id') + ','; 
				}
			});
		
			if (ids != '') {
				$.confirm({
	                title: 'Confirm!',
	                content: '<h4>确认删除选中文章!</h4>',
	                confirm: function () {
						$.ajax({
							type : 'get',
							url  :  g_aCfg.dynamic_url.article_delete + '/aid/' + ids,
							dataType: 'json',
							success : function(data){
								if (data.s == 1) {
									window.location.reload();
									return true;
								}
								
								T.index.tips('系统错误！');
								return false;
							}
						});
	                }
	           });  
			}
		});
	});
	
	//编辑栏目
	$('.update_catag').each(function(i, obj){
		$(obj).on('click', function(e){
			var id = $(e.target).parent().parent().attr('id');
			window.open(g_aCfg.dynamic_url.categories_add_or_update + '/cate_id/' + id);
		});
	});
	
	//编辑菜单
	$('.update_menu').each(function(i, obj){
		$(obj).on('click', function(e){
			var id = $(e.target).parent().parent().attr('id');
			window.location.href = g_aCfg.dynamic_url.navigation_addOrUpdate + '/nav_id/' + id;
		});
	});
	
	
	/*显示当前导航状态 active*/
	var url = window.location.href;
	$('.nav-list').find('.nav_status').each(function(i, obj){
		$(obj).removeClass('active');
		var _url = $(obj).find('a').get(0).href;
		url = url.replace('#', '');
		
		//r = url.match(/\/?s=(\w*)\//);
		//t = _url.match(/\/?s=(\w*)\//);
		
		if (url == _url){
			$(obj).addClass('active');
			$($(obj).parent().parent().get(0)).addClass('active open');
		}
	});
	
	
	//退出系统
	$('#logout').on('click', function(e){
		e.preventDefault();
		$.ajax({
			type : 'get',
			url  : g_aCfg.dynamic_url.loginout,
			dataType: 'json',
			success : function(data){
				window.location.href = g_aCfg.dynamic_url.login
			}
		});
	});
	
	//改变用户状态
	/*
	$('.lock').each(function(i, obj){
		$(obj).on('click', function(e){
			var id = $(this).attr('uid');
			$.ajax({
				type : 'get',
				url  : g_aCfg.dynamic_url.changeStatus + '/id/' + id,
				dataType: 'json',
				success : function(data){
					window.location.reload();
				}
			});
		});
	});
	*/
	
	
	//用户组权限设置
	var form_purwiews = $('#form_purwiews');
	form_purwiews.on('submit', function(e){
		
		$.ajax({
			type : 'POST',
			data : form_purwiews.serialize(),
			url  : g_aCfg.dynamic_url.purwiews_set,
			dataType: 'json',
			success : function(data){

				if (data.s == 1) {
					T.index.tips(data.err_str);
					return true;
				}
				
				T.index.tips(data.err_str);
				return false;
			}
		});
		
		return false;
	});
	
})(window.jQuery);


var T = {}
T.index = {
	
	'page' : function(page){
		var sample_previous = $('#sample_previous');
		var sample_next = $('#sample_next');
		var total_page  = $('#total_page').val();
		if (page == 1) {
			sample_previous.addClass('disabled');
			$(sample_previous.children().get(0)).removeAttr('href');
		}

		if (page == total_page) {
			sample_next.addClass('disabled');
			$(sample_next.children().get(0)).removeAttr('href');
		}
	},
	
	//消息提示
	'tips' : function(text)
	{
		bootbox.dialog({
			message: text,
			buttons: {
				"success" : {
					"label" : "确定",
					"className" : "btn btn-warning"
				}
			}
		});
	}
	
}

var T = {}
T.index = {
	
	'page' : function(page){
		var sample_previous = $('#sample_previous');
		var sample_next = $('#sample_next');
		var total_page  = $('#total_page').val();
		if (page == 1) {
			sample_previous.addClass('disabled');
			$(sample_previous.children().get(0)).removeAttr('href');
		}

		if (page == total_page) {
			sample_next.addClass('disabled');
			$(sample_next.children().get(0)).removeAttr('href');
		}
	},
	
	//消息提示
	'tips' : function(text)
	{
		bootbox.dialog({
			message: text,
			buttons: {
				"success" : {
					"label" : "确定",
					"className" : "btn btn-warning"
				}
			}
		});
	}
	
}

var Utils = {
	
	/**
	 * 判断val是否在数组arr中
	 * @param {array} arr
	 * @param {mix} val
	 * @param {boolean} bStrict = false
	 * @return {boolean}
	 */
	inArray : function(arr, val, bStrict/*=false*/)
	{
		bStrict = !!bStrict;
		if (bStrict) {
			for (var i = 0, j = arr.length; i < j; i++) {
				if (arr[i] === val){ return true; }
			}
		}
		else {
			for (var i = 0, j = arr.length; i < j; i++) {
				if (arr[i] == val){ return true;}
			}
		}
		return false;
	},
	
	isArray : function(array)
	{
		return array && array.constructor === Array;
	},
	
	/**
	 * 扩展replace方法，在字符串str查找search，并替换所有
	 * @param {string} str
	 * @param {string} search
	 * @param {string} replaceMent
	 * @param {boolean} bIgnore是否区分大小写默认false
	 * @return {string}
	 */
	replaceEx : function(str, search, replaceMent, bIgnore/*=false*/)
	{
		return (str + '').replace(new RegExp(this.regexpQuote(search), bIgnore ? 'g' : 'gi'), replaceMent);
	},
	
	/**
	 * 为正则表达式字符串str转义
	 * @param {string} str
	 * @param {string} delimiter
	 * @return {string}
	 */
	regexpQuote : function(str, delimiter/*=''*/)
	{
		return (str + '').replace(new RegExp('[.\\\\+*?\\[\\^\\]$(){}=!<>|:\\' + (delimiter || '') + '-]', 'g'), '\\$&');
	}
	
}

var Router = {	
	'delimiter' : g_aCfg.router.url_delimiter,
	'param_name' : g_aCfg.router.url_param_name,
	'encode_map' : {'/' : '~@:@~'},
	'encode' : function (str)
	{
		for (var repl in this.encode_map) {
			str = Utils.replaceEx(str, repl, this.encode_map[repl]);	
		}
		return encodeURIComponent(str);
	},
	'decode' : function (str)
	{
		str = decodeURIComponent(str);
		for (var repl in this.encode_map) {
			str = Utils.replaceEx(str, this.encode_map[repl], repl);
		}
		return str;
	},
	'get' : function(controllor, action, params)
	{
		controllor = controllor || '';
		action = action || '';
		params = params || {};
		var params = this.make(params);
		return '?' + this.param_name + '=' + controllor + this.delimiter + 
				action + (params ? (this.delimiter + params) : '');
	},
	'make' : function(params)
	{
		var ret = [];
		for (var name in params) {
			ret.push(this.encode(name));
			ret.push(this.encode(params[name]));
		}
		return ret.join(this.delimiter);
	},
	'bindForm' : function(isBind, control, action, form, includeBtn/*=false*/)
	{
		var that = this,
			core = function(){
				event.returnValue = false;
				location.href = '?' + that.param_name + '=' + that.encode(control) + that.delimiter + 
					that.encode(action) + that.delimiter + that.bindFormCore(form, includeBtn);	
			};
		isBind ? (form.onsubmit = core) : core();
	},
	'bindFormCore' : function(form, includeBtn /*=false*/)
	{
		includeBtn = !!includeBtn;
		var cols = form.getElementsByTagName('input'),
			params = {};
		
		for( var i = 0, j = cols.length; i < j; i ++) {
			if (!includeBtn && Utils.inArray(['button', 'submit', 'reset'], cols[i].type)) {
				continue ;	
			}
			if (cols[i].name) {
				params[cols[i].name] = cols[i].value;
			}
		}
		
		cols = form.getElementsByTagName('select');
		for (var i = 0, j = cols.length; i < j; i++) {
			if (cols[i].name) {
				params[cols[i].name] = cols[i].value;
			}	
		}
		return this.make(params);
	}
}	
