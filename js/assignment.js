$(document).ready(function(){
	$(document).on('click', '.courseid', function(event){
		var cid = $(this).attr('id');
		location.href = "dropoff.php?id=" + cid;
	});
	$(document).on('click', '.dlbtn', function(){
		var file_id = $(this).attr('id');
		window.open("downloadassignment.php?file_id=" + file_id);
	});
	$(document).on('click', '.checkgradings', function(){
		location.href = "grading.php";
	});
	$(document).on('click', '.grademarks', function(){
		location.href = "grading.php";
	});
	$(document).on('click', '.coursemarks', function(){
		var courseid = $(this).attr('id');
		openDropoff(courseid);
	});
	$(document).on('click', '.return', function(){
		getGrades();
	});
	$(document).on('click', '.seegrades', function(){
		var dropoffid = $(this).attr('id');
		getFeedback(dropoffid);
	});
	$(document).on('click', '.createdrop', function(){
		var cid = $(this).attr('id');
		var name = $('#assignname').val();
		var date = $('#deadline').val();
		if(name.length === 0 ){
			alert('Type in the dropoff name');
		}else{
			if (!Date.parse(date)) {
				alert('Select a date');
			} else {
				createDrop(date, cid, name);
			}
		}
	});
	$(document).on('click', '.gradebtn', function(){
		var comments = $('#comments').val();
		var drop = $('.dropoff').text();
		var marks = $('#marks').val();
		var uid = $(this).attr('id');
		if(comments == '' ){
			alert('Leave a comment');
		}else{
			if (marks == '') {
				alert('Input a mark');
			} else {
				var courseid = $('.courseid').attr('id');
				insertGrading(comments, marks, courseid, uid, drop);
				location.href = "submissions.php?id=" + drop;
			}
		}
	});
	$(document).on('click', '.expired', function(event){
		var dropoffid = $(this).attr('id');
		location.href = "submissions.php?id=" + dropoffid;
	});
	$(document).on('click', '.submitli', function(event){
		var submissid = $(this).attr('id');
		location.href = "grading.php?id=" + submissid;
	});
});

function createDrop(date, cid, name){
	$.ajax({
		url:"material_action.php",
		method:"POST",
		data:{date:date, cid:cid, name:name, action:'create_dropoff'},
		dataType: "json",
		success:function(response){
            alert('Dropoff point created successfully!');
			('.dropofflist').html(response.dropofflist);
		},
		error: function(xhr, status, error) {
			alert(xhr.responseText);
			alert(date);
		 }
	});
}

function insertGrading(comments, marks, courseid, uid, drop){
	$.ajax({
		url:"material_action.php",
		method:"POST",
		data:{comments:comments, marks:marks, courseid:courseid, uid:uid, drop:drop, action:'insert_grading'},
		dataType: "json",
		success:function(response){
            alert('Grading inserted');
		},
		error: function(xhr, status, error) {
			alert(xhr.responseText);
		 }
	});
}

function openDropoff(courseid){
	$.ajax({
		url:"material_action.php",
		method:"POST",
		data:{courseid:courseid, action:'open_dropoff'},
		dataType: "json",
		success:function(response){
			$('.checkgrade').html(response.checkgrade);
		},
		error: function(xhr, status, error) {
			alert(xhr.responseText);
			alert(courseid);
		 }
	});
}

function getGrades(){
	$.ajax({
		url:"material_action.php",
		method:"POST",
		data:{action:'get_grades'},
		dataType: "json",
		success:function(response){
			$('.checkgrade').html(response.checkgrade);
		},
		error: function(xhr, status, error) {
			alert(xhr.responseText);
		 }
	});
}

function getFeedback(dropoffid){
	$.ajax({
		url:"material_action.php",
		method:"POST",
		data:{dropoffid:dropoffid, action:'get_feedback'},
		dataType: "json",
		success:function(response){
			$('.gradedisp').html(response.gradedisp);
		},
		error: function(xhr, status, error) {
			alert(xhr.responseText);
		 }
	});
}