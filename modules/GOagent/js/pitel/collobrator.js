function filterchange() {
  $("#table").empty();
  $(".report-loader").fadeIn("slow");
  let URL = "./php/reports/collobrator.php";
  $.ajax({
    url: URL,
    type: "POST",
    data: {
      fromDate: $("#start_filterdate").val(),
      toDate: $("#end_filterdate").val(),
    },
    success: function (data) {
      if (data !== "") {
        $(".report-loader").fadeOut("slow");
        $("#table").html(data);
        var title = "VTA_Collabrator_";
        let end_date = new Date($("#end_filterdate").val());
        let enddate_string = moment(end_date).format("DD-MM-YYYY");
        title += enddate_string;
        $("#collabrator_table").DataTable({
          destroy: true,
          responsive: true,
          stateSave: true,
          drawCallback: function (settings) {
            var pagination = $(this)
              .closest(".dataTables_wrapper")
              .find(".dataTables_paginate");
            pagination.toggle(this.api().page.info().pages > 1);
          },
          dom: "Bfrtip",
          buttons: [
            {
              extend: "copy",
              title: title,
            },
            {
              extend: "csv",
              title: title,
            },
            {
              extend: "excel",
              title: title,
            },
            {
              extend: "print",
              title: title,
            },
          ],
        });
      }
      $(".report-loader").fadeOut("slow");
    },
  });
}
$(document).ready(function () {
  $.fn.select2.defaults.set("theme", "bootstrap");
  $("#datetimepicker1").datetimepicker({
    icons: {
      //time: 'fa fa-clock-o',
      date: "fa fa-calendar",
      up: "fa fa-chevron-up",
      down: "fa fa-chevron-down",
      previous: "fa fa-chevron-left",
      next: "fa fa-chevron-right",
      today: "fa fa-crosshairs",
      clear: "fa fa-trash",
    },
    //format: 'MM/DD/YYYY'
  });
  $("#datetimepicker2").datetimepicker({
    icons: {
      //time: 'fa fa-clock-o',
      date: "fa fa-calendar",
      up: "fa fa-chevron-up",
      down: "fa fa-chevron-down",
      previous: "fa fa-chevron-left",
      next: "fa fa-chevron-right",
      today: "fa fa-crosshairs",
      clear: "fa fa-trash",
    },
    //format: 'MM/DD/YYYY',
    useCurrent: false,
  });
  filterchange();
  $("#btn_filter").on("click", function () {
    filterchange();
  });
});
