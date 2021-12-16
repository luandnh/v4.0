const API_HOST = "https://ec-api.tel4vn.com"

const MAP_STATUS = {
  "A1": "A1",
  "A2": "A1",
  "A3": "A1",
  "A4": "A1",
  "A5": "A1",
  "A6": "A1",
  "C1": "A1",
  "H1": "A1",
  "AB": "AB",
  "PU": "AB",
  "B": "AB",
  "DROP": "AB",
  "F1": "AB",
  "F2": "AB",
  "F3": "AB",
  "F4": "AB",
  "F5": "AB",
  "PDROP": "AB",
  "NA": "AB",
  "E1": "E1",
  "E2": "E1",
  "E3": "E1",
  "E4": "E1",
  "E5": "E1",
  "E6": "E1",
  "D1": "D1",
  "D2": "D1",
  "D3": "D1",
  "D4": "D1",
  "D5": "D1",
  "D6": "D1",
  "G1": "D1"
}
function getDateNow() {
  var today = new Date();
  var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
  var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
  var dateTime = date + ' ' + time;
  return dateTime
}
function sync_vta_status(lead_id, status, vsub_status, received_date, customer_name, date_of_birth, identity_card_id, phone_number) {
  let data = JSON.stringify({
    "lead_id": lead_id.toString(),
    "status": status,
    "sub_status": vsub_status,
    "data": {
      "lead_id": lead_id.toString(),
      "received_date": received_date,
      "customer_name": customer_name,
      "date_of_birth": date_of_birth,
      "identity_card_id": identity_card_id,
      "phone_number": phone_number
    }
  })
  console.log(data);
  var settings = {
    "url": API_HOST + "/partner/v1/vtm/sync_status",
    "method": "POST",
    "timeout": 0,
    "headers": {
      "Content-Type": "application/json"
    },
    "data": data,
  };
  $.ajax(settings).done(function (response) {
    console.log("Update status success", response);
    tata.info('Cập nhật trạng thái VTA', 'Đã gửi thành công', {
      position: 'tl', animate: 'slide', duration: 2500
    })
  }).fail(function (response) {
    console.log("Update status failed", response);
  });
}


$(document).ready(function () {
  var now = new Date();
  var hrs = now.getHours();
  var our_msg = "";
  if (hrs > 6) our_msg = "Buổi sáng vui vẻ";
  if (hrs > 12) our_msg = "Buổi trưa vui vẻ";
  if (hrs > 17) our_msg = "Buổi chiều vui vẻ";
  $("#btn-dispo-submit").click(function () {
    let vendor_code = $(".formMain input[name='vendor_lead_code']").val();
    // vendor_code = "VTA"
    if (vendor_code == "VTA") {
      let timeNow = getDateNow();
      let vdob = $(".formMain input[name='date_of_birth']").val().split("-").reverse().join("-");
      let vlead_id = $(".formMain input[name='lead_id']").val();
      let vsub_status = TMP_STATUS;
      let videntity_card_id = $(".formMain input[name='identity_number']").val();
      let vphone_number = $(".formMain input[name='phone_code']").val() + $(".formMain input[name='phone_number']").val();
      let vfirst_name = $(".formMain input[name='first_name']").val();
      let vmiddle_initial = $(".formMain input[name='middle_initial']").val();
      let vlast_name = $(".formMain input[name='last_name']").val();
      let vcustomer_name = vfirst_name.trim();
      if (vmiddle_initial == "") {
        vcustomer_name = vcustomer_name.trim() + " " + vlast_name.trim();
      }
      if (vdob == "") {
        vdob = "01-01-1900";
      }
      else {
        vcustomer_name = vcustomer_name
          + " " + vmiddle_initial.trim() + " " + vlast_name.trim();
      }
      vcustomer_name = vcustomer_name.trim();
      vcustomer_name = vcustomer_name.replace("  ", " ")
      let vstatus = MAP_STATUS[vsub_status];
      if (vstatus == "" || vstatus == undefined) {
        console.log("Not found  lead_status for sub_status : " + vsub_status);
        tata.info('Cập nhật trạng thái VTA', 'Không gửi trạng thái: ' + "D1", {
          position: 'tl', animate: 'slide', duration: 2500
        })
        return;
      }
      sync_vta_status(vlead_id, vstatus, vsub_status, timeNow, vcustomer_name, vdob, videntity_card_id, vphone_number)
      TMP_STATUS = "";
    }
  });
})