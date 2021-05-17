var list_doc_collecting = [];
var is_upload_img_selfie = false;
var is_upload_id_card = false;
var selected_product = null;
var selected_employment_type = null;
const EC_API_USERNAME = "";
const EC_PROD_API_URL =
  "https://apipreprod.easycredit.vn/api/loanServices/v1/product-list";
const formatter = new Intl.NumberFormat("vi-VN", {
  style: "currency",
  currency: "VND",
});
const EC_API_PASSWORD = "";
const EC_API_TOKEN = "";
var selected_offer_id = "";
var selected_offer_amount = 0;
var selected_offer_insurance_type = "";
var selected_offer_tenor = 0;
var selected_monthly_installment = 0;
var selected_max_financed_amount = 0;
var selected_min_financed_amount = 0;
var percent_insurance = 0;
var offerinsurancetable;
var insurance_amount = 0;
let box_color = [
  "box-primary",
  "box-danger",
  "box-success",
  "box-warning",
  "box box-info",
  "box box-default",
];

let removeElement = (btn_id) => {
  if ($("#" + btn_id) != null && $("#" + btn_id).length) {
    let elem = document.getElementById(btn_id);
    elem.parentElement.removeChild(elem);
  }
};

(function ($) {
  $.fn.serializeFormJSON = function () {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function () {
      if (o[this.name]) {
        if (!o[this.name].push) {
          o[this.name] = [o[this.name]];
        }
        o[this.name].push(this.value || "");
      } else {
        o[this.name] = this.value || "";
      }
    });
    return o;
  };
})(jQuery);

$(document).ready(() => {
  $(document).on("click", "#submit_attachment", function (e) {
    e.preventDefault();
    const multiple_files = $(".MultiFile-applied.MultiFile");
    if (multiple_files.length == 0) {
      alert("No file to upload");
      return;
    }
    var request_id = $("#request_id").val();
    var phone_number = $("#phone_number").val();
    var attachments = multiple_files[0].MultiFile.files;
    list_doc_collecting = [];
    attachments.forEach(function (file) {
      var file_type = $(`select[name='${file.lastModified}']`).val();
      var identity_number = $("#identity_number").val();
      var formData = new FormData();
      formData.append("request_id", request_id);
      formData.append("phone_number", "0" + phone_number);
      formData.append("identity_number", identity_number);
      formData.append("file_type", file_type);
      formData.append("file", file);
      var upload_status = true;
      var settings = {
        url: "https://ec02-api.tel4vn.com/v1/document/upload",
        method: "POST",
        timeout: 0,
        processData: false,
        mimeType: "multipart/form-data",
        contentType: false,
        data: formData,
      };
      $.ajax(settings)
        .fail((result, status, error) => {
          console.log(result);
          let msg = "Please contact developer!";
          if (result.message !== undefined) {
            msg = result.message;
          }
          swal("Upload file fail!", msg, "error");
        })
        .success((result, status, error) => {
          let resp = JSON.parse(result);
          if (resp.status == "success") {
            var doc = { file_type: resp.file_type, file_name: resp.file_name };
            list_doc_collecting.push(doc);
            swal(
              "Upload file success!",
              "Upload attachment success",
              "success"
            );
          }
        });
    });
  });

  // Upload img_selfie
  $(document).on("click", "#submit_img_selfie", function (e) {
    e.preventDefault();
    const files = $("#img_selfie")[0].files;
    if (files.length == 0) {
      alert("No img_selfie file to upload");
      return;
    }
    var request_id = $("#request_id").val();
    var phone_number = $("#phone_number").val();
    var identity_number = $("#identity_number").val();
    var formData = new FormData();
    formData.append("request_id", request_id);
    formData.append("file_type", "PIC");
    formData.append("phone_number", "0" + phone_number);
    formData.append("file", files[0]);
    formData.append("identity_number", identity_number);
    var settings = {
      url: "https://ec02-api.tel4vn.com/v1/document/upload",
      method: "POST",
      timeout: 0,
      processData: false,
      mimeType: "multipart/form-data",
      contentType: false,
      data: formData,
    };
    $.ajax(settings)
      .fail((result, status, error) => {
        console.log(result);
        let msg = "Please contact developer!";
        if (result.message !== undefined) {
          msg = result.message;
        }
        swal("Upload file fail!", msg, "error");
      })
      .success((result, status, error) => {
        let resp = JSON.parse(result);
        if (resp.status == "success") {
          $("input[name='img_selfie']")[0].value = resp.file_name;
          swal("OK!", "Upload Image Selfie Success", "success");
          console.log(resp);
        }
      });
  });
  // Upload img_id_card
  $(document).on("click", "#submit_img_id_card", function (e) {
    e.preventDefault();
    const files = $("#img_id_card")[0].files;
    if (files.length == 0) {
      alert("No img_id_card file to upload");
      return;
    }
    var request_id = $("#request_id").val();
    var phone_number = $("#phone_number").val();
    var identity_number = $("#identity_number").val();
    var formData = new FormData();
    formData.append("request_id", request_id);
    formData.append("file_type", "PID");
    formData.append("phone_number", "0" + phone_number);
    formData.append("file", files[0]);
    formData.append("identity_number", identity_number);
    var settings = {
      url: "https://ec02-api.tel4vn.com/v1/document/upload",
      method: "POST",
      timeout: 0,
      processData: false,
      mimeType: "multipart/form-data",
      contentType: false,
      data: formData,
    };
    $.ajax(settings)
      .fail((result, status, error) => {
        console.log(result);
        let msg = "Please contact developer!";
        if (result.message !== undefined) {
          msg = result.message;
        }
        swal("Upload file fail!", msg, "error");
      })
      .success((result, status, error) => {
        let resp = JSON.parse(result);
        if (resp.status == "success") {
          $("input[name='img_id_card']")[0].value = resp.file_name;
          swal("OK!", "Upload Image ID Card Success", "success");
        }
      });
  });
  let fullLoanTab =
    '<li role="presentation" id="full_loan_tab_href" ondblclick="auto_fill()">' +
    '<a href="#full-loan" aria-controls="home" role="tab" data-toggle="tab" class="bb0">' +
    '<span class="fa fa-file-text-o hidden"></span>' +
    "Full Loan</a>" +
    "</li>";
  $("#agent_tablist").append(fullLoanTab);
  clearForm($("#full-loan-form"));
});

