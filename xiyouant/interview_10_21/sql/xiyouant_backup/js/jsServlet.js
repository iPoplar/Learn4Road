$(function(){

		var timer;
	/*点击登录按钮，执行Ajax 发送和接收数据*/
	$("#login-button").click(function(){
			
			// clearInterval(timer1);
			// clearInterval(timer2);
			// clearInterval(timer3);

			var formInfo = $("form").serializeArray();
			
			$.ajax({		
			 	type:"GET",
			 	async:false,
			 	url:'signin.php',
			 	data:formInfo,
			 	dataType:"jsonp",
			 	jsonp:"callback",
			 	success: function(json){

			 		var id = json.id;
					if(id!="000000")
					{
						var name = json.name;
						var status = json.status;
						var direction = json.direction;
						var judge = json.judge;
						/*
						 alert("大量弹框来袭，不要惊慌，只是测试");
						 alert(json.id + "这是result的属性id"); //回调输出
						 alert(json.name + "这是result的属性name");
						 alert(json.status + "这是result的属性status");
						 alert(json.direction + "这是result的属性direction");
						 */
						alert("签到成功，请等待");

						document.getElementById("id").value = "";
						document.getElementById("userName").value = "";

						dataFlag = true;

						main_1(id, name, status, direction, judge,dataFlag);

					}else{
						var test = json.test;
						alert(test);
					}


			 	},
			 	error:function(){
			 		alert('login fail');
			 	}
			 
			});
		
	});


	//方式一中的 数据包装
	/*
	function callback(result){
				alert("这里是到了回调函数处!");
				console.log(result);
			}

		var sta1 = {"status":"3"};
		var sta2 = {"status":"6"};
		var sta3 = {"status":"9"};

		


		function refresh1(sta1) {
				$.ajax({		
				 	type:"GET",
				 	async:false,
				 	url:'info.php',
				 	data:sta1,
				 	dataType:"jsonp",
				 	jsonp:"callback",
				 	success: function(json){
				 		
				 	alert("这里要进行大数据处理啦！！高能啊！");
				 	$.each(json, function(i, item){



						alert(json[1].name);
				 		var dbId = item.id;
				 		var dbSta = item.status;				 		
				 		changeStatus(dbSta, dbId);
				 	})
		 		},
		 	error:function(){
		 		alert('fail');
	 	}
	 
		});
		    }
		timer1 = setInterval(refresh1, 5000);
		*/

		//这里是对其他的状态的测试

	//	方式二 ------注意 7,8,9行的代码，当把setInterval()打开的时候，将这三行代码也去掉注释
		
		function refresh1(){
			 $.getJSON('info.php',{"status":"3"}, function(json){

		 			// console.log(json.id + json.name);	
                      $.each(json, function(index, item){
				 		
				 		var dbId = item.id;
				 		var dbSta = item.status;
				 		var dbName = item.name;				 		
				 		var dbDir = item.direction;
				 		var dbJu = item.judge;
				 		console.log(dbSta+ "和" + dbId + "和" + dbName + "和" + dbDir + "和" + dbJu);
				 		
				 		changeStatus(dbSta, dbName, dbId, dbDir, dbJu);
				 	})
                     
            });
			
		}


		function refresh2(){
			 $.getJSON('info.php',{"status":"6"}, function(json){

		 			// console.log(json.id + json.name);	
                     $.each(json, function(index, item){
				 		
				 		var dbId = item.id;
				 		var dbSta = item.status;
				 		var dbName = item.name;				 		
				 		var dbDir = item.direction;
				 		var dbJu = item.judge;
				 		console.log(dbSta+ "和" + dbId + "和" + dbName + "和" + dbDir + "和" + dbJu);
				 		
				 		changeStatus(dbSta, dbName, dbId, dbDir, dbJu);
				 	})
                     
            });
			
		}
		
		function refresh3(){
			 $.getJSON('info.php',{"status":"9"}, function(json){

		 			// console.log(json.id + json.name);	
                     $.each(json, function(index, item){
				 		
				 		var dbId = item.id;
				 		var dbSta = item.status;
				 		var dbName = item.name;				 		
				 		var dbDir = item.direction;
				 		var dbJu = item.judge;
				 		console.log(dbSta+ "和" + dbId + "和" + dbName + "和" + dbDir + "和" + dbJu);
				 		
				 		changeStatus(dbSta, dbName, dbId, dbDir, dbJu);
				 	})
                     
            });
			
		}

		function refresh4(){
			 $.getJSON('info.php',{"status":"5811"}, function(json){

		 			// console.log(json.id + json.name);
				 		
				 		var dbId = json.id;
                        var dbSta = json.status;
				 		var dbMessage = json.message;
				 		var dbName = json.name;				 		
				 		
				 		console.log(dbSta+ "和" + dbId + "和" + dbMessage);
						 if(dbId=="000000")
						 {

						 }else{
							 notice("学生:"+dbName+" 学号:"+dbId+""+dbMessage);
						 }
			
		});
	}


		refresh1();
		timer1 = setInterval(refresh1, 5000);
		timer2 = setInterval(refresh2, 5000);
		timer3 = setInterval(refresh3, 5000);
		timer4 = setInterval(refresh4, 5000);
	

	/*
	其中 status 表示其状态， 3 为 一面一等待， 6 为 一面二等待 ， 9 为 二面等待
	direction 为 该人所选的方向 1 为 安全组，2 为 web 组， 3 为技术运营组 
	*/	
		var flag = false;
		var nowClass = null;

		function addData(id, name, status, direc, judge){

			var sta = null;
			var dir = null;


		if( direc == 1) {

			dir = "安全组";
		}else if(direc == 2){

			dir = "web 组";
		}else if(direc == 3){

			dir = "技术运营组 ";
		}


		if(status == 3){

			sta = "一面一等待";

			 var $htmlLi = $("<li>"+id+"--"+name+"--"+dir+"--"+judge+"</li>");
			
			var $ul = $('.tab_1 ul');
			$ul.append($htmlLi);
		//	alert("嘿嘿，你已经被记录在案了！");
		//	notice("一面一等待hO(∩_∩)O哈！");

		}else if( status == 6){	

			sta = "一面二等待";

			 var $htmlLi = $("<li>"+id+"--"+name+"--"+dir+"--"+judge+"</li>");
			var $ul = $('.tab_2 ul');
			$ul.append($htmlLi);
			//alert("嘿嘿，你已经被记录在案了！");
		//	notice("一面二等待hO(∩_∩)O哈！");

		}else if(status == 9){

			sta = "二面等待";

			 var $htmlLi = $("<li>"+id+"--"+name+"--"+dir+"--"+judge+"</li>");
			var $ul = $('.tab_3 ul');
			$ul.append($htmlLi);
			//alert("嘿嘿，你已经被记录在案了！");
		//	notice("二面等待hO(∩_∩)O哈！");
		}

		
	}
	
		// addData("00131034", "pop", 6, 2);


		function deleteData(className,id){

			var Id = id;

			//alert("这是到了删除的操作");
			$('.'+className +' li').each(function(index) {			
			

			userId = $(this).text().split('--')[0];						
			if(id == userId){
				$('.'+className +' li').eq(index).remove();
				//alert("删除~\(≧▽≦)/~啦啦啦!!!!!");
			}
		  });
		}

		// deleteData("tab_1","01131034");

		/*
			判断ul中是否存在指定的id
			返回值为 拥有此id的上上级标签的className
		*/
		function hasUser(id){

			flag = false;
			$('#tabBox li').each(function(index) {				

			userId = $(this).text().split('--')[0];			

			if(id == userId){
				flag = true;
			//	alert("有此用户的标志为:"+flag);				
				nowClass = $(this).parent().parent().attr("class");
			//	alert("有此用户的状态选卡的Class为:"+nowClass);

				return nowClass;
			}

		});
	}

	 //hasUser("09131034");

	 function notice(str){

	 	$(".bottom").text(str);
	 }

	 function changeStatus(sta, name, id, direction, judge){

	 		if( nowClass){
					nowClass=nowClass.split(" ")[0];
					//alert(nowClass+ "!!!!!!!!!!这是处理了的nowClass");
			}

	 	if(sta == 3){

	 		 $('.tab_1 li').each(function(index) {				

			var strId = $(this).text().split('--')[0];			

			// if(id == strId){
			// 	///说明当前的ul的学生的状态没有变
			// 	//不做操作
			// }else{
			// 	//当前的选项卡中没有此学生

			// 	hasUser(id); //为了获取此id的学生跑到那个组中去了的class
			// 	alert(nowClass+ "这是nowClass");

			// 	deleteData(nowClass,id);

			//  	addData(id, name, sta, direction);	
			// }

			if( id != strId){

				hasUser(id);

				//alert(nowClass+ "这是处在changStatus中的，要删除了nowClass");
				if( nowClass){
					nowClass=nowClass.split(" ")[0];
					//alert(nowClass+ "!!!!!!!!!!这是处理了的nowClass");
				}
				
				deleteData(nowClass,id);
				addData(id, name, sta, direction, judge);
			}

		});
	 	}else if( sta == 6){
	 		 $('.tab_2 li').each(function(index) {				

			var strId = $(this).text().split('--')[0];			

			if( id != strId){

				hasUser(id);

				//alert(nowClass+ "这是处在changStatus中的，要删除了nowClass");
				if( nowClass){
					nowClass=nowClass.split(" ")[0];
					//alert(nowClass+ "!!!!!!!!!!这是处理了的nowClass");
				}
				
				deleteData(nowClass,id);
				addData(id, name, sta, direction, judge);
			}

		});


	 	}else if( sta == 9){
	 		 $('.tab_3 li').each(function(index) {				

			var strId = $(this).text().split('--')[0];			

			if( id != strId){

				hasUser(id);

				//alert(nowClass+ "这是处在changStatus中的，要删除了nowClass");
				if( nowClass){
					nowClass=nowClass.split(" ")[0];
					//alert(nowClass+ "!!!!!!!!!!这是处理了的nowClass");
				}
				
				deleteData(nowClass,id);
				addData(id, name, sta, direction, judge);
			}
		});

	 	}
	 }



	 function main_1(id, name, status, direction, judge, dataFlag){

	 	/*
	 		得到4中数据, 还有有数据(id, name, status, direction),返回是否成功的标志(dataFlag);
	 	*/


	 	//hasUser("09131034");		
	 	hasUser(id);

	 	if( flag == false && dataFlag){

	 		addData(id, name, sta, direction, judge);	 		
	 		alert("这厮第一个if");
	 	}

	 	if( flag && dataFlag){
				
			 	//deleteData("tab_1","09131034");
			 	deleteData(nowClass,id);

			 	addData(id, name, sta, direction, judge); 
			 	alert("这厮第2个if");
	 	}

	 }
	 

});
	
	
