const CRM_API_HOST = "https://ec-api-dev.tel4vn.com/ec";
const DEBT_API_HOST = "https://uatapis.easycredit.vn"
const PARTNER_CODE = "TEL";
const LANGUAGE = {
  "Data not found by search anything field":"Dữ liệu không được tìm thấy bằng cách tìm kiếm bất kỳ trường nào"
}
function currency_vnd(x) {
  return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",")+"đ";
}
var DEBT_RESTUCT_DATA = null;
var PIC_IMAGE = "";
var ID_CARD_IMAGE = "";
function error_msg(msg, seconds = 2500, title = "Lỗi")
{
  tata.error(title, msg, {
    position: 'tl', animate: 'slide', duration: seconds
  })
}
function info_msg(msg, seconds = 2500, title = "Thông báo")
{
  tata.info(title, msg, {
    position: 'tl', animate: 'slide', duration: seconds
  })
}
let upload_pic_image = function ()
{
  if (PIC_IMAGE != "") {
    return;
  }
  let fileIn = $(`#debt-restruct #updated_info input[name='pic_image']`)[0].files[0];
  const reader = new FileReader();
  reader.addEventListener("load", function ()
  {
    info_msg("Thành công", 1000, "Tải chân dung");
    PIC_IMAGE = reader.result;
  }, false);
  if (fileIn) {
    reader.readAsDataURL(fileIn);
  }
}
let upload_id_image = function ()
{
  if (ID_CARD_IMAGE != "") {
    return;
  }
  let fileIn = $(`#debt-restruct #updated_info input[name='id_card_image']`)[0].files[0];
  const reader = new FileReader();
  reader.addEventListener("load", function ()
  {
    info_msg("Thành công", 3000, "Tải CMND/CCCD");
    ID_CARD_IMAGE = reader.result;
  }, false);
  if (fileIn) {
    reader.readAsDataURL(fileIn);
  }
}
let SetPaymentTerm = (term_arr) =>
{
  let paymentSelect = $("select[name='ext_payment_term']");
  paymentSelect.empty();
  for (let t = 0; t < term_arr.length; t++) {
    $(`<option value="${term_arr[t]}">${term_arr[t]}</option>`).appendTo(paymentSelect);
  }
}
function clearFormDebt(clear_all = false)
{
  if (clear_all) {
    let exist_contracts = $("select[name='exist_contract_number']");
    exist_contracts.empty();
    $(`<option cust_id ="" value="" selected>Trống</option>`).appendTo(exist_contracts);
    exist_contracts.trigger('change');
  }
  $("#customer_info")
    .find(":input")
    .not(":button,:reset, :hidden, :checkbox, :radio")
    .val("");
  $("#debt_restructuring")
    .find(":input")
    .not(":button,:reset, :hidden, :checkbox, :radio")
    .val("");
  $("#loan_info")
    .find(":input")
    .not(":button,:reset, :hidden, :checkbox, :radio")
    .val("");
  $("#current_request")
    .find(":input")
    .not(":button,:reset, :hidden, :checkbox, :radio")
    .val("");
  $("#updated_info")
    .find(":input")
    .not(":button,:reset, :hidden, :checkbox, :radio")
    .val("");
}
let SetExistCustomer = (cust_arr) =>
{
  DEBT_RESTUCT_DATA = {}
  let exist_contracts = $("select[name='exist_contract_number']");
  exist_contracts.empty();
  $(`<option cust_id ="" value="" selected>Trống</option>`).appendTo(exist_contracts);
  cust_arr.forEach(element =>
  {
    DEBT_RESTUCT_DATA[element.loan_info.contract_number] = element;
    $(`<option cust_id ="${element.customer_info.cust_id}" value="${element.loan_info.contract_number}">${element.loan_info.contract_number}</option>`).appendTo(exist_contracts);
  });

  $("#debt-restruct select[name='exist_contract_number']").on("change", (e) =>
  {
    let tmp = $("select[name='exist_contract_number'] :selected").attr("cust_id");
    $("#debt_customer_list input[name='exist_cust_id']").val(tmp);
    FillDebtForm(DEBT_RESTUCT_DATA[$("select[name='exist_contract_number'] :selected").val()]);
  });
  if (cust_arr.length > 0) {
    let opts = $("select[name='exist_contract_number']")[0];
    opts[opts.length - 1].selected = true;
    $("select[name='exist_contract_number']").trigger('change');
  }
}
let SetComapyAddress = () =>
{
  var companyProvince = $("#debt-restruct select[name='company_province']");
  var companyDistrict = $("#debt-restruct select[name='company_district']");
  var companyWard = $("#debt-restruct select[name='company_ward']");

  companyProvince.select2({ tags: true });
  companyDistrict.select2({ tags: true });
  companyWard.select2({ tags: true });
  $(`<option value="" selected></option>`).appendTo(companyProvince);
  $(`<option value="" selected></option>`).appendTo(companyWard);
  for (const [key, value] of Object.entries(PROVINCE)) {
    $(`<option value="${key}">${value}</option>`).appendTo(companyProvince);
  }
  // 
  $("#debt-restruct select[name='company_province']").on("change", (e) =>
  {
    let province_id = companyProvince.val();
    companyDistrict.empty();
    companyWard.empty();
    $(`<option value="" selected></option>`).appendTo(companyDistrict);
    $(`<option value="" selected></option>`).appendTo(companyWard);
    if (province_id != "") {
      for (const [key, value] of Object.entries(DISTRICT)) {
        if (value.province_id == province_id) {
          $(`<option value="${key}">${value.district_name}</option>`).appendTo(companyDistrict);
        }
      }
    }
  });
  // 
  $("#debt-restruct select[name='company_district']").on("change", () =>
  {
    let districtID = companyDistrict.val();
    console.info(districtID);
    companyWard.empty();
    $(`<option value="" selected></option>`).appendTo(companyWard);
    if (districtID != "") {
      for (const [key, value] of Object.entries(WARD)) {
        if (value.district_id == districtID) {
          $(`<option value="${key}">${value.ward_name}</option>`).appendTo(companyWard);
        }
      }
    }
  });
};
let translate = function (input)
{
  let text = LANGUAGE[input];
  if (text == "" || text == undefined) {
    return input;
  }
  return text;
}
let generate_requestID = () =>
{
  return PARTNER_CODE + new Date().getTime();
}
$.fn.serializeObject = function ()
{
  var o = {};
  var a = this.serializeArray();
  $.each(a, function ()
  {
    if (o[this.name]) {
      if (!o[this.name].push) {
        o[this.name] = [o[this.name]];
      }
      o[this.name].push(this.value || '');
    } else {
      o[this.name] = this.value || '';
    }
  });
  return o;
};
function getDateNow()
{
  var today = new Date();
  var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
  var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
  var dateTime = date + ' ' + time;
  return dateTime
}
function create_debt_restructing()
{
  let debtTab =
    '<li  style="border: 1px solid #b0b0b0ad;border-radius: 5px;font-family: Helvetica !important;font-size: large;" role="presentation" id="debt-restruct_href">' +
    '<a href="#debt-restruct" aria-controls="home" role="tab" data-toggle="tab" class="bb0">' +
    '<span class="fa fa-file-text-o hidden"></span>' +
    "Cơ cấu nợ</a>" +
    "</li>";
  $("#agent_tablist").append(debtTab);
}