let ECShowProducts = (partner_code, request_id) => {
  $("#hide_div_eligible").hide();
  $("#create-offer-table").empty();
  $("#create-offer-table").attr("hidden", true);
  $("#offer-datatable").empty();
  removeElement("submit_fullloan_btn");
  removeElement("product_tab_href");
  $("#offer-datatable")[0].innerHTML = `
	<div class="col-xl-12 col-lg-8">
	    <table id="offer-list-table" class="display responsive no-wrap table table-responsive table-striped table-bordered" width="100%">
	    </table>
	</div>
	<div class="col-xl-12 col-lg-4">
	    <table id="offer-insurance-list-table" class="display responsive no-wrap table table-responsive table-striped table-bordered" width="100%">
	    </table>
	</div>
`;
  clearForm($("#full-loan-form"));
  if (request_id != "" && request_id.length > 0) {
    SyncFullLoanFromAPI(request_id);
  } else {
    request_id = partner_code + Date.now().toString();
    $(".formMain input[name='request_id']").val(request_id);
  }
  if (partner_code != "" && partner_code.length > 0) {
    let productTab =
      '<li role="presentation" id="product_tab_href">' +
      '<a href="#products" aria-controls="home" role="tab" data-toggle="tab" class="bb0">' +
      '<span class="fa fa-file-text-o hidden"></span>' +
      "Products</a>" +
      "</li>";
    $("#agent_tablist").append(productTab);
    $("#accordion").empty();
    $("#hide_div_eligible").show();
    ajaxGetECProducts(partner_code, request_id).done((result) => {
      if (result.code == "SUCCESS") {
        ECProducts = result.data;
        let color_index = 0;
        let index = 1;
        ECProducts.forEach((product) => {
          let productBox = $("<div></div>", {
            class: "panel box " + box_color[color_index],
          });
          let productBoxHeader =
            '<div class="box-header with-border">' +
            '<h4 class="box-title">' +
            '<a data-toggle="collapse" data-parent="#accordion" href="#collapse' +
            index +
            '">' +
            product.employee_type +
            " - " +
            product.employee_description_en;
          "</a>" + "</h4>" + "</div>";
          productBox.append(productBoxHeader);
          tmp_in = index === 1 ? "in" : "";
          let productBoxBody =
            '<div id="collapse' +
            index +
            `" class="panel-collapse collapse ${tmp_in}">` +
            '<div class="box-body">' +
            "<table id=productTable" +
            index +
            ' class="display responsive no-wrap table table-responsive table-striped table-bordered" width="100%">' +
            "</table>" +
            "</div>" +
            "</div>";
          productBox.append(productBoxBody);

          $("#accordion").append(productBox);
          console.log(product.product_list);
          let table = $("#productTable" + index).DataTable({
            destroy: true,
            responsive: true,
            data: product.product_list,
            columns: [
              {
                title: "Product Code",
                data: "product_code",
              },
              {
                title: "Min loan term",
                data: "loan_min_tenor",
              },
              {
                title: "Max loan term",
                data: "loan_max_tenor",
              },
              {
                title: "Min loan amount",
                data: "loan_min_amount",
                render: (data) => {
                  result =
                    data != null
                      ? data.toLocaleString("vi-VN", {
                          style: "currency",
                          currency: "VND",
                        })
                      : 0;
                  return result;
                },
              },
              {
                title: "Max loan amount",
                data: "loan_max_amount",
                render: (data) => {
                  result =
                    data != null
                      ? data.toLocaleString("vi-VN", {
                          style: "currency",
                          currency: "VND",
                        })
                      : 0;
                  return result;
                },
              },
              {
                title: "Interest Rate",
                data: "interest_rate",
              },
              {
                title: "Action",
                render: () => {
                  return '<button class="btn btn-sm btn-success btn-product-view"><i class="fa fa-fw fa-eye"></i></button>';
                },
              },
            ],
          });
          $("#productTable" + index + " tbody").on(
            "click",
            "tr .btn-product-view",
            function () {
              clearForm($("#product-detail-form"));
              $("#product-detail-form-bundle").empty();
              let tmp_data = table.row($(this).closest("tr")).data();
              let table_index = 0;
              for (const property in tmp_data) {
                if (!Array.isArray(tmp_data[property])) {
                  let value = tmp_data[property];
                  if (property.includes("amount")) {
                    value =
                      value != null
                        ? value.toLocaleString("vi-VN", {
                            style: "currency",
                            currency: "VND",
                          })
                        : 0;
                  }
                  $("#product-detail-form input[name='" + property + "']").val(
                    value
                  );
                  $(
                    "#product-detail-form textarea[name='" + property + "']"
                  ).val(value);
                } else {
                  tmp_data[property].forEach((elem) => {
                    table_index++;
                    let bundle_div =
                      `<div class="row" id="product-detail-form-bundle-${table_index}">` +
                      '<div class="col-xs-6">' +
                      '<div class="mda-form-group label-floating">' +
                      `<label for="bundle_name">Bundle Name</label>` +
                      `<input name="bundle_name" type="text" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" readonly value="">` +
                      "</div></div>" +
                      '<div class="col-xs-3">' +
                      '<div class="mda-form-group label-floating">' +
                      `<label for="bundle_code">Bundle Code</label>` +
                      `<input name="bundle_code" type="text" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" readonly value="">` +
                      "</div></div>" +
                      '<div class="col-xs-3">' +
                      '<div class="mda-form-group label-floating">' +
                      `<label for="min_request">Min Request</label>` +
                      `<input name="min_request" type="text" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" readonly value="">` +
                      "</div></div>" +
                      "</div>";
                    $("#product-detail-form-bundle").append(bundle_div);
                    for (const prop in elem) {
                      if (!Array.isArray(elem[prop])) {
                        let value = elem[prop];
                        $(
                          "#product-detail-form-bundle-" +
                            table_index +
                            " input[name='" +
                            prop +
                            "']"
                        ).val(value);
                      } else {
                        let tmp_table =
                          `<table id="tableProductDetail${table_index}" class="display responsive no-wrap table table-responsive table-striped table-bordered" width="100%">` +
                          "</table>";
                        $("#product-detail-form-bundle-" + table_index).append(
                          tmp_table
                        );
                        let table = $(
                          "#tableProductDetail" + table_index
                        ).DataTable({
                          destroy: true,
                          responsive: true,
                          searching: false,
                          lengthChange: false,
                          data: elem[prop],
                          columns: [
                            {
                              title: "Doc EN",
                              data: "doc_description_en",
                            },
                            {
                              title: "Doc VI",
                              data: "doc_description_vi",
                            },
                            {
                              title: "Format",
                              data: "doc_format_request",
                            },
                            {
                              title: "Type",
                              data: "doc_type",
                            },
                          ],
                        });
                      }
                    }
                  });
                }
                console.log(`${property}: ${tmp_data[property]}`);
              }
              $("#product-detail-modal").modal("show");
              // TEL4VN TEST
              sync_from_product();
            }
          );
          color_index++;
          index++;
          if (color_index >= box_color.length) {
            color_index = 0;
          }
        });
      }
    });
  }
  return request_id;
};
let ECProducts = null;

