$(document).ready(function(){
    $(document).on('click', '.sendmsg', function(event){
		var to_user_id = $(this).attr('id');
		sendMessage(to_user_id);
	});
	$(document).on('click', '.consultbtn', function() {
        var uid = $(this).attr('id');
        window.location = "consultslot.php?id=" + uid; 
    });
});

function sendMessage(to_user_id){
	message = $(".textarea").val();
	$('.textarea').val('');
	if($.trim(message) == ''){
		return false;
	}
	$.ajax({
		url:"sendmessage.php",
		method:"POST",
		data:{to_user_id:to_user_id, chat_message:message, action:'insert_chat'},
		dataType:"json",
		success:function(response){
			window.location.href = "messageroom.php";
		},
		error:function(){
			alert(to_user_id);
		}
	});
}