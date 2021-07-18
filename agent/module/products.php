<div id="products" role="tabpanel" class="tab-pane">
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Products</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="box-group" id="accordion">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="offer" role="tabpanel" class="tab-pane">
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Offer</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row" id="offer-datatable">
                        <div class="col-xl-12 col-lg-12">
                            <table id="offer-list-table" class="display responsive no-wrap table table-responsive table-striped table-bordered" width="100%">

                            </table>
                        </div>
                        <div class="col-xl-12 col-lg-12">
                            <table id="offer-insurance-list-table" class="display responsive no-wrap table table-responsive table-striped table-bordered" width="100%">

                            </table>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 10px;padding: 20px 10px; border: 1px solid #5cb85c;">
                    <div class="col-xl-12 col-lg-12">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4">
                                <div class="col-lg-2">
                                    <div class="iconCircle">
                                        <i class="fa fa-info fa-2x"></i>
                                    </div>
                                </div>
                                <div class="col-lg-10">
                                    <h3 class="text-light-blue">
                                        UPLOAD CHECK ELIGIBLE
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="row">
                            <div class="col-sm-12" style="padding-bottom: 10px;">
                                <label class="form_label" for="img_id_card">ID CARD</label>
                                <input type="text" name="img_id_card" class="id_img_hide" required />
                                <input type="file" id="img_id_card" class="id_img custom-file-input" />
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-sm-12">
                                <button id="submit_img_id_card" class="btn btn-warning">submit_img_id_card</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="row">
                            <div class="col-sm-12" style="padding-bottom: 10px;">
                                <label class="form_label" for="img_selfie">img_selfie</label>
                                    <input type="text" name="img_selfie" class="id_img_hide" required />
                                    <input type="file" id="img_selfie" class="id_img custom-file-input" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <button id="submit_img_selfie" class="btn btn-warning">submit_img_selfie</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--  -->
                <!-- PRODUCT DETAIL DEBUG-->
                <!--  -->
                <div class="row" style="margin-bottom: 10px;padding: 20px 10px; border: 1px solid #5cb85c;">
                    <div class="col-xl-6 col-lg-12">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4">
                                <div class="col-lg-2">
                                    <div class="iconCircle">
                                        <i class="fa fa-envelope fa-2x"></i>
                                    </div>
                                </div>
                                <div class="col-lg-10">
                                    <h3 class="text-light-blue">
                                        UPLOAD CHECK DOCS
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div id="product_detail" class="row">
                            <div class="col-xl-12 col-lg-12">
                                <label style="font-size: large;" id="product_required_description">Chứng từ bắt buộc </label>
                            </div>
                            <div class="col-xl-12 col-lg-12">
                                <hr style="margin: 5px !important;">
                            </div>
                            <div class="col-xl-12 col-lg-12">
                                <div class="mda-form-group label-floating">
                                    <input type="text" name="product_required_document" class="mda-form-control ng-pristine ng-empty ng-invalid ng-touched" readonly disabled>
                                    <label style="font-size: large;">Mã chứng từ bắt buộc: </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12" id="product_name_detail">
                    </div>
                    <div class="col-sm-12" style="padding-bottom: 10px;">
                        <label class="form_label" for="attachment_files">upload_attach</label>
                        <input multiple type="file" id="attachment_files" class="attachment-input" />
                    </div>
                    <div class="col-sm-12">
                        <button class="btn btn-warning" id="submit_attachment">submit_attachment</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6 col-lg-6">
                        <button class="btn btn-primary" id="submit-docs" > Gửi Chứng Từ </button>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <button class="btn btn-primary" id="submit-offer" hidden> <?= $lh->translationFor('submit_offer') ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="product-detail-modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><b>Product Detail</b></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form id="product-detail-form">
                            <div class="row">
                                <div class="col-xs-3">
                                    <div class="mda-form-group label-floating">
                                        <label class="form_label" for="product_code">Product Code</label>
                                        <input name="product_code" type="text" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" readonly="" value="" />
                                    </div>
                                </div>
                                <div class="col-xs-9">
                                    <div class="mda-form-group label-floating">
                                        <label class="form_label" for="product_description">Product Description</label>
                                        <textarea name="product_description" type="text" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" readonly="">

                                </textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-3">
                                    <div class="mda-form-group label-floating">
                                        <label class="form_label" for="loan_min_amount">Loan Min Amount</label>
                                        <input name="loan_min_amount" type="text" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" readonly="" value="" />
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="mda-form-group label-floating">
                                        <label class="form_label" for="loan_max_amount">Loan Max Amount</label>
                                        <input name="loan_max_amount" type="text" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" readonly="" value="" />
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="mda-form-group label-floating">
                                        <label class="form_label" for="loan_min_tenor">Loan Min Tenor</label>
                                        <input name="loan_min_tenor" type="text" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" readonly="" value="" />
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="mda-form-group label-floating">
                                        <label class="form_label" for="loan_max_tenor">Loan Max Tenor</label>
                                        <input name="loan_max_tenor" type="text" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" readonly="" value="" />
                                    </div>
                                </div>
                            </div>
                            <div id="product-detail-form-bundle">
                            </div>
                        </form>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php $lh->translateText("close"); ?></button>
            </div>
        </div>
    </div>
</div>

<div id="offer-detail-modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><b>Mô tả khoản vay</b></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <form id="offer-detail-form">
                        </form>
                    </div>
                    <div class="col-md-8" id="offer-detail-table">

                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php $lh->translateText("close"); ?></button>
            </div>
        </div>
    </div>
</div>

