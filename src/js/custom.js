$(document).ready(function() {
    $("#add").show(200);

    $("#btn-add").click(function(){
	$("#add").show(200);
	$("#mod").hide(200);
	$("#del").hide(200);
	$("input[name*='pwd'").val("");
    });
    $("#btn-mod").click(function(){
	$("#add").hide(200);
	$("#mod").show(200);
	$("#del").hide(200);
	$("input[name*='pwd'").val("");
    });
    $("#btn-del").click(function(){
	$("#add").hide(200);
	$("#mod").hide(200);
	$("#del").show(200);
	$("input[name*='pwd'").val("");
    });
 
    $("#notif").fadeOut(2000);

});
   
