var RequireResubmit = {}
var tmp_eligible = ""
var proposal_id = ""
var isUploadPIC = false;
var isUploadPID = false;
var RequiredDocs = {
    "PID": false,
    "PIC": false
}
var allow_check_docs = []
function get_select_options(id_name) {
    var ddlArray = new Array();
    var ddl = document.getElementById(id_name);
    for (i = 0; i < ddl.options.length; i++) {
        ddlArray[i] = ddl.options[i].value;
    }
    return ddlArray;
}

function get_main_phone_number() {
    let alt_phone = $(".formMain input[name='alt_phone']").val();
    if (alt_phone == "" || alt_phone == undefined) {
        return $(".formMain input[name='phone_number']").val();
    }
    return alt_phone;
}

function generate_url(request_id, file_name, doc_type, proposal_id = "") {
    let param = {
        file_name: file_name,
        request_id: request_id,
        partner_code: 'TEL',
        doc_type: doc_type,
        proposal_id: proposal_id
    };
    return $.ajax({
        type: "GET",
        url: EC_PROD_API_URL +
            "/los-united/v1/document/presinged-url" +
            "?" +
            $.param(param, true),
        async: true,
        dataType: "json",
        headers: {
            "Content-Type": "application/json",
        },
    }).fail((result, status, error) => {
        RequireResubmit[doc_type] = false
        console.log("generate_url error : ", result);
        let msg = result.responseJSON.message;
        RequiredDocs[doc_type] = (msg.includes("đã được upload trước đó"));
        if (msg.includes("đã được upload trước đó")) {
            tata.info('Đã gửi', msg, {
                position: 'tl',
                animate: 'slide',
                duration: 2500
            })
        } else {
            tata.error('Không thành công', msg, {
                position: 'tl',
                animate: 'slide',
                duration: 2500
            })
        }
    });
}

function put_file_s3(doc_type, url, file, file_name, doc_id = "") {
    var form = new FormData();
    form.append(doc_type, file, file_name);
    var settings = {
        "url": url,
        "method": "PUT",
        "timeout": 0,
        "processData": false,
        "mimeType": "multipart/form-data",
        "contentType": false,
        "data": form
    };
    $.ajax(settings).done(function (response) {
        tata.info('Upload file success', "", {
            position: 'tl',
            animate: 'slide',
            duration: 2500
        })
        console.log(response);
        RequiredDocs[doc_type] = true
        RequireResubmit[doc_type] = doc_id
    }).fail(function (res) {
        // alert("Push to s3 failed");
        RequiredDocs[doc_type] = false
        RequireResubmit[doc_type] = false
        tata.error('Upload file fail', res.toString(), {
            position: 'tl',
            animate: 'slide',
            duration: 2500
        })
        console.log(res)
    });
}

function getCurrentDate() {
    let date_ob = new Date();
    let date = ("0" + date_ob.getDate()).slice(-2);
    let month = ("0" + (date_ob.getMonth() + 1)).slice(-2);
    let year = date_ob.getFullYear();
    let hours = date_ob.getHours();
    let minutes = date_ob.getMinutes();
    let seconds = date_ob.getSeconds();
    if (hours < 10) {
        hours = "0" + hours
    }
    if (minutes < 10) {
        minutes = "0" + minutes
    }
    if (seconds < 10) {
        seconds = "0" + seconds
    }
    return year + "-" + month + "-" + date + " " + hours + ":" + minutes + ":" + seconds;
}
console.stdlog = console.log.bind(console);
console.logs = {};
console.log = function () {
    console.logs[getCurrentDate()] = Array.from(arguments);
    console.stdlog.apply(console, arguments);
}
console.log("agent-easy-credit-v1");
var list_doc_collecting = [];
var is_upload_img_selfie = false;
var is_upload_id_card = false;

const EC_API_USERNAME = "";
const formatter = new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
});
const num_formatter = new Intl.NumberFormat("vi-VN");
const EC_API_PASSWORD = "";
const EC_API_TOKEN = "";
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
// 
var isUploadedDocs = [false, false, false];
let AllowSelectOffer = function () {
    if (isUploadedDocs[0] & isUploadedDocs[1] & isUploadedDocs[2]) {
        $("#submit-offer").attr('disabled', false);
    } else {
        $("#submit-offer").attr('disabled', true);
    }
}
//
let box_color = [
    "box-primary",
    "box-danger",
    "box-success",
    "box-warning",
    "box box-info",
    "box box-default",
];
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
$(document).on('blur', 'input[type="date"]', function () {
    var cur_date = new Date($(this)[0].value);
    var today = new Date()
    var yesterday = new Date(today)
    yesterday.setDate(yesterday.getDate() - 1)
    if (cur_date < new Date("1900-01-01") || (cur_date > new Date(yesterday))) {
        sweetAlert("Thời gian không được nhỏ hơn 1900 và lớn hơn ngày hôm qua")
    }
});

$(document).on('blur', 'input[tag="phone"]', function () {
    let phone_number = $(this)[0].value;
    var vnf_regex = /((09|03|07|08|05)+([0-9]{8})\b)/g;
    if (phone_number !== '') {
        if (vnf_regex.test(phone_number) == false) {
            sweetAlert('Số điện thoại của bạn không đúng định dạng!');
        }
    }
});

