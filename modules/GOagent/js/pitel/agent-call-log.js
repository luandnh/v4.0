$(document).ready(function () {
  LoadAllowedCampaigns();
  LoadAllCallStatus();
  const start = moment();
  const end = moment();
  $("#daterange-btn-calllogs").daterangepicker(
    {
      startDate: start,
      endDate: end,
      ranges: {
        Today: [moment(), moment()],
        Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
        "Last 7 Days": [moment().subtract(6, "days"), moment()],
        "Last 30 Days": [moment().subtract(29, "days"), moment()],
        "This Month": [moment().startOf("month"), moment().endOf("month")],
        "Last Month": [
          moment().subtract(1, "month").startOf("month"),
          moment().subtract(1, "month").endOf("month"),
        ],
      },
    },
    (start, end) => {
      $("#daterange-btn-calllogs span").html(
        start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY")
      );
      $("#daterange-value-calllogs").val(
        start.format("YYYY-MM-DD") + " - " + end.format("YYYY-MM-DD")
      );
    }
  );
  // PRODUCTIVITY
  $("#daterange-btn-productivity").daterangepicker(
    {
      startDate: start,
      endDate: end,
      ranges: {
        Today: [moment(), moment()],
        Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
        "Last 7 Days": [moment().subtract(6, "days"), moment()],
        "Last 30 Days": [moment().subtract(29, "days"), moment()],
        "This Month": [moment().startOf("month"), moment().endOf("month")],
        "Last Month": [
          moment().subtract(1, "month").startOf("month"),
          moment().subtract(1, "month").endOf("month"),
        ],
      },
    },
    (start, end) => {
      $("#daterange-btn-productivity span").html(
        start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY")
      );
      $("#daterange-value-productivity").val(
        start.format("YYYY-MM-DD") + " - " + end.format("YYYY-MM-DD")
      );
    }
  );
  // PERFORM
  $("#daterange-btn-performance").daterangepicker(
    {
      startDate: start,
      endDate: end,
      ranges: {
        Today: [moment(), moment()],
        Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
        "Last 7 Days": [moment().subtract(6, "days"), moment()],
        "Last 30 Days": [moment().subtract(29, "days"), moment()],
        "This Month": [moment().startOf("month"), moment().endOf("month")],
        "Last Month": [
          moment().subtract(1, "month").startOf("month"),
          moment().subtract(1, "month").endOf("month"),
        ],
      },
    },
    (start, end) => {
      $("#daterange-btn-performance span").html(
        start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY")
      );
      $("#daterange-value-performance").val(
        start.format("YYYY-MM-DD") + " - " + end.format("YYYY-MM-DD")
      );
    }
  );
  // 
  $("#daterange-btn-calllogs span").html(
    start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY")
  );
  $("#daterange-value-calllogs").val(
    start.format("YYYY-MM-DD") + " - " + end.format("YYYY-MM-DD")
  );
  // PRODUCTIVITY
  $("#daterange-btn-productivity span").html(
    start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY")
  );
  $("#daterange-value-productivity").val(
    start.format("YYYY-MM-DD") + " - " + end.format("YYYY-MM-DD")
  );
  // PERFORM
  $("#daterange-btn-performance span").html(
    start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY")
  );
  $("#daterange-value-performance").val(
    start.format("YYYY-MM-DD") + " - " + end.format("YYYY-MM-DD")
  );
  // 
  $("#agent-call-log").on("click", (e) => {
    e.preventDefault();
    ShowContentModule("calllogs")
    $("#calllogs-list")
      .removeClass("display")
      .addClass("table table-striped table-bordered");
    $("#contents-calllogs").css("margin", "1em");
    $("#contents-calllogs").show();
    LoadCallLogs();
  });

  $("#productivity").on("click", (e) => {
    e.preventDefault();
    ShowContentModule("productivity")
    $("#productivity-list")
      .removeClass("display")
      .addClass("table table-striped table-bordered");
    $("#contents-productivity").css("margin", "1em");
    $("#contents-productivity").show();
    LoadProductivityLogs();
  });
  
  $("#performance").on("click", (e) => {
    e.preventDefault();
    ShowContentModule("performance")
    $("#performance-list")
      .removeClass("display")
      .addClass("table table-striped table-bordered");
    $("#contents-performance").css("margin", "1em");
    $("#contents-performance").show();
    LoadPerformance();
  });
});

