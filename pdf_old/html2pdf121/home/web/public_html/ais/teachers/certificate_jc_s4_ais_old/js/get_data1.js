$(function()
{
subject();
medal();

function subject(){
		dataMap={};
		dataMap['kelas']=$('#listkelas').val();
		dataMap['camp']=$('#listcampus').val();
		dataMap['year']=16;
		$.post('php/get_subject.php', dataMap, function(data){
			var h='<select id="listsubject">';
			json=$.parseJSON(data);
			$.each(json.data, function(i, item){
				h+='<option id="s_'+item.id+'" value="'+item.id+'">'+item.Subject_Name+'</option>'; 
			})
			$('#subject').html(h);
		})
	}
	
	function convert(){
		dataMap={};
		dataMap['kampus']=$('#listcampus').val();
		dataMap['kelas']=$('#listkelas').val();
		dataMap['medal']=$('#listmedal').val();
		dataMap['subject']=$('#listsubject').val();
	//	var kampus=dataMap['kampus']
		window.open("php/report.php?kampus="+dataMap['kampus']+"&ruang="+dataMap['kelas']+"&medal="+dataMap['medal']+"&subject="+dataMap['subject']);
	}

	
	
$(document).on('click','[id^="generate"]',function(e){
	convert();
	})
	
})