let ajaxGetECProducts = (partner_code, request_id) => {
  return $.ajax({
    url: "https://ec02-api.tel4vn.com/ec/api/loanServices/v1/product-list",
    method: "POST",
    timeout: 0,
    headers: {
      Authorization: "Bearer 98530a76-4198-4b60-a99a-0489e2dd4b4f",
      "Content-Type": "application/json",
    },
    data: JSON.stringify({
      request_id: request_id,
      channel: "DSA",
      partner_code: partner_code,
      product_line: "BUSINESS",
    }),
  }).fail((result, status, error) => {
    console.log(result);
    let msg = "Please contact developer!";
    if (result.message !== undefined) {
      msg = result.message;
    }
    swal("Get products data fail!", msg, "error");
  });
};
$(document).on("click", "#submit-offer", function (e) {
  e.preventDefault();
  let loan_request_id = $(".formMain input[name='request_id']").val();
  let partner_code = $(".formMain input[name='partner_code']").val();
  if (
    selected_offer_insurance_type == undefined ||
    selected_offer_insurance_type == ""
  ) {
    swal("Choose offer fail!", "Please Choose Insurace Type", "error");
    return;
  }
  let offer_data = {
    request_id: loan_request_id,
    partner_code: partner_code,
    selected_offer_id: selected_offer_id,
    selected_offer_amount: selected_offer_amount.toString(),
    selected_offer_insurance_type: selected_offer_insurance_type,
  };

  $.ajax({
    type: "POST",
    url: "https://ec02-api.tel4vn.com/ec/api/loanRequestServices/v1/dsa/select-offer",
    processData: true,
    data: JSON.stringify(offer_data),
    async: true,
    dataType: "json",
    headers: {
      Authorization: "Bearer 98530a76-4198-4b60-a99a-0489e2dd4b4f",
      "Content-Type": "application/json",
    },
  })
    .fail((result, status, error) => {
      console.log(result);
      let msg = "Please contact developer!";
      msg = result.responseJSON.message;
      if (result.message !== undefined) {
        msg = result.message;
      }
      swal("Send offer data fail!", msg, "error");
    })
    .done((result) => {
      console.log(result);
      if (result.code == "RECEIVED") {
        swal("Success", result.message, "success");
      } else {
        swal("Error!", result.message, "error");
      }
    });
});
$("#eligible_btn").on("click", (e) => {
  e.preventDefault();
  let partner_code = $(".formMain input[name='partner_code']").val();
  if (partner_code.length < 1) {
    swal("Error!", "Partner Code is empty!", "error");
  } else {
    let request_id = $(".formMain input[name='request_id']").val();
    if (request_id == "") {
      request_id = partner_code + Date.now().toString();
    }
    let first_name = $(".formMain input[name='first_name']").val();
    let middle_initial = $(".formMain input[name='middle_initial']").val();
    let last_name = $(".formMain input[name='last_name']").val();
    let customer_name = last_name + " " + middle_initial + " " + first_name;
    let phone_number =
      $(".formMain input[name='phone_code']").val() +
      $(".formMain input[name='phone_number']").val();
    let date_of_birth = $(".formMain input[name='date_of_birth']").val();
    let issue_date = $(".formMain input[name='identity_issued_on']").val();
    let tem_province = $(".formMain input[name='province']").val();
    let job_type = $(".formMain input[name='job_type']").val();
    date_of_birth = moment(date_of_birth, "YYYY-MM-DD").format("DD-MM-YYYY");
    issue_date = moment(issue_date, "YYYY-MM-DD").format("DD-MM-YYYY");
    let eligible_data = {
      lead_id: "" + lead_id,
      request_id: request_id,
      channel: "DSA",
      partner_code: partner_code,
      dsa_agent_code: "DSAMKK1233",
      identity_card_id: $(".formMain input[name='identity_number']").val(),
      date_of_birth: date_of_birth,
      customer_name: customer_name,
      issue_date: issue_date,
      phone_number: phone_number,
      issue_place: $(".formMain select[name='identity_issued_by']").val(),
      email: $(".formMain input[name='email']").val(),
      tem_province: tem_province,
      job_type: job_type,
    };
    console.log(eligible_data);
    // BUG
    // eligible_data.customer_name = "TUAN"
    //
    $.ajax({
      type: "POST",
      url: "https://ec02-api.tel4vn.com/ec/api/eligibleService/v1/eligible/check",
      processData: true,
      data: JSON.stringify(eligible_data),
      async: true,
      dataType: "json",
      headers: {
        "Content-Type": "application/json",
        Authorization: "Bearer 98530a76-4198-4b60-a99a-0489e2dd4b4f",
      },
    })
      .fail((result, status, error) => {
        console.log(result);
        var erro = result.responseJSON;
        let msg = "Please contact developer!";
        request_id = partner_code + Date.now().toString();
        $(".formMain input[name='request_id']").val(request_id);
        if (result.message !== undefined) {
          msg = result.message;
        }
        swal(
          "Send eligible data fail!",
          erro.error.error_message + "Please try again",
          "error"
        );
      })
      .done((result) => {
        console.log(result);
        if (result.code == "ELIGIBLE") {
          swal("Success", result.message, "success");
          let request_id = result.data.request_id;
          updateRequestId(request_id, lead_id);
          // $(".formMain input[name='request_id']").val(result.data.request_id);
          // $.ajax({
          //   type: "POST",
          //   url: "https://ec02-api.tel4vn.com/v1/lead/requestId",
          //   processData: true,
          //   data: JSON.stringify({
          //     lead_id: "" + lead_id,
          //     request_id: request_id,
          //   }),
          //   async: true,
          //   dataType: "json",
          // }).done((update_result) => {
          //   swal("Success", "Update request_id success", "success");
          // });
          SyncFullLoanFromContact();
        } else {
          swal("Error!", result.message, "error");
        }
      });
  }
});

let SyncFullLoanFromAPI = (request_id) => {
  try {
    ajaxGetOldFullLoan(request_id).done((result) => {
      let data = result.data;
      let document = data.document;
      if (document != undefined && document != null) {
        for (const property in document) {
          $("#full-loan-form input[name='" + property + "']").val(
            document[property]
          );
        }
        $("#full-loan-form select[name='gender']").val(document.gender);
        $("#full-loan-form select[name='employment_type']").val(
          document.employment_type
        );
        $("#full-loan-form select[name='disbursement_method']").val(
          document.disbursement_method
        );
        $("#full-loan-form select[name='income_frequency']").val(
          document.income_frequency
        );
        $("#full-loan-form select[name='married_status']").val(
          document.married_status
        );
      }
    });
  } catch (err) {
    console.log(err);
  }
};

