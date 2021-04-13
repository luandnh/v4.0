const EC_API_URL = "http://localhost:8000";
const TEL4VN_API_URL = "http://localhost:8000";
const EC_API_USERNAME = "";
const EC_API_PASSWORD = "";
const EC_API_TOKEN = "";

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
  let fullLoanTab =
    '<li role="presentation" id="full_loan_tab_href">' +
    '<a href="#full-loan" aria-controls="home" role="tab" data-toggle="tab" class="bb0">' +
    '<span class="fa fa-file-text-o hidden"></span>' +
    "Full Loan</a>" +
    "</li>";
  $("#agent_tablist").append(fullLoanTab);
  clearForm($("#full-loan-form"));
});

let ECShowProducts = (partner_code, request_id) => {
  $("#hide_div_eligible").hide();
  removeElement("submit_fullloan_btn");
  removeElement("product_tab_href");
  clearForm($("#full-loan-form"));
  if (request_id != "" && request_id.length > 0) {
    SyncFullLoanFromAPI(request_id);
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
    ajaxGetECProducts(partner_code).done((result) => {
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
          console.log(product.document_collecting);
          let table = $("#productTable" + index).DataTable({
            destroy: true,
            responsive: true,
            data: product.document_collecting,
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
              $("#product-detail-form").empty();
              let tmp_data = table.row($(this).closest("tr")).data();
              for (const property in tmp_data) {
                if (!Array.isArray(tmp_data[property])) {
                  let name = property.split("_");
                  let property_name = "";
                  name.forEach((elem) => {
                    property_name += capitalize(elem) + " ";
                  });
                  property_name = property_name.trim();
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
                  let tmp_div =
                    '<div class="form-group">' +
                    `<label for="${property}" class="col-form-label">${property_name}</label>` +
                    `<input id="${property}" type="text" class="form-control" readonly value="${value}">` +
                    "</div>";
                  $("#product-detail-form").append(tmp_div);
                } else {
                  tmp_data[property].forEach((elem) => {
                    let table_index = 0;
                    for (const prop in elem) {
                      if (!Array.isArray(elem[prop])) {
                        let name = prop.split("_");
                        let property_name = "";
                        name.forEach((elem) => {
                          property_name += capitalize(elem) + " ";
                        });
                        property_name = property_name.trim();
                        let value = elem[prop];
                        let tmp_div =
                          '<div class="form-group">' +
                          `<label for="${prop}" class="col-form-label">${property_name}</label>` +
                          `<input id="${prop}" type="text" class="form-control" readonly value="${value}">` +
                          "</div>";
                        $("#product-detail-form").append(tmp_div);
                      } else {
                        table_index++;
                        let tmp_table =
                          `<table id="tableProductDetail${table_index}" class="display responsive no-wrap table table-responsive table-striped table-bordered" width="100%">` +
                          "</table>";
                        $("#product-detail-table").append(tmp_table);
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
                  // <table id="product-detail-table" class="display responsive no-wrap table table-responsive table-striped table-bordered" width="100%">
                  // </table>
                }
                console.log(`${property}: ${tmp_data[property]}`);
              }
              $("#product-detail-modal").modal("show");
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
};
let ECProducts = null;

let ajaxGetECProducts = (partner_code) => {
  let postdata = {
    partner: partner_code,
  };
  return $.ajax({
    type: "POST",
    url: EC_API_URL + "/v1/dev/product",
    processData: true,
    data: postdata,
    async: true,
    dataType: "json",
    headers: {
      "Content-Type": "application/json",
    },
  }).fail((result, status, error) => {
    console.log(result);
    let msg = "Please contact developer!";
    if (result.message !== undefined) {
      msg = result.message;
    }
    swal("Get products data fail!", msg, "error");
  });
};

$("#eligible_btn").on("click", (e) => {
  e.preventDefault();
  let partner_code = $(".formMain input[name='partner_code']").val();
  if (partner_code.length < 1) {
    swal("Error!", "Partner Code is empty!", "error");
  } else {
    let request_id = partner_code + Date.now().toString();
    let first_name = $(".formMain input[name='first_name']").val();
    let middle_initial = $(".formMain input[name='middle_initial']").val();
    let last_name = $(".formMain input[name='last_name']").val();
    let customer_name = last_name + " " + middle_initial + " " + first_name;
    let phone_number =
      $(".formMain input[name='phone_code']").val() +
      $(".formMain input[name='phone_number']").val();
    let date_of_birth = $(".formMain input[name='date_of_birth']").val();
    let issue_date = $(".formMain input[name='identity_issued_on']").val();
    date_of_birth = moment(date_of_birth, "YYYY-MM-DD").format("DD-MM-YYYY");
    issue_date = moment(issue_date, "YYYY-MM-DD").format("DD-MM-YYYY");
    let eligible_data = {
      request_id: request_id,
      channel: partner_code,
      partner_code: partner_code,
      dsa_agent_code: "",
      identity_card_id: $(".formMain input[name='identity_number']").val(),
      date_of_birth: date_of_birth,
      customer_name: customer_name,
      issue_date: issue_date,
      phone_number: phone_number,
      issue_place: $(".formMain input[name='identity_issued_by']").val(),
      email: $(".formMain input[name='email']").val(),
    };
    console.log(eligible_data);
    $.ajax({
      type: "POST",
      url: EC_API_URL + "/v1/dev/eligible",
      processData: true,
      data: JSON.stringify(eligible_data),
      async: true,
      dataType: "json",
      headers: {
        "Content-Type": "application/json",
      },
    })
      .fail((result, status, error) => {
        console.log(result);
        let msg = "Please contact developer!";
        if (result.message !== undefined) {
          msg = result.message;
        }
        swal("Send eligible data fail!", msg, "error");
      })
      .done((result) => {
        console.log(result);
        if (result.code == "ELIGIBLE") {
          $(".formMain input[name='request_id']").val(result.data.request_id);
          swal("Success", result.message, "success");
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

$("#full-loan-form input[name='check_same_address']").on("change", (e) => {
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
    issue_place: $(".formMain input[name='identity_issued_by']").val(),
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
};

function clearForm($form) {
  $form
    .find(":input")
    .not(":button, :submit, :reset, :hidden, :checkbox, :radio")
    .val("");
  $form.find(":checkbox, :radio").prop("checked", false);
}

$("#full-loan-form").on("submit", (e) => {
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
  let post_data = JSON.stringify(form_data);
  $.ajax({
    type: "POST",
    url: EC_API_URL + "/v1/dev/fullloan",
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
      let msg = "Please contact developer!";
      if (result.message !== undefined) {
        msg = result.message;
      }
      swal("Send full-loan data fail!", msg, "error");
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
          PollingOfferFromEC(form_data.request_id);
        }, 5000);
      } else {
        swal("Error!", "Send full-loan data fail!", "error");
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
let IsSuccessPolled = false;
let PolledTotal = 1;
let PolledOfferInterval = null;
function PollingOfferFromEC(request_id) {
  PolledTotal++;
  if (IsSuccessPolled === false && PolledTotal < 180) {
    ajaxGetOffer(request_id).done((result) => {
      if (result.data.document != undefined && result.data.document != null) {
        IsSuccessPolled = true;
        offer = result.data.document;
        offerList = offer.data.offer_list;
        SetOfferDetail(offerList);
      }
    });
  } else {
    clearInterval(PolledOfferInterval);
  }
}

function SetOfferDetail(offerList) {
  console.log(offerList);
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
        data: "offer_tenor",
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
        data: "offer_variant",
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
    let tmp_data = offerTable.row($(this).closest("tr").prev()[0]).data();
    $("#offer-insurance-list-table").DataTable({
      destroy: true,
      responsive: true,
      searching: false,
      lengthChange: false,
      data: tmp_data.insurance_list,
      columns: [
        {
          title: "Type",
          data: "insurance_type",
        },
        {
          title: "Amount",
          data: "insurance_amount",
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
          data: "percentage_insurance",
          render: (data) => {
            return data * 100 + "%";
          },
        },
        {
          title: "Base Calculation",
          data: "base_calculation",
        },
      ],
    });
  });
}

function capitalize(string) {
  return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
}