function pmt(monthlyRate, monthlyPayments, presentValue, residualValue, advancedPayments) {
    t1 = 1 + monthlyRate
    t2 = Math.pow(t1, monthlyPayments)
    t3 = Math.pow(t1, (monthlyPayments - advancedPayments))
    return (presentValue - (residualValue / t2)) / (((1 - (1 / (t3))) / monthlyRate) + advancedPayments);
}
let simulator = (e) => {
    try {

        let sm_loan_amount = $("#full-loan-form input[name='loan_amount']").val();
        let sm_loan_tenor = $("#full-loan-form input[name='loan_tenor']").val();
        let sm_insu = $("input[name='simu_insurance']:checked").val();
        if (sm_insu == undefined) {
            $("input[name='simu_insurance']")[0].checked = true;
            sm_insu = 0;
        }
	console.log("insu",sm_insu)
        $("input[name='simu_insurance']")[sm_insu == 0 ? 0 : (sm_insu == 6 ? 1 : 2)].checked = true;
        let ir = selected_product.interest_rate;
        let sm_total_offer = parseInt(sm_loan_amount * (1 + sm_insu / 100)) + "";
        // let sm_monthly = parseInt(sm_total_offer / sm_loan_tenor) + "";
        // let sm_monthly = parseInt( (sm_total_offer / sm_loan_tenor) + sm_total_offer*(ir/100)/12)+ "";
        // pmt(0.35/12,0.5*12,10000000,1,0)
        let sm_monthly = parseInt(pmt((ir / 100) / 12, sm_loan_tenor, sm_total_offer, 1, 0)) + "";

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
    } catch (error) {

    }
    //
};
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
    $(document).on("click", "#report_error", function (e) {
        tata.info('Tạo tập tin log', 'Vui lòng đợi', {
            position: 'tl',
            animate: 'slide',
            duration: 1000
        })
        let tsp = getCurrentDate().split("-").join("_").split(":").join("_").split(" ").join("_");
        var a = document.createElement('a');
        var blob = new Blob([JSON.stringify(console.logs, null, 4)], { 'type': 'application/octet-stream' });
        a.href = window.URL.createObjectURL(blob);
        let fname = 'ReportLog_' + tsp + ".json";
        a.download = fname;
        a.click();
        tata.info('Thành công : ' + fname, 'Gửi tập tin log đến developer để kiểm tra', {
            position: 'tl',
            animate: 'slide',
            duration: 5000
        })
    });
    $("input[name='simu_insurance']")[0].checked = true;

    $(document).on("click", "#submit_file_resubmit", function (e) {
        var request_id = $("#request_id").val();
        var phone_number = $("#full-loan-form input[name='phone_number']").val();
        if (phone_number[0] == '0') {
            phone_number = phone_number.slice(1, phone_number.length)
        }
        var identity_number = $("#full-loan-form input[name='identity_card_id']").val();

        var ls = $("input[mark='resubmit']")
        for (let index = 0; index < ls.length; index++) {
            let file_input = ls[index];
            let files = file_input.files;
            if (files.length == 0) {
                alert("Required all file input")
                return;
            }
        }
        for (let index = 0; index < ls.length; index++) {
            let file_input = ls[index];
            let file = file_input.files[0];
            let file_type = file_input.getAttribute("file_type");
            let file_name = `${file_type}_${identity_number}_0${phone_number}_TEL${Date.now().toString()}.pdf`
            generate_url(request_id, file_name, file_type, $("#contract_number").val()).done((result) => {
                if (result.code != 0) {
                    swal("Upload file fail!", result.msg, "error");
                    RequireResubmit[doc_type] = false
                    return;
                }
                let data = result.data;
                let url = data.url;
                let docs_id = data.doc_id;
                put_file_s3(file_type, url, file, file_name, docs_id)
            });
        }
    });
    $(document).on("click", "#resubmit_btn", function (e) {
        let list_docs = []
        for (const [key, value] of Object.entries(RequireResubmit)) {
            if (RequireResubmit[key] == false) {
                alert(key + " is not upload success");
                return;
            }
            list_docs.push({
                "doc_id": value,
                "doc_type": key
            })
        }
        var settings = {
            "url": EC_PROD_API_URL + "/los-united/v1/dsa/docs/resubmit",
            "method": "POST",
            "timeout": 0,
            "headers": {
                "Content-Type": "application/json"
            },
            "data": JSON.stringify({
                "request_id": $("#request_id").val(),
                "contract_number": $("#contract_number").val(),
                "doc_id_list": list_docs
            }),
        };
        $.ajax(settings).done(function (response) {
            alert("OK")
            console.log(response);
        }).fail(function (response) {
            console.log(response);
            alert("FAIL")
        });
    });
    $(document).on("click", "#submit_attachment", function (e) {
        e.preventDefault();
        const multiple_files = $(".MultiFile-applied.MultiFile");
        if (multiple_files.length == 0) {
            sweetAlert("Chưa có file được chọn");
            return;
        }
        var request_id = $("#request_id").val();
        var phone_number = $("#full-loan-form input[name='phone_number']").val();
        if (phone_number[0] == '0') {
            phone_number = phone_number.slice(1, phone_number.length)
        }
        var attachments = multiple_files[0].MultiFile.files;
        for (let tmp = 0; tmp < multiple_files.length; tmp++) {
            if (multiple_files[tmp].MultiFile.files.length != 0) {
                attachments = multiple_files[tmp].MultiFile.files;
            }
        }
        list_doc_collecting = [];
        if (attachments.length == 0) {
            sweetAlert("Chưa có file được chọn. Nếu là lỗi, vui lòng liên hệ developer");
            return;
        }
        attachments.forEach(function (file) {
            var file_type = $(`select[name='${file.lastModified + file.name}']`)[0].value;
            var identity_number = $("#full-loan-form input[name='identity_card_id']").val();
            let file_name = `${file_type}_${identity_number}_0${phone_number}_TEL${Date.now().toString()}.pdf`
            generate_url(request_id, file_name, file_type, $("#contract_number").val()).done((result) => {
                if (result.code != 0) {
                    swal("Upload file fail!", result.msg, "error");
                    return;
                }
                let data = result.data;
                let url = data.url;
                put_file_s3(file_type, url, file, file_name)
            });
        });
    });
    $(document).on("click", "#submit_attachment2", function (e) {
        e.preventDefault();
        const multiple_files = $("input[id^='attachment_files2_']");
        if (multiple_files.length == 0) {
            sweetAlert("Chưa có file được chọn");
            return;
        }
        var request_id = $("#request_id").val();
        var phone_number = $("#full-loan-form input[name='phone_number']").val();
        if (phone_number[0] == '0') {
            phone_number = phone_number.slice(1, phone_number.length)
        }
        var attachments = multiple_files[0].MultiFile.files;
        for (let tmp = 0; tmp < multiple_files.length; tmp++) {
            if (multiple_files[tmp].MultiFile.files.length != 0) {
                attachments = multiple_files[tmp].MultiFile.files;
            }
        }
        list_doc_collecting = [];
        if (attachments.length == 0) {
            sweetAlert("Chưa có file được chọn. Nếu là lỗi, vui lòng liên hệ developer");
            return;
        }
        attachments.forEach(function (file) {
            var file_type = $(`select[name='${file.lastModified + file.name}']`)[0].value;
            var identity_number = $("#full-loan-form input[name='identity_card_id']").val();
            var formData = new FormData();
            formData.append("request_id", request_id);
            formData.append("phone_number", "0" + phone_number);
            formData.append("identity_number", identity_number);
            formData.append("file_type", file_type);
            formData.append("file", file);
            var upload_status = true;
            var settings = {
                url: CRM_API_URL + "/v1/document/upload",
                // url: "http://ec-api-dev.tel4vn.com/v1/document/upload",
                method: "POST",
                timeout: 0,
                processData: false,
                mimeType: "multipart/form-data",
                contentType: false,
                data: formData,
            };
            $.ajax(settings)
                .fail((result, status, error) => {
                    console.log("Submit_attachment failed: ", result);
                    let msg = "Please contact developer!";
                    isUploadedDocs[2] = false;
                    // AllowSelectOffer();
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
                    swal("Upload file fail!", msg, "error");
                })
                .success((result, status, error) => {
                    let resp = JSON.parse(result);
                    if (resp.status == "success") {
                        var doc = { file_type: resp.file_type, file_name: resp.file_name };
                        console.log("Upload success : ", doc)
                        list_doc_collecting.push(doc);

                        isUploadedDocs[2] = true;
                        // AllowSelectOffer();
                        swal(
                            "Upload file success!",
                            "Upload attachment success",
                            "success"
                        );
                    }
                });
        });
    });

    // SELECT OFFER
    // Upload img_selfie
    $(document).on("click", "#submit_img_selfie", function (e) {
        e.preventDefault();
        const files = $("#img_selfie")[0].files;
        if (files.length == 0) {
            sweetAlert("No img_selfie file to upload");
            return;
        }
        // TEST 
        // $("#full-loan-form input[name='identity_card_id']").val("215491214");
        // $("#identity_number").val("215491214");
        // 
        var request_id = $("#request_id").val();
        var phone_number = $("#full-loan-form input[name='phone_number']").val();
        if (phone_number[0] == '0') {
            phone_number = phone_number.slice(1, phone_number.length)
        }
        var identity_number = $("#full-loan-form input[name='identity_card_id']").val();
        var formData = new FormData();
        formData.append("request_id", request_id);
        formData.append("file_type", "PIC");
        formData.append("phone_number", "0" + phone_number);
        formData.append("file", files[0]);
        formData.append("identity_number", identity_number);
        var settings = {
            url: CRM_API_URL + "/v1/document/upload",
            // url: "http://ec-api-dev.tel4vn.com/v1/document/upload",
            method: "POST",
            timeout: 0,
            processData: false,
            mimeType: "multipart/form-data",
            contentType: false,
            data: formData,
        };
        $.ajax(settings)
            .fail((result, status, error) => {
                console.log("Submit_attachment: ", result);
                isUploadedDocs[0] = false;
                // AllowSelectOffer();
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
                swal("Upload file fail!", msg, "error");
            })
            .success((result, status, error) => {
                let resp = JSON.parse(result);
                console.log("Upload success : ", resp);
                if (resp.status == "success") {
                    $("input[name='img_selfie']")[0].value = resp.file_name;
                    isUploadedDocs[0] = true;
                    // AllowSelectOffer();
                    swal("OK!", "Upload Image Selfie Success", "success");
                }
            });
    });
    // Upload img_id_card
    $(document).on("click", "#submit_img_id_card", function (e) {
        e.preventDefault();
        const files = $("#img_id_card")[0].files;
        if (files.length == 0) {
            sweetAlert("No img_id_card file to upload");
            return;
        }
        // TEST
        // $("#full-loan-form input[name='identity_card_id']").val("215491214");
        // $("#identity_number").val("215491214");
        // 

        var request_id = $("#request_id").val();
        var phone_number = $("#full-loan-form input[name='phone_number']").val();
        if (phone_number[0] == '0') {
            phone_number = phone_number.slice(1, phone_number.length)
        }
        var identity_number = $("#full-loan-form input[name='identity_card_id']").val();
        var formData = new FormData();
        formData.append("request_id", request_id);
        formData.append("file_type", "PID");
        formData.append("phone_number", "0" + phone_number);
        formData.append("file", files[0]);
        formData.append("identity_number", identity_number);
        var settings = {
            url: CRM_API_URL + "/v1/document/upload",
            // url: "http://ec-api-dev.tel4vn.com/v1/document/upload",0
            method: "POST",
            timeout: 0,
            processData: false,
            mimeType: "multipart/form-data",
            contentType: false,
            data: formData,
        };
        $.ajax(settings)
            .fail((result, status, error) => {
                console.log("Submit_img_id_card: ", result);
                isUploadedDocs[1] = false;
                // AllowSelectOffer();
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
                swal("Upload file fail!", msg, "error");
            })
            .success((result, status, error) => {
                let resp = JSON.parse(result);
                console.log("Upload success : ", resp);
                if (resp.status == "success") {
                    $("input[name='img_id_card']")[0].value = resp.file_name;
                    swal("OK!", "Upload Image ID Card Success", "success");
                    isUploadedDocs[1] = true;
                    // AllowSelectOffer();
                }
            });
    });
    // 
    // SUBMIT FULLLOAN
    // Upload img_selfie
    $(document).on("click", "#submit_img_selfie2", function (e) {
        e.preventDefault();
        /*if ($("#vendor_lead_code").val() == VTA_List) {
             sweetAlert("Không upload ảnh với VTA lead");
             return;
        }*/
        const files = $("#img_selfie2")[0].files;
        if (files.length == 0) {
            sweetAlert("No img_selfie file to upload");
            return;
        }
        // •	[file_type]_[identity_card_id]_[phone_number]_[partner_code][timestamp]
        var request_id = $("#request_id").val();
        var identity_number = $("#full-loan-form input[name='identity_card_id']").val();
        var phone_number = $("#full-loan-form input[name='phone_number']").val();
        if (phone_number[0] == '0') {
            phone_number = phone_number.slice(1, phone_number.length)
        }
        let file_name = `PIC_${identity_number}_0${phone_number}_TEL${Date.now().toString()}.pdf`
        generate_url(request_id, file_name, "PIC").done((result) => {
            if (result.code != 0) {
                swal("Upload file fail!", result.msg, "error");
                return;
            }
            let data = result.data;
            let url = data.url;
            let docs_id = data.doc_id;
            put_file_s3("PIC", url, files[0], file_name)
        });
    });
    // Upload img_id_card
    $(document).on("click", "#submit_img_id_card2", function (e) {
        e.preventDefault();

        /*if ($("#vendor_lead_code").val() == VTA_List) {
             sweetAlert("Không upload ảnh với VTA lead");
             return;
        }*/
        const files = $("#img_id_card2")[0].files;
        if (files.length == 0) {
            sweetAlert("No img_id_card file to upload");
            return;
        }
        var request_id = $("#request_id").val();
        var identity_number = $("#full-loan-form input[name='identity_card_id']").val();
        var phone_number = $("#full-loan-form input[name='phone_number']").val();
        if (phone_number[0] == '0') {
            phone_number = phone_number.slice(1, phone_number.length)
        }
        let file_name = `PID_${identity_number}_0${phone_number}_TEL${Date.now().toString()}.pdf`
        generate_url(request_id, file_name, "PID").done((result) => {
            if (result.code != 0) {
                // swal("Upload file fail!", result.msg, "error");
                tata.error('Upload file fail', result.msg, {
                    position: 'tl',
                    animate: 'slide',
                    duration: 2500
                })
                return;
            }
            let data = result.data;
            let url = data.url;
            let docs_id = data.doc_id;
            put_file_s3("PID", url, files[0], file_name)
        });
    });
    // 
    let fullLoanTab =
        '<li  style="border: 1px solid #b0b0b0ad;border-radius: 5px;font-family: Helvetica !important;font-size: large;" role="presentation" id="full_loan_tab_href">' +
        '<a href="#full-loan" aria-controls="home" role="tab" data-toggle="tab" class="bb0">' +
        '<span class="fa fa-file-text-o hidden"></span>' +
        "Thông tin khoản vay</a>" +
        "</li>";
    $("#agent_tablist").append(fullLoanTab);
    clearForm($("#full-loan-form"));
    clearAFForm();
});
let CreateOfferTab = function () {
    let offerTab =
        '<li role="presentation" id="offer_tab_href">' +
        '<a href="#offer" aria-controls="home" role="tab" data-toggle="tab" class="bb0">' +
        '<span class="fa fa-file-text-o hidden"></span>' +
        "Offer</a>" +
        "</li>";
    $("#agent_tablist").append(offerTab);
}
let fill_file_requier = function (data) {
    let list_files = data.list_error_file;
    $("#list_resubmit").html(``);
    let b_html = ``;
    for (let index = 0; index < list_files.length; index++) {
        let element = list_files[index];
        RequireResubmit[element.doc_type] = false
        b_html += `
      <div class="mda-form-group label-floating">
        <label class="form_label" for="product_code">${element.doc_type}</label>
        <input mark="resubmit" type="file" file_type="${element.doc_type}" style="color: black;background: transparent;width: 100%;"/>
      </div>`
    }
    $("#list_resubmit").html(b_html);
}
let ResubmitTab = function () {
    let offerTab =
        '<li role="presentation" id="offer_tab_href">' +
        '<a href="#resubmit" aria-controls="home" role="tab" data-toggle="tab" class="bb0">' +
        '<span class="fa fa-file-text-o hidden"></span>' +
        "Resubmit</a>" +
        "</li>";
    $("#agent_tablist").append(offerTab);
}
let ECShowProducts = (partner_code, request_id, app_status, status, call_status, reject_reason = "") => {
    $("#full-loan-form input[name='dsa_agent_code']").val(DSA_CODE);
    removeElement("offer_tab_href");
    clearForm($("#full-loan-form"));
    ShowStatusOnForm(status, call_status, app_status, reject_reason);
    $("#hide_div_eligible").hide();
    $("#create-offer-table").empty();
    SetProductListForm();
    // $("#offer-datatable").empty();
    removeElement("submit_fullloan_btn");
    removeElement("product_tab_href");
    //   $("#offer-datatable")[0].innerHTML = `
    // 	<div class="col-xl-12 col-lg-8">
    // 	    <table id="offer-list-table" class="display responsive no-wrap table table-responsive table-striped table-bordered" width="100%">
    // 	    </table>
    // 	</div>
    // 	<div class="col-xl-12 col-lg-4">
    // 	    <table id="offer-insurance-list-table" class="display responsive no-wrap table table-responsive table-striped table-bordered" width="100%">
    // 	    </table>
    // 	</div>
    // `;
    clearForm($("#full-loan-form"));
    clearAFForm();
    if (app_status == "VALIDATED") {
        CreateOfferTab();
        ajaxGetOffer(request_id).done((result) => {
            if (result.data.offer_list != undefined && result.data.offer_list != null) {
                IsSuccessPolled = true;
                SyncFullLoanFromAPI(request_id);
                // offer = result.data.document;
                offerList = result.data.offer_list;
                proposal_id = result.data.proposal_id;
                $("#contract_number").val(proposal_id);
                SetOfferDetail(offerList);
            } else {
                proposal_id = "";
            }
        });
    } else if (app_status == "RESUBMIT") {
        RequireResubmit = {}
        ResubmitTab()
        ajaxGetDoc(request_id).done((result) => {
            if (
                result.data != undefined &&
                result.data.document != undefined
            ) {
                let record = result.data.document.data;
                $("#contract_number").val(record.contract_number);
                fill_file_requier(record);
            }
        });
    }

    if (request_id == "" || request_id.length == 0) {
        request_id = partner_code + Date.now().toString();
        $(".formMain input[name='request_id']").val(request_id);
    }
    if (partner_code != "" && partner_code.length > 0) {
        let productTab =
            '<li role="presentation" id="product_tab_href" hidden>' +
            '<a href="#products" aria-controls="home" role="tab" data-toggle="tab" class="bb0">' +
            '<span class="fa fa-file-text-o hidden"></span>' +
            "Products</a>" +
            "</li>";
        $("#agent_tablist").append(productTab);
        $("#accordion").empty();
        $("#hide_div_eligible").show();
        ajaxGetECProducts(partner_code, request_id);
        lead_id = $(".formMain input[name='lead_id']").val();
        // TEST
        // lead_id = "1234";
        if (lead_id != "" && lead_id.length > 0) {
            try {
                SyncFullLoanFromAPI(lead_id);
            } catch (error) {
                console.log(error);
            }
        }
    }
    return request_id;
};
let ECProducts = null;

