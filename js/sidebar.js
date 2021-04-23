var nav = document.getElementById("main");

window.onclick = function(event){
	if (event.target == nav){
		document.getElementById("mySidenav").style.width = "85px";
		document.getElementById("main").style.marginLeft = "85px";
	}
}

function myFunction(x){
	x.classList.toggle("change");
}

function toggle(x){
	if(x.classList.contains('change')){
		document.getElementById("mySidenav").style.width = "250px";
		document.getElementById("main").style.marginLeft = "250px";
	}else{
		document.getElementById("mySidenav").style.width = "85px";
		document.getElementById("main").style.marginLeft = "85px";
	}
}