let ShowContentModule = (content) => {
  var thisContents = $("#loaded-contents div[id^='contents-']");
  $.each(thisContents, function () {
    var contentID = $(this).prop('id').replace('contents-', '');
    if (contentID == content) {
      $(this).show();
    } else {
      $(this).hide();
    }
  });
  $("#cust_info").hide();
  $("#loaded-contents").show();
  $("#agent_dashboard").hide();
}

let allowed_campaigns = [];
$("#calllogs-href").click(function (e) { });

function LoadCallLogs() {
  $("#calllogs-list").css("width", "100%");
  const daterange = $("#daterange-value-calllogs").val().split(" - ");
  let param = {
    from_date: `${daterange[0]} 00:00:00`,
    to_date: `${daterange[1]} 23:59:59`,
    campaign: $("#calllogs-select-campaigns").val(),
    status: $("#calllogs-select-status").val(),
    partner_code: $("#calllogs-input-partner-code").val(),
    limit: 999999,
    offset: 0,
  };

  console.log($.param(param, true))
  $.ajax({
    type: "GET",
    url:
      CRM_API_URL +
      "/v1/report/agent/call-log/" +
      user_id +
      "?" +
      $.param(param, true),
    async: true,
    dataType: "json",
    headers: {
      "Content-Type": "application/json",
    },
    success: function (result, status, xhr) {
      $("#calllogs-list").DataTable({
        responsive: true,
        info: false,
        destroy: true,
        paging: true,
        ordering: true,
        lengthChange: false,
        data: result.data,
        columns: [
          {
            title: "Ngày gọi",
            data: "call_date",
            render: (data) => {
              return moment(data).subtract(7, "h").format("DD-MM-YYYY HH:mm:ss");
            },
          },
          {
            title: "Partner Code",
            data: "partner_code"
          },
          {
            title: "Lead Code",
            data: "vendor_lead_code"
          },
          {
            title: "Khách hàng",
            data: {
              last_name: "last_name",
              middle_initial: "middle_initial",
              first_name: "first_name",
            },
            render: function (data) {
              return (
                data.last_name +
                " " +
                data.middle_initial +
                " " +
                data.first_name
              );
            },
          },
          {
            title: "Số điện thoại",
            data: "phone_number",
          },
          {
            title: "Trạng thái",
            data: "status_name",
          },
          {
            title: "Thời lượng cuộc gọi",
            data: "call_duration",
          },
          {
            title: "Mã hợp đồng",
            data: "contract_number",
          },
          {
            title: "Mã Yêu cầu",
            data: "request_id",
          },
          {
            title: "Trạng thái hợp đồng",
            data: "app_status",
          },
          {
            title: "#",
            data: {
              lead_id: "lead_id",
              phone_number: "phone_number",
              phone_code: "phone_code",
            },
            render: (data) => {
              return '<button id="lead-info-' + data.lead_id + '" data-leadid="' + data.lead_id + '" onclick="ViewCustInfo(' + data.lead_id + ');" class="btn btn-info btn-sm" style="margin: 2px;" title=""><i class="fa fa-file-text-o"></i></button>' +
                '<button id="dial-lead-' + data.lead_id + '" data-leadid="' + data.lead_id + '" onclick="ManualDialNext(\'\',' + data.lead_id + ',' + data.phone_code + ',' + data.phone_number + ',\'\',\'0\');" class="btn btn-primary btn-sm" style="margin: 2px;" title="Click to dial"><i class="fa fa-phone"></i></button>'
            }
          }
        ],
      });
    },
    error: function (xhr, status, error) {
      console.log("Get calllogs fail!");
    },
  });
}

