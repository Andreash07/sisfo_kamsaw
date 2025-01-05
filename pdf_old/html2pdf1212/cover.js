$(function(){
	CKEDITOR.replace( 'editor1' );
$('#getcode').click(function(){
	
	
	var editor_data = CKEDITOR.instances.editor1.getData();
	svelist_id = $('#svelist_id').val();
	sname = $('#subjectname').val();
		$('#code').text(editor_data);
			dataMap2 = {};
			dataMap2['table_name'] = 'sve_list';
			dataMap2['primary_key'] = 'id';
			dataMap2['primary_key_value'] = svelist_id;
			dataMap2['field_to_update'] = 'cover_page';
			dataMap2['new_value'] = editor_data;
			$.post('services/sv_uni_update.php', dataMap2, function(data2){
				alert('Changes Saved!');
				//alert(sname);
				if(sname=="Manda")
				{
					
					//alert('cover_c')
					para = {};
					para['htmlcode'] = editor_data;
					para['svelist_id'] = svelist_id;
					$.post('html2pdf/examples/cover_c.php', para, function(data){
						
						alert('PDF Done!');
							location.href='html2pdf/examples/cover_page/cover_'+svelist_id+'.pdf';
						
						
					})
				}
				else if(sname=="Chine")
				{
					//alert(sname)
					//alert('cover_chine')
					para = {};
					para['htmlcode'] = editor_data;
					para['svelist_id'] = svelist_id;
					$.post('html2pdf/examples/cover_chine.php', para, function(data){
						alert('PDF Done!');
							location.href='html2pdf/examples/cover_page/cover_'+svelist_id+'.pdf';
						
						
					})
					
				}else	
				{
					
					//alert(sname)
					para = {};
					para['htmlcode'] = editor_data;
					para['svelist_id'] = svelist_id;
					$.post('html2pdf/examples/cover.php', para, function(data){
						alert('PDF Done!');
							location.href='html2pdf/examples/cover_page/cover_'+svelist_id+'.pdf';
						
						
					})
				}	
			})
		
		
		
})

})