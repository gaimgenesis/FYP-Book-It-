$(document).ready(function(){
	setInterval(function(){
		updateUserChat();
	}, 1000);
	$(document).on('click', '.contact', function(){
		$('.contact').removeClass('active');
		$(this).addClass('active');
		var to_user_id = $(this).data('touserid');
		showUserChat(to_user_id);
		$(".message").attr('id', 'message'+to_user_id);
		$(".chatButton").attr('id', 'submitchat'+to_user_id);
	});
	$(document).on('click', '.submitchat', function(event){
		var to_user_id = $(this).attr('id');
		to_user_id = to_user_id.replace(/submitchat/g, "");
		sendMessage(to_user_id);
	});
	$(document).on('click', '.profile', function(){
		var to_user_id = $(".profilelink").attr('id');
		to_user_id = to_user_id.replace(/userid/g, "");
		location.href = "profile.php?id="+to_user_id;
	});
	$(document).on('click', '.gotoprof', function(){
		location.href = "search.php";
	});
});

function sendMessage(to_user_id){
	message = $(".message-input input").val();
	$('.message-input input').val('');
	if($.trim(message) == ''){
		return false;
	}
	$.ajax({
		url:"sendmessage.php",
		method:"POST",
		data:{to_user_id:to_user_id, chat_message:message, action:'insert_chat'},
		dataType:"json",
		success:function(response){
			var resp = $.parseJSON(response);
			$('#conversation').html(resp.conversation);
		},
		error: function(xhr, status, error) {
			alert(xhr.responseText);
		 }
	});
}

function showUserChat(to_user_id){
	$.ajax({
		url:"chat_action.php",
		method:"POST",
		data:{to_user_id:to_user_id, action:'show_chat'},
		dataType: "json",
		success:function(response){
			$('#profile').html(response.profile);
			$('#conversation').html(response.conversation);
		}
	});
}

function updateUserChat(){
	$('li.contact.active').each(function(){
		var to_user_id = $(this).attr('data-touserid');
		$.ajax({
			url:"chat_action.php",
			method:"POST",
			data:{to_user_id:to_user_id, action:'update_chat'},
			dataType: "json",
			success:function(response){
				$('#conversation').html(response.conversation);
			},
			error: function(){
				alert(to_user_id);
			}
		});
	});
}