function LoadProductivityLogs() {
  $("#productivity-list").css("width", "100%");
  const daterange = $("#daterange-value-productivity").val().split(" - ");
  let param = {
    from_date: `${daterange[0]} 00:00:00`,
    to_date: `${daterange[1]} 23:59:59`,
    user: user,
    campaign: $("#productivity-select-campaigns").val(),
    limit: 999999,
    offset: 0,
  };
  console.log($.param(param, true))
  $.ajax({
    type: "GET",
    url:
      CRM_API_URL +
      "/v1/report/agent/productivity" + "?" +
      $.param(param, true),
    async: true,
    dataType: "json",
    headers: {
      "Content-Type": "application/json",
    },
    success: function (result, status, xhr) {
      $("#productivity-list").DataTable({
        responsive: true,
        info: false,
        destroy: true,
        paging: true,
        ordering: true,
        lengthChange: false,
        data: result.data,
        columns: [
          {
            title: "Team",
            data: "user_group"
          },
          {
            title: "USER",
            data: "user"
          },
          {
            title: "Customer",
            data: "total_talk",
            render(data) {
              return converter(data);
            }
          },
          {
            title: "Total call",
            data: "total_call",
          },
          {
            title: "Answer",
            data: "answer",
          },
          {
            title: "No answer",
            data: "noanswer",
          },
          {
            title: "Busy",
            data: "busy",
          },
          {
            title: "Cancel",
            data: "cancel",
          },
          {
            title: "Denied",
            data: "denied",
          },
          {
            title: "Sip_erro",
            data: "sip_erro",
          },
          {
            title: "Unknown",
            data: "unknown",
          }
        ],
      });
    },
    error: function (xhr, status, error) {
      console.log("Get calllogs fail!");
    },
  });
}
let converter = (time) => {
  if (time == "" || time == "0" || time == 0) {
    return "00:00:00";
  }
  try {

    let date = new Date(0);
    date.setSeconds(time);
    var timeString = date.toISOString().substr(11, 8);
    return timeString;
  } catch (error) {
    return "00:00:00";
  }
}
function LoadPerformance() {
  $("#performance-list").css("width", "100%");
  const daterange = $("#daterange-value-performance").val().split(" - ");
  let param = {
    from_date: `${daterange[0]} 00:00:00`,
    to_date: `${daterange[1]} 23:59:59`,
    user: user,
    campaign: $("#performance-select-campaigns").val(),
    limit: 999999,
    offset: 0,
  };
  console.log($.param(param, true))
  $.ajax({
    type: "GET",
    url:
      CRM_API_URL +
      "/v1/report/agent/performance" + "?" +
      $.param(param, true),
    async: true,
    dataType: "json",
    headers: {
      "Content-Type": "application/json",
    },
    success: function (result, status, xhr) {
      let performance = [];
      $("#performance-list").DataTable({
        responsive: true,
        info: false,
        destroy: true,
        paging: true,
        ordering: true,
        lengthChange: false,
        data: result.data,
        columns: [
          {
            title: "Ngày tạo",
            data: "entry_date",
            render: (data) => {
              return moment(data).subtract(7, "h").format("DD-MM-YYYY HH:mm:ss");
            },
          }, {
            title: "Người tạo",
            data: "user"
          }, {
            title: "Partner Code",
            data: "partner_code"
          }, {
            title: "SDT",
            data: "phone_number"
          }, {
            title: "Tên khách hàng",
            data: "customername"
          }, {
            title: "Request ID",
            data: "request_id"
          }, {
            title: "Trạng thái hợp đồng",
            data: "app_status"
          }, {
            title: "Mã hợp đồng",
            data: "contract_number"
          }, {
            title: "#",
            data: {
              lead_id: "lead_id",
              phone_number: "phone_number",
              phone_code: "phone_code",
            },
            render: (data) => {
              return '<button id="lead-info-' + data.lead_id + '" data-leadid="' + data.lead_id + '" onclick="ViewCustInfo(' + data.lead_id + ');" class="btn btn-info btn-sm" style="margin: 2px;" title=""><i class="fa fa-file-text-o"></i></button>' +
                '<button id="dial-lead-' + data.lead_id + '" data-leadid="' + data.lead_id + '" onclick="ManualDialNext(\'\',' + data.lead_id + ',' + data.phone_code + ',' + data.phone_number + ',\'\',\'0\');" class="btn btn-primary btn-sm" style="margin: 2px;" title="Click to dial"><i class="fa fa-phone"></i></button>'
            }
          }
          // lead_id	entry_date	modify_date	user	list_id	phone_number	first_name	middle_initial	last_name	partner_code	sale_code	app_status	reject_reason	request_id	proposal_id	phone_code alt_phone	last_local_call_time
        ],
      });
    },
    error: function (xhr, status, error) {
      console.log("Get calllogs fail!");
    },
  });
}
// 
$("#calllogs-search-btn").on("click", () => {
  LoadCallLogs();
});

