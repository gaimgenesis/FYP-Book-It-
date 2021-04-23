$(document).ready(function(){	
    setInterval(function(){
        var quiz_id = $('.createques').attr('id');
        quiz_id = quiz_id.replace(/btn/g, "");
        countQuestions(quiz_id);
	}, 5000);
	$(document).on('click', '.courseid', function(){
		var course_id = $(this).attr('id');
		location.href = "quiz.php";
    });
    $(document).on('click', '.finish', function(){
		location.href = "quiz.php";
	});
    $(document).on('click', '.createquiz', function(){
        var course_id = $(this).attr('id');
        var qname = $('.qnamefield').val();
        if(qname == ""){
            alert("Enter a quiz name.");
        }else{
            createQuiz(course_id, qname);
        }
    });
    var ans = [];
    var corr = [];
    $(document).on('click', '.createques', function(){
        var quiz_id = $(this).attr('id');
        quiz_id = quiz_id.replace(/btn/g, "");
        var qname = $('.questionname').val();
        $(".ans").each(function(){
            var answers = $(this).val();
            ans.push(answers);
        });
        var opt = $('#ansopt').val();
        if(opt == 'a'){
            corr = [1, 0, 0, 0];
        }else if(opt == 'b'){
            corr = [0, 1, 0, 0];
        }else if(opt == 'c'){
            corr = [0, 0, 1, 0];
        }else{
            corr = [0, 0, 0, 1];
        }
        if(ans.length === 0 || qname == ""){
            alert("Please fill in the text fields.");
        }else{
            createQuestion(qname, ans, corr, quiz_id);
        }
        ans.length = 0;
    });
});

function createQuiz(course_id, qname){
    $.ajax({
		url:"quiz_action.php",
		method:"POST",
		data:{course_id:course_id, qname:qname, action:"create_quiz"},
		dataType:"json",
		success:function(response){
            $('.quizidhidden').html(response.quizidhidden);
            alert("Quiz title created");
            var quizid = $(".quizid").val();
            location.href = "createquiz.php?id="+quizid;
        },
        error:function(xhr, status, error){
            alert(xhr.responseText);
        }
	});
}

function createQuestion(qname, ans, corr, quiz_id){
    $.ajax({
		url:"quiz_action.php",
		method:"POST",
		data:{qname:qname, ans:ans, corr:corr, quiz_id:quiz_id, action:"create_question"},
		dataType:"json",
		success:function(response){
            alert('Question created.');
            ans.length = 0;
            $('.questionname').val("");
            $(".ans").each(function(){
                $(this).val("");
            });
        },
        error:function(xhr, status, error){
            alert(xhr.responseText);
        }
	});
}

function countQuestions(quiz_id){
    $.ajax({
		url:"quiz_action.php",
		method:"POST",
		data:{quiz_id:quiz_id, action:"count_question"},
		dataType:"json",
		success:function(response){
            $('#quescount').html(response.quescount);
        },
        error:function(xhr, status, error){
            alert(xhr.responseText);
        }
	});
}