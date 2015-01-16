$( function(ready) {
 	var input = document.getElementById("file-input"), formdata = false;

 	if (window.FormData) {
 		formdata = new FormData();
 	//	document.getElementById("btn").style.display = "none";
 	}

	if (input.addEventListener) {
 		input.addEventListener("change", function (evt) {
			var img, reader, file;

		 	file = this.files[0];
	
		 	if (!!file.type.match(/image.*/)) {
	
		 	} 
			if ( window.FileReader ) {
				reader = new FileReader();
				reader.onloadend = function (e) { 
					showUploadedItem(e.target.result);
				};
				reader.readAsDataURL(file);
			}
	if (formdata) {
		formdata.append("file[]", file);
	}
		
			if (formdata) {
				$.ajax({
					url: "upload.php",
					type: "POST",
					data: formdata,
					processData: false,
					contentType: false,
					success: function (res) {
			//			document.getElementById("response").innerHTML = res; 
						alert(res);
					}
				});
			}

	 	}, false);
 	}

  	$('.counter2').jOdometer({increment: 9, counterStart:'00000', counterEnd:99999, numbersImage: 'images/jodometer-numbers.png', delayTime: 10, speed: 250, spaceNumbers: 2});
	
	$("#Start").click(function(){
		$.ajax({
			url: "compare.php",
			success: function (res) {
				alert(res);
				$('.counter2').hide();
        		$('.counter3').jOdometer({increment: 9, counterStart:'000', counterEnd:res, numbersImage: 'images/jodometer-numbers2.png', delayTime: 10, speed: 250, spaceNumbers: 2, widthNumber: 24, heightNumber: 53});
			}
		});
			$("#glass").animate({
				width: "70%",
				left: "20%",
				top: "10%"
			});
		
	});
});


function userSubmit(event){
	event.stopPropagation();
	event.preventDefault();
	var content = $('#file-input').file;
	var request = $.ajax({
		url: "upload.php",
		type: "POST",
		data: content
//		{	
//			id: id,
//			passwd: passwd,
//			passwd2: passwd2,
//			name: name
//		}
	});

	request.success(function( result ){
		if(result=="yes")
			location.href="user.php";
		else
			alert(result);
	});
		
//	request.fail(function( jqXHR, textStatus){
//		alert("無法更新: "+textStatus);
////		alert("無法更新: "+jqXHR.responseText);
//	});
}

 function showUploadedItem (source) {
 //	var list = document.getElementById("image-list"),
 //	li   = document.createElement("li"),
 //	img  = document.createElement("img");
 //	img.src = source;
 //	li.appendChild(img);
 //	list.appendChild(li);
 	$('#file-img').attr("src",source);
 }