let ajaxGetOldFullLoan = (request_id) => {
  return $.ajax({
    type: "GET",
    url: TEL4VN_API_URL + `/v1/fullloan/${request_id}`,
    async: true,
    dataType: "json",
    headers: {
      "Content-Type": "application/json",
    },
  }).fail((result, status, error) => {
    console.log(result);
  });
};

let ajaxGetOffer = (request_id) => {
  return $.ajax({
    type: "GET",
    url: TEL4VN_API_URL + `/v1/offer/${request_id}`,
    async: true,
    dataType: "json",
    headers: {
      "Content-Type": "application/json",
    },
  }).fail((result, status, error) => {
    console.log(result);
  });
};

let ajaxGetStatus = (lead_id) => {
  return $.ajax({
    type: "GET",
    url: `https://ec02-api.tel4vn.com/v1/lead/${lead_id}/status`,
    async: true,
    dataType: "json",
    headers: {
      "Content-Type": "application/json",
    },
  }).fail((result, status, error) => {
    console.log(result);
  });
};

let CheckBoxSyncFieldFullLoan = (flag) => {
  if (!flag === true) {
    flag = false;
  }
  $("#full-loan-form input[name='permanent_address']").prop("disabled", flag);
  $("#full-loan-form input[name='permanent_province']").prop("disabled", flag);
  $("#full-loan-form input[name='permanent_district']").prop("disabled", flag);
  $("#full-loan-form input[name='permanent_ward']").prop("disabled", flag);
  if (flag == true) {
    $("#full-loan-form input[name='permanent_province']").val(
      $("#full-loan-form input[name='tem_province']").val()
    );
    $("#full-loan-form input[name='permanent_address']").val(
      $("#full-loan-form input[name='tem_address']").val()
    );
    $("#full-loan-form input[name='permanent_district']").val(
      $("#full-loan-form input[name='tem_district']").val()
    );
    $("#full-loan-form input[name='permanent_ward']").val(
      $("#full-loan-form input[name='tem_ward']").val()
    );
    $("#full-loan-form input[name='tem_address']").on("change", (e) => {
      $("#full-loan-form input[name='permanent_address']").val(
        $("#full-loan-form input[name='tem_address']").val()
      );
    });
    $("#full-loan-form input[name='tem_province']").on("change", (e) => {
      $("#full-loan-form input[name='permanent_province']").val(
        $("#full-loan-form input[name='tem_province']").val()
      );
    });
    $("#full-loan-form input[name='tem_district']").on("change", (e) => {
      $("#full-loan-form input[name='permanent_district']").val(
        $("#full-loan-form input[name='tem_district']").val()
      );
    });
    $("#full-loan-form input[name='tem_ward']").on("change", (e) => {
      $("#full-loan-form input[name='permanent_ward']").val(
        $("#full-loan-form input[name='tem_ward']").val()
      );
    });
  } else {
    $("#full-loan-form input[name='permanent_address']").unbind();
    $("#full-loan-form input[name='permanent_province']").unbind();
    $("#full-loan-form input[name='permanent_district']").unbind();
    $("#full-loan-form input[name='permanent_ward']").unbind();
  }
};

$("input[type='checkbox'][name='check_same_address']").on("change", (e) => {
  CheckBoxSyncFieldFullLoan(
    $("#full-loan-form input[name='check_same_address']").is(":checked")
  );
});

let SyncFullLoanFromContact = () => {
  let first_name = $(".formMain input[name='first_name']").val();
  let middle_initial = $(".formMain input[name='middle_initial']").val();
  let last_name = $(".formMain input[name='last_name']").val();
  let customer_name = last_name + " " + middle_initial + " " + first_name;
  let phone_number =
    $(".formMain input[name='phone_code']").val() +
    $(".formMain input[name='phone_number']").val();
  tmp_data = {
    request_id: $(".formMain input[name='request_id']").val(),
    partner_code: $(".formMain input[name='partner_code']").val(),
    lead_code: $(".formMain input[name='vendor_lead_code']").val(),
    customer_name: customer_name,
    gender: $(".formMain select[name='gender']").val(),
    date_of_birth: $(".formMain input[name='date_of_birth']").val(),
    identity_card_id: $(".formMain input[name='identity_number']").val(),
    issue_date: $(".formMain input[name='identity_issued_on']").val(),
    issue_place: $(".formMain select[name='identity_issued_by']").val(),
    identity_card_id_2: "",
    phone_number: phone_number,
    email: $(".formMain input[name='email']").val(),
    employment_type: $(".formMain input[name='email']").val(),
    product_type: "As",
    loan_amount: 0,
    loan_tenor: "",
    tem_province: "",
    tem_district: "",
    tem_ward: $(".formMain input[name='city']").val(),
    tem_address: $(".formMain input[name='address1']").val(),
    years_of_stay: 0,
    permanent_province: "",
    permanent_district: "",
    permanent_ward: "",
    permanent_address: "",
    profession: "",
    married_status: "",
    house_type: "",
    number_of_dependents: "0",
    disbursement_method: "1",
    beneficiary_name: "",
    beneficiary_bank: "",
    bank_branch: "",
    bank_account: "",
    monthly_income: 0,
    other_income: 0,
    income_method: "CASH",
    income_frequency: "M",
    income_receiving_date: "15",
    monthly_expense: 0,
    job_title: "",
    company_name: "",
    workplace_city: "",
    workplace_district: "",
    workplace_ward: "",
    workplace_address: "",
    workplace_phone: "",
    employment_contract: "",
    from: "2021",
    to: "2021",
    contract_term: "",
    tax: "",
    loan_purpose: "",
    other_contact: "",
    detail_contact: "",
    relation_1: "",
    relation_1_name: "",
    relation_1_phone_number: "",
    relation_2: "",
    relation_2_name: "",
    relation_2_phone_number: "",
    mailing_address: "",
    lending_method: "",
    business_date: "",
    business_license_number: "",
    annual_revenue: 0,
    annual_profit: 0,
    monthly_revenue: 0,
    monthly_profit: 0,
    "3rd_Party_duration": "",
    list_doc_collecting: {
      file_type_id: ["PIC", "PID"],
      file_name: [
        "PIC_212546374_0988834589_SAP159569495581.pdf",
        "PID_212546374_0988834589_SAP159569495581.pdf",
      ],
    },
  };
  for (const property in tmp_data) {
    $("#full-loan-form input[name='" + property + "']").val(tmp_data[property]);
  }
  $("#full-loan-form select[name='gender']").val(tmp_data.gender);
  if (!$("#full-loan-form input[name='check_same_address']").is(":checked")) {
    $("#full-loan-form input[name='check_same_address']").click();
  }
  $("#full-loan-form select[name='issue_place']")
    .val($(".formMain select[name='identity_issued_by']"))
    .trigger("change");
};
function clearInputFile(f) {
  if (f.value) {
    try {
      f.value = ""; //for IE11, latest Chrome/Firefox/Opera...
    } catch (err) {}
    if (f.value) {
      //for IE5 ~ IE10
      var form = document.createElement("form"),
        ref = f.nextSibling;
      form.appendChild(f);
      form.reset();
      ref.parentNode.insertBefore(f, ref);
    }
  }
}
function clearForm($form) {
  $form
    .find(":input")
    .not(":button, :submit, :reset, :hidden, :checkbox, :radio")
    .val("");
  $form.find(":checkbox, :radio").prop("checked", false);
  $("#submit-full-loan").attr("hidden", false);
  $("#submit-offer").attr("hidden", true);
  $("#offer-waiting").attr("hidden", true);
  clearInputFile($("#img_selfie")[0]);
  clearInputFile($("#img_id_card")[0]);
  selected_offer_insurance_type = "";
  var list_docs = $(".MultiFile-remove");
  for (let index = 0; index < list_docs.length; index++) {
    list_docs[index].click();
  }
  list_doc_collecting = [];
}

