$(function(){
convert()
function convert(){
		dataMap={};
		dataMap['kampus']=$('#listcampus').val();
		dataMap['kelas']=$('#listkelas').val();
		dataMap['medal']=$('#listmedal').val();
		alert(dataMap['kampus']+" "+dataMap['kelas']);
			var h="<table><tr><td>ID</td><td>Name</td><td>Medal</td></tr>";
		$.post('php/convert.php', dataMap, function(data){
			json=$.parseJSON(data);
			$.each(json.data, function(i,item){
				h+="<tr><td>"+item.id+"</td><td>"+item.Name+"</td><td>"+item.award+"</td></tr>";
			})
			h+="</table>";
			$("#report").html(h);
		})
	}

})