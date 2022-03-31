var selected_product = null;
var selected_employment_type = null;
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

let CheckBoxSyncFieldFullLoan = (flag) => {
  if (!flag === true) {
    flag = false;
  }
  // $("#full-loan-form input[name='permanent_address']").prop("disabled", flag);
  // $("#full-loan-form input[name='permanent_province']").prop("disabled", flag);
  // $("#full-loan-form input[name='permanent_district']").prop("disabled", flag);
  // $("#full-loan-form input[name='permanent_ward']").prop("disabled", flag);
  if (flag == true) {
    $("#full-loan-form select[name='permanent_province']")
      .val($("#full-loan-form select[name='tem_province']").val())
      .trigger("change");
    $("#full-loan-form select[name='permanent_district']")
      .val($("#full-loan-form select[name='tem_district']").val())
      .trigger("change");
    $("#full-loan-form select[name='permanent_ward']")
      .val($("#full-loan-form select[name='tem_ward']").val())
      .trigger("change");
    $("#full-loan-form input[name='permanent_address']").val(
      $("#full-loan-form input[name='tem_address']").val()
    );
    $("#full-loan-form input[name='tem_address']").on("change", (e) => {
      $("#full-loan-form input[name='permanent_address']").val(
        $("#full-loan-form input[name='tem_address']").val()
      );
    });
    $("#full-loan-form select[name='tem_province']").on("change", (e) => {
      $("#full-loan-form select[name='permanent_province']")
        .val($("#full-loan-form select[name='tem_province']").val())
        .trigger("change");
    });
    $("#full-loan-form select[name='tem_district']").on("change", (e) => {
      $("#full-loan-form select[name='permanent_district']")
        .val($("#full-loan-form select[name='tem_district']").val())
        .trigger("change");
    });
    $("#full-loan-form select[name='tem_ward']").on("change", (e) => {
      $("#full-loan-form select[name='permanent_ward']")
        .val($("#full-loan-form select[name='tem_ward']").val())
        .trigger("change");
    });
  } else {
    $("#full-loan-form input[name='permanent_address']").unbind();
    $("#full-loan-form select[name='permanent_province']").unbind();
    $("select[name='permanent_province']")
      .selectpicker("destroy")
      .selectpicker("render");
    $("#full-loan-form select[name='permanent_district']").unbind();
    $("select[name='permanent_district']")
      .selectpicker("destroy")
      .selectpicker("render");
    $("#full-loan-form select[name='permanent_ward']").unbind();
    $("select[name='permanent_ward']")
      .selectpicker("destroy")
      .selectpicker("render");
    SetPermanentAddress();
  }
};
// DEV AREA
let format_log_productlist = function (product_list) {
  let log_products = {};
  log_products.list = [];
  log_products.total = 0;
  for (let index = 0; index < product_list.length; index++) {
    let products = [];
    let type_products = product_list[index].product_list;
    for (let j = 0; j < type_products.length; j++) {
      let product = {};
      product.product_code = type_products[j].product_code;
      product.product_descriptio = type_products[j].product_description;
      products.push(product);
    }
    log_products.list.push(products);
    log_products.total += products.length;
  }
  console.log("Products: ", log_products);
};
// END DEV AREA
let ECProducts = null;
let box_color = [
  "box-primary",
  "box-danger",
  "box-success",
  "box-warning",
  "box box-info",
  "box box-default",
];

let SetPermanentAddress = () => {
  let permanentProvince = $("select[name='permanent_province']")[0];
  $("select[name='permanent_province']").empty();
  $(`<option value="" selected></option>`).appendTo(permanentProvince);
  for (const [key, value] of Object.entries(PROVINCE)) {
    $(`<option value="${key}">${value}</option>`).appendTo(permanentProvince);
  }
  $("select[name='permanent_province']").selectpicker("refresh");

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
  $("select[name='permanent_province']").val("").trigger("change");
};

let SetTemAddress = () => {
  let temProvince = $("select[name='tem_province']")[0];
  $(`<option value="" selected></option>`).appendTo(temProvince);
  for (const [key, value] of Object.entries(PROVINCE)) {
    $(`<option value="${key}">${value}</option>`).appendTo(temProvince);
  }
  $("select[name='tem_province']").selectpicker("refresh");

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
  $("select[name='tem_province']").val("").trigger("change");
};

