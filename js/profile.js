$(document).ready(function(){
    $('.search-box input[type="text"]').on("keyup input", function(){
        /* Get input value on change */
        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings(".result");
        if(inputVal.length){
            $.get("backend/search.php", {term: inputVal}).done(function(data){
                // Display the returned data in browser
                resultDropdown.html(data);
            });
        } else{
            resultDropdown.empty();
            getUsers();
        }
    });
    $(document).on('click', '.box', function() {
      window.location = $(this).find("a").attr("href"); 
      return false;
    });
    $(document).on('click', '.chgpass', function() {
        var cpass = $('.cpass').val();    
        var npass = $('.npass').val();  
        if($.trim(cpass) == ''){
            alert('Do not leave it blank');
        }else{
            if($.trim(npass) == ''){
                alert('Do not leave it blank');
            }else{
                chgPass(cpass, npass);
            }
        }
      });
    $(document).on('click', '.addutoc', function() {
        var userid = $('#selUser').val();    
        var cid = $('#selCourse').val();    
        if(userid == "0" || cid == "0"){
            alert('Do not leave it blank');
        }else{
            addUtoC(userid, cid);
        }
    });
    $(document).on('click', '.addcourse', function() {
        var cname = $('#coursename').val();  
        if($.trim(cname) == ''){
            alert('Do not leave it blank');
        }else{
            addCourse(cname);
        }
    });
    $(document).on('click', '.addu', function() {
        var username = $('#username').val();    
        var role = $('#opt').val();
        var position = $('#pos').val();    
        if($.trim(username) == '' || $.trim(role) == '' || $.trim(position) == ''){
            alert('Do not leave it blank');
        }else{
            addUser(username, role, position);
        }
    });
});

function getUsers(){
    $.ajax({
        url:"profilesearch.php",
        method:"POST",
        data:{action:'show_users'},
        dataType: "json",
        success:function(response){
            $('.result').html(response.result);
        }, 
        error: function(xhr, status, error) {
            alert(xhr.responseText);
         }
    });
}

function addUtoC(userid, cid){
    $.ajax({
        url:"profilesearch.php",
        method:"POST",
        data:{userid:userid, cid:cid, action:'add_usertocourse'},
        dataType: "json",
        success:function(response){
            alert('Added successfully!');
        }, 
        error: function(xhr, status, error) {
            alert('Data has been tampered. Contact system engineers immediately.');
         }
    });
}

function addCourse(cname){
    $.ajax({
        url:"profilesearch.php",
        method:"POST",
        data:{cname:cname, action:'add_course'},
        dataType: "json",
        success:function(response){
            alert('Added successfully!');
            location.href = "addusers.php";
        }, 
        error: function(xhr, status, error) {
            alert(xhr.responseText);
         }
    });
}

function addUser(username, role, position){
    $.ajax({
        url:"profilesearch.php",
        method:"POST",
        data:{username:username, role:role, position:position, action:'add_user'},
        dataType: "json",
        success:function(response){
            alert('Added successfully!');
            location.href = "addusers.php";
        }, 
        error: function(xhr, status, error) {
            alert(xhr.responseText);
         }
    });
}

function chgPass(cpass, npass){
    $.ajax({
        url:"profilesearch.php",
        method:"POST",
        data:{cpass:cpass, npass:npass, action:'chg_password'},
        dataType: "json",
        success:function(response){
            alert('Password changed successfully!');
            location.href = "uprofile.php";
        }, 
        error: function(xhr, status, error) {
            alert('Password is not correct.');
         }
    });
}