$("#productivity-search-btn").on("click", () => {
  LoadProductivityLogs();
});

$("#performance-search-btn").on("click", () => {
  LoadPerformance();
});
LoadAllCallStatus = () => {
  return $.ajax({
    type: "GET",
    url: CRM_API_URL +
      "/v1/status",
    async: true,
    dataType: "json",
    headers: {
      "Content-Type": "application/json",
    },
    success: function (result, status, xhr) {
      statuses = result.data;
      statuses.forEach(status => {
        let opt = $("<option>", {
          value: status.status,
          text: status.status_name,
        });
        $("#calllogs-select-status").append(opt);
      });
      $("#calllogs-select-status").multiselect({
        buttonWidth: "100%",
        maxHeight: 450,
        includeSelectAllOption: false,
        buttonClass: "btn btn-light",
        templates: {
          li: '<li><a href="javascript:void(0);"><label class="pl-2"></label></a></li>',
        },
        selectedClass: "btn-light",
      });
    },
    error: function (xhr, status, error) {
      console.log("Get allowed campaigns fail!");
    },
  });
};
LoadAllowedCampaigns = () => {
  const postData = {
    goAction: "goGetAllowedCampaigns",
    goUser: uName,
    goPass: uPass,
    has_location: true,
    responsetype: "json",
  };
  return $.ajax({
    type: "GET",
    url: "/goAPIv2/goAgent/goAPI.php",
    processData: true,
    data: postData,
    async: true,
    dataType: "json",
    headers: {
      "Content-Type": "application/json",
    },
    success: function (result, status, xhr) {
      allowed_campaigns = result.data.allowed_campaigns;
      for (const [key, value] of Object.entries(
        result.data.allowed_campaigns
      )) {
        const options_campaign = $("<option>", {
          value: key,
          text: value,
        });
        $("#calllogs-select-campaigns").append(options_campaign);
        $("#productivity-select-campaigns").append(options_campaign);
        $("#performance-select-campaigns").append(options_campaign);
      }
      $("#calllogs-select-campaigns").multiselect({
        buttonWidth: "100%",
        maxHeight: 450,
        includeSelectAllOption: false,
        buttonClass: "btn btn-light",
        templates: {
          li: '<li><a href="javascript:void(0);"><label class="pl-2"></label></a></li>',
        },
        selectedClass: "btn-light",
      });
      $("#productivity-select-campaigns").multiselect({
        buttonWidth: "100%",
        maxHeight: 450,
        includeSelectAllOption: false,
        buttonClass: "btn btn-light",
        templates: {
          li: '<li><a href="javascript:void(0);"><label class="pl-2"></label></a></li>',
        },
        selectedClass: "btn-light",
      });
      $("#performance-select-campaigns").multiselect({
        buttonWidth: "100%",
        maxHeight: 450,
        includeSelectAllOption: false,
        buttonClass: "btn btn-light",
        templates: {
          li: '<li><a href="javascript:void(0);"><label class="pl-2"></label></a></li>',
        },
        selectedClass: "btn-light",
      });
    },
    error: function (xhr, status, error) {
      console.log("Get allowed campaigns fail!");
    },
  });
};