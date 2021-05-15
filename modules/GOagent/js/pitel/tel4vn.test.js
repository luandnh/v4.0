function auto_fill() {
  let testData = {
   "email":"abc@easycredit.vn",
   "employment_type":"E",
   "product_type":"13026",
   "loan_amount":12000000,
   "loan_tenor":6,
   "tem_province":"79",
   "tem_district":"766",
   "tem_ward":"26965",
   "tem_address":"432 Phạm Thế Hiển",
   "years_of_stay":"5",
   "permanent_province":"79",
   "permanent_district":"766",
   "permanent_ward":"26965",
   "permanent_address":"432 Phạm Thế Hiển",
   "profession":"TRL",
   "married_status":"M",
   "house_type":"ONC",
   "number_of_dependents":0,
   "disbursement_method":"bank",
   "beneficiary_name":"Code E",
   "bank_code":"204",
   "bank_branch_code":"20204007",
   "bank_account":"1234567890",
   "monthly_income":300000000,
   "other_income":5000000,
   "income_method":"TRANS",
   "income_frequency":"M",
   "income_receiving_date":30,
   "monthly_expense":10000000,
   "job_title":"BOR",
   "workplace_name":"Roxar VietNam",
   "workplace_province":"79",
   "workplace_district":"766",
   "workplace_ward":"26965",
   "workplace_address":"268 Cộng Hòa",
   "workplace_phone":"0981234567",
   "employment_contract_type":"PC",
   "employment_contract_year_from":"2018",
   "employment_contract_year_to":"2021",
   "employment_contract_term":"employment_contract_term",
   "tax_id":"tax_id",
   "loan_purpose":"EMT",
   "other_contact":"OME",
   "detail_contact":"test@gmail.com",
   "relation_1":"SB",
   "relation_1_name":"alex nguyen",
   "relation_1_phone_number":"0123456789",
   "relation_2":"SB",
   "relation_2_name":"tran an",
   "relation_2_phone_number":"0123456789",
   "mailing_address":"permanent",
   "3rd_Party_duration":"1 năm",
   "sale_code": "DSA",
   "lending_method": "Vay hạn mức",
   "business_date": "22-02-2019",
   "contract_term": "DT"
}

  for (const property in testData) {
    $("#full-loan-form input[name='" + property + "']").val(testData[property]);
  }
  $("#full-loan-form select").each(function (e) {
    try {
      var tmp = $(this);
      tmp[0].lastElementChild.selected = true;
    }
    catch (e) {
      console.log(e)
      console.log(tmp)
    }
  });
  $("#full-loan-form select[name='disbursement_method']")[0][0].selected = true;
  $("#full-loan-form input[name='check_same_address']")[0].checked = false;
  $("#full-loan-form input[name='check_same_address']").trigger('change');
  $("#full-loan-form select[name='employment_type']").val("SE");
  $("#full-loan-form select[name='employment_type']").trigger('change')
  $(".selectpicker").each(function (e) {
    try {
      var tmp = $(this);
      tmp[0].lastElementChild.selected = true;
      tmp.trigger("change");
    }
    catch (e) {
      console.log(e)
      console.log(tmp)
    }
  });
}

function sync_from_product(){
  $("#full-loan-form input[name='product_type']").val($("#product-detail-form input[name='product_code']").val());
  var tables = $("#product-detail-form-bundle table")
  var docs_string = "";
  for (var i = 0 ; i < tables.length; i++) {
      let table = tables[i];
      if (table.childElementCount>0){
          let tmp_string = "["
          let rows = table.querySelectorAll(".odd,.even")
          if (rows.length >0 ){
              for (var j = 0 ; j < rows.length; j++) {
                  tmp_string+= rows[j].lastElementChild.textContent;
                  if (j!=rows.length-1){tmp_string+="|"}
              }
          }
          tmp_string+="]";
          docs_string+= tmp_string
          if (i!=tables.length-1){
              docs_string+=" && "
          }
      }
  }
  $("input[name='product_required_document']").val(docs_string);
  console.log(docs_string)
}