let ajaxGetToken = () =>
{
  return $.ajax(settings = {
    "url":  DEBT_API_HOST+"/aaa/v02/oauth2/token",
    "method": "POST",
    "timeout": 0,
    "headers": {
      "Authorization": "Basic dGVsNHZuOjdIbEgjcHJMZG9zdw==",
      "Content-Type": "application/x-www-form-urlencoded"
    },
    "data": {
      "grant_type": "client_credentials"
    }
  }).fail((result, status, error) =>
  {
    console.log("Query error : ", result);
    error_msg("Không thể xác thực");
  });
};

let ajaxQueryCI = (body_data) =>
{
  let access_token = body_data.access_token;
  if (access_token == "" || access_token == undefined) {
    error_msg("Không thể xác thực")
    return;
  }
  console.log("Query body", body_data);
  return $.ajax({
    type: "POST",
    method: "POST",
    url:  DEBT_API_HOST+"/los-united/v1/debt-restructuring/customer-info",
    processData: true,
    async: true,
    dataType: "json",
    "headers": {
      "Authorization": "Bearer " + access_token,
      "Content-Type": "application/json"
    },
    data: JSON.stringify(body_data),
  }).fail((result, status, error) =>
  {
    console.log("Query error : ", result);
  });
};

function FillDebtForm(json_data)
{
  if (json_data == null || json_data == undefined) {
    clearFormDebt();
    return;
  }
  try {
    Object.keys(json_data).forEach((val, ix) =>
    {
      let per_form = json_data[val];
      let form_name = val;
      Object.keys(json_data[val]).forEach((key, iy) =>
      {
        $(`#${form_name} input[name='${key}']`).val(per_form[key]);
      })
    })
    // $(`#debt-restruct select[name='ext_payment_term']`).val(json_data.debt_restructuring.ext_payment_term).trigger('change');
    SetPaymentTerm(json_data.debt_restructuring.ext_payment_term);
    $(`#debt-restruct select[name='company_province']`).val(json_data.updated_info.company_province).trigger('change');;
    $(`#debt-restruct select[name='company_district']`).val(json_data.updated_info.company_district).trigger('change');;
    $(`#debt-restruct select[name='company_ward']`).val(json_data.updated_info.company_ward).trigger('change');;
    $(`#customer_info input`).attr('readonly', true).attr('disabled', true);
    $(`#current_request input`).attr('readonly', true).attr('disabled', true);
    $(`#debt_restructuring input`).attr('readonly', true).attr('disabled', true);
    $(`#loan_info input`).attr('readonly', true).attr('disabled', true);
    $(`#debt input[tag='currency2']`).trigger("blur");
  } catch (error) {
    console.log("FillDebtForm", error)
  }
}
function CreateDebtFullData(body_object)
{
  ajaxGetToken().done((token_result) =>
  {
    let access_token = token_result.access_token;
    body_object['access_token'] = access_token;
    ajaxQueryCI(body_object).done((result) =>
    {
      console.log("Query response", result);
      let request_id = $(`#debt-restruct input[name='request_id']`).val();
      if (request_id == "" || request_id == undefined) {
        request_id = generate_requestID();
        $(`#debt-restruct input[name='request_id']`).val(request_id);
      }
      if (result.code == 0) {
        // Is array data
        let json_data = null;
        if (result.data.constructor.name == "Object") {
          json_data = result.data;
        } else if (result.data.constructor.name == "Array") {
          if (result.data.length == 0) {
            error_msg("Không tìm thấy khách hàng");
            return;
          }
          else {
            if (result.data.length > 1) {
              info_msg("Vui lòng chú ý !", 2000, "Có nhiều hơn một khách hàng được tìm thấy");
            }
            SetExistCustomer(result.data);
            return;
          }
        } else {
          error_msg("Không xác định được kiểu dữ liệu");
          return;
        }
        // 
        FillDebtForm(json_data)
      } else {
        error_msg(`${translate(result.message)}`, 2500,"Không thành công");
        return;
      }
    });
  });
}
function create_debt_info(body_data, save_type)
{
  let saveSetting = {
    "url": CRM_API_HOST+ "/restruct",
    "method": "POST",
    "timeout": 0,
    "headers": {
      "Content-Type": "application/json"
    },
    "data": JSON.stringify({
      "lead_id": body_data.lead_id + "",
      "user": body_data.user,
      "request_id": body_data.request_id,
      "status": save_type,
      "document": body_data.document,
      "request_ref": body_data.request_ref,
      "create_type": save_type
    }),
  };
  $.ajax(saveSetting).done(function (response)
  {
    console.log("Save debt",response);
  }).fail(function (response)
  {
    console.log("Save debt",response);
  });
}
let validate_emi_info = function ()
{
  let emi_info = {};
  let contract_number = $(`#debt-restruct input[name='contract_number']`).val();
  let ext_payment_term = $(`#debt-restruct select[name='ext_payment_term']`).val();
  let cus_id = $(`#debt-restruct input[name='cust_id']`).val();
  if (contract_number == "" || contract_number == undefined) {
    error_msg(`Thiếu thông tin: ${translate('contract_number')}`)
    return false;
  } else {
    emi_info["contract_number"] = contract_number;
  }
  if (ext_payment_term == "" || ext_payment_term == undefined) {
    error_msg(`Thiếu thông tin: ${translate('ext_payment_term')}`)
    return false;
  } else {
    emi_info["tenorDebtStruct"] = ext_payment_term;
  }

  if (cus_id == "" || cus_id == undefined) {
    error_msg(`Thiếu thông tin: ${translate('cus_id')}`)
    return false;
  } else {
    emi_info["cus_id"] = cus_id;
  }
  if ($("#customer_info input[name='phone_number']").val() != "") {
    emi_info["phone_number"] = $("#customer_info input[name='phone_number']").val();
  }
  if ($("#customer_info input[name='identity_card']").val() != "") {
    emi_info["identity_card"] = $("#customer_info input[name='identity_card']").val();
  }
  emi_info["date"] = getDateNow();
  return emi_info;
}
let validate_debt_restruct_request_data = () =>
{
  let request_id = $(`#debt-restruct input[name='request_id']`).val();
  if (request_id == "" || request_id == undefined) {
    request_id = generate_requestID();
  }
  let contract_number = $(`#debt-restruct input[name='contract_number']`).val();
  if (contract_number == "" || contract_number == undefined) {
    error_msg(`Thiếu ${translate('contract_number')}`);
    return false;
  }
  let cust_id = $(`#debt-restruct input[name='cust_id']`).val();
  if (cust_id == "" || cust_id == undefined) {
    error_msg(`Thiếu ${translate('cust_id')}`);
    return false;
  }
  let job_type = $(`#debt-restruct #updated_info input[name='job_type']`).val();
  if (job_type == "" || job_type == undefined) {
    error_msg(`Thiếu ${translate('job_type')}`);
    return false;
  }
  let company_address = $(`#debt-restruct input[name='company_address']`).val();
  if (company_address == "" || company_address == undefined) {
    error_msg(`Thiếu ${translate('company_address')}`);
    return false;
  }
  let company_name = $(`#debt-restruct #updated_info input[name='company_name']`).val();
  if (company_name == "" || company_name == undefined) {
    error_msg(`Thiếu ${translate('company_name')}`);
    return false;
  }
  let company_province = $(`#debt-restruct select[name='company_province']`).val();
  if (company_province == "" || company_province == undefined) {
    error_msg(`Thiếu ${translate('company_province')}`);
    return false;
  }
  let company_ward = $(`#debt-restruct select[name='company_ward']`).val();
  if (company_ward == "" || company_ward == undefined) {
    error_msg(`Thiếu ${translate('company_ward')}`);
    return false;
  }
  let company_district = $(`#debt-restruct select[name='company_district']`).val();
  if (company_district == "" || company_district == undefined) {
    error_msg(`Thiếu ${translate('company_district')}`);
    return false;
  }
  let monthly_income = $(`#debt-restruct #updated_info  input[name='monthly_income']`).val();
  if (monthly_income == "" || monthly_income == undefined) {
    error_msg(`Thiếu ${translate('monthly_income')}`);
    return false;
  }
  let other_income = $(`#debt-restruct #updated_info  input[name='other_income']`).val();
  if (other_income == "" || other_income == undefined) {
    error_msg(`Thiếu ${translate('other_income')}`);
    return false;
  }
  let monthly_expense = $(`#debt-restruct #updated_info input[name='monthly_expense']`).val();
  if (monthly_expense == "" || monthly_expense == undefined) {
    error_msg(`Thiếu ${translate('monthly_expense')}`);
    return false;
  }

  let ext_payment_term = $(`#debt-restruct select[name='ext_payment_term']`).val();
  if (ext_payment_term == "" || ext_payment_term == undefined) {
    error_msg(`Thiếu ${translate('ext_payment_term')}`);
    return false;
  }

  let ID_Card = $(`#debt-restruct #updated_info input[name='id_card_image']`)[0].files[0];

  let PIC = $(`#debt-restruct #updated_info input[name='pic_image']`)[0].files[0];
  if (ID_Card == undefined) {
    error_msg(`Thiếu ${translate('id_card_image')}`);
    return false;
  }
  if (PIC == undefined) {
    error_msg(`Thiếu ${translate('pic_image')}`);
    return false;
  }
  // if (PIC_IMAGE == "") {
  //   error_msg(`Thiếu ${translate('pic_image')}`);
  //   return false;
  // }
  // if (ID_CARD_IMAGE == "") {
  //   error_msg(`Thiếu ${translate('id_card_image')}`);
  //   return false;
  // }
  let raw_info = Object.assign($(`#debt-restruct #updated_info input`).serializeObject(), $(`#debt-restruct #updated_info select`).serializeObject());
  // raw_info['id_card_image'] = ID_CARD_IMAGE;
  // raw_info['pic_image'] = PIC_IMAGE;
  raw_info['contract_number'] = contract_number;
  raw_info['ext_payment_term'] = ext_payment_term;
  raw_info['cust_id'] = cust_id;
  raw_info['request_id'] = request_id;
  return raw_info;
}
$(document).ready(function ()
{
  SetComapyAddress();
  
  $(document).on("keyup", '#debt input[tag="currency2"]', function () {
    if ( val== "" || val == undefined) { }
    this.value = val.replace(/[^0-9\.]/g, "");
    this.value = this.value.split(",").join("");
  });

  $(document).on("blur", '#debt input[tag="currency2"]', function () {
    if (this.value == "" || this.value == undefined) { }
    this.value = this.value.replace(/[^0-9\.]/g, "");
    this.value = this.value.split(",").join("");
    this.value = currency_vnd(this.value);
  });
  $("select[name='ext_payment_term']").select2({
    data: Array.from({ length: 36 }, (_, i) => i),
    tags: true
  });;
  $("select[name='exist_contract_number']").select2({
    tags: true
  });;
  //  TEST DATA
  let phone_number = "0969133718";
  let identity_card = "187708921";
  // END TEST
  var body_object = {
    phone_number: phone_number,
    identity_card: identity_card
  }
  clearFormDebt(true);
  CreateDebtFullData(body_object);
  $(document).on("click", "#debt_test", function (e)
  {
      //  TEST DATA
    let phone_number = "0969133718";
    let identity_card = "187708921";
    let body_object_request = {
      phone_number: phone_number,
      identity_card: identity_card
    }
    clearFormDebt(true);
    CreateDebtFullData(body_object_request);
  });
  $(document).on("click", "#submit-docs-debt", function (e)
  {
    upload_id_image();
    upload_pic_image();
  });
  $(document).on("click", "#submit-debt", function (e)
  {
    let debt_update_info = validate_debt_restruct_request_data();
    if (debt_update_info != false) {
      let request_id = debt_update_info.request_id;
      $("#customer_info input[name='request_id']").val(request_id);
      let id_card_image = $(`#debt-restruct #updated_info input[name='id_card_image']`)[0].files[0];
      let pic_image = $(`#debt-restruct #updated_info input[name='pic_image']`)[0].files[0];
      var form = new FormData();
      // TESTING
      debt_update_info.contract_number = "hihi19";
      // 
      form.append("request_id", `${debt_update_info.request_id}`);
      form.append("contract_number", `${debt_update_info.contract_number}`);
      form.append("cust_id", `${debt_update_info.cust_id}`);
      form.append("job_type", `${debt_update_info.job_type}`);
      form.append("company_name", `${debt_update_info.company_name}`);
      form.append("company_address", `${debt_update_info.company_address}`);
      form.append("company_province", `${debt_update_info.company_province}`);
      form.append("company_district", `${debt_update_info.company_district}`);
      form.append("company_ward", `${debt_update_info.company_ward}`);
      form.append("monthy_income", `${debt_update_info.monthly_income}`);
      form.append("other_income", `${debt_update_info.other_income}`);
      form.append("monthy_expense", `${debt_update_info.monthly_expense}`);
      form.append("PIC", pic_image, `PIC_${debt_update_info.request_id}.pdf`);
      form.append("extension_payment_terms", `${debt_update_info.ext_payment_term}`);
      form.append("PID", id_card_image, `PID_${debt_update_info.request_id}.pdf`);
      var settings = {
        "url": DEBT_API_HOST+ "/los-united/v1/debt-restructuring/register-debt-restructuring",
        "method": "POST",
        "timeout": 0,
        "processData": false,
        "mimeType": "multipart/form-data",
        "contentType": false,
        "data": form
      };
      $.ajax(settings).done(function (resp)
      {
        let response = resp;
        try {
          response = JSON.parse(resp);
        } catch (error) {
        }
        info_msg("Thành công", 3000, "Gửi thông tin cập nhật");
        console.log(response);
        let code = response.code;
        let request_ref = response.request_ref;
        $("#current_request input[name='request_ref']").val(request_ref);
        if (code == 0) {
          info_msg("Mã cơ cấu: " + response.request_ref, translate(response.message));
          if (lead_id == "" || lead_id == undefined) {
            error_msg("Thiếu lead_id");
            // TEST 
            lead_id = "1234";
          }
          let body_data = {
            "lead_id": lead_id + "",
            "user": user,
            "request_id": $("#customer_info input[name='request_id']").val(),
            "document": "",
            "request_ref": $("#current_request input[name='request_ref']").val()
          }
          create_debt_info(body_data, "SENT");
          return;
        } else {
          error_msg(translate(response.message), "Không thành công");
        }
      }).fail(function (response)
      {
        console.log("DEBT_REQUEST", response);
        try {
            error_msg(translate(response.message), "Không thành công");
        } catch (error) {
          error_msg("Đã có lỗi xảy ra. Vui lòng liên hệ admin!",3000, "Lỗi");
        }
        return;
      });
    }
  });
  $(document).on("click", "#save-debt", function (e)
  {
    let body_data = {
      "lead_id": lead_id + "",
      "user": user,
      "request_id": $("#customer_info input[name='request_id']").val(),
      "document": "",
      "request_ref": $("#current_request input[name='request_ref']").val()
    }
    create_debt_info(body_data, "UPDATE");
  });
  $(document).on("click", "#debt-calculate-emi", function (e)
  {
    let emi_info = validate_emi_info();
    console.log("EMI body", emi_info);
    CreateDebtFullData(emi_info);
  });
  if (user == 'quangtran') {
    create_debt_restructing();
  }
})