function SetCustomerOfferDetail() {
  $("#create-offer-table")[0].innerHTML = `
  <tr>
    <th colspan="2">Offer Detail</th>
  </tr>
  <tr>
      <td>Customer Offer Amount</td>
      <td><input name="customer-offer-amount" type="text" value='' class="customer-offer-input"></td>
  </tr>
  <tr>
    <td>Offer Amount</td>
    <td><input name="offer-amount" type="number" value='${selected_offer_amount}' class="customer-offer-input-readonly">${formatter.format(
    selected_offer_amount
  )}</td>
  </tr>
  <tr>
      <td>Offer Tenor</td>
      <td><input name="customer-offer-tenor" value="${selected_offer_tenor}" type="number" class="customer-offer-input-readonly">${selected_offer_tenor} month</td>
  </tr>
  <tr>
      <td>Percent</td>
      <td><input name="customer-offer-percent" value="${percent_insurance}" type="number" class="customer-offer-input-readonly">${percent_insurance}%</td>
  </tr>
  <tr>
      <td>Total Offer</td>
      <td><input name="customer-offer-total" value="21200000" type="number" class="customer-offer-input-readonly">${formatter.format(
        21200000
      )}</td>
  </tr>
  <tr>
      <td>Monthly</td>
      <td><input name="customer-offer-monthly" value="1200000" type="number" class="customer-offer-input-readonly">${formatter.format(
        1200000
      )}</td>
  </tr>
  `;
}
$(document).on("change", 'select[name="product_type"]', function () {
  let product_code = this.value;
});

$(document).on("change", 'select[name="employment_type"]', function () {
  selected_employment_type = null;
  let em_type = this.value;
  if (ECProducts != undefined){
      ECProducts.forEach((et) => {
          if (et.employee_type == em_type){
              selected_employment_type = et;
              let product_lists = et.product_list;
               let select_product_type = $("select[name='product_type']")[0];
               select_product_type.innerHTML =""
               for (prd of product_lists) {
                    $(`<option value="${prd.product_code}">${prd.product_code} - ${prd.product_description}</option>`).appendTo(select_product_type);
                }
              return;
          }
      });
  }
});
$(document).on("keyup", 'input[name="customer-offer-amount"]', function () {
  if (this.value == "" || this.value == undefined) {
    //
  }
  this.value = this.value.replace(/[^0-9\.]/g, "");
  this.value = this.value.replace(".", "");
});
$(document).on("blur", 'input[name="customer-offer-amount"]', function () {
  this.value = formatter.format(this.value);
});

$(document).on("click", 'input[name="select_insurance"]', function () {
  $("#create-offer-table").empty();
  $("#create-offer-table").attr("hidden", false);
  let tmp_data2 = offerinsurancetable.row(this).data();
  if (tmp_data2 == undefined) {
    tmp_data2 = offerinsurancetable.row($(this).closest("tr")).data();
  }
  selected_offer_insurance_type = tmp_data2.type;
  percent_insurance = tmp_data2.percent_insurance;
  insurance_amount = tmp_data2.mount;
  SetCustomerOfferDetail();
});
$("#full-loan-form").on("submit", (e) => {
  lead_id = $(".formMain input[name='lead_id']").val() * 1;
  e.preventDefault();
  let form_data = $("#full-loan-form").serializeFormJSON();
  form_data.lead_id = parseInt(lead_id);
  form_data.monthly_income = parseInt(form_data.monthly_income);
  form_data.other_income = parseInt(form_data.other_income);
  form_data.monthly_expense = parseInt(form_data.monthly_expense);
  form_data.loan_amount = parseInt(form_data.loan_amount);
  form_data.annual_revenue = parseInt(form_data.annual_revenue);
  form_data.annual_profit = parseInt(form_data.annual_profit);
  form_data.monthly_revenue = parseInt(form_data.monthly_revenue);
  form_data.monthly_profit = parseInt(form_data.monthly_profit);
  // QUANG
  form_data.dsa_agent_code = "DSAMKK1233";
  form_data.list_doc_collecting = list_doc_collecting;
  form_data.date_of_birth = moment(
    form_data.date_of_birth,
    "YYYY-MM-DD"
  ).format("DD-MM-YYYY");
  form_data.issue_date = moment(form_data.issue_date, "YYYY-MM-DD").format(
    "DD-MM-YYYY"
  );
  form_data.doc_collecting_list = form_data.list_doc_collecting;
  console.log(form_data);
  //

  //
  let post_data = JSON.stringify(form_data);
  $("#offer-waiting").attr("hidden", false);
  // post to EC
  $.ajax({
    url: "https://ec02-api.tel4vn.com/ec/api/loanRequestServices/v1/dsa/send-loan-application",
    method: "POST",
    timeout: 0,
    headers: {
      Authorization: "Bearer 98530a76-4198-4b60-a99a-0489e2dd4b4f",
      "Content-Type": "application/json",
    },
    data: post_data,
  })
    .fail((result, status, error) => {
      var er_data = result.responseJSON.body;
      console.log(er_data.body);
      let msg = "Please contact developer!";
      if (result.message !== undefined) {
        msg = result.message;
      }
      swal("Send full-loan data fail!", er_data.message, "error");
      $("#offer-waiting").attr("hidden", true);
    })
    .done((result) => {
      if (
        result.status_code == 200 &&
        result.body != undefined &&
        result.body.code == "RECEIVED"
      ) {
        swal("OK!", result.body.message, "success");
        IsSuccessPolled = false;
        PolledTotal = 1;
        PolledOfferInterval = setInterval(() => {
          PollingOfferFromEC(form_data.request_id, lead_id);
        }, 5000);
      } else {
        swal("Error!", "Send full-loan data fail!", "error");
        $("#offer-waiting").attr("hidden", true);
      }
    });
  $.ajax({
    type: "POST",
    url: TEL4VN_API_URL + "/v1/fullloan",
    processData: true,
    data: post_data,
    async: true,
    dataType: "json",
    headers: {
      "Content-Type": "application/json",
    },
  })
    .fail((result, status, error) => {
      console.log(result);
    })
    .done((result) => {
      console.log(result);
    });
});
function updateRequestId(request_id, lead_id) {
  $("#full-loan-form input[name='request_id']").val(request_id);
  $(".formMain input[name='request_id']").val(request_id);
  $("#submit-full-loan")[0].disabled = true;
  $.ajax({
    type: "POST",
    url: "https://ec02-api.tel4vn.com/v1/lead/requestId",
    processData: true,
    data: JSON.stringify({
      lead_id: "" + lead_id,
      request_id: request_id,
    }),
    async: true,
    dataType: "json",
  }).done((update_result) => {
    $("#submit-full-loan")[0].disabled = false;
    swal("Success", "Update request_id success", "success");
  });
}
let IsSuccessPolled = false;
let PolledTotal = 1;
let PolledOfferInterval = null;
function PollingOfferFromEC(request_id, lead_id) {
  PolledTotal++;
  if (IsSuccessPolled === false && PolledTotal < 180) {
    ajaxGetStatus(lead_id).done((result) => {
      if (result.data.app_status != "" && result.data.reject_reason != "") {
        if (result.data.app_status == "VALIDATED") {
          ajaxGetOffer(request_id).done((result) => {
            if (
              result.data.document != undefined &&
              result.data.document != null
            ) {
              IsSuccessPolled = true;
              offer = result.data.document;
              offerList = offer.data.offer_list;
              SetOfferDetail(offerList);
            }
          });
        } else {
          IsSuccessPolled = true;
          $("#create-offer-table").empty();
          $("#create-offer-table").attr("hidden", true);
          $("#offer-datatable").empty();
          swal("Offer Reject", "Reason: " + result.data.reject_reason, "error");
          // Update request_id
          request_id =
            $("#full-loan-form input[name='partner_code']").val() +
            Date.now().toString();
          updateRequestId(request_id, lead_id);
        }
      }
    });
  } else {
    clearInterval(PolledOfferInterval);
  }
}

