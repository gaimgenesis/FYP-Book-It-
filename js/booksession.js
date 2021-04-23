$(document).ready(function(){
	$(document).on('click', '.book', function(event){
		var sess_id = $('.conlist').attr('id');
		bookSession(sess_id);
	});
	$(document).on('click', '.nosessbtn', function(event){
		location.href = "search.php";
	});
	$(document).on('click', '.cancelsess', function(event){
		var reason = $('.reasoning').val();
		var sess_id = $(this).attr('id');
		if(reason == ""){
            alert("Enter a reasoning.");
        }else{
            cancelSess(reason, sess_id);
        }
	});	
});

function bookSession(sess_id){
	$.ajax({
		url:"consultation_action.php",
		method:"POST",
		data:{sess_id:sess_id, action:'book_session'},
		dataType: "json",
		success:function(response){
            alert('Session booked successfully!');
            location.href = "consultlist.php";
		},
		error: function(xhr, status, error) {
			alert('Session booked successfully!');
			location.href = "consultlist.php";
		 }
	});
}

function cancelSess(reason, sess_id){
	$.ajax({
		url:"consultation_action.php",
		method:"POST",
		data:{reason:reason, sess_id:sess_id, action:'cancel_session'},
		dataType: "json",
		success:function(response){
            alert('Session cancel successfully!');
            location.href = "consultlist.php";
		},
		error: function(xhr, status, error) {
			alert('Session cancel successfully!');
			location.href = "consultlist.php";
		 }
	});
}
