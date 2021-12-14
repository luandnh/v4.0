const API_BAOMINH = "https://cnbh.baominh.vn:4455/api/chungnhanbh/taochungnhan";
const AUTHEN_CODE = "easy:123654";
const PRODUCT_CODE = "EC_BHSKTD1"
const PROGRAM_CODE = "EC_BHSKTD1"
const required_field = ["Benmuabaohiem","Ngaysinh","SoCMND","Ngaycap","Noicap","Diachi","Dienthoai","Email","Sotienbaohiem","Tungay","Denngay","Thoihanbaohiem","Phibaohiem","Ngaycapdon"]
const ChangeFormateDate = function(oldDate)
{
  let ch = "-";
  if (!oldDate.includes(ch)){
    ch = "/";
  }
  return oldDate.toString().split(ch).reverse().join(ch);
}
const validate_baominh_form = function(form_data){
  let data = {}
  for (let index = 0; index < form_data.length; index++) {
    const element = form_data[index];
    let key = element.name;
    if (required_field.includes(element.name) && (element.value ==""|| element.value==undefined)){
      return [false, "Thiếu thông tin : "+element.name]
    }
    data[key] = element.value
  };
  return [true, data]
}
$(document).ready(function () {
  $("#partner-baominh-form input[id='product_code']").val(PRODUCT_CODE);
  $("#partner-baominh-form input[id='program_code']").val(PROGRAM_CODE);
  $("#agent-partner-baominh").on("click", (e) => {
    e.preventDefault();
    ShowContentModule("partner-baominh");
  });
  
  $("#submit-bao-minh").on("click", (e) => {
    if (user == undefined || user == ""){
      swal("Thiếu thông tin", "Thiếu username", "error");
      return;
    }
    let baominh_form = $("#bao-minh-form").serializeArray();
    let validate_form = validate_baominh_form(baominh_form);
    if (validate_form[0]==false){
      swal("Thiếu thông tin", validate_form[1], "error");
      return;
    }
    let json_data = validate_form[1]
    json_data.Denngay = ChangeFormateDate(json_data.Denngay)
    json_data.Ngaycap = ChangeFormateDate(json_data.Ngaycap)
    json_data.Ngaycapdon = ChangeFormateDate(json_data.Ngaycapdon)
    json_data.Ngaysinh = ChangeFormateDate(json_data.Ngaysinh)
    let form_data = [json_data];
    let data = JSON.stringify({
      "SanPham": PRODUCT_CODE,
      "Data": JSON.stringify(form_data),
      "ChuongTrinh": PROGRAM_CODE,
      "User" : user
    });
    var settings = {
      "url": TEL4VN_API_URL + "/partner/v1/baominh",
      "method": "POST",
      "headers": {
        "Authentication": AUTHEN_CODE,
        "Content-Type": "application/x-www-form-urlencoded"
      },
      "data":  data
    };
    $.ajax(settings).done(function (response) {
      console.log(response);
      if (response.created){
        swal("Success!", "Gửi thông tin thành công", "success");
        $("#bao-minh-form").find(":input").val("");
      }else{
        swal("Error", response.msg, "error");
      }
    }).fail(function (response) {
      console.log(response);
      let alertmsg = "";
      let msg = response.responseJSON;
      if (msg != undefined){
        console.log(msg);
        alertmsg = msg.error;
      } else{
        alertmsg = response.responseText;
      }
      swal("Không thành công", alertmsg, "error");
    })
  });
});