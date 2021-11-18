function filterchange() {
  $("#table").empty();
  $(".report-loader").fadeIn("slow");
  let URL = "./php/crm/viewDownloadList.php";
  $.ajax({
    url: URL,
    type: "POST",
    success: function (data) {
      if (data !== "") {
        $(".report-loader").fadeOut("slow");
        $("#table").html(data);
        $("#list_download_table").DataTable({
          destroy: true,
          responsive: true,
          stateSave: true,
          drawCallback: function (settings) {
            var pagination = $(this)
              .closest(".dataTables_wrapper")
              .find(".dataTables_paginate");
            pagination.toggle(this.api().page.info().pages > 1);
          }
        });
      }
      $(".report-loader").fadeOut("slow");
    },
  });
}
$(document).ready(function () {
  console.log("download.js");
  filterchange();
  $(document).on('click','a[tag="remove-list"]', function(){
    let file_name = $(this).attr('file-name');
    let file_path =  $(this).attr('file-path');
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