let SetWorkAddress = () => {
  let workplaceProvince = $("select[name='workplace_province']")[0];
  $(`<option value="" selected></option>`).appendTo(workplaceProvince);
  for (const [key, value] of Object.entries(PROVINCE)) {
    $(`<option value="${key}">${value}</option>`).appendTo(workplaceProvince);
  }
  $("select[name='workplace_province']").selectpicker("refresh");

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
  $("select[name='workplace_province']").val("").trigger("change");
};
function SetProductListForm() {
  $("#create-offer-table")[0].innerHTML = `
    <tr>
      <th colspan="2">Offer Detail</th>
    </tr>
    <tr>
      <td>Khoản vay</td>
      <td><input name="customer-offer-amount" type="text" value='' class="customer-offer-input" readonly></td>
    </tr>
    <tr>
      <td>Kỳ hạn vay</td>
      <td><input name="customer-offer-tenor" value="" type="number" class="customer-offer-input-readonly" readonly></td>
    </tr>
    <tr>
      <td>Bảo hiểm</td>
      <td><input name="customer-offer-percent" value="" type="text" class="customer-offer-input-readonly" readonly></td>
    </tr>
    <tr>
      <td>Tổng khoản vay</td>
      <td><input name="customer-offer-total" value="" type="text" class="customer-offer-input-readonly" readonly></td>
    </tr>
    <tr>
      <td>Khoản trả hàng tháng</td>
      <td><input name="customer-offer-monthly" value="" type="text" class="customer-offer-input-readonly" readonly></td>
    </tr>
    `;
  $("input[name='simu_insurance']")[0].checked = true;
}

