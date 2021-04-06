$(".browse-btn").click(function () {
  $(".file-box").click();
});
$("#uploadleads-href").click(function (e) {
  goGetAllListsOfCampaign();
  $("#uploadleads-modal").modal("show");
});
$(".file-box").change(function () {
  var myFile = $(this).prop("files");
  var Filename = myFile[0].name;

  $(".file-name").val(Filename);
  console.log($(this).val());
});

$(document).ready(function () {
  // RESET LEAD MAPPING CONTAINER ON CLOSE
  $("#LeadMappingContainer").on("hidden.bs.modal", function () {
    $("#LeadMapSubmit").val(0);
    $("#lead_map_data").html("");
    $("#lead_map_fields").html("");
  });
});
let allowed_lists = [];
let goGetAllListsOfCampaign = () => {
  const postData = {
    goAction: "goGetAllLists",
    goUser: uName,
    goPass: uPass,
    log_user: uName,
    responsetype: "json",
    has_login: logging_in,
    campaign_id: campaign_id,
  };
  return $.ajax({
    type: "GET",
    url: "/goAPIv2/goAgentPitel/goAPI.php",
    processData: true,
    data: postData,
    async: true,
    dataType: "json",
    headers: {
      "Content-Type": "application/json",
    },
    success: function (result, status, xhr) {
      allowed_lists = result.data;
      $("#list_id").empty();
      allowed_lists.forEach((element) => {
        opt = $("<option>", {
          value: element.list_id,
          text: element.list_name,
        });
        $("#list_id").append(opt);
      });
    },
    error: function (xhr, status, error) {
      console.log("Get allowed campaigns fail!");
    },
  });
};

// Progress bar function
function goProgressBar() {
  var formData = new FormData($("#upload_form")[0]);
  var progress_bar_id = "#progress-wrp"; //ID of an element for response output
  var percent = 0;

  var result_output = "#output"; //ID of an element for response output
  var my_form_id = "#upload_form"; //ID of an element for response output
  var submit_btn = $(this).find("input[type=button]"); //btnUpload

  formData.append("tax_file", $("input[type=file]")[0].files);

  $.ajax({
    url: "./php/AddLoadLeads.php",
    type: "POST",
    data: formData,
    contentType: false,
    cache: false,
    processData: false,
    maxChunkSize: 1000000000,
    maxRetries: 100000000,
    retryTimeout: 5000000000,
    timeout: 0,
    xhr: function () {
      //upload Progress
      var xhr = $.ajaxSettings.xhr();
      if (xhr.upload) {
        xhr.upload.addEventListener(
          "progress",
          function (event) {
            var position = event.loaded || event.position;
            var total = event.total;
            if (event.lengthComputable) {
              percent = Math.ceil((position / total) * 100);
            }

            //update progressbar
            $(progress_bar_id + " .progress-bar").css("width", +percent + "%");
            $(progress_bar_id + " .status").text(percent + "%");
            //$(progress_bar_id + " .status").innerHTML = percent + '%';

            if (percent === 100) {
              //$('#dStatus').css("display", "block");
              //$('#dStatus').css("color", "#4CAF50");
              //$('#qstatus').text("File Uploaded Successfully. Please wait for the TOTAL of leads uploaded.(Do not refresh the page)");
              //$('#qstatus').text("Data Processing. Please Wait.");
              //sweetAlert("Oops...", "Something went wrong!", "error");

              //var uploadMsgTotal = "Total Leads Uploaded: "+res;

              swal({
                title: "CSV file upload complete.",
                text:
                  "Data Now Processing. Please Wait. DO NOT refresh the page.",
                type: "info",
                showCancelButton: false,
                closeOnConfirm: false,
              });
            }
          },
          true
        );
      }
      return xhr;
    },
    mimeType: "multipart/form-data",
    statusCode: {
      503: function (responseObject, textStatus, errorThrown) {
        //console.log(responseObject, textStatus, errorThrown);
        // Service Unavailable (503)
        // This code will be executed if the server returns a 503 response
        //alert(responseObject + textStatus);
        //$.ajax(this);
        upload_timeout(JSON.stringify(textStatus));
        return;
      },
    },
  }).done(function (res) {
    //console.log(res);
    var data = jQuery.parseJSON(res);
    if (
      $("#LeadMapSubmit").val() === "0" &&
      $("#LeadMapSubmit").is(":checked")
    ) {
      lead_mapping(res);
    } else {
      upload_alert(data.result, data.msg);
    }
  });
} //function end

function upload_alert(res, msg) {
  if (res === "success") var uploadMsgTotal = msg;
  else var uploadMsgTotal = msg;
  swal(
    {
      title: "Data Processing Complete !",
      text: uploadMsgTotal,
      type: res,
    },
    function () {
      getContactList();
      $("#LeadMappingContainer").modal("hide");
    }
  );
}

function upload_timeout(uploadMsg) {
  swal({
    title: "Request Timeout",
    text: uploadMsg,
    type: "error",
  });
}

function lead_mapping(res) {
  var obj = JSON.parse(res);
  var data = obj.data;
  var sf = obj.standard_fields;
  var cf = obj.custom_fields;
  //console.log( obj );
  if (cf[0] !== "") var all = sf.concat(cf);
  else var all = sf;
  var i;
  console.log(cf[0]);
  console.log(all.length);
  for (i = 0; i < all.length; i++) {
    $("#lead_map_data").append(
      '<div class="form-group"><label>' +
        all[i] +
        '</label><span id="span_' +
        all[i] +
        '"></span></span></div>'
    );
    $("<input>")
      .attr({ type: "hidden", name: "map_fields[]", value: all[i] })
      .appendTo("#lead_map_fields");
    var sel = $(
      '<select name="map_data[]" class="form-control select2">'
    ).appendTo("#span_" + all[i]);
    sel.append($("<option>").attr("value", ".").text("NONE"));
    for (x = 0; x < data.length; x++) {
      //if(data[i] === data[x])
      //sel.append($("<option>").attr('value',x).text(data[x]).prop('selected', true));
      //else
      sel.append($("<option>").attr("value", x).text(data[x]));
    }
  }
  $("#LeadMapSubmit").val("1");
  swal.close();
  $("#LeadMappingContainer").modal("show");
}
