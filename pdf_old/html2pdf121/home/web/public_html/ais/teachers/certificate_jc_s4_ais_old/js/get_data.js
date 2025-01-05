$(function(){
	date();
/*	function date()
	{	
	dataMap={};
	dataMap['kampus']=$('#campus').val();
	$.post('php/get_graduation_date.php', dataMap, function(graduate){
		json=$.parseJSON(graduate);
		var h='<select id="list_graduation_date">';
		h+='<option id="g_0" roomid="0" level_id="0" value="" selected >Please choose date!</option>';
		$.each(json.graduate, function(i, item){
		h+='<option id="d_'+item.id+'" value="'+item.graduation_date+'">'+item.graduation_date+'</option>';
			})
			$('#graduation_date').html(h);
	})
	
	}*/
	function date(idcam)
	{	
	dataMap={};
	dataMap['kampus']=$('#campus').val();
	dataMap['level_id']=$('#level_id').val();
	$.post('php/get_graduation_date.php', dataMap, function(graduate){
		json=$.parseJSON(graduate);
		var h='<select id="list_graduation_date">';
		if (json.graduate==0){
			h+='<option id="g_0" roomid="0" level_id="0" value="" selected >No Record, Please add data graduation date!</option>';
		}
		else if(json!=null){
			h+='<option id="g_0" roomid="0" level_id="0" value="" selected >Please choose date!</option>';
			$.each(json.graduate, function(i, item){
			h+='<option id="d_'+item.id+'" value="'+item.graduation_date+'">'+item.graduation_date+'</option>';
				})
		}
			$('#graduation_date').html(h);
	})
	
	}
	
	function convert(){
	//	alert($('#kelas').val())
		dataMap={};
		dataMap['kampus']=$('#campus').val();
		dataMap['kelas']=$('#kelas').val();
		dataMap['date']=$('#list_graduation_date').val();
		dataMap['room_id']=$('#room_id').val();
		dataMap['level_id']=$('#level_id').val();
		//alert(dataMap['room_id']);
		//alert(dataMap['level_id']);
	//	var kampus=dataMap['kampus']
		
		window.open("php/report.php?kampus="+dataMap['kampus']+"&classroom_id="+dataMap['kelas']+"&level_id="+dataMap['level_id']+"&room_id="+dataMap['room_id']+"&date="+dataMap['date']);
		//+"&kelas="+dataMap['kelas']"&medal="+dataMap['medal']"method=GET");
		//alert(dataMap['kampus']+" "+dataMap['kelas']);
			//var h="<table><tr><td>ID</td><td>Name</td><td>Medal</td></tr>";
		//$.post('php/convert.php', dataMap, function(data){
			//window.location.replace("php/test.php");
			//json=$.parseJSON(data);
			//$.each(json.data, function(i,item){
				//h+="<tr><td>"+item.id+"</td><td>"+item.Name+"</td><td>"+item.award+"</td></tr>";
			//})
			//h+="</table>";
			//$("#report").html(h);
		//})
		}

		function convert_ecert(){
	//	alert($('#kelas').val())
		dataMap={};
		dataMap['kampus']=$('#campus').val();
		dataMap['kelas']=$('#kelas').val();
		dataMap['date']=$('#list_graduation_date').val();
		dataMap['room_id']=$('#room_id').val();
		dataMap['level_id']=$('#level_id').val();
		//alert(dataMap['room_id']);
		//alert(dataMap['level_id']);
	//	var kampus=dataMap['kampus']
		
		window.open("php/report_background.php?kampus="+dataMap['kampus']+"&classroom_id="+dataMap['kelas']+"&level_id="+dataMap['level_id']+"&room_id="+dataMap['room_id']+"&date="+dataMap['date']);
		//+"&kelas="+dataMap['kelas']"&medal="+dataMap['medal']"method=GET");
		//alert(dataMap['kampus']+" "+dataMap['kelas']);
			//var h="<table><tr><td>ID</td><td>Name</td><td>Medal</td></tr>";
		//$.post('php/convert.php', dataMap, function(data){
			//window.location.replace("php/test.php");
			//json=$.parseJSON(data);
			//$.each(json.data, function(i,item){
				//h+="<tr><td>"+item.id+"</td><td>"+item.Name+"</td><td>"+item.award+"</td></tr>";
			//})
			//h+="</table>";
			//$("#report").html(h);
		//})
		}
	
	
	
$(document).on('change','[id^="listcampus"]',function(e){
	e.stopPropagation();
	//alert($('#listcampus').val());
	kelas($('#listcampus').val());
	})
$(document).on('click','[id="generate"]',function(e){
convert();

//$(document).on('change','[id^="listkelas"]',function(e){
	//e.stopPropagation();
	//dataMap={};
	//subject();
	//medal();
	//})
	
})

$(document).on('click','[id="generate_ecert"]',function(e){
convert_ecert();

//$(document).on('change','[id^="listkelas"]',function(e){
	//e.stopPropagation();
	//dataMap={};
	//subject();
	//medal();
	//})
	
})
})