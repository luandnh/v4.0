
<div id="full-loan_copy" role="tabpanel" class="tab-pane">
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h4 class="box-title">1.<?=$lh->translationFor('full_loan_detail')?></h4>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="box-group">
                        <form action="#" id="full-loan-form-copy">
                            <div class="row">
                                <div class="col-xl-3 col-lg-4">
                                    <div class="mda-form-group label-floating" data-children-count="1">
                                        <input name="request_id" type="text" width="auto" value="" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" readonly>
                                        <label for="request_id">1. <?=$lh->translationFor('id')?></label>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-4">
                                    <div class="mda-form-group label-floating" data-children-count="1">
                                        <input name="partner_code" type="text" width="auto" value="" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" readonly>
                                        <label for="partner_code">2. <?=$lh->translationFor('partner_code')?></label>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-4">
                                    <div class="mda-form-group label-floating" data-children-count="1">
                                        <input name="lead_code" type="text" width="auto" value="" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" readonly>
                                        <label for="lead_code">3. <?=$lh->translationFor('leadcode')?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                        <h4>2. <?=$lh->translationFor('customer_information')?></label></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6 col-lg-12">
                                    <div class="mda-form-group label-floating" data-children-count="1">
                                        <input name="customer_name" type="text" width="auto" value="" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="customer_name">2.1. <?=$lh->translationFor('customer_name')?></label>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-6">
                                    <div class="mda-form-group label-floating" data-children-count="1">
                                        <select name="gender" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched select" required>
                                            
                                            <option value="M"><?=$lh->translationFor('male')?></label></option>
                                            <option value="F"><?=$lh->translationFor('female')?></label></option>
                                        </select>
                                        <label for="gender">2.2. <?=$lh->translationFor('gender')?></label>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
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
                                        <label for="identity_card_id">2.4. <?= $lh->translationFor('identity_card_id') ?></label>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="issue_date" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="issue_date">2.5.  <?= $lh->translationFor('identity_issue_date') ?></label>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <select name="issue_place" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched select" required>
                                            
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
                                        <label for="issue_place">2.6. <?= $lh->translationFor('identity_issue_place') ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="identity_card_id_2" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched">
                                        <label for="identity_card_id_2">2.7. <?= $lh->translationFor('identity_card_id') ?> 2</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6 col-lg-6">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="phone_number" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="phone_number">2.8. <?= $lh->translationFor('phone_number') ?></label>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="email" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="email">2.9.  <?= $lh->translationFor('email') ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <!-- <input type="text" name="other_contact" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required> -->
                                        <select name="other_contact" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched select" required>
                                            <option value="DOM">Số điện thoại nhà</option>
                                            <option value="BUR">Số điện thoại công ty</option>
                                            <option value="APPM">Ứng dụng di động (Zalo, Viber…)</option>
                                            <option value="OME">Thư điện tử khác (email)</option>
                                            <option value="ZALO">Tài khoản zalo</option>
                                            <option value="FB">Tài khoản Facebook</option>
                                            <option value="AUTGSM">Số điện thoại khác</option>
                                        </select>
                                        <label for="other_contact">2.10. <?= $lh->translationFor('other_contact') ?></label>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="detail_contact" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched">
                                        <label for="detail_contact">2.11. <?= $lh->translationFor('detail_contact') ?></label>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="tax" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" >
                                        <label for="tax">2.12. <?= $lh->translationFor('tax') ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-3 col-lg-6">
                                    <div class="mda-form-group label-floating">
                                        <!-- <input type="text" name="house_type" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required> -->
                                        <select name="house_type" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched select" required>
                                            <option value="ONC">Nhà sở hữu (không nợ vay)</option>
                                            <option value="OC">Nhà sở hữu (đang có nợ vay)</option>
                                            <option value="LOC">Nhà thuê/mướn/trọ</option>
                                            <option value="A">Ở cùng người thân/họ hàng/bạn bè</option>
                                            <option value="F">Ở cùng cha mẹ</option>
                                            <option value="OTH">Khác</option>
                                        </select>
                                        <label for="house_type">2.13. <?= $lh->translationFor('house_type') ?></label>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-6">
                                    <div class="mda-form-group label-floating">
                                        <!-- <input type="text" name="tem_province" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required> -->
                                        <label  class="select_label"  for="tem_province">2.14. <?= $lh->translationFor('province') ?></label>
                                        <select name="tem_province"  class="selectpicker ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" data-live-search="true" required>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-6">
                                    <div class="mda-form-group label-floating">
                                        <!-- <input type="text" name="tem_district" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required> -->
                                        <label class="select_label"  for="tem_district">2.15. <?= $lh->translationFor('district') ?></label>
                                        <select name="tem_district"  class="selectpicker ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" data-live-search="true" required>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-6">
                                    <div class="mda-form-group label-floating">
                                        <!-- <input type="text" name="tem_ward" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required> -->
                                        <label class="select_label"  for="tem_ward">2.16. <?= $lh->translationFor('ward') ?></label>
                                        <select name="tem_ward"  class="selectpicker ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" data-live-search="true" required>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-9 col-lg-9">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="tem_address" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="tem_address">2.17. <?= $lh->translationFor('address') ?></label>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3">
                                    <div class="mda-form-group label-floating">
                                        <input type="number" min="0" max="999999999999" name="years_of_stay" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="years_of_stay">2.18. <?= $lh->translationFor('years_of_stay') ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="mda-form-group label-floating">
                                        <div class="checkbox">
                                            <label data-children-count="1">
                                                <input type="checkbox" name="check_same_address" readonly>
                                                <?= $lh->translationFor('check_same_address') ?></label>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <!-- <input type="text" name="permanent_province" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required> -->
                                        <label class="select_label"  for="permanent_province">2.19. <?= $lh->translationFor('permanent_province') ?></label>
                                        <select name="permanent_province"  class="selectpicker ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" data-live-search="true" required>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <!-- <input type="text" name="permanent_district" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required> -->
                                        <label class="select_label"  for="permanent_district">2.20. <?= $lh->translationFor('permanent_district') ?></label>
                                        <select name="permanent_district"  class="selectpicker ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" data-live-search="true" required>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <!-- <input type="text" name="permanent_ward" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required> -->
                                        <label class="select_label"  for="permanent_ward">2.21. <?= $lh->translationFor('permanent_ward') ?></label>
                                        <select name="permanent_ward"  class="selectpicker ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" data-live-search="true" required>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="permanent_address" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="permanent_address">2.22. <?= $lh->translationFor('permanent_address') ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <h4>3. <?= $lh->translationFor('work') ?></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-2 col-lg-3">
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
                                        <label class="select_label" for="job_type">3.1. <?= $lh->translationFor('job_type') ?></label>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3">
                                    <div class="mda-form-group label-floating" data-children-count="1">
                                        <select name="profession" class="selectpicker ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" data-live-search="true" required>
                                            
                                            <option value="MAG">Giám đốc</option>
                                            <option value="BOR">Chủ hộ kinh doanh</option>
                                            <option value="RRT">Hưu trí</option>
                                            <option value="TLR">Trưởng Nhóm/Giám Sát</option>
                                            <option value="CDY">Trưởng/phó phòng</option>
                                            <option value="WKL">Công Nhân/Lao Động Phổ Thông</option>
                                            <option value="SST">Nhân Viên/Chuyên Viên</option>
                                            <option value="OFS">Sỹ quan</option>
                                            <option value="OTH">Khác</option>
                                        </select>
                                        <label class="select_label" for="profession">3.2. Profession</label>
                                    </div>
                                </div>
                                <div class="col-xl-1 col-lg-3">
                                    <div class="mda-form-group label-floating" data-children-count="1">
                                        <select name="employment_type" class="selectpicker ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" data-live-search="true" required>
                                            
                                            <option value="E">Đi làm hưởng lương</option>
                                            <option value="SE">Tự kinh doanh</option>
                                            <option value="RP">Hưởng lương hưu</option>
                                            <option value="FE">Làm nghề tự do</option>
                                            </select>
                                        <label class="select_label" for="employment_type">3.3. Employment Type</label>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-3">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="company_name" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched">
                                        <label for="company_name">3.4. <?= $lh->translationFor('company_name') ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <!-- <input type="text" name="workplace_province" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required> -->
                                        <label  class="select_label" for="workplace_province">3.5. <?= $lh->translationFor('workplace_province') ?></label>
                                        <select name="workplace_province"  class="selectpicker ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" data-live-search="true" required>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <!-- <input type="text" name="workplace_district" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required> -->
                                        <label  class="select_label" for="workplace_district">3.6. <?= $lh->translationFor('workplace_district') ?></label>
                                        <select name="workplace_district"  class="selectpicker ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" data-live-search="true" required>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <!-- <input type="text" name="workplace_ward" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required> -->
                                        <label  class="select_label" for="workplace_ward">3.7. <?= $lh->translationFor('workplace_ward') ?></label>
                                        <select name="workplace_ward"  class="selectpicker ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" data-live-search="true" required>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6 col-lg-6">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="workplace_phone" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="workplace_phone">3.8. <?= $lh->translationFor('workplace_phone') ?></label>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="workplace_name" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="workplace_name">3.9. <?= $lh->translationFor('workplace_name') ?></label>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="workplace_address" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="workplace_address">3.10. <?= $lh->translationFor('workplace_address') ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6 col-lg-3">
                                    <div class="mda-form-group label-floating">
                                        <select name="employment_contract"  class="selectpicker ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" data-live-search="true" required>
                                        <option value="IT">HĐLĐ toàn thời gian không xác định thời hạn</option>
                                        <option value="DT">HĐLĐ toàn thời gian có xác định thời hạn</option>
                                        <option value="ST">HĐ mùa vụ</option>
                                        <option value="PC">HĐ thử việc</option>
                                        <option value="PT">HĐLĐ bán thời gian</option>
                                        <option value="OTH">Khác</option>
                                        </select>
                                        <label  class="select_label"  for="employment_contract">3.11. <?= $lh->translationFor('employment_contract') ?></label>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-3">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="contract_term" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="contract_term">3.12. <?= $lh->translationFor('contract_term') ?></label>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-3">
                                    <div class="mda-form-group label-floating">
                                        <input type="number" min="2000" max="2100" name="from" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="from">3.13. <?= $lh->translationFor('from') ?></label>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-3">
                                    <div class="mda-form-group label-floating">
                                        <input type="number" min="2000" max="2100" name="to" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="to">3.14. <?= $lh->translationFor('to') ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <h4>4. <?= $lh->translationFor('relationship') ?></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="mda-form-group label-floating" data-children-count="1">
                                        <select name="married_status" class="selectpicker ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched select" required>
                                            <option value="V">Góa</option>
                                            <option value="M">Đã kết hôn</option>
                                            <option value="D">Ly hôn</option>
                                            <option value="C">Độc thân</option>
                                            <option value="CON">Sống chung</option>
                                        </select>
                                        <label class="select_label" for="married_status">4.1. <?= $lh->translationFor('married_status') ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-2 col-lg-2">
                                    <div class="mda-form-group label-floating">
                                        <!-- <input type="text" name="relation_1" class="selectpicker ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required> -->
                                        <select name="relation_1" class="selectpicker ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched select" required>
                                            <option value="CP">Bạn bè/Đồng nghiệp sống cùng tỉnh</option>
                                            <option value="RHH">Họ hàng cùng hộ khẩu</option>
                                            <option value="OTH">Khác</option>
                                            <option value="HW">Vợ/Chồng</option>
                                            <option value="PS">Cha/Mẹ</option>
                                            <option value="CN">Con</option>
                                            <option value="SB">Anh/Chị/Em ruột</option>
                                            <option value="RSP">Họ hàng sống cùng tỉnh</option>
                                        </select>
                                        <label for="relation_1">4.1. <?= $lh->translationFor('relation_1') ?></label>

                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="relation_1_name" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="relation_1_name">4.2. <?= $lh->translationFor('relation_1_name') ?></label>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="relation_1_phone_number" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="relation_1_phone_number">4.3. <?= $lh->translationFor('relation_1_phone_number') ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-2 col-lg-2">
                                    <div class="mda-form-group label-floating">
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
                                        <label for="relation_2">4.4. <?= $lh->translationFor('relation_2') ?></label>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="relation_2_name" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="relation_2_name">4.5. <?= $lh->translationFor('relation_2_name') ?></label>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="relation_2_phone_number" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="relation_2_phone_number">4.6. <?= $lh->translationFor('relation_2_phone_number') ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <h4>5. <?= $lh->translationFor('disbursement') ?></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-2 col-lg-4">
                                    <div class="mda-form-group label-floating" data-children-count="1">
                                        <select name="disbursement_method" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched select" required>
                                            <option value="cash">Tiền mặt</option>
                                            <option value="trans">Chuyển khoản</option>
                                            <option value="mixed">Chuyển khoản và tiền mặt</option>
                                        </select>
                                        <label  class="select_label" for="disbursement_method">5.1. <?= $lh->translationFor('disbursement_method') ?></label>
                                    </div>
                                </div>
                                <div class="col-xl-10 col-lg-8">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="beneficiary_name" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched">
                                        <label for="beneficiary_name">5.2. <?= $lh->translationFor('beneficiary_name') ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="mda-form-group label-floating">
                                        <label class="select_label" for="bank_code">5.3. <?= $lh->translationFor('bank_code') ?></label>
                                        <select name="bank_code"  class="selectpicker ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" data-live-search="true" required>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="bank_branch_code" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched">
                                        <label for="bank_branch_code">5.4. <?= $lh->translationFor('bank_branch_code') ?></label>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-8">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="bank_account" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched">
                                        <label for="bank_account">5.5. <?= $lh->translationFor('bank_account') ?></label>
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
                                        <label for="income_method">5.6. <?= $lh->translationFor('income_method') ?></label>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <select name="income_frequency" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched select" required>
                                            <option value="M"><?= $lh->translationFor('month') ?></option>
                                            <option value="D"><?= $lh->translationFor('date') ?></option>
                                            <option value="Q"><?= $lh->translationFor('quarter') ?></option>
                                        </select>
                                        <label for="income_frequency">5.7. <?= $lh->translationFor('income_frequency') ?></label>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <input type="number" min="0" max="999999999999" name="income_receiving_date" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched">
                                        <label for="income_receiving_date">5.8. <?= $lh->translationFor('income_receiving_date') ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <input type="number" min="0" max="999999999999" name="monthly_income" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="monthly_income">5.9. <?= $lh->translationFor('monthly_income') ?></label>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <input type="number" min="0" max="999999999999" name="other_income" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched">
                                        <label for="other_income">5.10. <?= $lh->translationFor('other_income') ?></label>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <input type="number" min="0" max="999999999999" name="monthly_expense" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="monthly_expense">5.11. <?= $lh->translationFor('monthly_expense') ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <h4>6. <?= $lh->translationFor('loan_detail') ?></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 col-lg-4">
                                    <div class="mda-form-group label-floating" data-children-count="1">
                                        <!-- <select name="product_type" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched select" required>
                                        </select> -->
                                        <input type="text" name="product_type" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="product_type">6.1. <?= $lh->translationFor('product_type') ?></label>
                                    </div>
                                </div>
                                <div class="col-xl-8 col-lg-8">
                                    <div class="mda-form-group label-floating">
                                        <!-- <input type="text" name="loan_purpose" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required> -->
                                        <label class="select_label" for="loan_purpose">6.2. <?= $lh->translationFor('loan_purpose') ?></label>
                                        <select name="loan_purpose"  class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" data-live-search="true" required>
                                            <option value="HR">Chi phí sửa chữa nhà ở</option>
                                            <option value="ROL">Mua phương tiện đi lại, đồ dùng, trang thiết bị gia đình</option>
                                            <option value="EMT">Chi phí học tập, chữa bệnh, du lịch, văn hóa, thể dục, thể thao</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="loan_tenor" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="loan_tenor">6.3. <?= $lh->translationFor('loan_tenor') ?></label>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <input type="number" min="0" max="999999999999" name="loan_amount" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="loan_amount">6.4. <?= $lh->translationFor('loan_amount') ?></label>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="lending_method" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="lending_method">6.5. <?= $lh->translationFor('lending_method') ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-6">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="business_date" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="business_date">6.6. <?= $lh->translationFor('business_date') ?></label>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-6">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="business_license_number" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched">
                                        <label for="business_license_number">6.7. <?= $lh->translationFor('business_license_number') ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-3 col-lg-3">
                                    <div class="mda-form-group label-floating">
                                        <input type="number" min="0" max="999999999999" name="annual_revenue" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="annual_revenue">6.8. <?= $lh->translationFor('annual_revenue') ?></label>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3">
                                    <div class="mda-form-group label-floating">
                                        <input type="number" min="0" max="999999999999" name="annual_profit" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="annual_profit">6.9. <?= $lh->translationFor('annual_profit') ?></label>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3">
                                    <div class="mda-form-group label-floating">
                                        <input type="number" min="0" max="999999999999" name="monthly_revenue" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="monthly_revenue">6.10. <?= $lh->translationFor('monthly_revenue') ?></label>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3">
                                    <div class="mda-form-group label-floating">
                                        <input type="number" min="0" max="999999999999" name="monthly_profit" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="monthly_profit">6.11. <?= $lh->translationFor('monthly_profit') ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6 col-lg-6">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="3rd_Party_duration" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="3rd_Party_duration">6.12. <?= $lh->translationFor('3rd_Party_duration') ?></label>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="sale_code" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
                                        <label for="sale_code">6.13. <?= $lh->translationFor('sale_code') ?></label>
                                    </div>
                                </div>
                            </div>
                    
                            <div class="row"  id="offer-waiting" hidden>
                            <div class="col-xl-12 col-lg-6" >
                                <button class="buttonload" style="background-color: #3f51b5; border: none; border-radius: 10px; color: white; padding: 12px 24px;font-size: 16px;">
                                <i class="fa fa-spinner fa-spin" style="margin: 0px 5px;"></i><?= $lh->translationFor('wait_for_offer') ?>
                                </button>
                                </div>
                            </div>
                            <div class="row hidden" id="offer-datatable">
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
                                <div class="col-xl-12 col-lg-8">
                                    <table id="create-offer-table" hidden>
                                           
                                    </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-bottom: 10px;">
                                <div class="row">
                                    <div class="col-sm-6" style="padding-bottom: 10px;">
                                            <label for="img_id_card"><?= $lh->translationFor('img_id_card') ?></label>
                                            <input type="text" name="img_id_card" class="id_img_hide" required/>
                                            <input type="file" id="img_id_card" class="id_img custom-file-input"/>
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-sm-6">
                                        <button id="submit_img_id_card" class="btn btn-warning"><?= $lh->translationFor('submit_img_id_card') ?></button>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-bottom: 10px;">
                                <div class="row">
                                    <div class="col-sm-6" style="padding-bottom: 10px;">
                                            <label for="img_selfie"><?= $lh->translationFor('img_selfie') ?></label>
                                            <input type="text" name="img_selfie" class="id_img_hide" required/>
                                            <input type="file" id="img_selfie" class="id_img custom-file-input"/>
                                    </div>
                                </div>
                                <div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <button id="submit_img_selfie" class="btn btn-warning"><?= $lh->translationFor('submit_img_selfie') ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--  -->
                            <!-- PRODUCT DETAIL DEBUG-->
                            <div id="product_detail" class="row">
                                <div class="col-xl-8 col-lg-8">
                                    <div class="mda-form-group label-floating">
                                        <input type="text" name="product_required_document" class="mda-form-control ng-pristine ng-empty ng-invalid ng-touched" readonly disabled>
                                        <label>Required document: </label>
                                    </div>
                                </div>
                            </div>
                            <!--  -->
                            <div class="row" style="margin-bottom: 10px;">
                                <div class="col-sm-12" style="padding-bottom: 10px;">
                                        <label for="attachment_files"><?= $lh->translationFor('upload_attach') ?></label>
                                        <input multiple type="file" id="attachment_files" class="attachment-input"/>
                                </div>
                                <div class="col-sm-12">
                                    <button id="submit_attachment"><?= $lh->translationFor('submit_attachment') ?></button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <button class="btn btn-primary" id="submit-full-loan" type="submit"><?= $lh->translationFor('submit') ?></button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <button class="btn btn-primary" id="submit-offer" hidden> <?= $lh->translationFor('submit_offer') ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>