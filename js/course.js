$(document).ready(function(){	
	$(document).on('click', '.courseid', function(){
		var course_id = $(this).attr('id');
		location.href = "coursemat.php?id="+course_id;
	});
	$(document).on('click', '.delete', function(){
		var mat_id = $(this).attr('id');
		deleteMat(mat_id);
		var modal = document.getElementById("matmodal");
		modal.style.display = "none";	
		var course_id = $(".courseid").val();
		updateLectureList(course_id);
		updateLabList(course_id);	
	});
	$(document).on('click', '.download', function(){
		var mat_id = $(this).attr('id');
		window.open("download.php?file_id=" + mat_id);
	});
	$(document).on('click', '.stdmat', function(){
		var mat_id = $(this).attr('id');
		window.open("download.php?file_id=" + mat_id);
	});
});

function deleteMat(mat_id){
	$.ajax({
		url:"material_action.php",
		method:"POST",
		data:{mat_id:mat_id, action:"delete_material"},
		dataType:"json",
		success:function(response){
			alert('Material deleted successfully');
		},
		error: function() {
			alert('Material deleted successfully');
		 }
	});
}

function updateLectureList(course_id){
	$.ajax({
		url:"material_action.php",
		method:"POST",
		data:{course_id:course_id, action:'update_lecturelist'},
		dataType: "json",
		success:function(response){
			$('#lecturemat').html(response.lecturemat);
		},
		error: function(xhr, status, error) {
			alert(xhr.responseText);
		 }
	});
}

function updateLabList(course_id){
	$.ajax({
		url:"material_action.php",
		method:"POST",
		data:{course_id:course_id, action:'update_lablist'},
		dataType: "json",
		success:function(response){
			$('#labmat').html(response.labmat);
		},
		error: function(xhr, status, error) {
			alert(xhr.responseText);
		 }
	});
}