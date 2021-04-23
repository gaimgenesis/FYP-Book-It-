$(document).ready(function(){
	$(document).on('click', '.reportsess', function(){
		var session_id = $(this).attr('id');
        reportSess(session_id);
	});
});

function reportSess(session_id){
	$.ajax({
		url:"consultation_action.php",
		method:"POST",
		data:{session_id:session_id, action:"report_session"},
		dataType:"json",
		success:function(response){
			alert('Session reported');
            location.href = "consultations.php";
		},
		error:function(xhr){
			alert('Session reported');
            location.href = "consultations.php";
		}
	});
}