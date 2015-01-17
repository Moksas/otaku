$(document).ready( function() {
  /* login */
  $('#Loginbutton').click(function(){
 	 $('#loginform').modal({
 	         fadeDuration: 250,
 	   	      fadeDelay: 1.5
 	 });
	 return false;
  });
  $('#note').click(function(){
	 $('#loginform').animate({
		 height: 500
	 }, 500);
	 $('#formHide').show();
	 $('#note').hide();
	 $('#LoginB').val("Register");
  });
  $("#LoginLogin").on('submit', userSubmit);
  /* user */
  $("#imgfile").on('change', userUpload);
});

function loginOpen(){
  $('#loginform').height(170);
  $('#formHide').hide();
  $('#note').show();
  $('#LoginB').val("Login");
}

function userSubmit(event){
	event.stopPropagation();
	event.preventDefault();

	var id=$("#text").val();
	var passwd=$("#password").val();
	var name=null;
	var passwd2=null;
	if( !$('#note').is(":visible") ){
		var ans = confirm("Are you sure to register?");
		if(!ans){
			loginOpen(); 
			return;
		}
		/* register */
		name=$("#name").val();
		passwd2=$("#password2").val();
	}

	var request = $.ajax({
		url: "login.php",
		type: "POST",
		data: 
		{	
			id: id,
			passwd: passwd,
			passwd2: passwd2,
			name: name
		}
	});
		
	request.success(function( result ){
		if(result=="yes"){
	//		location.href="user.php";
			alert("Login succeed!!");
			location.replace("./");
		}
		else
			alert(result);
	});
		
	request.fail(function( jqXHR, textStatus){
		alert("無法更新: "+textStatus);
//		alert("無法更新: "+jqXHR.responseText);
	});
}

/* user */

function userUpload(event){
	alert("change");
	var files = $("#imgfile").val();
	if(files.type.match('image.*')) alert("fine");
	else alert("wrong");
/*	var request = $.ajax({
		url: "upload.php",
		type: "POST",
		data: {imgfile: files},
		cache: false,
	//	dataType: 'json',
		processData: false,
		contentType: false,
//		success: function(data, textStatus, jqXHR)
//		{
//		if(typeof data.error === 'undefined')
//		{
//		// Success so call function to process the form
//		submitForm(event, data);
//		}
//		else
//		{
//		// Handle errors here
//		console.log('ERRORS: ' + data.error);
//		}
//		},
//error: function(jqXHR, textStatus, errorThrown)
//	   {
//		   // Handle errors here
//		   console.log('ERRORS: ' + textStatus);
//		   // STOP LOADING SPINNER
//	   }
	});
		
	request.success(function( result ){
		if(result.search("error")==-1)
			location.href=result;
		else
			alert(result);
	});
		
	request.fail(function( jqXHR, textStatus){
		alert("無法更新: "+textStatus);
//		alert("無法更新: "+jqXHR.responseText);
	});
*/
}