<div id="full-loan" role="tabpanel" class="tab-pane">
    <style>
        .iconCircle {
            display: table;
            width: 50px;
            height: 50px;
            border-radius: 999px;
            border: solid #C0C0C0;
        }

        .iconCircle i {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
        }

        .gi-2x {
            font-size: 2em;
        }

        .gi-3x {
            font-size: 3em;
        }

        .gi-4x {
            font-size: 4em;
        }

        .gi-5x {
            font-size: 5em;
        }
    </style>
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-solid">
                <div id="smartwizard">
                    <ul class="nav">
                        <li>
                            <a class="nav-link" href="#step-1">
                                AF <br />Chọn sản phẩm
                            </a>
                        </li>
                        <li>
                            <a class="nav-link" href="#step-2">
                                AF1 <br />Thông tin cơ bản
                            </a>
                        </li>
                        <li>
                            <a class="nav-link" href="#step-3">
                                AF2 <br />Thông tin chi tiết
                            </a>
                        </li>
                        <li>
                            <a class="nav-link" href="#step-4">
                                AF3 <br />Thông tin thu nhập
                            </a>
                        </li>
                        <li>
                            <a class="nav-link" href="#step-5">
                                AF4 <br />Thông tin bổ sung
                            </a>
                        </li>
                        <li>
                            <a class="nav-link" href="#step-6">
                                AF5 <br />Thông tin chứng từ
                            </a>
                        </li>
                    </ul>
                    <form action="#" id="full-loan-form">
                        <div class="tab-content">
                            <div id="step-1" class="tab-pane active" role="tabpanel">
                                <!-- 1.PRODUCT -->
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4">
                                        <div class="col-lg-2">
                                            <div class="iconCircle">
                                                <i class="fa fa-credit-card fa-2x"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-10">
                                            <h3 ondblclick='ECShowProducts("TEL","TEL123")' class="text-light-blue">
                                                <?= $lh->translationFor('loan_detail') ?>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-1 col-lg-12">
                                        <div class="mda-form-group label-floating" data-children-count="1">
                                            <select name="employment_type" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" data-live-search="true" required>
                                                <option value=""></option>
                                                <option value="E">Đi làm hưởng lương</option>
                                                <option value="SE">Tự kinh doanh</option>
                                                <option value="RP">Hưởng lương hưu</option>
                                                <option value="FE">Làm nghề tự do</option>
                                            </select>
                                            <label class="select_label" for="employment_type"><?= $lh->translationFor('employment_type') ?></label>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-12">
                                        <div class="mda-form-group label-floating" data-children-count="1">
                                            <!-- <select name="product_type" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched select" required>
                                        </select> -->
                                            <select name="product_type" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required></select>
                                            <label class="form_label" for="product_type"><?= $lh->translationFor('product_type') ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4 col-lg-6">
                                        <div class="row">
                                            <div class="col-xl-4 col-lg-12">
                                                <label class="form_label" for="loan_tenor"><?= $lh->translationFor('loan_tenor') ?></label>
                                                <div class="row">
                                                    <div class="col-xl-4 col-lg-9">
                                                        <input type="range" name="range_loan_tenor" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" value="0" min="0" max="50" oninput="changeLoanTennor(this);">
                                                    </div>
                                                    <div class="col-xl-4 col-lg-3">
                                                        <input type="number" onblur="checkminmax(this)" step="1" name="loan_tenor" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" min="0" value="0" max="50" oninput="changeLoanTennorRange(this);" required="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-4 col-lg-12">
                                                <label class="form_label" class="form_label" for="loan_amount"><?= $lh->translationFor('loan_amount') ?></label>
                                                <div class="row">
                                                    <div class="col-xl-4 col-lg-9">
                                                        <input type="range" step="500000" name="range_loan_amount" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" value="0" min="0" max="999999999999" oninput="changeLoanAmount(this);">
                                                    </div>
                                                    <div class="col-xl-4 col-lg-3">
                                                        <input type="number" onblur="checkminmax(this)" step="500000" name="loan_amount" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" min="0" value="0" max="999999999999" oninput="changeLoanAmountRange(this);" required="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-4 col-lg-12">
                                                <label class="form_label" for="product_type"><?= $lh->translationFor('product_type') ?></label>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="simu_insurance" class="insurance" value="0" checked>
                                                        Không bảo hiểm - 0%
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="simu_insurance" class="insurance" value="6">
                                                        Gói cơ bản - 6%
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="simu_insurance" class="insurance" value="8">
                                                        Gói nâng cao - 8%
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--  -->
                                    <div class="col-xl-12 col-lg-6">
                                        <table id="create-offer-table">
                                            <tr>
                                                <th colspan="2"><?= $lh->translationFor('offer_detail') ?></th>
                                            </tr>
                                            <tr>
                                                <td><?= $lh->translationFor('customer_offer_amount') ?></td>
                                                <td><input name="customer-offer-amount" type="text" value='' class="customer-offer-input" onchange="simulator(this)"></td>
                                            </tr>
                                            <tr>
                                                <td><?= $lh->translationFor('customer_offer_tenor') ?></td>
                                                <td><input name="customer-offer-tenor" value="" type="number" class="customer-offer-input-readonly" onchange="simulator(this)"></td>
                                            </tr>
                                            <tr>
                                                <td><?= $lh->translationFor('customer_offer_percent') ?></td>
                                                <td><input name="customer-offer-percent" value="" type="text" class="customer-offer-input-readonly" onchange="simulator(this)"></td>
                                            </tr>
                                            <tr>
                                                <td><?= $lh->translationFor('customer_offer_total') ?></td>
                                                <td><input name="customer-offer-total" value="" type="number" class="customer-offer-input-readonly" onchange="simulator(this)"></td>
                                            </tr>
                                            <tr>
                                                <td><?= $lh->translationFor('customer_offer_monthly') ?></td>
                                                <td><input name="customer-offer-monthly" value="" type="number" class="customer-offer-input-readonly" onchange="simulator(this)"></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-4 col-lg-12">
                                        <div class="mda-form-group label-floating">
                                            <h4 class="text-light-blue" style="font-size: larger;">Kết quả tính toán này chỉ mang tính chất tham khảo và có thể sai lệch nhỏ so với kết quả tính toán thực tế dựa theo hồ sơ tín dụng cá nhân của riêng bạn.</h4>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="row">
                                    <div class="col-xl-4 col-lg-12">
                                        <div class="mda-form-group label-floating">
                                            <input type="text" name="lending_method" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                            <label class="form_label" for="lending_method"><?= $lh->translationFor('lending_method') ?></label>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="row" id="bussiness_se" hidden>
                                    <div class="col-xl-12 col-lg-6">
                                        <div class="mda-form-group label-floating">
                                            <input type="text" name="business_date" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched">
                                            <label class="form_label" for="business_date"><?= $lh->translationFor('business_date') ?></label>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-6">
                                        <div class="mda-form-group label-floating">
                                            <input type="text" name="business_license_number" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched">
                                            <label class="form_label" for="business_license_number"><?= $lh->translationFor('business_license_number') ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" hidden>
                                    <div class="col-xl-3 col-lg-3">
                                        <div class="mda-form-group label-floating">
                                            <input disabled type="number" min="0" max="999999999999" name="annual_revenue" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched">
                                            <label class="form_label" for="annual_revenue"><?= $lh->translationFor('annual_revenue') ?></label>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3">
                                        <div class="mda-form-group label-floating">
                                            <input disabled type="number" min="0" max="999999999999" name="annual_profit" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched">
                                            <label class="form_label" for="annual_profit"><?= $lh->translationFor('annual_profit') ?></label>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3">
                                        <div class="mda-form-group label-floating">
                                            <input type="text" min="0" max="999999999999" tag="currency" name="monthly_revenue" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched">
                                            <label class="form_label" for="monthly_revenue">1.10. <?= $lh->translationFor('monthly_revenue') ?></label>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3">
                                        <div class="mda-form-group label-floating">
                                            <input type="number" min="0" max="999999999999" name="monthly_profit" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched">
                                            <label class="form_label" for="monthly_profit">1.11. <?= $lh->translationFor('monthly_profit') ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" hidden>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="mda-form-group label-floating">
                                            <input disabled type="text" name="3rd_Party_duration" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched">
                                            <label class="form_label" for="3rd_Party_duration">1.12. <?= $lh->translationFor('3rd_Party_duration') ?></label>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="mda-form-group label-floating">
                                            <input disabled type="text" name="sale_code" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched">
                                            <label class="form_label" for="sale_code">1.13. <?= $lh->translationFor('sale_code') ?></label>
                                        </div>
                                    </div>
                                </div>
                                <!-- END -->
                            </div>
                            <div id="step-2" class="tab-pane active" role="tabpanel">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4">
                                        <div class="col-lg-2">
                                            <div class="iconCircle">
                                                <i class="fa fa-user fa-2x"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-10">
                                            <h3 class="text-light-blue">
                                                Thông tin cá nhân
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-8 col-lg-6">
                                        <div class="mda-form-group label-floating" data-children-count="1">
                                            <input readonly name="customer_name" type="text" width="auto" value="" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                            <label class="form_label" for="customer_name"><?= $lh->translationFor('customer_name') ?></label>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6">
                                        <div class="mda-form-group label-floating" data-children-count="1">
                                            <select readonly name="gender" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched select" required>
                                                <option value="M"><?= $lh->translationFor('male') ?></label></option>
                                                <option value="F"><?= $lh->translationFor('female') ?></label></option>
                                            </select>
                                            <label class="form_label" for="gender"><?= $lh->translationFor('gender') ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="mda-form-group label-floating">
                                            <input readonly type="date" name="date_of_birth" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                            <label class="form_label" for="date_of_birth"><?= $lh->translationFor('date_of_birth') ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="mda-form-group label-floating">
                                            <!-- <input type="text" name="permanent_province" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" > -->
                                            <label class="select_label" for="live_province"><?= $lh->translationFor('live_province') ?></label>
                                            <select name="live_province" class="selectpicker ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" data-live-search="true">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="mda-form-group label-floating">
                                            <input type="text" name="country" value="Việt Nam" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" readonly>
                                            <label class="form_label" for="contry"><?= $lh->translationFor('country') ?></label>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4">
                                        <div class="col-lg-2">
                                            <div class="iconCircle">
                                                <i class="fa fa-credit-card fa-2x"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-10">
                                            <h3 class="text-light-blue">
                                                Giấy tờ tuỳ thân
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="mda-form-group label-floating">
                                            <input readonly type="text" name="identity_card_id" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                            <label class="form_label" for="identity_card_id"><?= $lh->translationFor('identity_card_id') ?></label>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="mda-form-group label-floating">
                                            <input readonly min="01-01-1990" type="date" name="issue_date" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                            <label class="form_label" for="issue_date"><?= $lh->translationFor('identity_issue_date') ?></label>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="mda-form-group label-floating">
                                            <label class="form_label" for="issue_place"><?= $lh->translationFor('identity_issue_place') ?></label>
                                            <select readonly name="issue_place" class="selectpicker ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched select" required>
                                                <option value="VIP15">Cục CSĐKQLCT&DLQGVDC</option>
                                                <option value="VIP16">Cục CSQLHC về TTXH</option>
                                                <option value="VIP67"></option>
                                                <option value="VIP66">Hà Tây</option>
                                                <option value="VIP22">Đồng Tháp</option>
                                                <option value="VIP23">Gia Lai</option>
                                                <option value="VIP24">Hà Giang</option>
                                                <option value="VIP25">Hà Nam</option>
                                                <option value="VIP20">Điện Biên</option>
                                                <option value="VIP21">Đồng Nai</option>
                                                <option value="VIP43">Nghệ An</option>
                                                <option value="VIP44">Ninh Bình</option>
                                                <option value="VIP37">Lai Châu</option>
                                                <option value="VIP38">Lâm Đồng</option>
                                                <option value="VIP39">Lạng Sơn</option>
                                                <option value="VIP40">Lào Cai</option>
                                                <option value="VIP41">Long An</option>
                                                <option value="VIP42">Nam Định</option>
                                                <option value="VIP01">An Giang</option>
                                                <option value="VIP02">Bà Rịa Vũng Tàu</option>
                                                <option value="VIP03">Bắc Cạn</option>
                                                <option value="VIP04">Bắc Giang</option>
                                                <option value="VIP05">Bạc Liêu</option>
                                                <option value="VIP06">Bắc Ninh</option>
                                                <option value="VIP07">Bến Tre</option>
                                                <option value="VIP08">Bình Định</option>
                                                <option value="VIP62">Tuyên Quang</option>
                                                <option value="VIP63">Vĩnh Long</option>
                                                <option value="VIP64">Vĩnh Phúc</option>
                                                <option value="VIP54">Sơn La</option>
                                                <option value="VIP55">Tây Ninh</option>
                                                <option value="VIP56">Thái Bình</option>
                                                <option value="VIP57">Thái Nguyên</option>
                                                <option value="VIP58">Thanh Hóa</option>
                                                <option value="VIP59">Thừa Thiên Huế</option>
                                                <option value="VIP60">Tiền Giang</option>
                                                <option value="VIP61">Trà Vinh</option>
                                                <option value="VIP53">Sóc Trăng</option>
                                                <option value="VIP65">Yên Bái</option>
                                                <option value="VIP19">Đắk Nông</option>
                                                <option value="VIP09">Bình Dương</option>
                                                <option value="VIP10">Bình Phước</option>
                                                <option value="VIP11">Bình Thuận</option>
                                                <option value="VIP12">Cà Mau</option>
                                                <option value="VIP13">Cần Thơ</option>
                                                <option value="VIP14">Cao Bằng</option>
                                                <option value="VIP17">Đà Nẵng</option>
                                                <option value="VIP18">Đắk Lắk</option>
                                                <option value="VIP26">Hà Nội</option>
                                                <option value="VIP34">Khánh Hòa</option>
                                                <option value="VIP35">Kiên Giang</option>
                                                <option value="VIP36">Kon Tum</option>
                                                <option value="VIP27">Hà Tĩnh</option>
                                                <option value="VIP28">Hải Dương</option>
                                                <option value="VIP29">Hải Phòng</option>
                                                <option value="VIP30">Hậu Giang</option>
                                                <option value="VIP47">Phú Yên</option>
                                                <option value="VIP48">Quảng Bình</option>
                                                <option value="VIP49">Quảng Nam</option>
                                                <option value="VIP50">Quảng Ngãi</option>
                                                <option value="VIP31">TP.Hồ Chí Minh</option>
                                                <option value="VIP32">Hòa Bình</option>
                                                <option value="VIP33">Hưng Yên</option>
                                                <option value="VIP51">Quảng Ninh</option>
                                                <option value="VIP52">Quảng Trị</option>
                                                <option value="VIP45">Ninh Thuận</option>
                                                <option value="VIP46">Phú Thọ</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4">
                                        <div class="col-lg-2">
                                            <div class="iconCircle">
                                                <i class="fa fa-phone fa-2x"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-10">
                                            <h3 class="text-light-blue">
                                                Thông tin liên lạc
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="mda-form-group label-floating">
                                            <input readonly tag="phone" type="text" name="phone_number" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                            <label class="form_label" for="phone_number"><?= $lh->translationFor('phone_number') ?></label>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="mda-form-group label-floating">
                                            <input type="text" name="email" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched">
                                            <label class="form_label" for="email"><?= $lh->translationFor('email') ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="term_confirm" checked="true" required>
                                                Tôi cam kết những thông tin cung cấp là hoàn toàn chính xác
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="condition_confirm" checked="true" required>
                                                Tôi đồng ý với quy định về bảo mật thông tin tại Điều 2 của <a>Hợp đồng tín dụng của EasyCredit</a>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="step-3" class="tab-pane active" role="tabpanel">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4">
                                        <div class="col-lg-2">
                                            <div class="iconCircle">
                                                <i class="fa fa-map-marker fa-2x"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-10">
                                            <h3 class="text-light-blue">
                                                Nơi ở hiện tại
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="mda-form-group label-floating">
                                            <!-- <input type="text" name="tem_province" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required> -->
                                            <label class="select_label" for="tem_province"><?= $lh->translationFor('province') ?></label>
                                            <select name="tem_province" class="selectpicker ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" data-live-search="true" required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="mda-form-group label-floating">
                                            <!-- <input type="text" name="tem_district" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required> -->
                                            <label class="select_label" for="tem_district"><?= $lh->translationFor('district') ?></label>
                                            <select name="tem_district" class="selectpicker ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" data-live-search="true" required>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="mda-form-group label-floating">
                                            <!-- <input type="text" name="tem_ward" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required> -->
                                            <label class="select_label" for="tem_ward"><?= $lh->translationFor('ward') ?></label>
                                            <select name="tem_ward" class="selectpicker ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" data-live-search="true" required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="mda-form-group label-floating">
                                            <input type="text" name="tem_address" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                            <label class="form_label" for="tem_address"><?= $lh->translationFor('address') ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4">
                                        <div class="col-lg-2">
                                            <div class="iconCircle">
                                                <i class="fa fa-map-marker fa-2x"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-10">
                                            <h3 class="text-light-blue">
                                                Địa chỉ thường trú
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="mda-form-group label-floating">
                                            <div class="checkbox">
                                                <label class="form_label" data-children-count="1">
                                                    <input type="checkbox" name="check_same_address" readonly>
                                                    <?= $lh->translationFor('check_same_address') ?></label>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="mda-form-group label-floating">
                                            <!-- <input type="text" name="permanent_province" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required> -->
                                            <label class="select_label" for="permanent_province"><?= $lh->translationFor('province') ?></label>
                                            <select name="permanent_province" class="selectpicker ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" data-live-search="true" required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="mda-form-group label-floating">
                                            <!-- <input type="text" name="permanent_district" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required> -->
                                            <label class="select_label" for="permanent_district"><?= $lh->translationFor('district') ?></label>
                                            <select name="permanent_district" class="selectpicker ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" data-live-search="true" required>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="mda-form-group label-floating">
                                            <!-- <input type="text" name="permanent_ward" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required> -->
                                            <label class="select_label" for="permanent_ward"><?= $lh->translationFor('ward') ?></label>
                                            <select name="permanent_ward" class="selectpicker ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" data-live-search="true" required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="mda-form-group label-floating">
                                            <input type="text" name="permanent_address" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                            <label class="form_label" for="permanent_address"><?= $lh->translationFor('address') ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4">
                                        <div class="col-lg-2">
                                            <div class="iconCircle">
                                                <i class="fa fa-briefcase fa-2x"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-10">
                                            <h3 class="text-light-blue">
                                                Thông tin công việc
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="mda-form-group label-floating">
                                            <select name="job_type" class="selectpicker ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" data-live-search="true" required>
                                                <option value="BPR">Lĩnh vực tôn giáo, tín ngưỡng</option>
                                                <option value="RPT">Phóng viên/Nhà báo</option>
                                                <option value="RHR">Nhà hàng/khách sạn/quán ăn</option>
                                                <option value="INA">Đại lý bảo hiểm</option>
                                                <option value="HHG">Tạp vụ/Giúp việc nhà</option>
                                                <option value="UNT">Thất nghiệp</option>
                                                <option value="STS">Tiểu thương, buôn bán (có địa điểm cố định)</option>
                                                <option value="ENA">Kỹ sư, Kiến trúc sư</option>
                                                <option value="FIN">Người sống bằng lợi tức (tiền cho thuê cố định, lãi suất tiền gửi,…)</option>
                                                <option value="BM">Nhân viên kinh doanh</option>
                                                <option value="DCC">Nhân viên thu hồi nợ các tổ chức tín dụng</option>
                                                <option value="SSTS">Tự kinh doanh dịch vụ vận tải</option>
                                                <option value="ATH">Vận động viên</option>
                                                <option value="ARS">Văn nghệ sĩ</option>
                                                <option value="OTH">Khác</option>
                                                <option value="DRI">Tài xế /Xe ôm</option>
                                                <option value="SFF">Nhân viên văn phòng</option>
                                                <option value="HW">Nội trợ</option>
                                                <option value="FAM">Nông dân (trồng trọt/chăn nuôi)</option>
                                                <option value="STE">Công nhân viên chức nhà nước</option>
                                                <option value="CHEF">Đầu bếp</option>
                                                <option value="TRL">Giáo viên/giảng viên</option>
                                                <option value="RTE">Hưu trí</option>
                                                <option value="PUM">Lao động phổ thông</option>
                                                <option value="PAP">Kinh doanh dịch vụ cầm đồ</option>
                                                <option value="DCP">Bác sĩ/Y tá/Dược sĩ</option>
                                                <option value="HAK">Bán hàng tự do (không có địa điểm cố định)</option>
                                                <option value="SEC">Bảo vệ</option>
                                                <option value="POA">Công an/Quân đội</option>
                                                <option value="WOK">Công nhân</option>
                                                <option value="FIM">Ngư dân</option>
                                                <option value="ACJ">Luật sư/Thư ký toà án/Thẩm phán/Chánh án/Thi hành án hoặc các vị trí liên quan đến toà án </option>
                                                <option value="CHTEP">Nghề thủ công (cắt tóc, thợ may, thợ điện, thợ nước, …)</option>
                                            </select>
                                            <label class="select_label" for="job_type"><?= $lh->translationFor('job_type') ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="mda-form-group label-floating">
                                            <select name="employment_contract" class="selectpicker ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" data-live-search="true" required>
                                                <option value="IT" selected>HĐLĐ toàn Thời gian không xác định thời hạn</option>
                                                <option value="DT">HĐLĐ toàn Thời gian có xác định thời hạn</option>
                                                <option value="ST">HĐ mùa vụ</option>
                                                <option value="PC">HĐ thử việc</option>
                                                <option value="PT">HĐLĐ bán Thời gian</option>
                                                <option value="OTH">Khác</option>
                                            </select>
                                            <label class="select_label" for="employment_contract"><?= $lh->translationFor('employment_contract') ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-4">
                                        <div class="mda-form-group label-floating">
                                            <input type="number" value="2021" min="2000" max="2100" name="from" onblur="checkContract(this)" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                            <label class="form_label" for="from"><?= $lh->translationFor('from') ?></label>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-4">
                                        <div class="mda-form-group label-floating">
                                            <input type="number" value="2021" onblur="checkContract(this)" min="2000" max="2100" name="to" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                            <label class="form_label" for="to"><?= $lh->translationFor('to') ?></label>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-4">
                                        <div class="mda-form-group label-floating">
                                            <input readonly type="text" value="0" name="contract_term" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                            <label class="form_label" for="contract_term"><?= $lh->translationFor('contract_term') ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                </div>
                            </div>
                            <div id="step-4" class="tab-pane active" role="tabpanel">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4">
                                        <div class="col-lg-2">
                                            <div class="iconCircle">
                                                <i class="fa fa-money fa-2x"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-10">
                                            <h3 class="text-light-blue">
                                                Thu nhập của bạn
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="mda-form-group label-floating">
                                            <select name="income_method" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched select" required>
                                                <option value="Chuyển khoản">Chuyển khoản</option>
                                                <option value="Tiền mặt">Tiền mặt</option>
                                                <!-- <option value="Chuyển khoản và tiền mặt">Chuyển khoản và tiền mặt</option> -->
                                            </select>
                                            <label class="form_label" for="income_method"><?= $lh->translationFor('income_method') ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="mda-form-group label-floating">
                                            <select name="income_frequency" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched select" required>
                                                <option value="M"><?= $lh->translationFor('month') ?></option>
                                                <option value="D"><?= $lh->translationFor('date') ?></option>
                                                <option value="Q"><?= $lh->translationFor('quarter') ?></option>
                                            </select>
                                            <label class="form_label" for="income_frequency"><?= $lh->translationFor('income_frequency') ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="mda-form-group label-floating">
                                            <select name="income_receiving_date" class="selectpicker ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" data-live-search="true" required>
                                                <option value="1" selected>1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                                <option value="13">13</option>
                                                <option value="14">14</option>
                                                <option value="15">15</option>
                                                <option value="16">16</option>
                                                <option value="17">17</option>
                                                <option value="18">18</option>
                                                <option value="19">19</option>
                                                <option value="20">20</option>
                                                <option value="21">21</option>
                                                <option value="22">22</option>
                                                <option value="23">23</option>
                                                <option value="24">24</option>
                                                <option value="25">25</option>
                                                <option value="26">26</option>
                                                <option value="27">27</option>
                                                <option value="28">28</option>
                                                <option value="29">29</option>
                                                <option value="30">30</option>
                                                <option value="31">31</option>
                                            </select>
                                            <label class="select_label" for="income_receiving_date"><?= $lh->translationFor('income_receiving_date') ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="mda-form-group label-floating">
                                            <input type="text" tag="currency" min="0" max="999999999999" step="500000" name="monthly_income" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                            <label class="form_label" for="monthly_income"><?= $lh->translationFor('monthly_income') ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="mda-form-group label-floating">
                                            <input step="500000" tag="currency" type="text" min="0" max="999999999999" name="other_income" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched">
                                            <label class="form_label" for="other_income"><?= $lh->translationFor('other_income') ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <!--  -->
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="mda-form-group label-floating">
                                            <input step="500000" tag="currency" type="text" min="0" max="999999999999" name="monthly_expense" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                            <label class="form_label" for="monthly_expense"><?= $lh->translationFor('monthly_expense') ?></label>
                                        </div>
                                    </div>
                                    <!--  -->
                                </div>
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4">
                                        <div class="col-lg-2">
                                            <div class="iconCircle">
                                                <i class="fa fa-building fa-2x"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-10">
                                            <h3 class="text-light-blue">
                                                Nơi làm việc của bạn
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="mda-form-group label-floating" data-children-count="1">
                                            <select name="profession" class="selectpicker ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" data-live-search="true" required>
                                                <option value="MAG">Giám đốc</option>
                                                <option value="BOR">Chủ hộ kinh doanh</option>
                                                <option value="RRT">Hưu trí</option>
                                                <option value="TLR">Trưởng Nhóm/Giám Sát</option>
                                                <option value="CDY">Trưởng/phó phòng</option>
                                                <option value="WKL">Công Nhân/Lao Động Phổ Thông</option>
                                                <option value="SST" selected>Nhân Viên/Chuyên Viên</option>
                                                <option value="OFS">Sỹ quan</option>
                                                <option value="OTH">Khác</option>
                                            </select>
                                            <label class="select_label form_label" for="profession"><?= $lh->translationFor('profession') ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="mda-form-group label-floating">
                                            <input type="text" name="workplace_name" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                            <label class="form_label" for="workplace_name"><?= $lh->translationFor('workplace_name') ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="mda-form-group label-floating">
                                            <!-- <input type="text" name="workplace_province" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required> -->
                                            <label class="select_label" for="workplace_province"><?= $lh->translationFor('province') ?></label>
                                            <select name="workplace_province" class="selectpicker ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" data-live-search="true" required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="mda-form-group label-floating">
                                            <!-- <input type="text" name="workplace_district" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required> -->
                                            <label class="select_label form_label" for="workplace_district"><?= $lh->translationFor('district') ?></label>
                                            <select name="workplace_district" class="selectpicker ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" data-live-search="true" required>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="mda-form-group label-floating">
                                            <!-- <input type="text" name="workplace_ward" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required> -->
                                            <label class="select_label" for="workplace_ward"><?= $lh->translationFor('ward') ?></label>
                                            <select name="workplace_ward" class="selectpicker ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" data-live-search="true" required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="mda-form-group label-floating">
                                            <input type="text" name="workplace_address" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                            <label class="form_label" for="workplace_address"><?= $lh->translationFor('workplace_address') ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="mda-form-group label-floating">
                                            <input tag="phone" value="1234567890" type="text" name="workplace_phone" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                            <label class="form_label" for="workplace_phone"><?= $lh->translationFor('workplace_phone') ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="step-5" class="tab-pane active" role="tabpanel">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4">
                                        <div class="col-lg-2">
                                            <div class="iconCircle">
                                                <i class="fa fa-user fa-2x"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-10">
                                            <h3 class="text-light-blue">
                                                Thông tin thêm về bạn
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="mda-form-group label-floating">
                                            <!-- <input type="text" name="house_type" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required> -->
                                            <select name="house_type" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched select" required>
                                                <option value="ONC">Nhà sở hữu (không nợ vay)</option>
                                                <option value="OC">Nhà sở hữu (đang có nợ vay)</option>
                                                <option value="LOC">Nhà thuê/mướn/trọ</option>
                                                <option value="A">Ở cùng người thân/họ hàng/bạn bè</option>
                                                <option value="F" selected="true">Ở cùng cha mẹ</option>
                                                <option value="OTH">Khác</option>
                                            </select>
                                            <label class="form_label" for="house_type"><?= $lh->translationFor('house_type') ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="mda-form-group label-floating" data-children-count="1">
                                            <select name="married_status" class="selectpicker ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched select" required>
                                                <option value="V">Góa</option>
                                                <option value="M">Đã kết hôn</option>
                                                <option value="D">Ly hôn</option>
                                                <option value="C" selected>Độc thân</option>
                                                <option value="CON">Sống chung</option>
                                            </select>
                                            <label class="select_label" for="married_status"><?= $lh->translationFor('married_status') ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="mda-form-group label-floating">
                                            <input type="number" value="5" min="0" max="100" name="years_of_stay" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                            <label class="form_label" for="years_of_stay"><?= $lh->translationFor('years_of_stay') ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="mda-form-group label-floating">
                                            <input type="number" value="0" min="0" max="100" name="amount_people" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched">
                                            <label class="form_label" for="amount_people"><?= $lh->translationFor('amount_people') ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4">
                                        <div class="col-lg-2">
                                            <div class="iconCircle">
                                                <i class="fa fa-bank fa-2x"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-10">
                                            <h3 class="text-light-blue">
                                                Thông tin giải ngân
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="mda-form-group label-floating">
                                            <!-- <input type="text" name="loan_purpose" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required> -->
                                            <label class="select_label" for="loan_purpose"><?= $lh->translationFor('loan_purpose') ?></label>
                                            <select name="loan_purpose" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" data-live-search="true" required>
                                                <option value="HR">Chi phí sửa chữa nhà ở</option>
                                                <option value="ROL">Mua phương tiện đi lại, đồ dùng, trang thiết bị gia đình</option>
                                                <option value="EMT">Chi phí học tập, chữa bệnh, du lịch, văn hóa, thể dục, thể thao</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="mda-form-group label-floating" data-children-count="1">
                                            <select name="disbursement_method" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched select">
                                                <option value="cash" selected>Tiền mặt</option>
                                                <option value="bank">Chuyển khoản</option>
                                                <!-- <option value="mixed">Chuyển khoản và tiền mặt</option> -->
                                            </select>
                                            <label class="select_label" for="disbursement_method"><?= $lh->translationFor('disbursement_method') ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div id="disbursement_method_bank" hidden='true'>
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12">
                                            <div class="mda-form-group label-floating">
                                                <label class="select_label" for="bank_code"><?= $lh->translationFor('bank_code') ?></label>
                                                <select name="bank_code" class="selectpicker ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" data-live-search="true">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12">
                                            <div class="mda-form-group label-floating">
                                                <label class="select_label" for="bank_area"><?= $lh->translationFor('bank_area') ?></label>
                                                <select name="bank_area" class="selectpicker ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" data-live-search="true">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12">
                                            <div class="mda-form-group label-floating">
                                                <label class="select_label" for="bank_branch_code"><?= $lh->translationFor('bank_branch_code') ?></label>
                                                <select name="bank_branch_code" class="selectpicker ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" data-live-search="true">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12">
                                            <div class="mda-form-group label-floating">
                                                <input type="text" name="bank_account" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched">
                                                <label class="form_label" for="bank_account"><?= $lh->translationFor('bank_account') ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="mda-form-group label-floating">
                                            <input readonly type="text" name="beneficiary_name" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                            <label for="beneficiary_name"><?= $lh->translationFor('beneficiary_name') ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4">
                                        <div class="col-lg-2">
                                            <div class="iconCircle">
                                                <i class="fa fa-commenting-o fa-2x"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-10">
                                            <h3 class="text-light-blue">
                                                Thông tin liên lạc khác của bạn
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="mda-form-group label-floating">
                                            <label class="form_label" for="other_contact"><?= $lh->translationFor('other_contact') ?></label>
                                            <!-- <input type="text" name="other_contact" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required> -->
                                            <select name="other_contact" class="selectpicker ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched select" required>
                                                <option value="DOM">Số điện thoại nhà</option>
                                                <option value="BUR">Số điện thoại công ty</option>
                                                <option value="APPM">Ứng dụng di động (Zalo, Viber…)</option>
                                                <option value="OME">Thư điện tử khác (email)</option>
                                                <option value="ZALO">Tài khoản zalo</option>
                                                <option value="FB">Tài khoản Facebook</option>
                                                <option value="AUTGSM">Số điện thoại khác</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="mda-form-group label-floating">
                                            <input type="text" name="detail_contact" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched">
                                            <label class="form_label" for="detail_contact"><?= $lh->translationFor('detail_contact') ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-5 col-lg-5">
                                        <div class="col-lg-2">
                                            <div class="iconCircle">
                                                <i class="fa fa-hand-o-right fa-2x"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-10">
                                            <h3 class="text-light-blue">
                                                Thông tin liên lạc người thân khi cần
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="row col-lg-6">
                                        <div class="col-xl-12 col-lg-12">
                                            <div class="mda-form-group label-floating">
                                                <label class="form_label" for="relation_1"><?= $lh->translationFor('relation_1') ?></label>
                                                <!-- <input type="text" name="relation_1" class="selectpicker ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required> -->
                                                <select name="relation_1" class="selectpicker ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched select" required>
                                                    <option value="CP">Bạn bè/Đồng nghiệp sống cùng tỉnh</option>
                                                    <option value="RHH">Họ hàng cùng hộ khẩu</option>
                                                    <option value="HW">Vợ/Chồng</option>
                                                    <option value="PS">Cha/Mẹ</option>
                                                    <option value="CN">Con</option>
                                                    <option value="SB">Anh/Chị/Em ruột</option>
                                                    <option value="RSP">Họ hàng sống cùng tỉnh</option>
                                                    <option value="OTH">Khác</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12">
                                            <div class="mda-form-group label-floating">
                                                <input type="text" name="relation_1_name" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                                <label class="form_label" for="relation_1_name"><?= $lh->translationFor('relation_1_name') ?></label>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12">
                                            <div class="mda-form-group label-floating">
                                                <input type="text" tag="phone" name="relation_1_phone_number" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                                <label class="form_label" for="relation_1_phone_number"><?= $lh->translationFor('relation_1_phone_number') ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-lg-6">
                                        <div class="col-xl-12 col-lg-12">
                                            <div class="mda-form-group label-floating">
                                                <label class="form_label" for="relation_2"><?= $lh->translationFor('relation_2') ?></label>
                                                <!-- <input type="text" name="relation_2" class="selectpicker ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required> -->
                                                <select name="relation_2" class="selectpicker ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched select" required>
                                                    <option value="CP">Bạn bè/Đồng nghiệp sống cùng tỉnh</option>
                                                    <option value="RHH">Họ hàng cùng hộ khẩu</option>
                                                    <option value="OTH">Khác</option>
                                                    <option value="HW">Vợ/Chồng</option>
                                                    <option value="PS">Cha/Mẹ</option>
                                                    <option value="CN">Con</option>
                                                    <option value="SB">Anh/Chị/Em ruột</option>
                                                    <option value="RSP">Họ hàng sống cùng tỉnh</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12">
                                            <div class="mda-form-group label-floating">
                                                <input type="text" name="relation_2_name" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                                <label class="form_label" for="relation_2_name"><?= $lh->translationFor('relation_2_name') ?></label>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12">
                                            <div class="mda-form-group label-floating">
                                                <input tag="phone" type="text" name="relation_2_phone_number" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                                <label class="form_label" for="relation_2_phone_number"><?= $lh->translationFor('relation_2_phone_number') ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="mda-form-group label-floating">
                                            <input value="<?= $_SESSION['user'] ?>" readonly type="text" name="dsa_agent_code" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                            <label class="form_label" for="dsa_agent_code"><?= $lh->translationFor('dsa_agent_code') ?></label>
                                        </div>
                                    </div>
                                </div>
                                <!-- <button class="btn btn-primary" id="submit-full-loan" type="submit"><?= $lh->translationFor('submit') ?></button> -->
                            </div>
                            <div id="step-6" class="tab-pane active" role="tabpanel">
                                <div class="row" style="margin-bottom: 10px;padding: 20px 10px; border: 1px solid #5cb85c;">
                                    <div class="col-xl-6 col-lg-12">
                                        <div class="row">
                                            <div class="col-xl-4 col-lg-4">
                                                <div class="col-lg-2">
                                                    <div class="iconCircle">
                                                        <i class="fa fa-info fa-2x"></i>
                                                    </div>
                                                </div>
                                                <div class="col-lg-10">
                                                    <h3 class="text-light-blue">
                                                        UPLOAD CHECK ELIGIBLE
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-12">
                                        <div class="row">
                                            <div class="col-sm-12" style="padding-bottom: 10px;">
                                                <label class="form_label" for="img_id_card2"><?= $lh->translationFor('img_id_card') ?></label>
                                                <input type="text" name="img_id_card2" class="id_img_hide" required />
                                                <input type="file" id="img_id_card2" class="id_img custom-file-input" />
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom: 10px;">
                                            <div class="col-sm-12">
                                                <button id="submit_img_id_card2" class="btn btn-warning"><?= $lh->translationFor('submit_img_id_card') ?></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-12">
                                        <div class="row">
                                            <div class="col-sm-12" style="padding-bottom: 10px;">
                                                <label class="form_label" for="img_selfie2"><?= $lh->translationFor('img_selfie') ?></label>
                                                <input type="text" name="img_selfie2" class="id_img_hide" required />
                                                <input type="file" id="img_selfie2" class="id_img custom-file-input" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <button id="submit_img_selfie2" class="btn btn-warning"><?= $lh->translationFor('submit_img_selfie') ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--  -->
                                <!-- PRODUCT DETAIL DEBUG-->
                                <!--  -->
                                <div class="row" style="margin-bottom: 10px;padding: 20px 10px; border: 1px solid #5cb85c;">
                                    <div class="col-xl-6 col-lg-12">
                                        <div class="row">
                                            <div class="col-xl-4 col-lg-4">
                                                <div class="col-lg-2">
                                                    <div class="iconCircle">
                                                        <i class="fa fa-envelope fa-2x"></i>
                                                    </div>
                                                </div>
                                                <div class="col-lg-10">
                                                    <h3 class="text-light-blue">
                                                        UPLOAD CHECK DOCS
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div id="product_detail" class="row">
                                            <div class="col-xl-12 col-lg-12">
                                                <label style="font-size: large;" id="product_required_description">Chứng từ bắt buộc </label>
                                            </div>
                                            <div class="col-xl-12 col-lg-12">
                                                <hr style="margin: 5px !important;">
                                            </div>
                                            <div class="col-xl-12 col-lg-12">
                                                <div class="mda-form-group label-floating">
                                                    <input type="text" name="product_required_document" class="mda-form-control ng-pristine ng-empty ng-invalid ng-touched" readonly disabled>
                                                    <label style="font-size: large;">Mã chứng từ bắt buộc: </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12" id="product_name_detail">
                                    </div>
                                    <div class="col-sm-12" style="padding-bottom: 10px;">
                                        <label class="form_label" for="attachment_files2"><?= $lh->translationFor('upload_attach') ?></label>
                                        <input multiple type="file" id="attachment_files2" class="attachment-input" />
                                    </div>
                                    <div class="col-sm-12">
                                        <button class="btn btn-warning" id="submit_attachment"><?= $lh->translationFor('submit_attachment') ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>