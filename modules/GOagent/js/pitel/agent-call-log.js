$(document).ready(function () {
  LoadAllowedCampaigns();
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
  $("#daterange-btn-calllogs span").html(
    start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY")
  );
  $("#daterange-value-calllogs").val(
    start.format("YYYY-MM-DD") + " - " + end.format("YYYY-MM-DD")
  );
  $("#agent-call-log").on("click", (e) => {
    e.preventDefault();

    $("#cust_info").hide();
    $("#loaded-contents").show();
    $("#agent_dashboard").hide();
    $("#calllogs-list")
      .removeClass("display")
      .addClass("table table-striped table-bordered");
    $("#contents-calllogs").css("margin", "1em");
    $("#contents-calllogs").show();
    LoadCallLogs();
  });
});

let allowed_campaigns = [];
$("#calllogs-href").click(function (e) {});

function LoadCallLogs() {
  $("#calllogs-list").css("width", "100%");
  const daterange = $("#daterange-value-calllogs").val().split(" - ");
  let campaigns_id = $("#calllogs-select-campaigns").val();
  let param = {
    from_date: `${daterange[0]} 00:00:00`,
    to_date: `${daterange[1]} 23:59:59`,
    campaigns: campaigns_id.join(),
    limit: 999999,
    offset: 0,
  };
  $.ajax({
    type: "GET",
    url:
      CRM_API_URL +
      "/v1/report/agent/call-log/" +
      user_id +
      "?" +
      $.param(param),
    async: true,
    dataType: "json",
    headers: {
      "Content-Type": "application/json",
    },
    success: function (result, status, xhr) {
      $("#calllogs-list").DataTable({
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
              return moment(data).format("DD-MM-YYYY HH:mm:ss");
            },
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
            title: "Mã Yêu cầu",
            data: "request_id",
          },
          {
            title: "Trạng thái hợp đồng",
            data: "app_status",
          },
        ],
      });
    },
    error: function (xhr, status, error) {
      console.log("Get calllogs fail!");
    },
  });
}
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
        AddCampaignOptions(key, value);
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
    },
    error: function (xhr, status, error) {
      console.log("Get allowed campaigns fail!");
    },
  });
};
function AddCampaignOptions(key, value) {
  const options_campaign = $("<option>", {
    value: key,
    text: value,
  });
  $("#calllogs-select-campaigns").append(options_campaign);
}
$("#calllogs-search-btn").on("click", () => {
  LoadCallLogs();
});
