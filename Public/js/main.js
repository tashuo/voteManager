$(document).ready(function(){
	//禁止form表单回车提交
	$('#voteForm, #voteUpdateForm, #registerForm, #registerUpadteForm').keydown(function(e) {
		var key = window.event?e.keyCode:e.which;
		if(key.toString() == '13'){
			return false;
		}
	});

	//动态添加新选择项
	$(document).delegate('.addOption', 'click', function(e) {
		//分别获取各个父节点，对其进行处理
		var divNode = $(this).parent().parent();
		var name = divNode.children().first().attr('name');

		//获取最后一个input框的placeholder的值，并自增1
		var placeholder = divNode.children().first().attr('placeholder');
		var placeholder_num = placeholder.slice(2);
		var new_placeholder = '选项'+(parseInt(placeholder_num)+1);

		//获取最后一个input框的name值，并自增1
		var name_1 = name.slice(0,name.indexOf('_'));
		var name_2 = name.slice((name.length-1));
		var new_name = name_1+'_'+(parseInt(name_2)+1);

		//将当前的button改为删除的按钮
		$(this).replaceWith('<button class="btn btn-danger deleteOption" type="button" data-toggle="tooltip" data-placement="right" title="删除一个子选项">删除</button>');
		
		//添加新的元素
		divNode.after('<div class="input-group"><input type="text" class="form-control require" name="'+new_name+'" placeholder="'+new_placeholder+'"/><span class="input-group-btn"><button class="btn btn-info addOption" type="button" data-toggle="tooltip" data-placement="right" title="新建一个子选项">添加</button></span></div>').hide().fadeIn('slow');

		//捕捉焦点
		divNode.next().children('input').focus();
	});

	//动态删除子选择项
	$('#optionTable').delegate('.deleteOption', 'click', function(e){
		var divNode = $(this).parents('div.input-group')
		var tdNode = divNode.parent()
		var nowIndex = tdNode.find('div').index(divNode)
		tdNode.find('div').each(function(index){
			if(index > nowIndex){
				var inputNode = $(this).find('input')
				inputNode.attr('name' ,inputNode.attr('name').slice(0, inputNode.attr('name').indexOf('_'))+'_'+(index)) 
			}
		})
		divNode.remove();
	})

	//动态删除选择项
	$('#optionTable').delegate('.deleteItem', 'click', function(e){
		var trNode = $(this).parents('tr');
		var nowIndex = $('#optionTable tr').index(trNode)
		$('#optionTable tr').each(function(index){
			if(index > nowIndex){
				$(this).find('select').attr('name', 'childType'+(index-2));
				$(this).find('input[name="childTitle'+(index-1)+'"]').attr('name', 'childTitle'+(index-2));
				$(this).find('input[name="childRange'+(index-1)+'"]').attr('name', 'childRange'+(index-2));
				$(this).find('td').last().find('input').each(function(childIndex){
					console.log('test=>'+childIndex+'=>'+index)
					$(this).attr('name', 'childOption'+(index-2)+'_'+(childIndex+1));
				})
			}
		})

		trNode.fadeOut('slow');
		//除去头部th，和隐藏的tr，即减去2
		$('#optionNum').val($('#optionTable tr').length-2);
		console.log('optionNum: '+$('#optionNum').val());
		//隐藏的元素依然会提交所以这里要删除
		trNode.remove()
	})

	//判断是否选择的是文本框
	$(document).delegate('#optionTable select', 'change', function(e){
		var trIndex = $('#optionTable tr').index($(this).parents('tr'))-1;
		// console.log(trIndex);
		var lastTd = $(this).parent().parent().next().next().next();
		console.log($(this).val())
		if($(this).val() == 'textarea' || $(this).val() == 'text' || $(this).val() == 'number'){
			console.log($(this).val())
			lastTd.html('<input type="text" class="form-control" placeholder="不可用" disabled/>');
		}else{
			lastTd.html('<div class="input-group"><input type="text" class="form-control require" placeholder="选项1"  name="childOption'+trIndex+'_1" /><span class="input-group-btn"><button class="btn btn-info addOption" type="button" data-toggle="tooltip" data-placement="right" title="新建一个子选项">添加</button></span></div>');
		}
	})

	//表单提交验证
	$('#voteForm, #voteUpdateForm, #registerForm, #registerUpadteForm').submit(function(e) {
		//如果有数据为空则进行报错提示
		$('.require').each(function() {
			// console.log('test');
			if($(this).val() == ''){
				console.log($(this))
				e.preventDefault();
				$(this).parent().addClass('has-error');
				$(this).focus();
				return false;
			}
		});

	});

	//投票表单提交验证
	$('#submitProForm').submit(function(e){
		$(this).find('.require').each(function(){
			if($(this).find('textarea').length > 0){
				if($(this).find('textarea').val() == ""){
					$(this).parent().addClass('warnning-border');
					e.preventDefault();
					return false;
				}
			}else if($(this).find("input[type='text']").length > 0){
				if($(this).find("input[type='text']").val() == ""){
					$(this).parent().addClass('warnning-border');
					e.preventDefault();
					return false;
				}
			}
			else if($(this).find('.radio').length > 0){
				if($(this).find('input:checked').length ==0){
					$(this).parent().addClass('warnning-border');
					e.preventDefault();
					return false;
				}
			}else if($(this).find('.checkbox').length > 0){
				var bool = false;
				$(this).find('input').each(function(){
					//此处要用prop！！非attr！！
					if($(this).prop('checked')){
						bool = true;
					}
				})
				if(!bool){
					$(this).parent().addClass('warnning-border');
					e.preventDefault();
					return false;
				}
			}
		})
	})

	//清除报错提示
	$('#submitProForm, #submitRegisterForm').delegate('input, textarea', 'keyup click', function(e){
		$('#submitProForm .panel, #submitRegisterForm .panel').removeClass('warnning-border');

	})

	//初始清除所有报错提示
	$(document).delegate('#voteForm input, #voteUpdateForm input, #registerForm input, #registerUpadteForm input','keyup',function(e) {
		$('div .has-error').removeClass('has-error');
	});


	//ajax删除投票
	$(document).delegate('.deleteProLink', 'click', function(e) {
		var proId = $(this).attr('idAttr');
		var trNode = $(this).parent().parent();
		// console.log(voteId);

		//此处要从href属性获取ajax提交的地址，不然直接在js里使用{:U('Vote/delete')}的话会直接转义
		var url = $(this).attr('href');
		$.post(url,
			{pId: proId},
			function(responce){
				console.log(responce);
				if(responce.status == 1){
					trNode.addClass('warnning-border');
					trNode.fadeOut('slow');	
				}else if(responce.status == 0){
					$('#myModal').modal();
				}
			});
		//阻止跳转
		e.preventDefault();
	});

	//判断报名项目是否需要登录,用来隐藏下个选项
	$('#registerForm input[name="loginRequire"], #registerUpdateForm input[name="loginRequire"]').change(function(){
		if($(this).val() == 1){
			$(this).parents('div.form-group').next().fadeIn()
		}else{
			$(this).parents('div.form-group').next().fadeOut()
		}
	})

	//投票结果页文本折叠功能
	$('.clickToggle').click(function(e){
		var divNode = $(this).prev()
		if(divNode.css('display') == 'none'){
			divNode.fadeIn()
			$(this).text('点击收起')
		}else{
			divNode.fadeOut()
			$(this).text('点击展开')
		}
		e.preventDefault();
	})

})

	//初始化flipclock
	function initFlipclock(selector, timeLong){
		var clock = $(selector).FlipClock(timeLong, {
			clockFace: 'DailyCounter',
			countdown: true
		})
	}