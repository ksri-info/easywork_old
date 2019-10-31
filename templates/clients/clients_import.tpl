<div id="import_add_form">
<br />
��� ������� ������������, <a href="/upload/import_clients.csv" class="link">��������� ������ ��������� ����� �������.</a>

<br /><br /><br />
<a href="javascript:;" id="client_imp_upload" class="link">������� ���� ��� �������</a> <span style="color:#666">(������ ����� .csv*)</span>
</div>

<div id="import_preview"></div>


<script>

new AjaxUpload($('#client_imp_upload'), {  
		  		    action: '/ajax/ajaxClients.php?mode=import_clients',  
		  		    name: 'uploadfile',  
		  		    onSubmit: function(file, ext){
						
						if (!(ext && /^(csv|xlsx)$/i.test(ext))){  
							// check for valid file extension  
							alert('������. ����������� ������ ����� Word Excel')
							return false;  
						} 
					},     
		  		    onComplete: function(file, response_data){  
						
						response = response_data;
						
						if(response=='0')
						{
							alert('������. ����������� ������ ����� �������� .csv');
						}
						else if(response=='2')
						{
							alert('��������� ������ ��� �������� �����');
						}
						else
						{ 
							$('#import_add_form').hide();
							$('#import_preview').html(response_data);
							
						}
							
					}
			}); 
			
</script>