let ajaxGetECProducts = (partner_code, request_id) => {
    return $.ajax({
        url: EC_PROD_API_URL + "/los-united/v1/product/vtman/product-list?partner_code=TEL",
        method: "GET",
        timeout: 0,
        headers: {
            // Authorization: "Bearer "+CRM_TOKEN,
            "Content-Type": "application/json",
        }
    }).fail((result, status, error) => {
        console.log("Get Product List Failed: ", result);
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
    }).done((result) => {
        //
        SetProductListForm();
        if (result.code == 0) {
            ECProducts = result.data;
            format_log_productlist(ECProducts);
            let color_index = 0;
            let index = 1;
            let select_product_code = $("select[name='product_code']")[0];
            let product_lists = ECProducts.sort(function (a, b) {
                return a.product_code.localeCompare(b.product_code)
            });
            $(`<option value="">Chọn sản phẩm</option>`).appendTo(select_product_code);
            for (prd of product_lists) {
                $(
                    `<option des="${prd.mkt_desc}" value="${prd.product_code}">${prd.product_code} - ${prd.mkt_desc}</option>`
                ).appendTo(select_product_code);
            }
            return;
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
                    columns: [{
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
                                data != null ?
                                    data.toLocaleString("vi-VN", {
                                        style: "currency",
                                        currency: "VND",
                                    }) :
                                    0;
                            return result;
                        },
                    },
                    {
                        title: "Khoản vay tối đa",
                        data: "loan_max_amount",
                        render: (data) => {
                            result =
                                data != null ?
                                    data.toLocaleString("vi-VN", {
                                        style: "currency",
                                        currency: "VND",
                                    }) :
                                    0;
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
                                        value != null ?
                                            value.toLocaleString("vi-VN", {
                                                style: "currency",
                                                currency: "VND",
                                            }) :
                                            0;
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
                                                columns: [{
                                                    title: "Doc EN",
                                                    data: "doc_description_en",
                                                },
                                                {
                                                    title: "Doc VI",
                                                    data: "doc_name",
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
    });;
};

let getLeadInfo = (lead_id) => {
console.log(lead_id)
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
        url: "https://ec02.tel4vn.com/goAPIv2/goLoadLeads/goAPI.php",
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
            console.log("Basic "+basic)
            SyncCustomerInfomation(lead_info, basic);
        })
        .fail(function (result) {
            console.log(result);
        });
};

let SyncCustomerInfomation = (thisVdata, basic_requestid) => {
    console.log(thisVdata)
    console.log(basic_requestid)
    $(".formMain input[name='first_name']").val("");
    $(".formMain input[name='middle_initial']").val("");
    $(".formMain input[name='last_name']").val("");
    $("#custormer_tab").click();
    LeadPrevDispo = thisVdata.status;
    $(".formMain input[name='vendor_lead_code']").val(thisVdata.vendor_lead_code);
    $(".formMain input[name='lead_id']")
        .val(thisVdata.lead_id)
        .trigger("change");
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
    } catch (error) { }
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

    var REGcommentsNL = new RegExp("!N!", "g");
    try {
        if (typeof thisVdata.comments !== 'undefined') {
            thisVdata.comments = thisVdata.comments.replace(REGcommentsNL, "\n");
        }
    } catch (error) {

    }
    $(".formMain textarea[name='comments']").val(thisVdata.comments).trigger('change');
    $(".formMain select[name='basic_request_id']").html("");
    basic_requestid.forEach(element => {
        let tmp = $(".formMain select[name='basic_request_id']").html();
        $(".formMain select[name='basic_request_id']").html(tmp + `<option value='${element.request_id}' selected>${element.request_id}</option>`)
    });
    ECShowProducts(thisVdata.partner_code, thisVdata.request_id, thisVdata.app_status, thisVdata.status, thisVdata.call_status, thisVdata.reject_reason)
    // $(".formMain textarea[name='call_notes']").val(thisVdata.call_notes).trigger('change');
};

$(document).on("click", "#mapping_af1", function (e) {
    let existed_basic_id = get_select_options("basic_request_id");
    if (existed_basic_id.includes($("#request_id").val()) == false || $("#request_id").val() == "") {
        swal("Không thành công", "RequestID chưa check basic info", "error");
        return;
    }
    SyncFullLoanFromContact()
    tata.info('Đã map', "Information --> AF1", {
        position: 'tl',
        animate: 'slide',
        duration: 2500
    })
});

$(document).on("click", "#change_request_btn", function (e) {
    let tmp = "TEL" + Date.now().toString();
    $(".formMain input[name='request_id']").val(tmp);
});
$(document).on("click", "#select_request_btn", function (e) {
    let tmp = $("#basic_request_id")[0].value;
    $(".formMain input[name='request_id']").val(tmp);
});
$(document).on("click", "#btn-application", function (e) {
    let leadId = $(this).attr("data-leadid");
    let status = $("#btnResumePause").attr("title");
    if (status == "Resume Dialing") {
        $("#returnhome").click();
        getLeadInfo(leadId);
    } else {
        swal("Không thành công", "Vui lòng Pause Dialer", "error");
        return;
    }
    // getLeadInfo("5547595");
});
$(document).on("click", "#submit-offer", function (e) {
    e.preventDefault();
    $(this).attr('disabled', 'disabled');
    let loan_request_id = $(".formMain input[name='request_id']").val();
    let partner_code = $(".formMain input[name='partner_code']").val();
    if (selected_offer_insurance_type == "NO") {
        selected_offer_insurance_type = NULL;
    }
    let offer_data = {
        request_id: loan_request_id,
        partner_code: partner_code,
        selected_offer_id: selected_offer_id,
        selected_offer_amount: selected_offer_amount,
        selected_offer_insurance_type: selected_offer_insurance_type,
    };

    $.ajax({
        type: "POST",
        url: EC_PROD_API_URL + "/los-united/v2/dsa/select-offer",
        processData: true,
        data: JSON.stringify(offer_data),
        async: true,
        dataType: "json",
        headers: {
            // Authorization: "Bearer "+CRM_TOKEN,
            "Content-Type": "application/json",
        },
    })
        .fail((result, status, error) => {

            $(this).removeAttr('disabled');
            let msg = "Please contact developer!";
            msg = result.responseJSON.message;
            if (result.message !== undefined) {
                msg = result.message;
            }
            if (result.responseText != undefined) {
                try {
                    let err = JSON.parse(result.responseText);
                    console.log("Select Offer Failed: ", result.responseJSON);
                    if (err.error != undefined) {
                        msg += "\n" + JSON.stringify(err.error);
                    }
                } catch (error) {
                    msg = result.responseText;
                }
            }
            swal("Send offer data fail!", msg, "error");
        })
        .done((result) => {
            $(this).removeAttr('disabled');
            if (result.code == "RECEIVED") {
                swal("Success", result.message, "success");
            } else {
                swal("Error!", result.message, "error");
            }
        });
});
$(document).on("click", "#scSubmit", function (e) {
    ajaxGetECProducts("TEL", "TEL123456789");
});
$("#eligible_btn").on("click", (e) => {
    // 

    // 
    $("#eligible_btn").attr("disabled", true);
    $("#full-loan-form input[name='dsa_agent_code']").val(DSA_CODE);
    e.preventDefault();
    let app_status = $(".formMain input[name='app_status']").val();
    if (DO_NOT_REAPP.includes(app_status)) {
        swal("Error!", "Không được lên lại hồ sơ với hồ sơ trạng thái : " + app_status, "error");
        $("#eligible_btn").attr("disabled", false);
        return;
    }
    let partner_code = $(".formMain input[name='partner_code']").val();
    if (partner_code.length < 1) {
        swal("Error!", "Partner Code is empty!", "error");
    } else {
        let request_id = $(".formMain input[name='request_id']").val();
        if (request_id == "") {
            request_id = partner_code + Date.now().toString();
        }
        let existed_basic_id = get_select_options("basic_request_id");
        if (existed_basic_id.includes(request_id) == true) {
            swal(
                "RequestID đã tồn tại.",
                "Vui lòng đổi requestID mới",
                "error"
            );
            $("#eligible_btn").attr("disabled", false);
            return;
        }
        let first_name = $(".formMain input[name='first_name']").val();
        let middle_initial = $(".formMain input[name='middle_initial']").val();
        let last_name = $(".formMain input[name='last_name']").val();
        let customer_name = first_name.trim();
        if (middle_initial == "") {
            customer_name = customer_name.trim() + " " + last_name.trim();
        } else {
            customer_name = customer_name +
                " " + middle_initial.trim() + " " + last_name.trim();
        }
        customer_name = customer_name.trim();
        customer_name = customer_name.replace("  ", " ").normalize();
        let phone_code = $(".formMain input[name='phone_code']").val();
        if (phone_code == "") { phone_code = "0" };
        let phone_number = phone_code + get_main_phone_number();
        let date_of_birth = $(".formMain input[name='date_of_birth']").val();
        // 
        let issue_date = $(".formMain input[name='identity_issued_on']").val();
        let id_number = $(".formMain input[name='identity_number']").val();
        let id_place = $(".formMain select[name='identity_issued_by']").val();
        // CHECK ALT IDENTITY CARD
        if ($(".formMain input[name='alt_identity_number']").val() != "") {
            id_number = $(".formMain input[name='alt_identity_number']").val();
            issue_date = $(".formMain input[name='alt_identity_issued_on']").val();
            id_place = $(".formMain select[name='alt_identity_issued_by']").val();
        } else {
            id_number = $(".formMain input[name='identity_number']").val();
            issue_date = $(".formMain input[name='identity_issued_on']").val();
            id_place = $(".formMain select[name='identity_issued_by']").val();
        }
        let tem_province = $(".formMain input[name='province']").val();
        let job_type = $(".formMain input[name='job_type']").val();
        let gender_v = $(".formMain select[name='gender']").val();
        // date_of_birth = moment(date_of_birth, "YYYY-MM-DD").format("DD-MM-YYYY");
        // issue_date = moment(issue_date, "YYYY-MM-DD").format("DD-MM-YYYY");
        let eligible_data = {
            lead_id: "" + lead_id,
            request_id: request_id,
            channel: "DSA",
            partner_code: partner_code,
            // dsa_agent_code: DSA_CODE,
            identity_card: id_number,
            date_of_birth: date_of_birth,
            customer_name: customer_name,
            issue_date: issue_date,
            phone_number: phone_number,
            issue_place: id_place,
            gender: gender_v
            // email: $(".formMain input[name='email']").val(),
            // tem_province: tem_province,
            // job_type: job_type,
        };
        let eligible_string = JSON.stringify(eligible_data);
        // if (tmp_eligible== eligible_string){
        //   swal(
        //     "Thông tin eligible giống trước",
        //     "Vui lòng thay đổi để eligible để hạn chế spam",
        //     "error"
        //   );
        //   return;
        // }
        // tmp_eligible = eligible_string;
        console.info("Eligible data: ", eligible_data);
        $.ajax({
            type: "POST",
            url: EC_PROD_API_URL + "/los-united/v1/dsa/basic-info",
            processData: true,
            data: eligible_string,
            async: true,
            dataType: "json",
            headers: {
                "Content-Type": "application/json",
                // Authorization: "Bearer "+CRM_TOKEN,
            },
        })
            .fail((result, status, error) => {
                $("#eligible_btn").attr("disabled", false);
                console.log("Eligible failed: ", result);
                var erro = result.responseJSON;
                let msg = "Please contact developer!";
                // request_id = partner_code + Date.now().toString();
                // $(".formMain input[name='request_id']").val(request_id);
                if (result.body !== undefined) {
                    msg = result.body.message;
                }
                if (erro != undefined) {
                    swal(
                        "Send eligible data fail!",
                        erro.body.message + "Please try again",
                        "error"
                    );
                } else {
                    swal(
                        "Send eligible data fail!",
                        error + "Please try again",
                        "error"
                    );
                }
            })
            .done((result) => {
                $("#eligible_btn").attr("disabled", false);
                // TESTING
                if (result.body.code == "ELIGIBLE") {
                    swal("Success", result.message, "success");
                    let request_id = $(".formMain input[name='request_id']").val();
                    updateRequestId(request_id, lead_id);
                    SyncFullLoanFromAPI(lead_id);
                    $("#full-loan-form select[name='employment_type']").trigger('change');
                    $("#full-loan-form input[name='condition_confirm']").prop('checked', true);
                    $("#full-loan-form input[name='other_confirm']").prop('checked', true);
                    $("#full-loan-form input[name='term_confirm']").prop('checked', true);
                } else if (result.body.code == "NOT_ELIGIBLE") {
                    request_id = partner_code + Date.now().toString();
                    $(".formMain input[name='request_id']").val(request_id);
                    swal("NOT ELIGIBLE!", result.body.message, "error");
                } else {
                    swal("SOMETHING ERROR", result.body.message, "error");
                }
            });
    }
});
let set_offer_upload_docs = () => {
    for (var i = 0; i < selected_product.bundles.length; i++) {
        let is_uploaded_docs = false;
        let docs = selected_product.bundles[i];
        tmp_product_names = "";
        tmp_product_names += `<div class="row">`;
        tmp_product_names += `
    <div class="col-lg-12">
      <label>${i + 1}/ ${docs.bundle_code} -  ${docs.bundle_name} . Tối thiểu: ${docs.min_request} loại giấy tờ</label>
    </div>`;
        let tmp_string = "[";
        for (var j = 0; j < docs.doc_list.length; j++) {
            tmp_string += docs.doc_list[j].doc_type;
            if (uploaded_docs.includes(docs.doc_list[j].doc_type)) {
                is_uploaded_docs = true;
            }
            tmp_product_names += `
        <div class="col-lg-3">
          <input type="text" value="${docs.doc_list[j].doc_type} - ${docs.doc_list[j].doc_name}" class="mda-form-control ng-pristine ng-empty ng-invalid ng-touched" readonly disabled>
        </div>
      `
            if (j != docs.doc_list.length - 1) {
                tmp_string += "|";
            }
        }
        tmp_string += "]";
        docs_string += tmp_string;

        tmp_product_names += `</div><hr style="margin : 10px">`;
        product_names += tmp_product_names;
        if (!is_uploaded_docs) {
            offder_product_names += tmp_product_names.replace("1/ ", "- ").replace("2/ ", "- ").replace("3/ ", "- ")
        }
        // offder_product_names += `</div><hr style="margin : 10px">`;
        if (i != selected_product.bundles.length - 1) {
            docs_string += " && ";
        }
    }
}
let getProductType = () => {
    allow_check_docs = []
    var docs_string = "";
    var offder_product_names;
    var offder_docs_string = "";
    var uploaded_docs = ["SPID", "SFRB"]
    var product_names = `<div class="row">
                          <div class="col-lg-12">
                            <label style="font-size: large;">Chứng từ bắt buộc </label>
                          </div>
                        </div>`;
    var offder_product_names = `<div class="row">
  <div class="col-lg-12">
    <label style="font-size: large;">Chứng từ bổ sung</label>
  </div>
</div>`;
    for (var i = 0; i < selected_product.bundles.length; i++) {
        let is_uploaded_docs = false;
        let docs = selected_product.bundles[i];
        tmp_product_names = "";
        tmp_product_names += `<div class="row">`;
        tmp_product_names += `
    <div class="col-lg-12">
      <label>${i + 1}/ ${docs.bundle_name} -  ${docs.bundle_name_vi} . Tối thiểu: ${docs.min_request} loại giấy tờ</label>
    </div>`;
        let tmp_string = "[";
        for (var j = 0; j < docs.doc_list.length; j++) {
            let dt = docs.doc_list[j].doc_type;
            let dn = docs.doc_list[j].doc_name;
            allow_check_docs.push({"doc_type":dt,"doc_name":dn})
            tmp_string += docs.doc_list[j].doc_type;
            if (uploaded_docs.includes(docs.doc_list[j].doc_type)) {
                is_uploaded_docs = true;
            }
            tmp_product_names += `
        <div class="col-lg-12">
          <input type="text" value="${docs.doc_list[j].doc_type} - ${docs.doc_list[j].doc_name}" class="mda-form-control ng-pristine ng-empty ng-invalid ng-touched" readonly disabled>
        </div>
      `
            if (j != docs.doc_list.length - 1) {
                tmp_string += "|";
            }
        }
        tmp_string += "]";
        docs_string += tmp_string;

        tmp_product_names += `</div><hr style="margin : 10px">`;
        product_names += tmp_product_names;
        if (!is_uploaded_docs) {
            offder_product_names += tmp_product_names.replace("1/ ", "- ").replace("2/ ", "- ").replace("3/ ", "- ")
        }
        // offder_product_names += `</div><hr style="margin : 10px">`;
        if (i != selected_product.bundles.length - 1) {
            docs_string += " && ";
        }
    }
    $("input[name='product_required_document']").val(docs_string);
    $("#product_name_detail").empty();
    $("#product_name_detail")[0].innerHTML = product_names;
    // $("input[name='product_required_document_offer']").val(docs_string);
    $("#product_name_detail_offer").empty();
    $("#product_name_detail_offer")[0].innerHTML = offder_product_names;
};
let validateFullloan = () => {
    let check = true;
    let msg = "";
    /*if ($("#vendor_lead_code").val()  != VTA_List) {
        if (RequiredDocs["PIC"] == false) {
            check = false;
            msg += "Chưa upload ảnh Sefie\n";
        }
        if (RequiredDocs["PID"] == false) {
            check = false;
            msg += "Chưa upload ảnh CMND\n";
        }
    }*/
    $("#full-loan-form").find('input:required').each(function () {
        let element = $(this);
        if (["workplace_address", "workplace_district", "workplace_name", "workplace_province", "workplace_ward"].includes(element.attr('name')) == false) {
            if (element[0].validationMessage != "") {
                msg += translator[element.attr('name')] + " : " + translator[element[0].validationMessage] + "\n";
            }
        }
    })
    $("#full-loan-form").find('select:required').each(function () {
        let element = $(this);
        if (["workplace_address", "workplace_district", "workplace_name", "workplace_province", "workplace_ward"].includes(element.attr('name')) == false) {
            if (element[0].validationMessage != "") {
                msg += translator[element.attr('name')] + " : " + translator[element[0].validationMessage] + "\n";
            }
        }
    })
    if ($("input[name='condition_confirm']")[0].checked == false) {
        check = false;
        msg += "Chưa đồng ý điều khoản\n";
    }
    if ($("input[name='term_confirm']")[0].checked == false) {
        check = false;
        msg += "Chưa đồng ý điều khoản\n";
    }
    if ($("input[name='other_confirm']")[0].checked == false) {
        check = false;
        msg += "Chưa đồng ý điều khoản\n";
    }
    if (!check) {
        sweetAlert(msg);
    }
    return check;
}
let SyncFullLoanFromAPI = (request_id) => {
    try {
        ajaxGetOldFullLoan(request_id).done((result) => {
            try { result = JSON.parse(result); } catch (error) { }
            if (result.error == "Not found") {
                SyncFullLoanFromContact()
                return;
            }
            try {
                let data = result.data;
                try { data = JSON.parse(data); } catch (error) { }
                let document = data.document;
                try { document = JSON.parse(document); } catch (error) { }
                for (const property in document) {
                    if (property == "loan_tenor" || property == "loan_amount") {
                        console.log(property, ":", document[property])
                    }
                    try {

                        $("#full-loan-form input[name='" + property + "']")
                            .val(document[property])
                            .trigger("change");
                        $("#full-loan-form select[name='" + property + "']")
                            .val(document[property])
                            .trigger("change");

                    } catch (error) {

                    }
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
                if ($("#vendor_lead_code").val() == VTA_List) {
                    try {
                        $("select[name='bank_code']")
                            .val(document["bank_code"])
                            .trigger("change")
                            .selectpicker("refresh");
                        if (document["bank_branch_code"] != null && document["bank_branch_code"] != undefined) {
                            let tmp_branch = BANK_BRANCH_CODE[document["bank_branch_code"]];
                            $("select[name='bank_area']")
                                .val(tmp_branch["area"])
                                .trigger("change")
                                .selectpicker("refresh");
                            $("select[name='bank_branch_code']")
                                .val(document["bank_branch_code"])
                                .trigger("change")
                                .selectpicker("refresh");
                        } else {
                            try {

                                $("select[name='bank_area']").val($("select[name='bank_area'] option")[1].value);
                                $("select[name='bank_area']").trigger("change").selectpicker("refresh");
                                $("select[name='bank_branch_code']").val($("select[name='bank_branch_code'] option")[1].value);
                                $("select[name='bank_branch_code']").trigger("change").selectpicker("refresh");
                                
                            } catch (error) {
                                
                                $("select[name='bank_area']").val($("select[name='bank_area'] option")[2].value);
                                $("select[name='bank_area']").trigger("change").selectpicker("refresh");
                                $("select[name='bank_branch_code']").val($("select[name='bank_branch_code'] option")[2].value);
                                $("select[name='bank_branch_code']").trigger("change").selectpicker("refresh");
                                

                            }
                        }
                    } catch (error) {

                    }

                }
                // CHECK ALT IDENTITY
                if ($(".formMain input[name='alt_identity_number']").val() != "") {
                    $("#full-loan-form input[name='identity_card_id']").val($(".formMain input[name='alt_identity_number']").val()).trigger("change");
                    $("#full-loan-form input[name='issue_date']").val($(".formMain input[name='alt_identity_issued_on']").val()).trigger("change");
                    $("#full-loan-form select[name='issue_place']").val($(".formMain select[name='alt_identity_issued_by']").val()).trigger("change").selectpicker("refresh");
                } else {
                    $("#full-loan-form input[name='identity_card_id']").val($(".formMain input[name='identity_number']").val()).trigger("change");
                    $("#full-loan-form input[name='issue_date']").val($(".formMain input[name='identity_issued_on']").val()).trigger("change");
                    $("#full-loan-form select[name='issue_place']").val($(".formMain select[name='identity_issued_by']").val()).trigger("change").selectpicker("refresh");
                }
                $("#full-loan-form input[name='date_of_birth']").val(
                    moment(document["date_of_birth"], "DD-MM-YYYY").format("YYYY-MM-DD")
                );
                // 
                $("#full-loan-form input[name='phone_number']").val("0" + get_main_phone_number())
                $("#full-loan-form input[name='issue_date']")
                    .val($(".formMain input[name='identity_issued_on']").val())
                    .trigger("change");
                $("#full-loan-form select[name='issue_place']")
                    .val($(".formMain select[name='identity_issued_by']").val())
                    .trigger("change").selectpicker("refresh");
                $("#full-loan-form input[name='condition_confirm']").prop('checked', true)
                $("#full-loan-form input[name='term_confirm']").prop('checked', true)
                $("input[tag='currency']").trigger('blur');
                try {
                    let current_tenor = document['loan_tenor'];
                    let current_amount = document['loan_amount'];
                    console.log(current_amount, current_tenor)
                    $("input[name='range_loan_tenor']").val(current_tenor).trigger("input");
                    $("input[name='range_loan_amount']").val(current_amount).trigger("input");
                } catch (error) {
                    console.log(error)
                }
                $(`input[name='simu_insurance']`)[0].value = "0";
                $(`input[name='simu_insurance']`)[1].value = "6";
                $(`input[name='simu_insurance']`)[2].value = "8";
                $(`input[name='simu_insurance'][value='${data.document.simu_insurance}']`).click().trigger('change')
                simulator();
                $(".formMain input[name='city']").val(document.tem_ward)
                $(".formMain input[name='address1']").val(document.tem_address)
                $(".formMain select[name='gender']").val(document.gender);
                $("input[name='tem_address']").val(document.tem_address);
                // 
                if (document['check_same_address'] == 'on') {
                    $("input[name='check_same_address']").prop('checked', true).trigger('change');
                } else {
                    $("input[name='check_same_address']").prop('checked', false).trigger('change');
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
                $("#full-loan-form input[name='dsa_agent_code']").val(DSA_CODE);
                $("#img_id_card2").val("")
                $("#img_selfie2").val("")
                // MISS MATCH PRODUCT LIST OLD
                if (document["product_type"] != undefined){
                    $("select[name='product_code']")
                    .val(document["product_type"])
                    .trigger("change")
                }
                // 
                getProductType();
                SyncFullLoanFromContact();
            } catch (error) {
                console.log("SyncFullLoan", error)
                SyncFullLoanFromContact();
            }
        });
    } catch (err) {
        SyncFullLoanFromContact();
        console.log("SyncFullLoanFromAPI error : ", err);
    }
};

let SyncFullLoanFromAPIOld = (request_id) => {
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
        console.log("SyncFullLoanFromAPIOld error : ", err);
    }
};

let ajaxGetOldFullLoan = (request_id) => {
    // TEST
    // request_id = "5228003"
    return $.ajax({
        type: "GET",
        url: TEL4VN_API_URL + `/v1/fullloan/${request_id}`,
        async: true,
        dataType: "json",
        headers: {
            "Content-Type": "application/json",
        },
    }).fail((result, status, error) => {
        SyncFullLoanFromContact();
        console.log("SyncFullLoanFromContact error : ", result);
    });
};

let ajaxGetOffer = (request_id) => {
    // TEST
    // request_id = "SPO1610530540234"
    return $.ajax({
        type: "GET",
        url: EC_PROD_API_URL + `/los-united/v1/dsa/offers?request_id=${request_id}`,
        async: true,
        dataType: "json",
        headers: {
            "Content-Type": "application/json",
        },
    }).fail((result, status, error) => {
        console.log("ajaxGetOffer", result);
    });
};

let ajaxGetDoc = (request_id) => {
    // TEST
    return $.ajax({
        type: "GET",
        url: TEL4VN_API_URL + `/tel4vn/v1/resubmit/${request_id}`,
        async: true,
        dataType: "json",
        headers: {
            "Content-Type": "application/json",
        },
    }).fail((result, status, error) => {
        console.log("ajaxGetOffer", result);
    });
};
let ajaxGetStatus = (lead_id) => {
    return $.ajax({
        type: "GET",
        url: CRM_API_URL + `/v1/lead/${lead_id}/status`,
        async: true,
        dataType: "json",
        headers: {
            "Content-Type": "application/json",
        },
    }).fail((result, status, error) => {
        console.warn("ajaxGetStatus: ", result);
    });
};

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

$("input[type='checkbox'][name='check_same_address']").on("change", (e) => {
    CheckBoxSyncFieldFullLoan(
        $("#full-loan-form input[name='check_same_address']").is(":checked")
    );
});

let SyncFullLoanFromContact = () => {

    let first_name = $(".formMain input[name='first_name']").val();
    let middle_initial = $(".formMain input[name='middle_initial']").val();
    let last_name = $(".formMain input[name='last_name']").val();
    let customer_name = first_name.trim();
    if (middle_initial == "") {
        customer_name = customer_name.trim() + " " + last_name.trim();
    } else {
        customer_name = customer_name +
            " " + middle_initial.trim() + " " + last_name.trim();
    }
    customer_name = customer_name.trim();
    customer_name = customer_name.replace("  ", " ")
    let phone_number =
        $(".formMain input[name='phone_code']").val() + get_main_phone_number();
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
        tem_ward: $(".formMain input[name='city']").val(),
        tem_address: $(".formMain input[name='address1']").val(),
        workplace_phone: "1234567890",
    };
    for (const property in tmp_data) {
        $("#full-loan-form input[name='" + property + "']").val(tmp_data[property]);
    }
    $("#full-loan-form select[name='gender']").val(tmp_data.gender);
    $("#full-loan-form input[name='issue_date']")
        .val($(".formMain input[name='identity_issued_on']").val())
        .trigger("change");
    $("#full-loan-form input[name='beneficiary_name']").val(customer_name.normalize());
    $("#full-loan-form select[name='issue_place']")
        .val($(".formMain select[name='identity_issued_by']").val())
        .trigger("change").selectpicker("refresh");
    // CHECK ALT IDENTITY
    if ($(".formMain input[name='alt_identity_number']").val() != "") {
        $("#full-loan-form input[name='identity_card_id']").val($(".formMain input[name='alt_identity_number']").val()).trigger("change");
        $("#full-loan-form input[name='issue_date']").val($(".formMain input[name='alt_identity_issued_on']").val()).trigger("change");
        $("#full-loan-form select[name='issue_place']").val($(".formMain select[name='alt_identity_issued_by']").val()).trigger("change").selectpicker("refresh");
        $("#full-loan-form input[name='identity_card_id_other']").val($(".formMain input[name='identity_number']").val()).trigger("change");
    } else {
        $("#full-loan-form input[name='identity_card_id']").val($(".formMain input[name='identity_number']").val()).trigger("change");
        $("#full-loan-form input[name='issue_date']").val($(".formMain input[name='identity_issued_on']").val()).trigger("change");
        $("#full-loan-form select[name='issue_place']").val($(".formMain select[name='identity_issued_by']").val()).trigger("change").selectpicker("refresh");
    }
    $("#full-loan-form input[name='condition_confirm']").prop('checked', true)
    $("#full-loan-form input[name='term_confirm']").prop('checked', true)
    $("input[tag='currency']").trigger('blur');
    $("select[name='issue_place']").next("button")[0].disabled = true;
};

function clearInputFile(f) {
    if (f.value) {
        try {
            f.value = ""; //for IE11, latest Chrome/Firefox/Opera...
        } catch (err) { }
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

function clearAFForm() {

    $("a[role='tab']")[0].click();
    $('#smartwizard').smartWizard("reset");
    $("#full-loan-form select[name='issue_place']").val("").trigger("change").selectpicker("refresh");
    $("#full-loan-form select[name='tem_province']").val("").trigger("change").selectpicker("refresh");
    $("#full-loan-form select[name='permanent_province']").val("").trigger("change").selectpicker("refresh");
    $("#full-loan-form select[name='job_type']").val("SFF").trigger("change");
    $("#full-loan-form select[name='employment_contract']").val("IT").trigger("change");
    $("#full-loan-form input[name='tem_address']").val("");
    $("#full-loan-form input[name='permanent_address']").val("");
    $("#full-loan-form input[name='from']").val(2021).trigger("blur");
    $("#full-loan-form input[name='to']").val(2021).trigger("blur");
    $("#full-loan-form input[name='condition_confirm']").prop('checked', true)
    $("#full-loan-form input[name='term_confirm']").prop('checked', true)
    $("#full-loan-form input[name='other_confirm']").prop('checked', true)
}

function clearForm($form) {
    $(".formMain input[name='first_name']").val("");
    $(".formMain input[name='middle_initial']").val("");
    $(".formMain input[name='last_name']").val("");
    $form
        .find(":input")
        .not(":button, :submit, :reset, :hidden, :checkbox, :radio")
        .val("");
    $form.find(":checkbox, :radio").prop("checked", false);
    $("#submit-full-loan").attr("hidden", false);
    $("#submit-offer").attr("hidden", true);
    $("#offer-waiting").attr("hidden", true);
    $("#full-loan-form input[name='identity_card_id_other']").val("").trigger("change");
    $("input[name='request_id_ref']").val("");
    clearInputFile($("#img_selfie")[0]);
    clearInputFile($("#img_id_card")[0]);
    selected_offer_insurance_type = "";
    var list_docs = $(".MultiFile-remove");
    for (let index = 0; index < list_docs.length; index++) {
        list_docs[index].click();
    }
    list_doc_collecting = [];
    RequireResubmit = {}
    proposal_id = ""
    $("#contract_number").val("");
    isUploadPIC = false;
    isUploadPID = false;
    RequiredDocs = {
        "PID": false,
        "PIC": false
    }
}

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
    //$("input[name='simu_insurance']")[0].checked = true;
}

$(document).on("click", 'input[name="simu_insurance"]', function (e) {
    simulator(e);
});
$(document).on("change", 'select[name="product_code"]', function (e) {
    let product_code = this.value;
    $("input[name='simu_insurance']")[0].checked = true;
    ECProducts.forEach((prd) => {
        if (prd.product_code == product_code) {
            selected_product = prd;
            //
            // Loan tenor
            $("#full-loan-form input[name='range_loan_tenor']")[0].max =
                prd.max_tenor;
            $("#full-loan-form input[name='range_loan_tenor']")[0].min =
                prd.min_tenor;
            $("#full-loan-form input[name='range_loan_tenor']")[0].value =
                prd.min_tenor;
            //
            $("#full-loan-form input[name='loan_tenor']")[0].max = prd.max_tenor;
            $("#full-loan-form input[name='loan_tenor']")[0].min = prd.min_tenor;
            $("#full-loan-form input[name='loan_tenor']")[0].value =
                prd.min_tenor;
            //
            // Loan amount
            $("#full-loan-form input[name='range_loan_amount']")[0].max =
                prd.max_amt;
            $("#full-loan-form input[name='range_loan_amount']")[0].min =
                prd.min_amt;
            $("#full-loan-form input[name='range_loan_amount']")[0].value =
                prd.min_amt;
            //
            $("#full-loan-form input[name='loan_amount']")[0].max =
                prd.max_amt;
            $("#full-loan-form input[name='loan_amount']")[0].min =
                prd.min_amt;
            $("#full-loan-form input[name='loan_amount']")[0].value =
                prd.min_amt;
            //
            simulator(e)
            return;
        }
    });
    // if (selected_employment_type.employee_type != "SE") {
    //     $("#bussiness_se").attr('hidden', true)
    // } else {
    //     $("#bussiness_se").attr('hidden', false)
    // }
    getProductType();
    $("#product_required_description").text(selected_product.mkt_desc);
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
    $("#disbursement_method_bank").attr('hidden', !req)
});

$(document).on("change", 'select[name="employment_type"]', function () {
    selected_employment_type = $(this).val();
    console.log(selected_employment_type);
    if (selected_employment_type != "SE") {
        $("#bussiness_se").attr('hidden', true)
    } else {
        $("#bussiness_se").attr('hidden', false)
    }
});
// $(document).on("change", 'select[name="employment_type"]', function () {
//     selected_employment_type = null;
//     let em_type = this.value;
//     if (ECProducts != undefined) {
//         let select_product_code = $("select[name='product_code']")[0];
//         select_product_code.innerHTML = "";
//         ECProducts.forEach((et) => {
//             if (et.employee_type == em_type) {
//                 if (selected_employment_type == null) {
//                     selected_employment_type = et;
//                 } else {
//                     selected_employment_type.product_list = [].concat(selected_employment_type.product_list, et.product_list);
//                 }
//                 let product_lists = et.product_list.sort(function (a, b) {
//                     return a.product_code.localeCompare(b.product_code)
//                 });
//                 $(`<option value=""></option>`).appendTo(select_product_code);
//                 for (prd of product_lists) {
//                     $(
//                         `<option des="${prd.product_description}" value="${prd.product_code}">${prd.product_code} - ${prd.product_description}</option>`
//                     ).appendTo(select_product_code);
//                 }
//             }
//         });
//     }
// });

$(document).on("keyup", 'input[tag="currency"]', function () {
    let val = this.value;
    if (val == "" || val == undefined) { }
    this.value = val.replace(/[^0-9\.]/g, "");
    this.value = this.value.split(".").join("");
});

$(document).on("blur", 'input[tag="currency"]', function () {
    if (this.value == "" || this.value == undefined) { }
    this.value = this.value.replace(/[^0-9\.]/g, "");
    this.value = this.value.split(".").join("");
    this.value = formatter.format(this.value);
});

$(document).on("keyup", 'input[name="customer-offer-amount"]', function () {
    let val = this.value;
    if (val == "" || val == undefined) { }
    this.value = val.replace(/[^0-9\.]/g, "");
    this.value = this.value.split(".").join("");
});

$(document).on("keyup", 'input[name^="customer-offer"]', function () {
    let val = this.value;
    if (val == "" || val == undefined) { }
    this.value = val.replace(/[^0-9\.]/g, "");
    this.value = this.value.split(".").join("");
});
$(document).on("blur", 'input[name="customer-offer-amount"]', function () {
    let val = this.value;
    if (val == "" || val == undefined) { }
    this.value = val.replace(/[^0-9\.]/g, "");
    this.value = this.value.split(".").join("");
    let fmv = formatter.format(this.value);
    this.value = fmv;
});

$(document).on("blur", 'input[name="customer-offer-monthly"]', function () {
    let val = this.value;
    if (val == "" || val == undefined) { }
    this.value = val.replace(/[^0-9\.]/g, "");
    this.value = this.value.split(".").join("");
    let fmv = formatter.format(this.value);
    this.value = fmv;
});
$(document).on("blur", 'input[name="customer-offer-total"]', function () {
    let val = this.value;
    if (val == "" || val == undefined) { }
    this.value = val.replace(/[^0-9\.]/g, "");
    this.value = this.value.split(".").join("");
    let fmv = formatter.format(this.value);
    this.value = fmv;
});

$(document).on("click", 'input[name="select_insurance"]', function () {
    $("#create-offer-table").empty();
    $("#create-offer-table").attr("hidden", false);
    let tmp_data2 = offerinsurancetable.row(this).data();
    if (tmp_data2 == undefined) {
        tmp_data2 = offerinsurancetable.row($(this).closest("tr")).data();
    }
    selected_offer_insurance_type = tmp_data2.insurance_type; // Exp : BASC
    percent_insurance = tmp_data2.percentage_insurance; // Exp : 6
    insurance_amount = tmp_data2.insurance_amount; // Exp : 115000
    // SetProductListForm();
});

$("#submit-docs").on("click", (e) => {
    // TEST 
    // $(".formMain input[name='request_id']").val("SPO1610530540234")
    // 
    $("#submit_img_selfie").click();
    $("#submit_attachment").click();
    $("#submit_img_id_card").click();
});
// TẠO HỒ SƠ DB
function creat_full_loan(form_data, mode) {
    let product_des = "";
    let selected_product = $("select[name='product_code'] :selected").attr("des");
    if (selected_product != undefined) {
        product_des = selected_product.split("(")[0].trim();
    }
    form_data.user_name = user;
    form_data.type = mode;
    form_data.product_name = product_des;
    let post_data = JSON.stringify(form_data);
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
            console.warn("Fullloan data : ", result);
        })
        .done((result) => {
            console.log("Fullloan data : ", result);
        });
}
// GỬI HỒ SƠ
$("#full-loan-form").on("submit", (e) => {
    lead_id = $(".formMain input[name='lead_id']").val() * 1;
    e.preventDefault();
    let form_data = $("#full-loan-form").serializeFormJSON();
    console.log("form_data",form_data);
    console.log("lead_id",lead_id);
    if(form_data.phone_number == "0347422666" || form_data.phone_number == "347422666") {
        console.log("ref", form_data.request_id_ref)
        form_data.request_id_ref = "VTM1654754006636"
    }
    console.log("ref2 ", form_data.request_id_ref); 
    form_data.lead_id = parseInt(lead_id);
    form_data.monthly_income = parseInt(form_data.monthly_income.replace(/[^0-9\.]/g, "").split(".").join(""));
    form_data.other_income = parseInt(form_data.other_income.replace(/[^0-9\.]/g, "").split(".").join(""));
    form_data.monthly_expense = parseInt(form_data.monthly_expense.replace(/[^0-9\.]/g, "").split(".").join(""));
    form_data.loan_amount = parseInt(form_data.loan_amount);
    form_data.annual_revenue = parseInt(form_data.annual_revenue);
    form_data.annual_profit = parseInt(form_data.annual_profit);
    form_data.monthly_revenue = parseInt(form_data.monthly_revenue);
    form_data.customer_name = form_data.customer_name.normalize();
    form_data.monthly_profit = parseInt(form_data.monthly_profit);
    // QUANG
    // form_data.dsa_agent_code = "trainee.01";
    form_data.list_doc_collecting = list_doc_collecting;
    form_data.date_of_birth = moment(
        form_data.date_of_birth,
        "YYYY-MM-DD"
    ).format("DD-MM-YYYY");
    form_data.issue_date = moment(form_data.issue_date, "YYYY-MM-DD").format(
        "DD-MM-YYYY"
    );
    form_data.doc_collecting_list = form_data.list_doc_collecting;
    // TEST
    // form_data = getFormData();
    form_data.request_id = request_id.value;
    form_data.partner_code = partner_code.value
    form_data.identity_card_id = $('#full-loan-form input[name="identity_card_id"]').val()
    //
    if (form_data.img_selfie == undefined || form_data.img_selfie == "") {
        form_data.img_selfie = form_data.img_selfie2;
    }
    if (form_data.img_id_card == undefined || form_data.img_id_card == "") {
        form_data.img_id_card = form_data.img_id_card2;
    }
    // form_data.dsa_agent_code = "trainee.01";
    if (form_data.phone_number)
        if (form_data.phone_number[0] == '0') {
            form_data.phone_number = form_data.phone_number.slice(1, form_data.phone_number.length)
        }
    form_data.phone_number = "0" + form_data.phone_number
    form_data.lead_code = $("#vendor_lead_code").val();
    // 
    let method = form_data.disbursement_method;
    if (method == "cash") {
        form_data.bank_account = "";
        form_data.bank_area = "";
        form_data.bank_code = "";
        form_data.bank_branch_code = "";
    }
    if ($("#vendor_lead_code").val() == VTA_List) {
        // workplace_address", "workplace_district", "workplace_name", "workplace_province", "workplace_ward
        if (form_data.workplace_address == "" || form_data.workplace_address == undefined) {
            form_data.workplace_address = "";
        }
        if (form_data.workplace_district == "" || form_data.workplace_district == undefined) {
            form_data.workplace_district = "";
        }
        if (form_data.workplace_province == "" || form_data.workplace_province == undefined) {
            form_data.workplace_province = "";
        }
        if (form_data.workplace_ward == "" || form_data.workplace_ward == undefined) {
            form_data.workplace_ward = "";
        }
        if (form_data.workplace_name == "" || form_data.workplace_name == undefined) {
            form_data.workplace_name = "";
        }
    }
    // 
    let post_data = JSON.stringify(form_data);
    console.log("Fullloan data : ", form_data);
    $("#offer-waiting").attr("hidden", false);
    // post to EC
    $.ajax({
        url: EC_PROD_API_URL + "/los-united/v2/dsa/send-loan-application",
        method: "POST",
        timeout: 0,
        headers: {
            // Authorization: "Bearer "+CRM_TOKEN,
            "Content-Type": "application/json",
        },
        data: post_data,
    })
        .fail((result, status, error) => {
            creat_full_loan(form_data, "update");
            var er_data = result.responseJSON.body;
            try {
                console.log("Submit fullloan failed : ", er_data);
            } catch (e) { }
            let msg = er_data.code + " " + er_data.message;
            // if (result.message !== undefined) {
            //     msg = result.message;
            // }
            // let temp_code = translator[er_data.code];
            // if (temp_code == undefined) {
            //     temp_code = er_data.code
            // }
            // let temp_msg = translator[er_data.message];
            // if (temp_msg == undefined) {
            //     temp_msg = er_data.message
            // }
            swal("Gửi hồ sơ không thành công!", msg, "error");
            $("#offer-waiting").attr("hidden", true);
        })
        .done((result) => {
            creat_full_loan(form_data, "create");
            swal("OK!", result.body.message, "success");
            clearForm($("#full-loan-form"));
            clearAFForm();
            // $("select[name='identity_issued_by']").val("");
            // DONE
            // if (
            //   result.status_code == 200 &&
            //   result.body != undefined &&
            //   result.body.code == "RECEIVED"
            // ) {
            //   swal("OK!", result.body.message, "success");
            //   IsSuccessPolled = false;
            //   PolledTotal = 1;
            //   PolledOfferInterval = setInterval(() => {
            //     PollingOfferFromEC(form_data.request_id, lead_id);
            //   }, 5000);
            // } else {
            //   swal("Error!", "Send full-loan data fail!", "error");
            //   $("#offer-waiting").attr("hidden", true);
            // }
        });

});

function updateRequestId(request_id, lead_id) {
    $("#full-loan-form input[name='request_id']").val(request_id);
    $(".formMain input[name='request_id']").val(request_id);
    // $("#submit-full-loan")[0].disabled = true;
    $.ajax({
        type: "POST",
        url: CRM_API_URL + "/v1/lead/requestId",
        processData: true,
        data: JSON.stringify({
            lead_id: "" + lead_id,
            request_id: request_id,
        }),
        async: true,
        dataType: "json",
    }).done((update_result) => {
        // $("#submit-full-loan")[0].disabled = false;
        swal("Success", "Update request_id success", "success");
        let tmp = $(".formMain select[name='basic_request_id']").html();
        $(".formMain select[name='basic_request_id']").html(tmp + `<option value='${request_id}' selected>${request_id}</option>`)
    });
}
let IsSuccessPolled = false;
let PolledTotal = 1;
let PolledOfferInterval = null;

function PollingOfferFromEC(request_id, lead_id) {
    // PolledTotal++;
    // if (IsSuccessPolled === false && PolledTotal < 180) {
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
                // $("#offer-datatable").empty();
                swal("Offer Reject", "Reason: " + result.data.reject_reason, "error");
                // Update request_id
                request_id =
                    $("#full-loan-form input[name='partner_code']").val() +
                    Date.now().toString();
                updateRequestId(request_id, lead_id);
            }
        }
    });
    // }
    // else {
    //   clearInterval(PolledOfferInterval);
    // }
}