function SetOfferDetail(offerList) {
  console.log(offerList);
  $("#offer-datatable").removeClass("hidden");
  var offerTable = $("#offer-list-table").DataTable({
    destroy: true,
    responsive: true,
    searching: false,
    lengthChange: false,
    data: offerList,
    columns: [
      {
        title: "Offer Id",
        data: "offer_id",
      },
      {
        title: "Offer Amount",
        data: "offer_amount",
        render: (data) => {
          result =
            data != null
              ? data.toLocaleString("vi-VN", {
                  style: "currency",
                  currency: "VND",
                })
              : 0;
          return result;
        },
      },
      {
        title: "Interest Rate",
        data: "interest_rate",
      },
      {
        title: "Monthly Installment",
        data: "monthly_installment",
        render: (data) => {
          result =
            data != null
              ? data.toLocaleString("vi-VN", {
                  style: "currency",
                  currency: "VND",
                })
              : 0;
          return result;
        },
      },
      {
        title: "Offer Tenor",
        data: "tenor",
      },
      {
        title: "Min Financed Amount",
        data: "min_financed_amount",
        render: (data) => {
          result =
            data != null
              ? data.toLocaleString("vi-VN", {
                  style: "currency",
                  currency: "VND",
                })
              : 0;
          return result;
        },
      },
      {
        title: "Max Financed Amount",
        data: "max_financed_amount",
        render: (data) => {
          result =
            data != null
              ? data.toLocaleString("vi-VN", {
                  style: "currency",
                  currency: "VND",
                })
              : 0;
          return result;
        },
      },
      {
        title: "Offer Variant",
        data: "offer_var",
      },
      {
        title: "Offer Type",
        data: "offer_type",
      },
      {
        title: "View",
        render: () => {
          return '<button class="btn btn-sm btn-success btn-offer-view"><i class="fa fa-fw fa-eye"></i></button>';
        },
      },
    ],
  });

  $("#offer-list-table tbody").on("click", "tr .btn-offer-view", function (e) {
    e.preventDefault();
    $("#create-offer-table").empty();
    $("#create-offer-table").attr("hidden", true);
    let tmp_data = offerTable.row($(this).closest("tr").prev()[0]).data();
    selected_offer_amount = tmp_data.offer_amount;
    selected_offer_id = tmp_data.offer_id;
    selected_max_financed_amount = tmp_data.max_financed_amount;
    selected_min_financed_amount = tmp_data.min_financed_amount;
    selected_offer_tenor = tmp_data.offer_tenor;
    selected_monthly_installment = tmp_data.monthly_installment;
    offerinsurancetable = $("#offer-insurance-list-table").DataTable({
      destroy: true,
      responsive: true,
      searching: false,
      lengthChange: false,
      data: tmp_data.insurance_list,
      columns: [
        {
          title: "Type",
          data: "type",
        },
        {
          title: "Amount",
          data: "amount",
          render: (data) => {
            result =
              data != null
                ? data.toLocaleString("vi-VN", {
                    style: "currency",
                    currency: "VND",
                  })
                : 0;
            return result;
          },
        },
        {
          title: "Percentage",
          data: "percent_insurance",
          render: (data) => {
            return data + "%";
          },
        },
        {
          title: "Base Calculation",
          data: "base_calculation",
        },
        {
          title: "Select",
          data: "type",
          render: (data) => {
            return `<input type="radio" name="select_insurance" value="${data}" />`;
          },
        },
        {
          visible: false,
          data: "insurance_amount",
          render: (data) => {
            return `<input type="text" name="select_insurance_amount" value="${data}" />`;
          },
        },
      ],
    });
  });

  $("#submit-full-loan").attr("hidden", true);
  $("#offer-waiting").attr("hidden", true);
  $("#submit-offer").attr("hidden", false);
}

