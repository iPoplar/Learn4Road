$(function(){

		var timer;
		var arr=new Array()
		arr[0] = ["01","02"];
		arr[1] = ["11","12"];
		arr[2] = ["21","22"];
	
	
	//	方式二 ------注意 7,8,9行的代码，当把setInterval()打开的时候，将这三行代码也去掉注释
		
		function refresh1(){
			 $.getJSON('info.php',{"status":"3"}, function(json){

		 			// console.log(json.id + json.name);	
                      $.each(json, function(index, item){
				 		
				 		var dbId = item.id;
				 		var dbSta = item.status;
				 		var dbName = item.name;				 		
				 		var dbDir = item.direction;
				 		var dbError  = item.error;
				 		
				 		console.log(dbSta+ "和" + dbId + "和" + dbName + "和" + dbDir);
				 		
				 		
				 		console.log(dbError+"@@@@2");
				 		
				 		
				 		changeStatus(dbSta, dbName, dbId, dbDir, dbError);
				 	})
                     
            });
			
		}


		function refresh2(){
			 $.getJSON('info.php',{"status":"6"}, function(json){

		 			$.each(json, function(index, item){
				 		
				 		var dbId = item.id;
				 		var dbSta = item.status;
				 		var dbName = item.name;				 		
				 		var dbDir = item.direction;
				 		var dbError  = item.error;
				 		
				 		console.log(dbSta+ "和" + dbId + "和" + dbName + "和" + dbDir );
				 		
				 		
				 		console.log(dbError+"@@@@2");
				 		
				 		
				 		changeStatus(dbSta, dbName, dbId, dbDir, dbError);
				 	})
                     
            });
			
		}
		
		function refresh3(){
			 $.getJSON('info.php',{"status":"9"}, function(json){
	
                     $.each(json, function(index, item){
				 		
				 		var dbId = item.id;
				 		var dbSta = item.status;
				 		var dbName = item.name;				 		
				 		var dbDir = item.direction;
				 		var dbError  = item.error;
				 		
				 		console.log(dbSta+ "和" + dbId + "和" + dbName + "和" + dbDir);
				 		
				 		console.log(dbError+"@@@@2");
				 		
				 		
				 		changeStatus(dbSta, dbName, dbId, dbDir, dbError);
				 		
				 	})
                     
            });
			
		}

		function refresh4(){
			 $.getJSON('info.php',{"status":"5811"}, function(json){
				 		
				 		var dbId = json.id;
                        var dbSta = json.status;
				 		var dbMessage = json.message;
				 		var dbName = json.name;					 				 		
				 		
				 		console.log(dbSta+ "和" + dbId + "和" + dbMessage);
						 if(dbId=="000000")
						 {
						 	
						 }else{
						 	var str1 = "学生:"+dbName+" 学号:"+dbId;
						 	var str2 = dbMessage;

						 	changePlace(str1, str2);						 	
							notice();							
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
	direction 为 该人所选的方向 1 为 安全组，2 为 web 组， 3 为技术运营组 4 为视觉组
	*/	
		var flag = false;
		var nowClass = null;

		function addData(id, name, status, direc){

			var sta = null;
			var dir = null;


		if( direc == 1) {

			dir = "安全组";
		}else if(direc == 2){

			dir = "web 组";
		}else if(direc == 3){

			dir = "技术运营组 ";
		}else if(direc == 4){

			dir = "视觉组";
		}


		if(status == 3){

			sta = "一面一等待";

			 var $htmlLi = $("<li>"+id+"&nbsp;"+name+"&nbsp;"+dir+"</li>");
			
			var $ul = $('.tab_1 ul');
			$ul.append($htmlLi);
		
		}else if( status == 6){	

			sta = "一面二等待";

			var $htmlLi = $("<li>"+id+"&nbsp;"+name+"&nbsp;"+dir+"</li>");
			var $ul = $('.tab_2 ul');
			$ul.append($htmlLi);
			
		}else if(status == 9){

			sta = "二面等待";

			var $htmlLi = $("<li>"+id+"&nbsp;"+name+"&nbsp;"+dir+"</li>");
			var $ul = $('.tab_3 ul');
			$ul.append($htmlLi);
			
		}
		
	}	
		
		function deleteData(className,id){

			var Id = id;

			$('.'+className +' li').each(function(index) {			
			

			//userId = $(this).text().split(' ')[0];	
			userId = $(this).text().substring(0,8);
			
			if(id == userId){
				$('.'+className +' li').eq(index).remove();			
			}
		  });
		}

		/*
			判断ul中是否存在指定的id
			返回值为 拥有此id的上上级标签的className
		*/
		function hasUser(id){

			flag = false;
			$('#tabBox li').each(function(index) {				

			//userId = $(this).text().split(' ')[0];	
			userId = $(this).text().substring(0,8);

			if(id == userId){
				flag = true;
			//	alert("有此用户的标志为:"+flag);				
				nowClass = $(this).parent().parent().attr("class");
			//	alert("有此用户的状态选卡的Class为:"+nowClass);

				return nowClass;
			}

		});
	}
	
	 function notice(){	 	
	

	 	$(".p1").text(arr[0][0]);
	 	$(".p2").text(arr[0][1]);

	 	$(".p3").text(arr[1][0]);
	 	$(".p4").text(arr[1][1]);

	 	$(".p5").text(arr[1][0]);
	 	$(".p6").text(arr[1][1]);
	 }

	 function changePlace(str1, str2){
	 	arr[2][0] = arr[1][0];
	 	arr[2][1] = arr[1][1];

	 	arr[1][0] = arr[0][0];
	 	arr[1][1] = arr[0][1];

	 	arr[0][0] = str1;
	 	arr[0][1] = str2;

	 }

	 function changeStatus(sta, name, id, direction, dbError){

	 		if( nowClass){
					nowClass=nowClass.split(" ")[0];
			}


	 	if(sta == 3){

	 		
	 		if( dbError != "ok"){
	 			
	 			$(".tab_1 li").not(":first").remove();
	 		}else {
	 			 $('.tab_1 li').each(function(index) {				

					var strId = $(this).text().split(' ')[0];			


					if( id != strId){

						hasUser(id);
					
						if( nowClass){
							nowClass=nowClass.split(" ")[0];
						}
						
						deleteData(nowClass,id);
						addData(id, name, sta, direction);
					}

				});
	 		}

	 		
	 	}else if( sta == 6){
	 			 		
	 		if( dbError == 0){
	 			
	 			$(".tab_2 li").not(":first").remove();
	 		
	 		}else {
	 			 $('.tab_2 li').each(function(index) {				

					var strId = $(this).text().split(' ')[0];			


					if( id != strId){

						hasUser(id);
					
						if( nowClass){
							nowClass=nowClass.split(" ")[0];
						}
						
						deleteData(nowClass,id);
						addData(id, name, sta, direction);
					}

				});
	 		}

	 	}else if( sta == 9){	 		
	 		
	 		if( dbError == 0){

	 			$(".tab_3 li").not(":first").remove();

	 			
	 		}else {
	 			 $('.tab_3 li').each(function(index) {				

					var strId = $(this).text().split(' ')[0];			


					if( id != strId){

						hasUser(id);
					
						if( nowClass){
							nowClass=nowClass.split(" ")[0];
						}
						
						deleteData(nowClass,id);
						addData(id, name, sta, direction);
					}

				});
	 		}

	 	}
	 }



	 function main_1(id, name, status, direction, dataFlag){

	 	/*
	 		得到4中数据, 还有有数据(id, name, status, direction),返回是否成功的标志(dataFlag);
	 	*/

	 	hasUser(id);

	 	if( flag == false && dataFlag){

	 		addData(id, name, sta, direction);	
	 		
	 	}

	 	if( flag && dataFlag){
			 	
			 	deleteData(nowClass,id);

			 	addData(id, name, sta, direction); 
			 	
	 	}

	 }
	 

});
	
	
