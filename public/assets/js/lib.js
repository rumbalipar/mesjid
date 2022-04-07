function openWindow(url,name,w,h){
	var left = (screen.width / 2) - (w / 2);
	var top = (screen.height / 2) - (h / 2);
	return window.open(url,name,"top="+top+", left="+left+",height="+h+",width="+w+",scrollbars=yes,resizable=yes,location=no,menubar=no,toolbar=no,directories=no");
}

function goTo(){
	var link = $("#go").val();
	if(link == ""){
		alert("Nothing select");
	}else{
		window.location.href = link;
	}
	return false;
}

function isNumberKey(evt)
	       {
	          var charCode = (evt.which) ? evt.which : evt.keyCode;
	          if (charCode != 46 && charCode > 31 
	            && (charCode < 48 || charCode > 57))
	             return false;

	          return true;
	       }

function readURL(input,img) {
	if (input.files && input.files[0]) {
	  var reader = new FileReader();
	  
	  reader.onload = function(e) {
		$('#'+img).attr('src', e.target.result);
	  }
	  
	  reader.readAsDataURL(input.files[0]); // convert to base64 string
	}
  }

function openModal(title,src){
	$("#modal-title").html(title);
	$("#modal-action").modal('show');
	$("#modal-body").attr({
		src : src
	});
	return false;
}

function alertWithRefresh(text){
	swal({
		title: "Success",
		text: text,
		icon: "success",
		buttons: 'Ok!',
		dangerMode: false,
	}).then(() => window.location.href = window.location.href );
}

function confirmDelete(form){
	swal({
		title: "Apa anda yakin mau menghapus data ini ?",
		text: "Data yang sudah terhapus tidak dapat di kembalikan lagi",
		icon: "warning",
		buttons: [
			'Tidak, batalkan!',
			'Ya, Saya Yakin!'
		],
		dangerMode: true,
	}).then(function(isConfirm){
		if(isConfirm){
			form.submit();
		}
	});
}

function validateImageUpload(fileName)
{   
    var allowed_extensions = new Array("jpg","JPG","png","jpeg","jfif","PNG","gif","GIF","JPEG","JFIF");
    var file_extension = $("#"+fileName).val().split('.').pop();
    // split function will split the filename by dot(.), and pop function will pop the last element from the array which will give you the extension as well. If there will be no extension then it will return the filename.
    var cek = false;
    for(var i = 0; i <= allowed_extensions.length; i++)
    {
        if(allowed_extensions[i]==file_extension)
        {	
           cek = true;
           break;
        }
    }
    if(cek == false){
    	alert('Type File harus gambar');
		$("#"+fileName).val('');
		return false;
    }

    return false;
    
}