function capitalize(string) {
  return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
}
//
$(function () {
  //
  $("#attachment_files").MultiFile({
    onFileRemove: function (element, value, master_element) {
      console.log("Remove");
      $("#F9-Log").append("<li>onFileRemove - " + value + "</li>");
    },
    afterFileRemove: function (element, value, master_element) {
      console.log("After remove");
      $("#F9-Log").append("<li>afterFileRemove - " + value + "</li>");
    },
    onFileAppend: function (element, value, master_element) {
      console.log("After Append");
    },
    afterFileAppend: function (element, value, master_element) {
      var last_mdf = element.files[0].lastModified;
      $(`span[tag='multifile'][name='${last_mdf}']`)[0].innerHTML =
        `<SELECT name='${last_mdf}' class="select_file_type">
            <OPTION VALUE="SNID" SELECTED>SNID - CHỨNG MINH NHÂN NHÂN (CMND)/ NATIONAL ID</OPTION>
            <OPTION VALUE="SLCT">SLCT - HỢP ĐỒNG VAY (HĐV)/ LOAN CONTRACT</OPTION>
            <OPTION VALUE="SSPIC">SSPIC - HÌNH KHÁCH HÀNG/ CLIENT PHOTO</OPTION>
            <OPTION VALUE="SPID">SPID - THẺ CĂN CƯỚC CÔNG DÂN/ PEOPLE'S IDENTITY CARD</OPTION>
            <OPTION VALUE="SDRL">SDRL - GIẤY PHÉP LÁI XE (GPLX)/ DRIVING LICENSE</OPTION>
            <OPTION VALUE="SFRB">SFRB - SỔ HỘ KHẨU (SHK)/ FAMILY REGISTRATION BOOK</OPTION>
            <OPTION VALUE="SPPT">SPPT - HỘ CHIẾU (PP)/ PASSPORT</OPTION>
            <OPTION VALUE="SLBC">SLBC - HĐLĐ (LB)/ LABOR CONTRACT</OPTION>
            <OPTION VALUE="SBAS">SBAS - SAO KÊ LƯƠNG/ BANK ACCOUNT STATEMENT</OPTION>
            <OPTION VALUE="SBIZ">SBIZ - GIẤY PHÉP KINH DOANH/ BUSINESS LICENSE</OPTION>
            <OPTION VALUE="STAX">STAX - CHỨNG TỪ THUẾ/ TAX INVOICE</OPTION>
            <OPTION VALUE="SPEN">SPEN - SỔ HƯU TRÍ/ PENSION BOOK</OPTION>
            <OPTION VALUE="SINP">SINP - HĐBH/ INSURANCE POLICY</OPTION>
            <OPTION VALUE="SCCS">SCCS - SAO KÊ THẺ TÍN DỤNG/ CREDIT CARD STATEMENT</OPTION>
            <OPTION VALUE="SEB1">SEB1 - HÓA ĐƠN ĐIỆN DƯỚI 600,000 VND/ ELECTRICITY BILL LESS 600</OPTION>
            <OPTION VALUE="SEB2">SEB2 - HÓA ĐƠN ĐIỆN TỪ 600,000 VND/ ELECTRICITY BILL MORE 600</OPTION>
            <OPTION VALUE="SHIC">SHIC - THẺ BHYT/ HEALTH INSURANCE CARD</OPTION>
            <OPTION VALUE="SPMS">SPMS - LỊCH THANH TOÁN</OPTION>
            <OPTION VALUE="SSPMS">SSPMS - LỊCH THANH TOÁN SCAN</OPTION>
            <OPTION VALUE="SICS">SICS - MÀN HÌNH THÔNG TIN ICIC</OPTION>
            <OPTION VALUE="SSICS">SSICS - MÀN HÌNH THÔNG TIN ICIC SCAN</OPTION>
            <OPTION VALUE="SPPA">SPPA - HÌNH ẢNH TÀI SẢN MUA SẮM ĐẦU TƯ</OPTION>
            <OPTION VALUE="SVAT">SVAT - HÓA ĐƠN VAT</OPTION>
            <OPTION VALUE="SRIN">SRIN - HÓA ĐƠN BÁN LẺ</OPTION>
            <OPTION VALUE="SBPM">SBPM - HÓA ĐƠN TỪ MÁY THANH TOÁN</OPTION>
            <OPTION VALUE="SGDN">SGDN - PHIẾU XUẤT KHO</OPTION>
            <OPTION VALUE="SPTC">SPTC - HÌNH ẢNH HỢP ĐỒNG MUA BÁN</OPTION>
            <OPTION VALUE="SBAS">SBAS - SAO KÊ LƯƠNG/ BANK ACCOUNT STATEMENT</OPTION>
      </SELECT>` + $(`span[tag='multifile'][name='${last_mdf}']`)[0].innerHTML;
      $(".select_file_type").select2({
        allowClear: true,
      });
    },
    onFileSelect: function (element, value, master_element) {
      $("#F9-Log").append("<li>onFileSelect - " + value + "</li>");
    },
    afterFileSelect: function (element, value, master_element) {
      $("#F9-Log").append("<li>afterFileSelect - " + value + "</li>");
    },
    onFileInvalid: function (element, value, master_element) {
      $("#F9-Log").append("<li>onFileInvalid - " + value + "</li>");
    },
    onFileDuplicate: function (element, value, master_element) {
      $("#F9-Log").append("<li>onFileDuplicate - " + value + "</li>");
    },
    onFileTooMany: function (element, value, master_element) {
      $("#F9-Log").append("<li>onFileTooMany - " + value + "</li>");
    },
    onFileTooBig: function (element, value, master_element) {
      $("#F9-Log").append("<li>onFileTooBig - " + value + "</li>");
    },
    onFileTooMuch: function (element, value, master_element) {
      $("#F9-Log").append("<li>onFileTooMuch - " + value + "</li>");
    },
  });
});

