$(document).ready(function(){
	setInterval(function(){
		updateCheck();
		updateList();
	}, 5000);
	$(document).on('click', '.day', function(event){
		$('.day').removeClass('active');
		$(this).addClass('active');
	});
	$(document).on('click', '.report', function(event){
		location.href = "consultreport.php";
	});
	$(".delete").click(function(){
		var session_id = $(this).attr('id');
		deleteSession(session_id);
		var modal = document.getElementById("myModal");
		modal.style.display = "none";
	});
	var date = [];
	$(".valid").click(function(){
		if($('.day').hasClass('active')){
			$(".dateid").each(function(){
				var val = $(this).text();
				date.push(val);
			});
			var time = $(".timepicker").val();
			if(time == ""){
				alert("Please select the timeslot.");
			}else{
				var date1 = new Date('01/01/1970 ' + time);
				var date2 = new Date(date1);
				date2.setHours(date2.getHours()+1);
				var start = date1.toTimeString();
				var end = date2.toTimeString();
				start = start.split(' ')[0];
				end = end.split(' ')[0];
				MakeConsult(date, start, end);
				date=[];
		}
		}else{
			alert("Select a day.");
		}
	});	
});

function updateCheck(){	
	var day = $('.day.active').attr('id');	
	var check = $('#check').val();
		if($('#check').prop('checked') == true){
			var weekly = "true";
		}else{
			var weekly = "false";
		}
	$.ajax({
		url:"consultation_action.php",
		method:"POST",
		data:{day:day, weekly:weekly, action:"update_weekly"},
		dataType:"json",
		success:function(response){
			$('#weekly').html(response.weekly);
		}
	});
}

function updateList(){
	var opt = $('#opt').val();
	$.ajax({
		url:"consultation_action.php",
		method:"POST",
		data:{opt:opt, action:'update_list'},
		dataType: "json",
		success:function(response){
			$('#consultlist').html(response.consultlist);
		},
		error:function(){
			alert(opt);
		}
	});
}

function MakeConsult(date, start, end){
	$.ajax({
		url:"insert_consult.php",
		method:"POST",
		data:{date:date, start:start, end:end, action:"make_consultation"},
		dataType:"json",
		success:function(response){
			$('#consultlist').html(response.consultlist);
			alert('Session created successfully');
			date.length = 0;
		}
	});
}

function deleteSession(session_id){
	var opt = $('#opt').val();
	$.ajax({
		url:"insert_consult.php",
		method:"POST",
		data:{opt:opt, session_id:session_id, action:"delete_consultation"},
		dataType:"json",
		success:function(response){
			$('#consultlist').html(response.consultlist);
			alert('Session deleted successfully.');
		},
		error:function(){
			alert('Session deleted successfully.');
		}
	});
}