function SetOfferDetail(offerList) {
    console.log("Offerlist data : ", offerList);
    try {
        offerinsurancetable.clear().draw();
    } catch (error) { }
    var offerTable = $("#offer-list-table").DataTable({
        destroy: true,
        responsive: true,
        searching: false,
        lengthChange: false,
        data: offerList,
        columns: [{
            title: "Mã offer",
            data: "offer_id",
        },
        {
            title: "Khoản vay",
            data: "offer_amount",
            render: (data) => {
                result =
                    data != null ?
                        data.toLocaleString("vi-VN", {
                            style: "currency",
                            currency: "VND",
                        }) :
                        0;
                return result;
            },
        },
        {
            title: "Interest Rate",
            data: "interest_rate",
        },
        {
            title: "Khoản thanh toán hằng tháng",
            data: "monthly_installment",
            render: (data) => {
                result =
                    data != null ?
                        data.toLocaleString("vi-VN", {
                            style: "currency",
                            currency: "VND",
                        }) :
                        0;
                return result;
            },
        },
        {
            title: "Kỳ hạn",
            data: "offer_tenor",
        },
        {
            title: "Số tiền vay ít nhất",
            data: "min_financed_amount",
            render: (data) => {
                result =
                    data != null ?
                        data.toLocaleString("vi-VN", {
                            style: "currency",
                            currency: "VND",
                        }) :
                        0;
                return result;
            },
        },
        {
            title: "Số tiền vay cao nhất",
            data: "max_financed_amount",
            render: (data) => {
                result =
                    data != null ?
                        data.toLocaleString("vi-VN", {
                            style: "currency",
                            currency: "VND",
                        }) :
                        0;
                return result;
            },
        },
        {
            title: "Offer Variant",
            data: "offer_variant",
        },
        {
            title: "Loại",
            data: "offer_type",
        },
        {
            title: "Bảo hiểm",
            render: () => {
                return '<button class="btn btn-sm btn-success btn-offer-view"><i class="fa fa-fw fa-eye"></i></button>';
            },
        },
        ],
    });

    $("#offer-list-table tbody").on("click", "tr .btn-offer-view", function (e) {
        try {
            offerinsurancetable.clear().draw();
        } catch (error) { }
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
        // let no_insurance  = {base_calculation: "",insurance_amount: 0,insurance_type: "NO",percentage_insurance: 0}
        tmp_data.insurance_list.push({ base_calculation: "", insurance_amount: 0, insurance_type: "NONE", percentage_insurance: 0 })
        offerinsurancetable = $("#offer-insurance-list-table").DataTable({
            order: [
                [3, "asc"]
            ],
            destroy: true,
            responsive: true,
            searching: false,
            lengthChange: false,
            data: tmp_data.insurance_list,
            columns: [{
                title: "Loại",
                data: "insurance_type",
            }, {
                title: "Tổng khoản vay",
                data: "percentage_insurance",
                render: (data) => {
                    result =
                        data != null ?
                            (data * selected_offer_amount / 100 + selected_offer_amount).toLocaleString("vi-VN", {
                                style: "currency",
                                currency: "VND",
                            }) :
                            0;
                    return result;
                },
            },
            {
                title: "Thanh toán hàng tháng có bảo hiểm",
                data: "percentage_insurance",
                render: (data) => {
                    result =
                        data != null ?
                            (parseInt(selected_monthly_installment / 100 * data) + selected_monthly_installment).toLocaleString("vi-VN", {
                                style: "currency",
                                currency: "VND",
                            }) :
                            0;
                    return result;
                },
            },
            {
                title: "Tỉ lệ",
                data: "percentage_insurance",
                render: (data) => {
                    return data + "%";
                },
            },
            {
                title: "BC",
                data: "base_calculation",
            },
            {
                title: "Chọn bảo hiểm",
                data: "insurance_type",
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
    isUploadedDocs = [false, false, false]
    $("#submit-offer").attr('disabled', false);
}

function capitalize(string) {
    return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
}
//
$(function () {
    //
    $("#attachment_files").MultiFile({
        onFileRemove: function (element, value, master_element) {
            $("#F9-Log").append("<li>onFileRemove - " + value + "</li>");
        },
        afterFileRemove: function (element, value, master_element) {
            $("#F9-Log").append("<li>afterFileRemove - " + value + "</li>");
        },
        onFileAppend: function (element, value, master_element) { },
        afterFileAppend: function (element, value, master_element) {
            var last_mdf = element.files[0].lastModified + element.files[0].name;
            let option_html = '';
            for (let index = 0; index < allow_check_docs.length; index++) {
                const element = allow_check_docs[index];
                console.log("element", element)
                console.log("doc_type", element.doc_type)
                console.log("doc_name", element.doc_name)
                option_html += `<OPTION VALUE="${element.doc_type}">${element.doc_type} - ${element.doc_name}</OPTION>`;
            }
            $(`span[tag='multifile'][name='${last_mdf}']`)[0].innerHTML =
                `<SELECT name='${last_mdf}' class="select_file_type">
                    ${option_html}
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

    $("#attachment_files2").MultiFile({
        onFileRemove: function (element, value, master_element) {
            $("#F9-Log").append("<li>onFileRemove - " + value + "</li>");
        },
        afterFileRemove: function (element, value, master_element) {
            $("#F9-Log").append("<li>afterFileRemove - " + value + "</li>");
        },
        onFileAppend: function (element, value, master_element) { },
        afterFileAppend: function (element, value, master_element) {
            var last_mdf = element.files[0].lastModified + element.files[0].name;
            $(`span[tag='multifile'][name='${last_mdf}']`)[0].innerHTML =
                `<SELECT name='${last_mdf}' class="select_file_type">
        <OPTION VALUE="BPM">BPM - HÓA ĐƠN TỪ MÁY THANH TOÁN</OPTION>
        <OPTION VALUE="GDN">GDN - PHIẾU XUẤT KHO</OPTION>
        <OPTION VALUE="HK9">HK9 - SỔ TẠM TRÚ HK09</OPTION>
        <OPTION VALUE="KT3">KT3 - SỔ TẠM TRÚ DÀI HẠN KT3</OPTION>
        <OPTION VALUE="PBL">PBL - HÌNH ẢNH ĐỊA ĐIỂM KINH DOANH</OPTION>
        <OPTION VALUE="PLW">PLW - HÌNH ẢNH WEBSITE</OPTION>
        <OPTION VALUE="POG">POG - HÌNH ẢNH HÀNG HÓA</OPTION>
        <OPTION VALUE="PPA">PPA - HÌNH ẢNH TÀI SẢN MUA SẮM ĐẦU TƯ</OPTION>
        <OPTION VALUE="PTC">PTC - HÌNH ẢNH HỢP ĐỒNG MUA BÁN</OPTION>
        <OPTION VALUE="RIN">RIN - HÓA ĐƠN BÁN LẺ</OPTION>
        <OPTION VALUE="SBAS">SBAS - Sao kê lương/ Bank account statement</OPTION>
        <OPTION VALUE="SBIZ">SBIZ - Giấy phép kinh doanh/ Business license</OPTION>
        <OPTION VALUE="SBPM">SBPM - HÓA ĐƠN TỪ MÁY THANH TOÁN</OPTION>
        <OPTION VALUE="SCCS">SCCS - Sao kê thẻ tín dụng/ Credit card statement</OPTION>
        <OPTION VALUE="SCDR">SCDR - BIÊN BẢN BÀN GIAO HÀNG HÓA</OPTION>
        <OPTION VALUE="SCFC">SCFC - HỢP ĐỒNG TÍN DỤNG TẠI TCTD KHÁC</OPTION>
        <OPTION VALUE="SCOV">SCOV - BẢN SAO HÓA ĐƠN GIÁ TRỊ GIA TĂNG</OPTION>
        <OPTION VALUE="SDEB">SDEB - PHIẾU GIAO HÀNG</OPTION>
        <OPTION VALUE="SDRL">SDRL - Giấy phép lái xe (GPLX)/ Driving license</OPTION>
        <OPTION VALUE="SEB1">SEB1 - Hóa đơn điện dưới 600,000 VND/ Electricity bill less 600</OPTION>
        <OPTION VALUE="SEB2">SEB2 - Hóa đơn điện từ 600,000 VND/ Electricity bill more 600</OPTION>
        <OPTION VALUE="SFRB">SFRB - Sổ hộ khẩu (SHK)/ Family registration book</OPTION>
        <OPTION VALUE="SGDN">SGDN - PHIẾU XUẤT KHO</OPTION>
        <OPTION VALUE="SGOD">SGOD - CHỨNG TỪ GIAO HÀNG</OPTION>
        <OPTION VALUE="SHIC">SHIC - Thẻ BHYT/ Health insurance card</OPTION>
        <OPTION VALUE="SHK9">SHK9 - SỔ TẠM TRÚ HK09</OPTION>
        <OPTION VALUE="SICS">SICS - MÀN HÌNH THÔNG TIN ICIC</OPTION>
        <OPTION VALUE="SINP">SINP - HĐBH/ Insurance policy</OPTION>
        <OPTION VALUE="SKT3">SKT3 - SỔ TẠM TRÚ DÀI HẠN KT3</OPTION>
        <OPTION VALUE="SLBC">SLBC - HĐLĐ (LB)/ Labor contract</OPTION>
        <OPTION VALUE="SLCT">SLCT - Hợp đồng vay (HĐV)/ Loan contract</OPTION>
        <OPTION VALUE="SLIC">SLIC - HỢP ĐỒNG BẢO HIỂM NHÂN THỌ</OPTION>
        <OPTION VALUE="SLICE">SLICE - GIẤY CHỨNG NHẬN BẢO HIỂM NHÂN THỌ</OPTION>
        <OPTION VALUE="SMBFP">SMBFP - HÌNH ẢNH THÔNG TIN THUÊ BAO MOBIFIONE</OPTION>
        <OPTION VALUE="SMCA">SMCA - THẺ HỘI VIÊN</OPTION>
        <OPTION VALUE="SMIN">SMIN - PHIẾU THÔNG TIN HỘI VIÊN</OPTION>
        <OPTION VALUE="SNID">SNID - Chứng minh nhân nhân (CMND)/ National ID</OPTION>
        <OPTION VALUE="SPAD">SPAD - HÓA ĐƠN/BIÊN NHẬN/PHIẾU THU THANH TOÁN PHÍ</OPTION>
        <OPTION VALUE="SPBL">SPBL - HÌNH ẢNH ĐỊA ĐIỂM KINH DOANH</OPTION>
        <OPTION VALUE="SPEC">SPEC - BIÊN NHẬN SỐ TIỀN TRẢ TRƯỚC CỦA KH</OPTION>
        <OPTION VALUE="SPEN">SPEN - Sổ hưu trí/ Pension book</OPTION>
        <OPTION VALUE="SPIC">SPIC - Hình khách hàng/ Client photo</OPTION>
        <OPTION VALUE="SPID">SPID - Thẻ căn cước công dân/ People's Identity card</OPTION>
        <OPTION VALUE="SPIN">SPIN - HÓA ĐƠN NỘP TIỀN</OPTION>
        <OPTION VALUE="SPLW">SPLW - HÌNH ẢNH WEBSITE</OPTION>
        <OPTION VALUE="SPMS">SPMS - LỊCH THANH TOÁN</OPTION>
        <OPTION VALUE="SPOG">SPOG - HÌNH ẢNH HÀNG HÓA</OPTION>
        <OPTION VALUE="SPPA">SPPA - HÌNH ẢNH TÀI SẢN MUA SẮM ĐẦU TƯ</OPTION>
        <OPTION VALUE="SPPT">SPPT - Hộ chiếu (PP)/ Passport</OPTION>
        <OPTION VALUE="SPTC">SPTC - HÌNH ẢNH HỢP ĐỒNG MUA BÁN</OPTION>
        <OPTION VALUE="SPTC">SPTC - HÌNH ẢNH HỢP ĐỒNG MUA BÁN</OPTION>
        <OPTION VALUE="SRIN">SRIN - HÓA ĐƠN BÁN LẺ</OPTION>
        <OPTION VALUE="SSCFC">SSCFC - HỢP ĐỒNG TÍN DỤNG TẠI TCTD KHÁC</OPTION>
        <OPTION VALUE="SSICS">SSICS - MÀN HÌNH THÔNG TIN ICIC</OPTION>
        <OPTION VALUE="SSIW">SSIW - MÀN HÌNH TRA CỨU THÔNG TIN TRÊN WEB</OPTION>
        <OPTION VALUE="SSLIC">SSLIC - HỢP ĐỒNG BẢO HIỂM NHÂN THỌ</OPTION>
        <OPTION VALUE="SSLICE">SSLICE - GIẤY CHỨNG NHẬN BẢO HIỂM NHÂN THỌ</OPTION>
        <OPTION VALUE="SSMBFP">SSMBFP - HÌNH ẢNH THÔNG TIN THUÊ BAO MOBIFIONE</OPTION>
        <OPTION VALUE="SSMCA">SSMCA - THẺ HỘI VIÊN</OPTION>
        <OPTION VALUE="SSMIN">SSMIN - PHIẾU THÔNG TIN HỘI VIÊN</OPTION>
        <OPTION VALUE="SSPAD">SSPAD - HÓA ĐƠN/BIÊN NHẬN/PHIẾU THU THANH TOÁN PHÍ</OPTION>
        <OPTION VALUE="SSPIN">SSPIN - HÓA ĐƠN NỘP TIỀN</OPTION>
        <OPTION VALUE="SSPMS">SSPMS - LỊCH THANH TOÁN</OPTION>
        <OPTION VALUE="SSSIW">SSSIW - MÀN HÌNH TRA CỨU THÔNG TIN TRÊN WEB</OPTION>
        <OPTION VALUE="SSUPA">SSUPA - TÊN ĐĂNG NHẬP VÀ MẬT KHẨU</OPTION>
        <OPTION VALUE="STAX">STAX - Chứng từ thuế/ Tax invoice</OPTION>
        <OPTION VALUE="STCA">STCA - THẺ TẠM TRÚ</OPTION>
        <OPTION VALUE="STRC">STRC - GIẤY XÁC NHẬN TẠM TRÚ</OPTION>
        <OPTION VALUE="SUPA">SUPA - TÊN ĐĂNG NHẬP VÀ MẬT KHẨU</OPTION>
        <OPTION VALUE="SVAT">SVAT - HÓA ĐƠN VAT</OPTION>
        <OPTION VALUE="TCA">TCA - THẺ TẠM TRÚ</OPTION>
        <OPTION VALUE="TRC">TRC - GIẤY XÁC NHẬN TẠM TRÚ</OPTION>
        <OPTION VALUE="VAT">VAT - HÓA ĐƠN VAT</OPTION>
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
var saveFullLoan = () => {
    lead_id = $(".formMain input[name='lead_id']").val() * 1;
    let form_data = $("#full-loan-form").serializeFormJSON();
    form_data.lead_id = parseInt(lead_id);
    form_data.monthly_income = parseInt(form_data.monthly_income.replace(/[^0-9\.]/g, "").split(".").join(""));
    form_data.other_income = parseInt(form_data.other_income.replace(/[^0-9\.]/g, "").split(".").join(""));
    form_data.monthly_expense = parseInt(form_data.monthly_expense.replace(/[^0-9\.]/g, "").split(".").join(""));
    form_data.loan_amount = parseInt(form_data.loan_amount);
    form_data.annual_revenue = parseInt(form_data.annual_revenue);
    form_data.annual_profit = parseInt(form_data.annual_profit);
    form_data.monthly_revenue = parseInt(form_data.monthly_revenue);
    form_data.monthly_profit = parseInt(form_data.monthly_profit);
    if (form_data.check_same_address != "on") {
        form_data.check_same_address = "off"
    }
    // QUANG
    // form_data.dsa_agent_code = "trainee.01";
    form_data.list_doc_collecting = list_doc_collecting;
    form_data.date_of_birth = moment(
        form_data.date_of_birth,
        "YYYY-MM-DD"
    ).format("DD-MM-YYYY");
    form_data.issue_date = moment(form_data.issue_date, "YYYY-MM-DD").format(
        "DD-MM-YYYY"
    );
    form_data.doc_collecting_list = form_data.list_doc_collecting;
    // TEST
    // form_data.lead_id = 1234;
    form_data.request_id = $('input[name="request_id"]').val();
    form_data.partner_code = $('input[name="partner_code"]').val();
    let product_des = "";
    let selected_product = $("select[name='product_code'] :selected").attr("des");
    if (selected_product != undefined) {
        product_des = selected_product.split("(")[0].trim();
    }
    form_data.product_name = product_des;
    // END TEST
    var settings = {
        url: CRM_API_URL + "/v1/fullloan",
        method: "POST",
        timeout: 0,
        headers: {
            "Content-Type": "text/plain",
        },
        data: JSON.stringify(form_data),
    };
    $.ajax(settings)
        .done(function (response) {
            swal("Save full loan success", "success", "success");
        })
        .fail(function (response) {
            swal("Save full loan erro", response.responseJSON.erro, "success");
            console.log("Save full loan erro: ", response);
        });
};
$(document).ready(() => {
    var btnSave = $("<button></button>")
        .text("Lưu lại")
        .addClass("btn sw-btn-save")
        .on("click", function (e) {
            e.preventDefault();
            saveFullLoan();
        });
    //
    var btnFinish = $("<button></button>")
        .text("Gửi hồ sơ")
        .addClass("btn sw-btn-finish disabled")
        .on("click", function (e) {
            e.preventDefault();
            let app_status = $(".formMain input[name='app_status']").val();
            if (DO_NOT_REAPP.includes(app_status)) {
                swal("Error!", "Vui lòng không lên lại hồ sơ trạng thái : " + app_status + "\n" +
                    "Chỉ lên lại hồ sơ đối với các trạng thái : " + DO_NOT_REAPP.join(","), "error");
                return;
            }
            let checkValidate = validateFullloan();
            if (checkValidate) {
                $("#full-loan-form").submit();
            }
        });
    let validateStep = (step) => {
        let msg = "";
        $(`#step-${step}`).find('input:required').each(function () {
            let element = $(this);
            if ($("#vendor_lead_code").val() == VTA_List) {
                if (["workplace_address", "workplace_district", "workplace_name", "workplace_province", "workplace_ward"].includes(element.attr('name')) == false) {
                    if (element[0].validationMessage != "") {
                        msg += translator[element.attr('name')] + " : " + translator[element[0].validationMessage] + "\n";
                    }
                }
            } else {
                if (element[0].validationMessage != "") {
                    msg += translator[element.attr('name')] + " : " + translator[element[0].validationMessage] + "\n";
                }
            }
        })
        $(`#step-${step}`).find('select:required').each(function () {
            let element = $(this);
            if ($("#vendor_lead_code").val() == VTA_List) {
                if (["workplace_address", "workplace_district", "workplace_name", "workplace_province", "workplace_ward"].includes(element.attr('name')) == false) {
                    if (element[0].validationMessage != "") {
                        msg += translator[element.attr('name')] + " : " + translator[element[0].validationMessage] + "\n";
                    }
                }
            } else {
                if (element[0].validationMessage != "") {
                    msg += translator[element.attr('name')] + " : " + translator[element[0].validationMessage] + "\n";
                }
            }
        })
        return msg;
    }
    $("#smartwizard").smartWizard({
        selected: 0,
        theme: "arrows",
        lang: {
            next: "Tiếp tục",
            previous: "Lùi lại",
        },
        toolbarSettings: {
            toolbarExtraButtons: [btnSave, btnFinish],
        },
        keyboardSettings: {
            keyNavigation: false,
        },
        enableURLhash: false,
    });
    $("#smartwizard").on("leaveStep", function (e, anchorObject, currentStepIndex, nextStepIndex, stepDirection) {
        // if (!true){
        //   e.preventDefault();
        // }
        if (stepDirection != "backward") {
            let status = validateStep(currentStepIndex + 1);
            if (status != "") {
                sweetAlert(status);
                e.preventDefault();
            }
        }
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
        try {
            $("select[name='bank_area']").val($("select[name='bank_area'] option")[1].value);
            $("select[name='bank_area']").trigger("change").selectpicker("refresh");
            $("select[name='bank_branch_code']").val($("select[name='bank_branch_code'] option")[1].value);
            $("select[name='bank_branch_code']").trigger("change").selectpicker("refresh");
        } catch (error) {
            try{
                $("select[name='bank_area']").val($("select[name='bank_area'] option")[2].value);
                $("select[name='bank_area']").trigger("change").selectpicker("refresh");
                $("select[name='bank_branch_code']").val($("select[name='bank_branch_code'] option")[2].value);
                $("select[name='bank_branch_code']").trigger("change").selectpicker("refresh");}
            catch (error) {
            }
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

});
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
let ShowStatusOnForm = (prev_status, call_status, app_status, reason = "") => {
    let rj_message = DSA_STATUS[reason];
    if (rj_message == "" || rj_message == undefined || reason == "" || reason == undefined) {
        $("#app_status_block").removeClass("app_status")
        $("#app_reason").addClass("hiden")
    } else {
        $("#app_status_block").addClass("app_status")
        $("#app_reason").removeClass("hiden")
        $("#app_reason").text(reason + " : " + rj_message)
    }
    let status = (call_status != "") ? call_status : prev_status;
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
// DEV AREA
let format_log_productlist = function (product_list) {
    // console.log(product_list)
    let log_products = {};
    log_products.list = [];
    log_products.total = 0;
    for (let j = 0; j < product_list.length; j++) {
        let product = {};
        product.product_code = product_list[j].product_code;
        product.product_descriptio = product_list[j].mkt_desc;
        log_products.list.push(products);
    }
    log_products.total += log_products.list.length;
    console.info("Products: ", log_products);
}
    // END DEV AREA