let ajaxGetECProducts = (partner_code, request_id) => {
  return $.ajax({
    url: EC_PROD_API_URL + "/los-united/v1/product-list",
    method: "POST",
    timeout: 0,
    headers: {
      // Authorization: "Bearer "+CRM_TOKEN,
      "Content-Type": "application/json",
    },
    data: JSON.stringify({
      request_id: request_id,
      channel: "DSA",
      partner_code: partner_code,
      product_line: "BUSINESS",
    }),
  })
    .fail((result, status, error) => {
      console.error("Get Product List Failed: ", result);
      let msg = "Please contact developer!";
      if (result.message !== undefined) {
        msg = result.message;
      }

      if (result.responseText != undefined) {
        try {
          let err = JSON.parse(result.responseText);
          if (err.error != undefined) {
            msg = err.error;
          }
        } catch (error) {
          msg = result.responseText;
        }
      }
      swal("Get products data fail!", msg, "error");
    })
    .done((result) => {
      //
      SetProductListForm();
      if (result.code == "SUCCESS") {
        ECProducts = result.data;
        format_log_productlist(ECProducts);
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
          let table = $("#productTable" + index).DataTable({
            destroy: true,
            responsive: true,
            data: product.product_list,
            columns: [
              {
                title: "Mã sản phẩm",
                data: "product_code",
              },
              {
                title: "Thời hạn vay tối thiểu",
                data: "loan_min_tenor",
              },
              {
                title: "Thời hạn vay tối đa",
                data: "loan_max_tenor",
              },
              {
                title: "Khoảng vay tối thiếu",
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
                title: "Khoản vay tối đa",
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
                title: "Tỉ lệ lãi",
                data: "interest_rate",
              },
              {
                title: "Thao tác",
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
              }
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
};

function filterchange() {
  $("#table").empty();
  $(".report-loader").fadeIn("slow");
  var filter_type = $("#filter_type").val();
  var request = "";
  usergroup = $("#usergroup_id").val();
  let leadcode = $("#vendor_lead_code_sl").val();
  listID = $("#list_id").val();
  let URL = "./php/reports/sale_applications.php";
  $.ajax({
    url: URL,
    type: "POST",
    data: {
      pageTitle: filter_type,
      request: request,
      userID: $("#userID").val(),
      userGroup: usergroup,
      fromDate: $("#start_filterdate").val(),
      toDate: $("#end_filterdate").val(),
      listID: listID,
      leadCode: leadcode,
    },
    success: function (data) {
      if (data !== "") {
        $(".report-loader").fadeOut("slow");
        $("#table").html(data);
        var title = "Sale_Application_";
        let start_date = new Date($("#start_filterdate").val());
        let end_date = new Date($("#end_filterdate").val());
        let startdate_string = moment(start_date).format("DD-MM-YYYY");
        let enddate_string = moment(end_date).format("DD-MM-YYYY");
        if (startdate_string == enddate_string) {
          title += enddate_string;
        } else {
          title += startdate_string + "_" + enddate_string;
        }
        $("#application_table").DataTable({
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
let ajaxGetOldFullLoan = (request_id) => {
  return $.ajax({
    type: "GET",
    url: CRM_API_URL + `/v1/fullloan/${request_id}`,
    async: true,
    dataType: "json",
    headers: {
      "Content-Type": "application/json",
    },
  }).fail((result, status, error) => {
    console.error("ajaxGetOldFullLoan error : ", result);
  });
};

function clearForm($form) {
  $form
    .find(":input")
    .not(":button, :submit, :reset, :hidden, :checkbox, :radio")
    .val("");
  $form.find(":checkbox, :radio").prop("checked", false);
  selected_offer_insurance_type = "";
}
function clearAFForm() {
  $("#smartwizard").smartWizard("reset");
  $("#full-loan-form select[name='issue_place']")
    .val("")
    .trigger("change")
    .selectpicker("refresh");
  $("#full-loan-form select[name='tem_province']")
    .val("")
    .trigger("change")
    .selectpicker("refresh");
  $("#full-loan-form select[name='permanent_province']")
    .val("")
    .trigger("change")
    .selectpicker("refresh");
  $("#full-loan-form select[name='job_type']").val("SFF").trigger("change");
  $("#full-loan-form select[name='employment_contract']")
    .val("IT")
    .trigger("change");
  $("#full-loan-form input[name='tem_address']").val("");
  $("#full-loan-form input[name='permanent_address']").val("");
  $("#full-loan-form input[name='from']").val(2021).trigger("blur");
  $("#full-loan-form input[name='to']").val(2021).trigger("blur");
  $("#full-loan-form input[name='condition_confirm']").prop("checked", true);
  $("#full-loan-form input[name='other_confirm']").prop("checked", true);
  $("#full-loan-form input[name='term_confirm']").prop("checked", true);
  $("#list_upload_docs").empty();
}
let SyncFullLoanFromAPI = (request_id) => {
  // $("#app_detail_tab").click();
  clearForm($("#full-loan-form"));
  clearAFForm();
  try {
    ajaxGetOldFullLoan(request_id).done((result) => {
      if (result.error == "Not found") {
        console.error("Get Old Loan Error", result);
        return;
      }
      try {
        let data = result.data;
        let document = data.document;
        console.log("DOC", document);
        for (const property in document) {
          $("#full-loan-form input[name='" + property + "']")
            .val(document[property])
            .trigger("change");
          $("#full-loan-form select[name='" + property + "']")
            .val(document[property])
            .trigger("change");
        }
        $("select[name='tem_province']")
          .val(document["tem_province"])
          .trigger("change")
          .selectpicker("refresh");
        $("select[name='tem_district']")
          .val(document["tem_district"])
          .trigger("change")
          .selectpicker("refresh");
        $("select[name='tem_ward']")
          .val(document["tem_ward"])
          .trigger("change")
          .selectpicker("refresh");
        $("select[name='permanent_province']")
          .val(document["permanent_province"])
          .trigger("change")
          .selectpicker("refresh");
        $("select[name='permanent_district']")
          .val(document["permanent_district"])
          .trigger("change")
          .selectpicker("refresh");
        $("select[name='permanent_ward']")
          .val(document["permanent_ward"])
          .trigger("change")
          .selectpicker("refresh");
        $("select[name='workplace_province']")
          .val(document["workplace_province"])
          .trigger("change")
          .selectpicker("refresh");
        $("select[name='workplace_district']")
          .val(document["workplace_district"])
          .trigger("change")
          .selectpicker("refresh");
        $("select[name='workplace_ward']")
          .val(document["workplace_ward"])
          .trigger("change")
          .selectpicker("refresh");

        if ($("select[name='disbursement_method']").val() != "CASH") {
          $("select[name='bank_code']")
            .val(document["bank_code"])
            .trigger("change")
            .selectpicker("refresh");
          $("select[name='bank_area']")
            .val(document["bank_area"])
            .trigger("change")
            .selectpicker("refresh");
          $("select[name='bank_branch_code']")
            .val(document["bank_branch_code"])
            .trigger("change")
            .selectpicker("refresh");
        }
        $("#full-loan-form select[name='issue_place']")
          .val(document["issue_place"])
          .trigger("change")
          .selectpicker("refresh");
        $("#full-loan-form input[name='condition_confirm']").prop(
          "checked",
          true
        );
        $("#full-loan-form input[name='issue_date']").val(
          moment(document["issue_date"], "DD-MM-YYYY").format("YYYY-MM-DD")
        );
        $("#full-loan-form input[name='date_of_birth']").val(
          moment(document["date_of_birth"], "DD-MM-YYYY").format("YYYY-MM-DD")
        );
        $("#full-loan-form input[name='term_confirm']").prop("checked", true);
        $("input[tag='currency']").trigger("blur");
        $("input[name='range_loan_tenor']").trigger("input");
        $("input[name='range_loan_amount']").trigger("input");
        $(`input[name='simu_insurance']`)[0].value = "0";
        $(`input[name='simu_insurance']`)[1].value = "6";
        $(`input[name='simu_insurance']`)[2].value = "8";
        $(
          `input[name='simu_insurance'][value='${data.document.simu_insurance}']`
        )
          .click()
          .trigger("change");
        simulator();
        if (document["check_same_address"] == "on") {
          $("input[name='check_same_address']")
            .prop("checked", true)
            .trigger("change");
        } else {
          $("input[name='check_same_address']")
            .prop("checked", false)
            .trigger("change");
          $("select[name='permanent_province']")
            .val(document["permanent_province"])
            .trigger("change")
            .selectpicker("refresh");
          $("select[name='permanent_district']")
            .val(document["permanent_district"])
            .trigger("change")
            .selectpicker("refresh");
          $("select[name='permanent_ward']")
            .val(document["permanent_ward"])
            .trigger("change")
            .selectpicker("refresh");
        }
        try {
            $("#list_upload_docs").empty();
            let docs = '';
            document["list_doc_collecting"].forEach(element => {
                docs+= `
                <div class="mda-form-group label-floating">
                  <input value="${element.file_name}" type="text" class="mda-form-control ng-pristine ng-empty ng-invalid ng-touched" readonly>
                  <label style="font-size: large;">Mã chứng từ : ${element.file_type} </label>
                </div>`;
            });
            $("#list_upload_docs")[0].innerHTML = docs;
        } catch (error) {
          
        }
      } catch (error) {
        console.error("SyncFullLoanFromAPI error : ", error);
        swal(
          {
            title: "Không thành công!",
            text: "Lỗi:" + error.message,
            type: "error",
          },
          function () {
            // location.reload();
            // $(".preloader").fadeIn();
          }
        );
        return;
      }
    });
  } catch (err) {
    console.error("SyncFullLoanFromAPI error : ", err);
    swal(
      {
        title: "Không thành công!",
        text: "Lỗi:" + error.message,
        type: "error",
      },
      function () {
        // location.reload();
        // $(".preloader").fadeIn();
      }
    );
  }
};

function pmt(
  monthlyRate,
  monthlyPayments,
  presentValue,
  residualValue,
  advancedPayments
) {
  t1 = 1 + monthlyRate;
  t2 = Math.pow(t1, monthlyPayments);
  t3 = Math.pow(t1, monthlyPayments - advancedPayments);
  return (
    (presentValue - residualValue / t2) /
    ((1 - 1 / t3) / monthlyRate + advancedPayments)
  );
}
let simulator = (e) => {
  let sm_loan_amount = $("#full-loan-form input[name='loan_amount']").val();
  let sm_loan_tenor = $("#full-loan-form input[name='loan_tenor']").val();
  let sm_insu = $("input[name='simu_insurance']:checked").val();
  if (sm_insu == undefined) {
    $("input[name='simu_insurance']")[0].checked = true;
    sm_insu = 0;
  }
  let ir = selected_product.interest_rate;
  let sm_total_offer = parseInt(sm_loan_amount * (1 + sm_insu / 100)) + "";
  // let sm_monthly = parseInt(sm_total_offer / sm_loan_tenor) + "";
  // let sm_monthly = parseInt( (sm_total_offer / sm_loan_tenor) + sm_total_offer*(ir/100)/12)+ "";
  // pmt(0.35/12,0.5*12,10000000,1,0)
  let sm_monthly =
    parseInt(pmt(ir / 100 / 12, sm_loan_tenor, sm_total_offer, 1, 0)) + "";

  //
  $("#full-loan-form input[name='customer-offer-amount']")
    .val(sm_loan_amount.replace(/[^0-9\.]/g, "").replace(".", ""))
    .trigger("blur");
  $("#full-loan-form input[name='customer-offer-tenor']")
    .val(sm_loan_tenor.replace(/[^0-9\.]/g, "").replace(".", ""))
    .trigger("blur");
  $("#full-loan-form input[name='customer-offer-percent']").val(sm_insu + "%");
  $("#full-loan-form input[name='customer-offer-total']")
    .val(sm_total_offer.replace(/[^0-9\.]/g, "").replace(".", ""))
    .trigger("blur");
  $("#full-loan-form input[name='customer-offer-monthly']")
    .val(sm_monthly.replace(/[^0-9\.]/g, "").replace(".", ""))
    .trigger("blur");
  //
};
let removeElement = (btn_id) => {
  if ($("#" + btn_id) != null && $("#" + btn_id).length) {
    let elem = document.getElementById(btn_id);
    elem.parentElement.removeChild(elem);
  }
};
let changeLoanTennor = (e) => {
  e.form.loan_tenor.value = e.value;
  simulator(e);
};
let checkContract = (e) => {
  if (parseInt(e.form.from.value) < parseInt(e.form.from.min)) {
    e.form.from.value = e.form.from.min;
  }
  if (parseInt(e.form.from.value) > parseInt(e.form.from.max)) {
    e.form.from.value = e.form.from.max;
  }
  if (parseInt(e.form.to.value) < parseInt(e.form.to.min)) {
    e.form.to.value = e.form.from.min;
  }
  if (parseInt(e.form.to.value) > parseInt(e.form.to.max)) {
    e.form.to.value = e.form.from.max;
  }
  let fr = e.form.from.value;
  let to = e.form.to.value;
  let ct = to - fr;
  if (ct < 0) {
    ct = 0;
  }
  e.form.contract_term.value = ct;
};

let triggerMinMax = (e) => {
  if (parseInt(e.value) < parseInt(e.min)) {
    e.value = e.min;
  }
  if (parseInt(e.value) > parseInt(e.max)) {
    e.value = e.max;
  }
};
let checkminmax = (e) => {
  if (parseInt(e.value) < parseInt(e.min)) {
    e.value = e.min;
    simulator(e);
  }
  if (parseInt(e.value) > parseInt(e.max)) {
    e.value = e.max;
    simulator(e);
  }
};
let changeLoanTennorRange = (e) => {
  e.form.range_loan_tenor.value = e.value;
  simulator(e);
};
let changeLoanAmount = (e) => {
  e.form.loan_amount.value = e.value;
  simulator(e);
};
let changeLoanAmountRange = (e) => {
  e.form.range_loan_amount.value = e.value;
  simulator(e);
};
let getLeadInfo = (lead_id) => {
  clearForm($(".formMain"));
  $("#app_status_block").removeClass("app_status")
    $("#app_reason").addClass("hiden")
  var postData = {
    goAction: "goGetLead",
    goLeadID: lead_id,
    responsetype: "json",
  };
  $.ajax({
    type: "POST",
    url: goAPI + "/goLoadLeads/goAPI.php",
    processData: true,
    data: postData,
    dataType: "json",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
  })
    .done(function (result) {
      if (result.result != "success") {
        swal("Get products data fail!", "Lead not found", "error");
        return;
      }
      let lead_info = result.data;
      let basic = result.basic_requestid;
      SyncCustomerInfomation(lead_info,basic);
    })
    .fail(function (result) {
      console.log(result);
    });
};

let ShowStatusOnForm = (prev_status, call_status, app_status, reason = "") => {
  let rj_message = DSA_STATUS[reason];
  if (
    rj_message == "" ||
    rj_message == undefined ||
    reason == "" ||
    reason == undefined
  ) {
    $("#app_status_block").removeClass("app_status");
    $("#app_reason").addClass("hiden");
  } else {
    $("#app_status_block").addClass("app_status");
    $("#app_reason").removeClass("hiden");
    $("#app_reason").text(reason + " : " + rj_message);
  }
  let status = call_status != "" ? call_status : prev_status;
  ajaxGetCallStatus(status).done((result) => {
    $("#name_form input[name='prev_status']").val(result.data.status_name);
  });
  $("#name_form input[name='app_status']").val(app_status);
};

let ajaxGetCallStatus = (status) => {
  return $.ajax({
    type: "GET",
    url: CRM_API_URL + `/v1/status/${status}`,
    async: true,
    dataType: "json",
    headers: {
      "Content-Type": "application/json",
    },
  }).fail((result, status, error) => {
    console.warn("ajaxGetCallStatus: ", result);
  });
};
let SyncCustomerInfomation = (thisVdata,basic_requestid) => {
  $("#custormer_tab").click();
  LeadPrevDispo = thisVdata.status;
  ShowStatusOnForm(
    LeadPrevDispo,
    thisVdata.call_status,
    thisVdata.app_status,
    thisVdata.reject_reason
  );
  // $(".formMain input[name='vendor_lead_code']").val(thisVdata.vendor_lead_code);
  cust_phone_code = thisVdata.phone_code;
  $(".formMain input[name='phone_code']")
    .val(cust_phone_code)
    .trigger("change");
  cust_phone_number = thisVdata.phone_number;
  $(".formMain input[name='phone_number']")
    .val(cust_phone_number)
    .trigger("change");
  if (cust_phone_number === "" && thisVdata.alt_phone !== "") {
    cust_phone_number = thisVdata.alt_phone;
    $(".formMain input[name='phone_number']")
      .val(cust_phone_number)
      .trigger("change");
  }
  if (cust_phone_number === "" && thisVdata.address3 !== "") {
    cust_phone_number = thisVdata.address3;
    $(".formMain input[name='phone_number']")
      .val(cust_phone_number)
      .trigger("change");
  }
  $(".formMain input[name='title']").val(thisVdata.title);
  cust_first_name = thisVdata.first_name;
  if (cust_first_name !== "") {
    //$("#cust_full_name a[id='first_name']").editable('setValue', cust_first_name, true);
    $(".formMain input[name='first_name']")
      .val(cust_first_name)
      .trigger("change");
    $("#cust_full_name a[id='first_name']").html(cust_first_name);
  } else {
    //$("#cust_full_name a[id='first_name']").editable('setValue', null, true);
    $("#cust_full_name a[id='first_name']").html("");
  }
  cust_middle_initial = thisVdata.middle_initial;
  if (cust_middle_initial != "") {
    //$("#cust_full_name a[id='middle_initial']").editable('setValue', cust_middle_initial, true);
    $(".formMain input[name='middle_initial']")
      .val(cust_middle_initial)
      .trigger("change");
    $("#cust_full_name a[id='middle_initial']").html(cust_middle_initial);
  } else {
    //$("#cust_full_name a[id='middle_initial']").editable('setValue', null, true);
    $("#cust_full_name a[id='middle_initial']").html("");
  }
  cust_last_name = thisVdata.last_name;
  if (cust_last_name !== "") {
    //$("#cust_full_name a[id='last_name']").editable('setValue', cust_last_name, true);
    $(".formMain input[name='last_name']")
      .val(cust_last_name)
      .trigger("change");
    $("#cust_full_name a[id='last_name']").html(cust_last_name);
  } else {
    //$("#cust_full_name a[id='last_name']").editable('setValue', null, true);
    $("#cust_full_name a[id='last_name']").html("");
  }
  //EASY CREDIT
  //Identity
  $(".formMain input[name='identity_number']")
    .val(thisVdata.identity_number)
    .trigger("change");
  $(".formMain input[name='identity_issued_on']").val(
    thisVdata.identity_issued_on
  );
  $(".formMain select[name='identity_issued_by']")
    .val(thisVdata.identity_issued_by)
    .trigger("change");
  try {
    $(".formMain input[name='alt_identity_number']")
      .val(thisVdata.alt_identity_number)
      .trigger("change");
    $(".formMain input[name='alt_identity_issued_on']").val(
      thisVdata.alt_identity_issued_on
    );
    $(".formMain select[name='alt_identity_issued_by']")
      .val(thisVdata.alt_identity_issued_by)
      .trigger("change");
  } catch (error) {}
  //Vendor
  $(".formMain input[name='vendor_lead_code']")
    .val(thisVdata.vendor_lead_code)
    .trigger("change");
  $(".formMain input[name='partner_code']")
    .val(thisVdata.partner_code)
    .trigger("change");
  $(".formMain input[name='request_id']")
    .val(thisVdata.request_id)
    .trigger("change");
    $(".formMain input[name='address1']").val(thisVdata.address1).trigger('change');
    $(".formMain input[name='address2']").val(thisVdata.address2).trigger('change');
    $(".formMain input[name='city']").val(thisVdata.city).trigger('change');
    $(".formMain input[name='province']").val(thisVdata.province).trigger('change');
    $(".formMain input[name='postal_code']").val(thisVdata.postal_code).trigger('change');
    $(".formMain select[name='country_code']").val(thisVdata.country_code).trigger('change');
    $(".formMain select[name='gender']").val(thisVdata.gender).trigger('change');
    var dateOfBirth = thisVdata.date_of_birth;
    $(".formMain input[name='date_of_birth']").val(dateOfBirth);
    $(".formMain input[name='alt_phone']").val(thisVdata.alt_phone).trigger('change');
    $(".formMain input[name='email']").val(thisVdata.email).trigger('change');
    $(".formMain select[name='basic_request_id']").html("");
    basic_requestid.forEach(element => {
        let tmp = $(".formMain select[name='basic_request_id']").html();
        $(".formMain select[name='basic_request_id']").html(tmp+`<option value='${element.request_id}' selected>${element.request_id}</option>`)
    });
    var REGcommentsNL = new RegExp("!N!","g");
    if (typeof thisVdata.comments !== 'undefined') {
        thisVdata.comments = thisVdata.comments.replace(REGcommentsNL, "\n");
    }
    $(".formMain textarea[name='comments']").val(thisVdata.comments).trigger('change');
    // $(".formMain textarea[name='call_notes']").val(thisVdata.call_notes).trigger('change');
    
};
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
  ajaxGetECProducts("TEL", "TEL123456789");
  $("input[type='checkbox'][name='check_same_address']").on("change", (e) => {
    CheckBoxSyncFieldFullLoan(
      $("#full-loan-form input[name='check_same_address']").is(":checked")
    );
  });
  let live_province = $("select[name='live_province']")[0];
  $(`<option value="" selected></option>`).appendTo(live_province);
  for (const [key, value] of Object.entries(PROVINCE)) {
    $(`<option value="${key}">${value}</option>`).appendTo(live_province);
  }
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
  SetPermanentAddress();
  SetTemAddress();
  SetWorkAddress();

  $(document).on("blur", 'input[type="date"]', function () {
    var cur_date = new Date($(this)[0].value);
    var today = new Date();
    var yesterday = new Date(today);
    yesterday.setDate(yesterday.getDate() - 1);
    if (cur_date < new Date("1900-01-01") || cur_date > new Date(yesterday)) {
      sweetAlert("Thời gian không được nhỏ hơn 1900 và lớn hơn ngày hôm qua");
    }
  });
  $(document).on("blur", 'input[tag="phone"]', function () {
    let phone_number = $(this)[0].value;
    var vnf_regex = /((09|03|07|08|05)+([0-9]{8})\b)/g;
    if (phone_number !== "") {
      if (vnf_regex.test(phone_number) == false) {
        sweetAlert("Số điện thoại của bạn không đúng định dạng!");
      }
    }
  });

  $(document).on("change", 'select[name="disbursement_method"]', function () {
    let dis_method = this.value;
    let req = false;
    if (dis_method == "bank") {
      req = true;
    }
    $("#full-loan-form select[name='bank_code']").attr("required", req);
    $("#full-loan-form select[name='bank_area']").attr("required", req);
    $("#full-loan-form select[name='bank_branch_code']").attr("required", req);
    $("#full-loan-form input[name='bank_account']").attr("required", req);
    $("#disbursement_method_bank").attr("hidden", !req);
  });
  $(document).on("change", 'select[name="product_type"]', function (e) {
    let product_code = this.value;
    $("input[name='simu_insurance']")[0].checked = true;
    selected_employment_type.product_list.forEach((prd) => {
      if (prd.product_code == product_code) {
        selected_product = prd;
        // Loan tenor
        $("#full-loan-form input[name='range_loan_tenor']")[0].max =
          prd.loan_max_tenor;
        $("#full-loan-form input[name='range_loan_tenor']")[0].min =
          prd.loan_min_tenor;
        $("#full-loan-form input[name='range_loan_tenor']")[0].value =
          prd.loan_min_tenor;
        //
        $("#full-loan-form input[name='loan_tenor']")[0].max =
          prd.loan_max_tenor;
        $("#full-loan-form input[name='loan_tenor']")[0].min =
          prd.loan_min_tenor;
        $("#full-loan-form input[name='loan_tenor']")[0].value =
          prd.loan_min_tenor;
        //
        // Loan amount
        $("#full-loan-form input[name='range_loan_amount']")[0].max =
          prd.loan_max_amount;
        $("#full-loan-form input[name='range_loan_amount']")[0].min =
          prd.loan_min_amount;
        $("#full-loan-form input[name='range_loan_amount']")[0].value =
          prd.loan_min_amount;
        //
        $("#full-loan-form input[name='loan_amount']")[0].max =
          prd.loan_max_amount;
        $("#full-loan-form input[name='loan_amount']")[0].min =
          prd.loan_min_amount;
        $("#full-loan-form input[name='loan_amount']")[0].value =
          prd.loan_min_amount;
        //
        simulator(e);
        return;
      }
    });
    if (selected_employment_type.employee_type != "SE") {
      $("#bussiness_se").attr("hidden", true);
    } else {
      $("#bussiness_se").attr("hidden", false);
    }
  });
  $(document).on("click", 'input[name="simu_insurance"]', function (e) {
    simulator(e);
  });
  $(document).on("click", 'button[tag="btn_detail"]', function (e) {
    let request_id = $(this).attr("request_id");
    let lead_id = $(this).attr("lead_id");
    SyncFullLoanFromAPI(request_id);
    getLeadInfo(lead_id);
  });
  $(document).on("change", 'select[name="employment_type"]', function () {
    selected_employment_type = null;
    let em_type = this.value;
    if (ECProducts != undefined) {
      ECProducts.forEach((et) => {
        if (et.employee_type == em_type) {
          selected_employment_type = et;
          let product_lists = et.product_list.sort(function (a, b) {
            return a.product_code.localeCompare(b.product_code);
          });
          let select_product_type = $("select[name='product_type']")[0];
          select_product_type.innerHTML = "";
          $(`<option value=""></option>`).appendTo(select_product_type);
          for (prd of product_lists) {
            $(
              `<option des="${prd.product_description}" value="${prd.product_code}">${prd.product_code} - ${prd.product_description}</option>`
            ).appendTo(select_product_type);
          }
          return;
        }
      });
    }
  });
  console.log("sale_application.js");
  $("#smartwizard").smartWizard("reset");

  $("#smartwizard").smartWizard({
    selected: 0,
    theme: "arrows",
    lang: {
      next: "Tiếp tục",
      previous: "Lùi lại",
    },
    transition: {
      animation: "none",
      speed: "400", // Transion animation speed
      easing: "", // Transition animation easing. Not supported without a jQuery easing plugin
    },
    toolbarSettings: {
      toolbarExtraButtons: [],
    },
    anchorSettings: {
      anchorClickable: true, // Enable/Disable anchor navigation
      enableAllAnchors: true, // Activates all anchors clickable all times
      markDoneStep: true, // Add done state on navigation
      markAllPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
      removeDoneStepOnNavigateBack: false, // While navigate back done step after active step will be cleared
      enableAnchorOnDoneStep: true, // Enable/Disable the done steps navigation
    },
    keyboardSettings: {
      keyNavigation: false,
    },
    enableURLhash: false,
  });
  $("#smartwizard").on(
    "showStep",
    function (e, anchorObject, stepNumber, stepDirection) {
      if (stepDirection == "forward" && stepNumber == 4) {
        if ($(".btn.sw-btn-finish").hasClass("disabled")) {
          $(".btn.sw-btn-finish").removeClass("disabled");
        }
      }
      // if($('.btn.sw-btn-save').hasClass('disabled')){
      //     $('.btn.sw-btn-save').removeClass('disabled');
      // }
    }
  );
  filterchange();
  // NOT CHECK YET
  // on tab change, change sidebar
  $('a[data-toggle="tab"]').on("shown.bs.tab", function (e) {
    var target = $(e.target).attr("href"); // activated tab

    if (target == "#list_app_tab") {
      $("#list_app_tab").show();
      $("#application_detail_tab").hide();
      $("#legend_title").text("List Sale Application");
    }
    if (target == "#application_detail_tab") {
      $("#application_detail_tab").show();
      $("#list_app_tab").hide();
      $("#legend_title").text("Application Detail");
    }
  });
  $("#btn_filter").on("click", function () {
    filterchange();
  });
 
  if (window.location.href.indexOf("application_detail_tab") > -1) {
    $("#application_detail_tab").show();
    $("#list_app_fab").hide();
    $("#legend_title").text("Application Detail");
  }
});
