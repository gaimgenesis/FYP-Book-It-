$(document).ready(function(){	
    var score = parseInt($('.next').attr('id'), 10);
	$(document).on('click', '.courseid', function(){
		var course_id = $(this).attr('id');
		location.href = "coursequiz.php?id="+course_id;
	});
    $(document).on('click', '.quizmgmt', function(){
		var quiz_id = $(this).attr('id');
		location.href = "scorequiz.php?id="+quiz_id;
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
    $(document).on('click', '.play', function(){
		var quiz_id = $(this).attr('id');
		location.href = "playquiz.php?id="+quiz_id;
    });
    $(document).on('click', '.back', function(){
		location.href = "quiz.php";
    });
    $(document).on('click', '.ansli', function(){
        var corr = $(this).attr('id');
        if(corr == "0"){
            $(this).addClass('wrong');
            document.getElementsByClassName('wrong')[0].style.backgroundColor = "red";
        }else{
            ++score;
        }
        document.getElementById('1').style.backgroundColor = "green";
        $('.ansli').addClass('disabled');
        document.getElementsByClassName('next')[0].style.display = "block";
    });
    $(document).on('click', '.next', function(){
        var nextbtn = document.getElementsByClassName('next')[0];
        nextbtn.style.display = "none";
        var question_id = $('.questionid').attr('id');
        var limitone = parseInt($('.limitone').text(), 10);
        ++limitone;
        var limittwo = parseInt($('.limittwo').text(), 10);
        ++limittwo;
        showNext(question_id, limitone, limittwo, score);
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

function showNext(question_id, limitone, limittwo, score){
    $.ajax({
        url:"quiz_action.php",
        method:"POST",
        data:{question_id:question_id, limitone: limitone, limittwo: limittwo, score:score, action:"show_next"},
        dataType:"json",
        success:function(response){
            $('.quiznext').empty();
            $('.quiznext').html(response.quiznext);
        },
        error:function(xhr, status, error){
            alert(limitone);
            alert(limittwo);
            alert(score);
            alert(xhr.responseText);
        }
    })
}