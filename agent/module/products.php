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
                    <div class="col-md-4">
                        <form id="product-detail-form">
                        </form>
                    </div>
                    <div class="col-md-8" id="product-detail-table">

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
                <h4 class="modal-title"><b>Offer Detail</b></h4>
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
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Full-Loan Detail</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="box-group">
                        <form action="#" id="full-loan-form">
                            <div class="row">
                                <div class="col-xl-3 col-lg-4">
                                    <div class="mda-form-group label-floating" data-children-count="1">
                                        <input name="request_id" type="text" width="auto" value="" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" readonly>
                                        <label for="request_id">1. Id</label>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-4">
                                    <div class="mda-form-group label-floating" data-children-count="1">
                                        <input name="partner_code" type="text" width="auto" value="" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" readonly>
                                        <label for="partner_code">2. Partner Code</label>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-4">
                                    <div class="mda-form-group label-floating" data-children-count="1">
                                        <input name="lead_code" type="text" width="auto" value="" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" readonly>
                                        <label for="lead_code">3. Lead Code</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <h4>2. Customer Information</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="mda-form-group label-floating" data-children-count="1">
                                        <input name="customer_name" type="text" width="auto" value="" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="customer_name">2.1. Customer Name</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-6">
                                    <div class="mda-form-group label-floating" data-children-count="1">
                                        <select name="gender" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched select" required>
                                            <option value="" selected=""></option>
                                            <option value="M">Male</option>
                                            <option value="F">Female</option>
                                        </select>
                                        <label for="gender">2.2. Gender</label>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-6">
                                    <div class="mda-form-group label-floating">
                                        <input type="date" name="date_of_birth" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="date_of_birth">2.3 <?= $lh->translationFor('date_of_birth') ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="identity_card_id" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="identity_card_id">2.4. Identity Card Id</label>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="issue_date" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="issue_date">2.5. Issue Date</label>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="issue_place" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="issue_place">2.6. Issue Place</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="identity_card_id_2" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched">
                                        <label for="identity_card_id_2">2.7. Identity Card Id 2</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-6">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="phone_number" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="phone_number">2.8. Phone Number</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="email" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="email">2.9. Email</label>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="other_contact" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="other_contact">2.10. Other Contact</label>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="detail_contact" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched">
                                        <label for="detail_contact">2.11. Detail Contact</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-6">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="tax" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="tax">2.12. Tax</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-6">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="house_type" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="house_type">2.13. House Type</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="tem_province" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="tem_province">2.14. Province</label>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="tem_district" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="tem_district">2.15. District</label>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="tem_ward" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="tem_ward">2.16. Ward</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="tem_address" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="tem_address">2.17. Address</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="mda-form-group label-floating">
                                        <input type="number" min="0" max="999999999999" name="years_of_stay" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="years_of_stay">2.18. Year Of Stay</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="mda-form-group label-floating">
                                        <div class="checkbox">
                                            <label data-children-count="1">
                                                <input type="checkbox" name="check_same_address">
                                                Billing address is the same as contact address 1
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="permanent_province" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="permanent_province">2.19. Permanent Province</label>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="permanent_district" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="permanent_district">2.20. Permanent District</label>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="permanent_ward" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="permanent_ward">2.21. Permanent Ward</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="permanent_address" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="permanent_address">2.22. Permanent Address</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <h4>3. Work</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="job_title" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="job_title">3.1. Job Title</label>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="profession" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="profession">3.2. Profession</label>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4">
                                    <div class="mda-form-group label-floating" data-children-count="1">
                                        <select name="employment_type" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched select" required>
                                            <option value="" selected=""></option>
                                            <option value="E">Employee</option>
                                            <option value="SE">Self-Employee</option>
                                            <option value="RP">Retired</option>
                                            <option value="FE">Freelance</option>
                                        </select>
                                        <label for="employment_type">3.3. Employment Type</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-6">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="company_name" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="company_name">3.4. Company Name</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="workplace_city" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="workplace_city">3.5. Workplace City</label>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="workplace_district" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="workplace_district">3.6. Workplace District</label>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="workplace_ward" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="workplace_ward">3.7. Workplace Ward</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-6">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="workplace_phone" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="workplace_phone">3.8. Workplace Phone</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="workplace_address" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="workplace_address">3.9. Workplace Address</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6 col-lg-3">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="employment_contract" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="employment_contract">3.10. Contract</label>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-3">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="contract_term" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="contract_term">3.11. Contract Term</label>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-3">
                                    <div class="mda-form-group label-floating">
                                        <input type="number" min="2000" max="2100" name="from" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="from">3.12. From</label>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-3">
                                    <div class="mda-form-group label-floating">
                                        <input type="number" min="2000" max="2100" name="to" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="to">3.13. To</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <h4>4. Relationship</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="mda-form-group label-floating" data-children-count="1">
                                        <select name="married_status" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched select" required>
                                            <option value="" selected=""></option>
                                            <option value="M">Male</option>
                                            <option value="F">Female</option>
                                        </select>
                                        <label for="married_status">4.1. Married Status</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-2 col-lg-3">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="relation_1" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="relation_1">4.1. Relation 01</label>
                                    </div>
                                </div>
                                <div class="col-xl-10 col-lg-9">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="relation_1_name" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="relation_1_name">4.2. Relation 01 Name</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="relation_1_phone_number" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="relation_1_phone_number">4.3. Relation 01 Phone Number</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-2 col-lg-3">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="relation_2" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="relation_1">4.4. Relation 02</label>
                                    </div>
                                </div>
                                <div class="col-xl-10 col-lg-9">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="relation_2_name" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="relation_2_name">4.5. Relation 02 Name</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="relation_2_phone_number" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="relation_2_phone_number">4.6. Relation 02 Phone Number</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <h4>5. Disbursement</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="mda-form-group label-floating" data-children-count="1">
                                        <select name="disbursement_method" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched select" required>
                                            <option value="" selected=""></option>
                                            <option value="1">Cash</option>
                                            <option value="2">Bank</option>
                                        </select>
                                        <label for="disbursement_method">5.1. Disbursement Method</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="beneficiary_name" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched">
                                        <label for="beneficiary_name">5.2. Beneficiary Name</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-6">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="bank_code" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched">
                                        <label for="bank_code">5.3. Bank Code</label>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-6">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="bank_branch_code" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched">
                                        <label for="bank_branch_code">5.4. Bank Branch Code</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="bank_account" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched">
                                        <label for="bank_account">5.5. Bank Account</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="income_method" id="income_method" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <datalist id="income_method">
                                            <option value="CASH">
                                            <option value="BANK">
                                        </datalist>
                                        <label for="income_method">5.6. Income Method</label>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <select name="income_frequency" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched select" required>
                                            <option value="M">Month</option>
                                            <option value="D">Date</option>
                                            <option value="Q">Quarter</option>
                                        </select>
                                        <label for="income_frequency">5.7. Income Fequency</label>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <input type="number" min="0" max="999999999999" name="income_receiving_date" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched">
                                        <label for="income_receiving_date">5.8. Income Receiving Date</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-6">
                                    <div class="mda-form-group label-floating">
                                        <input type="number" min="0" max="999999999999" name="monthly_income" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="monthly_income">5.9. Monthly Income</label>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-6">
                                    <div class="mda-form-group label-floating">
                                        <input type="number" min="0" max="999999999999" name="other_income" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched">
                                        <label for="other_income">5.10. Other Income</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-6">
                                    <div class="mda-form-group label-floating">
                                        <input type="number" min="0" max="999999999999" name="monthly_expense" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="monthly_expense">5.11. Monthly Expense</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <h4>6. Loan Detail</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="mda-form-group label-floating" data-children-count="1">
                                        <!-- <select name="product_type" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched select" required>
                                        </select> -->
                                        <input type="text" name="product_type" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="product_type">6.1. Product Id</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="loan_purpose" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="loan_purpose">6.2. Loan Purpose</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="loan_tenor" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="loan_tenor">6.3. Loan Tenor</label>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <input type="number" min="0" max="999999999999" name="loan_amount" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="loan_amount">6.4. Loan Amount</label>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="lending_method" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="lending_method">6.5. Loan Method</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-6">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="business_date" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="business_date">6.6. Business Date</label>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-6">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="business_license_number" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="business_license_number">6.7. Business License Number</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-3 col-lg-3">
                                    <div class="mda-form-group label-floating">
                                        <input type="number" min="0" max="999999999999" name="annual_revenue" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="annual_revenue">6.8. Annual Revenue</label>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3">
                                    <div class="mda-form-group label-floating">
                                        <input type="number" min="0" max="999999999999" name="annual_profit" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="annual_profit">6.9. Annual Profit</label>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3">
                                    <div class="mda-form-group label-floating">
                                        <input type="number" min="0" max="999999999999" name="monthly_revenue" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="monthly_revenue">6.10. Monthly Revenue</label>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3">
                                    <div class="mda-form-group label-floating">
                                        <input type="number" min="0" max="999999999999" name="monthly_profit" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="monthly_profit">6.11. Monthly Profit</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-6">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="3rd_Party_duration" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="3rd_Party_duration">6.12. 3rd Party duration</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-6">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="sale_code" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="sale_code">6.13. Sale Code</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="offer-datatable">
                                <div class="col-xl-12 col-lg-8">
                                    <table id="offer-list-table" class="display responsive no-wrap table table-responsive table-striped table-bordered" width="100%">

                                    </table>
                                </div>
                                <div class="col-xl-12 col-lg-4">
                                    <table id="offer-insurance-list-table" class="display responsive no-wrap table table-responsive table-striped table-bordered" width="100%">

                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <button class="btn btn-primary" id="submit-full-loan" type="submit">Submit</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <button class="btn btn-primary" id="submit-offer" hidden>Submit Offer</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>