$(document).ready(() => {
  let permanentProvince = $("select[name='permanent_province']")[0];
  $(`<option value="" selected></option>`).appendTo(permanentProvince);
  for (const [key, value] of Object.entries(PROVINCE)) {
    $(`<option value="${key}">${value}</option>`).appendTo(permanentProvince);
  }

  $("select[name='permanent_province']").selectpicker("refresh");
  let temProvince = $("select[name='tem_province']")[0];
  $(`<option value="" selected></option>`).appendTo(temProvince);
  for (const [key, value] of Object.entries(PROVINCE)) {
    $(`<option value="${key}">${value}</option>`).appendTo(temProvince);
  }

  $("select[name='tem_province']").selectpicker("refresh");
  let workplaceProvince = $("select[name='workplace_province']")[0];
  $(`<option value="" selected></option>`).appendTo(workplaceProvince);
  for (const [key, value] of Object.entries(PROVINCE)) {
    $(`<option value="${key}">${value}</option>`).appendTo(workplaceProvince);
  }
  $("select[name='workplace_province']").selectpicker("refresh");

  $("select[name='permanent_province']").on("change", () => {
    $("select[name='permanent_district']").empty().selectpicker("refresh");
    $("select[name='permanent_ward']").empty().selectpicker("refresh");
    let permanentProvinceId = $("select[name='permanent_province']").val();
    if (permanentProvinceId != "") {
      let permanentDistrict = $("select[name='permanent_district']")[0];
      $(`<option value="" selected></option>`).appendTo(permanentDistrict);
      for (const [key, value] of Object.entries(DISTRICT)) {
        if (value.province_id == permanentProvinceId) {
          $(`<option value="${key}">${value.district_name}</option>`).appendTo(
            permanentDistrict
          );
        }
      }
      $("select[name='permanent_district']").selectpicker("refresh");
    }
  });
  $("select[name='permanent_district']").on("change", () => {
    $("select[name='permanent_ward']").empty().selectpicker("refresh");
    let permanentDistrictId = $("select[name='permanent_district']").val();
    if (permanentDistrictId != "") {
      let permanentWard = $("select[name='permanent_ward']")[0];
      $(`<option value="" selected></option>`).appendTo(permanentWard);
      for (const [key, value] of Object.entries(WARD)) {
        if (value.district_id == permanentDistrictId) {
          $(`<option value="${key}">${value.ward_name}</option>`).appendTo(
            permanentWard
          );
        }
      }
      $("select[name='permanent_ward']").selectpicker("refresh");
    }
  });
  $("select[name='tem_province']").on("change", () => {
    $("select[name='tem_district']").empty().selectpicker("refresh");
    $("select[name='tem_ward']").empty().selectpicker("refresh");
    let temProvinceId = $("select[name='tem_province']").val();
    if (temProvinceId != "") {
      let temDistrict = $("select[name='tem_district']")[0];
      $(`<option value="" selected></option>`).appendTo(temDistrict);
      for (const [key, value] of Object.entries(DISTRICT)) {
        if (value.province_id == temProvinceId) {
          $(`<option value="${key}">${value.district_name}</option>`).appendTo(
            temDistrict
          );
        }
      }
      $("select[name='tem_district']").selectpicker("refresh");
    }
  });
  $("select[name='tem_district']").on("change", () => {
    $("select[name='tem_ward']").empty().selectpicker("refresh");
    let temDistrictId = $("select[name='tem_district']").val();
    if (temDistrictId != "") {
      let temWard = $("select[name='tem_ward']")[0];
      $(`<option value="" selected></option>`).appendTo(temWard);
      for (const [key, value] of Object.entries(WARD)) {
        if (value.district_id == temDistrictId) {
          $(`<option value="${key}">${value.ward_name}</option>`).appendTo(
            temWard
          );
        }
      }
      $("select[name='tem_ward']").selectpicker("refresh");
    }
  });
  $("select[name='workplace_province']").on("change", () => {
    $("select[name='workplace_district']").empty().selectpicker("refresh");
    $("select[name='workplace_ward']").empty().selectpicker("refresh");
    let workplaceProvinceId = $("select[name='workplace_province']").val();
    if (workplaceProvinceId != "") {
      let workplaceDistrict = $("select[name='workplace_district']")[0];
      $(`<option value="" selected></option>`).appendTo(workplaceDistrict);
      for (const [key, value] of Object.entries(DISTRICT)) {
        if (value.province_id == workplaceProvinceId) {
          $(`<option value="${key}">${value.district_name}</option>`).appendTo(
            workplaceDistrict
          );
        }
      }
      $("select[name='workplace_district']").selectpicker("refresh");
    }
  });
  $("select[name='workplace_district']").on("change", () => {
    $("select[name='workplace_ward']").empty().selectpicker("refresh");
    let workplaceDistrictId = $("select[name='workplace_district']").val();
    if (workplaceDistrictId != "") {
      let workplaceWard = $("select[name='workplace_ward']")[0];
      $(`<option value="" selected></option>`).appendTo(workplaceWard);
      for (const [key, value] of Object.entries(WARD)) {
        if (value.district_id == workplaceDistrictId) {
          $(`<option value="${key}">${value.ward_name}</option>`).appendTo(
            workplaceWard
          );
        }
      }
      $("select[name='workplace_ward']").selectpicker("refresh");
    }
  });
  let bankMainCode = $("select[name='bank_code']")[0];
  $(`<option value="" selected></option>`).appendTo(bankMainCode);
  for (const [key, value] of Object.entries(BANK_CODE)) {
    $(`<option value="${key}">${value}</option>`).appendTo(bankMainCode);
  }
  $("select[name='bank_code']").selectpicker("refresh");

  let bankArea = $("select[name='bank_area']")[0];
  $(`<option value="" selected></option>`).appendTo(bankArea);

  for (const [key, value] of Object.entries(BANK_AREA)) {
    $(`<option value="${value}">${value}</option>`).appendTo(bankArea);
  }
  $("select[name='bank_area']").selectpicker("refresh");

  $("select[name='bank_code']").on("change", () => {
    let bankAreaValue = $("select[name='bank_area']").val();
    let bankMainCodeId = $("select[name='bank_code']").val();
    if (bankAreaValue != "" && bankMainCodeId != "") {
      $("select[name='bank_branch_code']").empty().selectpicker("refresh");
      let bankCode = $("select[name='bank_branch_code']")[0];
      $(`<option value="" selected></option>`).appendTo(bankCode);
      for (const [key, value] of Object.entries(BANK_BRANCH_CODE)) {
        if (value.area == bankAreaValue && value.bank_id == bankMainCodeId) {
          $(`<option value="${key}">${value.branch_name}</option>`).appendTo(
            bankCode
          );
        }
      }
      $("select[name='bank_branch_code']").selectpicker("refresh");
    }
  });
  $("select[name='bank_area']").on("change", () => {
    let bankAreaValue = $("select[name='bank_area']").val();
    let bankMainCodeId = $("select[name='bank_code']").val();
    if (bankAreaValue != "" && bankMainCodeId != "") {
      $("select[name='bank_branch_code']").empty().selectpicker("refresh");
      let bankCode = $("select[name='bank_branch_code']")[0];
      $(`<option value="" selected></option>`).appendTo(bankCode);
      for (const [key, value] of Object.entries(BANK_BRANCH_CODE)) {
        if (value.area == bankAreaValue && value.bank_id == bankMainCodeId) {
          $(`<option value="${key}">${value.branch_name}</option>`).appendTo(
            bankCode
          );
        }
      }
      $("select[name='bank_branch_code']").selectpicker("refresh");
    }
  });
});
