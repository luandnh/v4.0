$(document).ready(function () {
  console.log("callreport.js");
  $(document).on('click','#export_callreport_form', function(e){
    e.preventDefault();
    console.log("Oke")
    return;
    console.log(file_name, file_path)
    $.ajax({
      url: "./php/crm/API_removeDownload.php",
      type: "POST",
      data: {
        file_name: file_name,
        file_path: file_path
      },
      success: function(data) {
        if (data == "success"){
          swal({
						title: "Success",
						type: "success",
						confirmButtonColor: "#DD6B55",
						confirmButtonText: "OK",
						closeOnConfirm: false,
					},
					function(isConfirm) {
							window.location.reload();
					})
        }else{
          swal({
						title: "Error",
						text: data,
						type: "error"
					})
        }
      },
      error: function(data) {
        console.log(data);
        swal({
          title: "Error",
          text: "Something wrongs",
          type: "error"
        })
      },
    });
  })
});