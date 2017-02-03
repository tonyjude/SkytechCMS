 $(document).ready(function () {
 	var btn = $('#button1');
 	btn.on('submit', function(e){

		var _target = $(e.target);
		_input = _target.find('input');
		
		var msg_name = $(_input.get(0));
		var msg_company = $(_input.get(1));
		var msg_product  = $(_input.get(2));
		var msg_email = $(_input.get(3));
		var msg_message = $(_target.find('textarea').get(0));
		
		if (msg_name.val() == '') {
			$(".tishi").css("color","red");
			$(".tishi").text("I am cannot be empty");
			return false;
		}
		
		if (msg_company.val() == '') {
			$(".tishi").css("color","red");
			$(".tishi").text("Company Name cannot be empty");
			return false;
		}
		
		if (msg_product.val() == '') {
			$(".tishi").css("color","red");
			$(".tishi").text("Product cannot be empty");
			return false;
		}
		
		if (msg_email.val() == '') {
			$(".tishi").css("color","red");
			$(".tishi").text("Email cannot be empty");
			return false;
		}
		
		if (!/\w+@\w+\.\w+/.test(msg_email.val())) {
			$(".tishi").css("color","red");
			$(".tishi").text("Email format is wrong");
			return false;
		}
		
		if (msg_message.val() == '') {
			$(".tishi").css("color","red");
			$(".tishi").text("Message cannot be empty");
			return false;
		}
		
		$.ajax({
			type : 'POST',
			data : btn.serialize(),
			url  : "/?s=msgboard/index",
			dataType: 'json',
			success : function(data){
				if (data.s == 1) {
					alert('submit success!');
					window.location.href = '/';
					return true;
				}
				
				$(".tishi").css("color","red");
				$(".tishi").text(data.err_str);
				return false;
			}
		});
		
		return false;	
	});
	
	//In addition to the current URL home page on the current column highlights
 	 $(".nav li a:not(:first)").each(function(){
		$this = $(this);
		if($this[0].href==String(window.location)){
           $this.parent().addClass("selected");
       }
    });
	
	//left cate click
	$(".cate-sub-a").each(function(i,obj){
		$(obj).on('click', function(){
			$(this).parent().next().toggle('slow');
		});
	});
	
	//search
	$("#search-btn").on('click', function(e){
		if($(this).prev().val() == '') {
			return false;
		}
		
		$(this).parent().trigger('submit');
	});

 });