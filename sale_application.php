<?php

/**
 * @file 		telephonylist.php
 * @brief 		Manage List and Upload Leads
 * @copyright 	Copyright (c) 2020 GOautodial Inc. 
 * @author		Demian Lizandro A. Biscocho
 * @author     	Alexander Jim H. Abenoja
 *
 * @par <b>License</b>:
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Affero General Public License for more details.
 *
 *  You should have received a copy of the GNU Affero General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 **/
ini_set('memory_limit', '1024M');
ini_set('upload_max_filesize', '600M');
ini_set('post_max_size', '600M');
ini_set('max_execution_time', 0);
define('GO_BASE_DIRECTORY', dirname(dirname(dirname(__FILE__))));
require_once('./php/UIHandler.php');
require_once('./php/APIHandler.php');
require_once('./php/CRMDefaults.php');
require_once('./php/LanguageHandler.php');
include('./php/Session.php');
require_once('./php/goCRMAPISettings.php');
$ui = \creamy\UIHandler::getInstance();
$api = \creamy\APIHandler::getInstance();
$lh = \creamy\LanguageHandler::getInstance();
$user = \creamy\CreamyUser::currentUser();

//proper user redirects
if ($user->getUserRole() != CRM_DEFAULTS_USER_ROLE_ADMIN) {
	if ($user->getUserRole() == CRM_DEFAULTS_USER_ROLE_AGENT) {
		header("location: agent.php");
	}
}

$perm = $api->goGetPermissions('list,customfields');
$checkbox_all = $ui->getCheckAll("list");
$goAPI = (empty($_SERVER['HTTPS'])) ? str_replace('https:', 'http:', gourl) : str_replace('http:', 'https:', gourl);
?>
<html>

<head>
	<meta charset="UTF-8">
	<title><?php $lh->translateText('portal_title'); ?> - Sale Applications</title>
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

	<?php
	print $ui->standardizedThemeCSS();
	print $ui->creamyThemeCSS();
	print $ui->dataTablesTheme();
	?>

	<!-- Wizard Form style -->
	<link href="css/wizard-form.css" rel="stylesheet" type="text/css" />
	<link href="css/style.css" rel="stylesheet" type="text/css" />

	<!-- Datetime picker CSS -->
	<link rel="stylesheet" href="js/dashboard/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css">
	<!-- Date Picker JS -->
	<script type="text/javascript" src="js/dashboard/eonasdan-bootstrap-datetimepicker/build/js/moment.js"></script>
	<script type="text/javascript" src="js/dashboard/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-csv/0.71/jquery.csv-0.71.min.js"></script>
	<!-- FULLLOAN -->
	<link href="modules/GOagent/js/smart_wizard_all.min.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="js/dashboard/js/bootstrap/dist/css/bootstrap-select.min.css">
	<script src="js/dashboard/js/bootstrap/dist/js/bootstrap-select.min.js"></script>
	<!-- DATATABLES EXPORT -->
	<script src="js/plugins/datatables/buttons/buttons.html5.min.js" type="text/javascript"></script>
	<script src="js/plugins/datatables/buttons/buttons.print.min.js" type="text/javascript"></script>
	<script src="js/plugins/datatables/buttons/buttons.flash.min.js" type="text/javascript"></script>
	<script src="js/plugins/datatables/buttons/dataTables.buttons.min.js" type="text/javascript"></script>
	<script src="js/plugins/datatables/jszip.min.js" type="text/javascript"></script>
	<script type="text/javascript">
		const goAPI = '<?= $goAPI ?>';
	</script>
	<!--  -->
	<style type="text/css">
		#create-offer-table {
			font-family: Arial, Helvetica, sans-serif;
			border-collapse: collapse;
			width: 100%;
		}

		#create-offer-table td,
		#create-offer-table th {
			border: 1px solid #3f51b5;
			padding: 5px;
		}

		#create-offer-table tr:nth-child(even) {
			background-color: #f2f2f2;
		}

		#create-offer-table tr:hover {
			background-color: #ddd;
		}

		#create-offer-table th {
			padding-top: 12px;
			padding-bottom: 12px;
			text-align: left;
			background-color: #5bc0de;
			color: white;
		}

		.customer-offer-input {
			width: 100%;
			border: none;
			padding: 5px;
			font-size: large;
		}

		.customer-offer-input-readonly {
			width: 100%;
			border: none;
			padding: 5px;
			font-size: large;
			background: none;
		}

		#GoToTop {
			width: 40px;
			line-height: 40px;
			overflow: hidden;
			z-index: 999;
			display: none;
			cursor: pointer;
			-moz-transform: rotate(270deg);
			-webkit-transform: rotate(270deg);
			-o-transform: rotate(270deg);
			-ms-transform: rotate(270deg);
			transform: rotate(270deg);
			position: fixed;
			bottom: 20px;
			left: 20;
			background-color: #DDD;
			color: #555;
			text-align: center;
			font-size: 30px;
			text-decoration: none;
		}

		.tab-content {
			height: auto ! Important;
		}
	</style>

	<style type="text/css">
		.select2-container {
			width: 100% !important;
		}
	</style>
</head>

<?php print $ui->creamyBody(); ?>

<div class="wrapper">
	<!-- header logo: style can be found in header.less -->
	<?php print $ui->creamyHeader($user); ?>
	<!-- Left side column. contains the logo and sidebar -->
	<?php print $ui->getSidebar($user->getUserId(), $user->getUserName(), $user->getUserRole(), $user->getUserAvatar()); ?>

	<!-- Right side column. Contains the navbar and content of the page -->
	<aside class="right-side">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Sale Application
			</h1>
			<ol class="breadcrumb">
				<li><a href="./index.php"><i class="fa fa-home"></i> <?php $lh->translateText("home"); ?></a></li>
				<li><?php $lh->translateText("telephony"); ?></li>
				<li class="active"><?php $lh->translateText("lists"); ?>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">
			<?php
			if ($perm->list->list_read !== 'N') {
				$lists = $api->API_getAllLists();
				$user_groups = $api->API_getAllUserGroups();
			?>
				<div class="row">
					<div class="col-lg-9">
						<div class="panel panel-default">
							<div class="panel-body">
								<legend id="legend_title">List Sale Application</legend>
								<div role="tabpanel">
									<ul role="tablist" class="nav nav-tabs nav-justified">
										<li role="presentation" class="active">
											<a href="#list_app_tab" aria-controls="list_app_tab" role="tab" data-toggle="tab" class="bb0">
												<?php $lh->translateText("list"); ?></a>
										</li>
										<li role="presentation">
											<a id="custormer_tab" href="#custormer_information_tab" aria-controls="application_detail_tab" role="tab" data-toggle="tab" class="bb0">
												Customer Information </a>
										</li>
										<li role="presentation">
											<a id="app_detail_tab" href="#application_detail_tab" aria-controls="application_detail_tab" role="tab" data-toggle="tab" class="bb0">
												Detail Application </a>
										</li>
									</ul>

									<!-- Tab panes-->
									<div class="tab-content bg-white">
										<!--==== List ====-->
										<div id="list_app_tab" role="tabpanel" class="tab-pane active">
											<div class="report-loader" style="color:lightgray;">
												<center>
													<h3>
														<i class="fa fa-circle-o-notch fa-spin fa-2x fa-fw"></i>
														<?php $lh->translateText("loading..."); ?>
													</h3>
												</center>
											</div>
											<div class="box-body" id="table">
												<div collapse="panelChart9" class="panel-wrapper">
													<div class="panel-body">
														<div class="chart-splinev3 flot-chart"></div> <!-- data is in JS -> demo-flot.js -> search (Overall/Home/Pagkain)-->
													</div>
												</div>
											</div><!-- /.box-body -->
										</div><!-- /.list-tab -->

										<div id="custormer_information_tab" role="tabpanel" class="tab-pane">
											<div class="box-body">
												<!-- CONTENT -->
												<div id="contact_info" role="tabpanel" class="tab-pane active">

													<fieldset style="padding-bottom: 0px; margin-bottom: 0px;">
														<h4 style="display: flex;">
															<a href="#" data-role="button" class="btn btn-default pull-right edit-profile-button hidden" id="edit-profile" style="margin-left: auto;">Edit Information</a>
														</h4>
														<!-- <br/> -->
														<form role="form" id="name_form" class="formMain form-inline MultiFile-intercepted">

															<!--LEAD ID-->
															<input type="hidden" value="" name="lead_id">
															<!--LIST ID-->
															<input type="hidden" value="" name="list_id">
															<!--ENTRY LIST ID-->
															<input type="hidden" value="" name="entry_list_id">
															<!--VENDOR ID-->
															<input type="hidden" value="" name="vendor_lead_code">
															<!--GMT OFFSET-->
															<input type="hidden" value="" name="gmt_offset_now">
															<!--SECURITY PHRASE-->
															<input type="hidden" value="" name="security_phrase">
															<!--RANK-->
															<input type="hidden" value="" name="rank">
															<!--CALLED COUNT-->
															<input type="hidden" value="" name="called_count">
															<!--UNIQUEID-->
															<input type="hidden" value="" name="uniqueid">
															<!--SECONDS-->
															<input type="hidden" value="" name="seconds">
															<!--CUSTOM FORM LOADED-->
															<input type="hidden" value="0" name="FORM_LOADED">
															<!--ADDRESS3-->
															<input type="hidden" value="" name="address3">

															<div class="row">
																<div class="col-sm-6">
																	<div class="mda-form-group label-floating">
																		<input id="prev_status" name="prev_status" type="text" maxlength="30" value="" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched input-disabled" readonly="">
																		<label for="prev_status">Trạng thái cuộc gọi trước đó</label>
																	</div>
																</div>
																<div class="col-sm-6">
																	<div id="app_status_block" class="mda-form-group label-floating">
																		<input id="app_status" name="app_status" type="text" maxlength="30" value="" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched input-disabled" readonly="">
																		<label for="app_status">Trạng thái hợp đồng</label>
																		<label id="app_reason" class="app_reason hiden">CKYC-WRI02 : Wrong DOB</label>
																	</div>
																</div>
															</div>
															<div class="row">
																<div class="col-sm-4">
																	<div class="mda-form-group label-floating">
																		<input id="first_name" name="first_name" type="text" maxlength="30" value="" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched input-disabled" disabled="" required="">
																		<label for="first_name">Họ</label>
																	</div>
																</div>
																<div class="col-sm-4">
																	<div class="mda-form-group label-floating">
																		<input id="middle_initial" name="middle_initial" type="text" maxlength="30" value="" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched input-disabled" disabled="">
																		<label for="middle_initial">Tên lót</label>
																	</div>
																</div>
																<div class="col-sm-4">
																	<div class="mda-form-group label-floating">
																		<input id="last_name" name="last_name" type="text" maxlength="30" value="" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched input-disabled" disabled="" required="">
																		<label for="last_name">Tên</label>
																	</div>
																</div>
															</div>
														</form>

														<form id="contact_details_form" class="formMain MultiFile-intercepted">
															<!-- phone number & alternative phone number -->
															<div class="row">
																<div class="col-sm-6">
																	<div class="mda-form-group label-floating">
																		<span id="phone_numberDISP" class="hidden"></span>
																		<input id="phone_code" name="phone_code" type="hidden" value="">
																		<input id="phone_number" name="phone_number" type="number" min="0" maxlength="18" width="auto" value="" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched input-phone-disabled" disabled="" required="">
																		<input id="phone_number_DISP" type="number" min="0" maxlength="18" width="auto" value="" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched hidden" disabled="">
																		<label for="phone_number">Số điện thoại</label>
																		<!--
					<span class="mda-input-group-addon">
						<em class="fa fa-phone fa-lg"></em>
					</span>-->
																	</div>
																</div>
																<div class="col-sm-6">
																	<div class="mda-form-group label-floating">
																		<input id="alt_phone" name="alt_phone" type="number" min="0" maxlength="12" width="100" value="" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched input-disabled" disabled="">
																		<label for="alt_phone">Số điện thoại thay thế</label>
																	</div>
																</div>
															</div>
															<!-- /.phonenumber & alt phonenumber -->
															<!-- address1 & address2 -->
															<div class="row">
																<div class="col-xl-12 col-lg-6">
																	<div class="mda-form-group label-floating">
																		<input id="address1" name="address1" type="text" maxlength="100" width="auto" value="" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched input-disabled" disabled="">
																		<label for="address1">Địa chỉ</label>
																	</div>
																	<!--<span class="mda-input-group-addon">
				<em class="fa fa-home fa-lg"></em>
			</span>-->
																</div>
																<div class="col-xl-12 col-lg-6">
																	<div class="mda-form-group label-floating">
																		<input id="address2" name="address2" type="text" maxlength="100" value="" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched input-disabled" disabled="">
																		<label for="address2">Địa chỉ 2</label>
																	</div>
																</div>
															</div>
															<!-- /.address1 & address2 -->
															<div class="row">
																<div class="col-xl-12 col-lg-6">
																	<div class="mda-form-group label-floating">
																		<input id="country_code" name="country_code" type="text" maxlength="50" value="Việt Nam" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched input-disabled" readonly="" disabled="">
																		<label for="country_code">Mã quốc gia</label>
																	</div>
																</div>
																<div class="col-lg-3">
																	<div class="mda-form-group label-floating">
																		<input id="province" name="province" type="text" maxlength="50" value="" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched input-disabled" disabled="">
																		<label for="province">Tỉnh</label>
																	</div>
																</div>
																<div class="col-sm-3" hidden="">
																	<div class="mda-form-group label-floating">
																		<input id="city" name="city" type="text" maxlength="50" value="" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched input-disabled" disabled="">
																		<label for="city">City</label>
																	</div>
																</div>
																<div class="col-sm-3" hidden="">
																	<div class="mda-form-group label-floating">
																		<input id="state" name="state" type="text" maxlength="50" value="" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched input-disabled" disabled="">
																		<label for="state">State</label>
																	</div>
																</div>
																<div class="col-sm-3">
																	<div class="mda-form-group label-floating">
																		<input id="postal_code" name="postal_code" type="text" maxlength="10" value="" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched input-disabled" disabled="">
																		<label for="postal_code">Mã khu vực</label>
																	</div>
																</div>
															</div>
															<!-- /.city,state,postalcode -->

														</form>
														<form role="form" id="gender_form" class="formMain form-inline MultiFile-intercepted">
															<div class="row">

																<!-- country_code & email -->
																<div class="col-xl-12 col-lg-3">
																	<div class="mda-form-group label-floating">
																		<!-- add "mda-input-group" if with image -->
																		<input id="email" name="email" type="text" width="auto" value="" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched input-disabled" disabled="">
																		<label for="email">Địa chỉ email</label>
																	</div>
																</div>
																<div class="col-sm-3" hidden="">
																	<div class="mda-form-group label-floating">
																		<input id="title" name="title" type="text" maxlength="4" value="" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched input-disabled" disabled="">
																		<label for="title">Title</label>
																	</div>
																</div>
																<div class="col-sm-3">
																	<div class="mda-form-group label-floating">
																		<input id="job_type" name="job_type" type="text" maxlength="10" value="" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched input-disabled" disabled="">
																		<label for="job_type">Loại hình công việc</label>
																	</div>
																</div>
																<div class="col-sm-3">
																	<div class="mda-form-group label-floating">
																		<select id="gender" name="gender" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched select input-disabled" disabled="">
																			<option disabled="" value="" selected=""></option>
																			<option value="M">Nam</option>
																			<option value="F">Nữ</option>
																		</select>
																		<label for="gender">Giới tính</label>
																	</div>
																</div>
																<div class="col-sm-3">
																	<div class="mda-form-group label-floating">
																		<input type="date" id="date_of_birth" value="" name="date_of_birth" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched input-disabled" disabled="">
																		<label for="date_of_birth">Ngày sinh</label>
																	</div>
																</div>
															</div>
															<!-- /.gender & title -->

															<div class="row">
																<div class="col-sm-4">
																	<div class="mda-form-group label-floating">
																		<input id="partner_code" name="partner_code" type="text" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" readonly="">
																		<label required="" for="partner_code">Mã đối tác</label>
																	</div>
																</div>
																<div class="col-sm-4">
																	<div class="mda-form-group label-floating">
																		<input readonly="" id="vendor_lead_code" name="vendor_lead_code" type="text" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched">
																		<label for="vendor_lead_code">Lead Code</label>
																	</div>
																</div>
																<div class="col-sm-4">
																	<div class="mda-form-group label-floating">
																		<input readonly="" required="" id="request_id" name="request_id" type="text" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched">
																		<label for="request_id">Request Id</label>
																	</div>
																</div>
															</div>
														</form>
														<form role="form" id="identity_form" class="formMain form-inline MultiFile-intercepted">
															<div class="row">
																<div class="col-sm-4">
																	<div class="mda-form-group label-floating">
																		<input required="" id="identity_number" name="identity_number" type="text" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched">
																		<label for="identity_number">Chứng minh nhân dân</label>
																	</div>
																</div>
																<div class="col-sm-4">
																	<div class="mda-form-group label-floating">
																		<input id="identity_issued_on" name="identity_issued_on" type="date" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched">
																		<label for="identity_issued_on">Ngày cấp</label>
																	</div>
																</div>
																<div class="col-sm-4">
																	<div class="mda-form-group label-floating">
																		<select name="identity_issued_by" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched select" required="">
																			<option value="" selected=""></option>
																			<option value="VIP15">Cục CSĐKQLCT&amp;DLQGVDC</option>
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
																		<label for="identity_issued_by">Nơi cấp</label>
																	</div>
																</div>
															</div><!-- /.identity_number,identity_issued_on,identity_issued_by -->
															<div class="row">
																<div class="col-sm-4">
																	<div class="mda-form-group label-floating">
																		<input id="alt_identity_number" name="alt_identity_number" type="text" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched">
																		<label for="alt_identity_number">Chứng minh nhân dân thay thế</label>
																	</div>
																</div>
																<div class="col-sm-4">
																	<div class="mda-form-group label-floating">
																		<input id="alt_identity_issued_on" name="alt_identity_issued_on" type="date" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched">
																		<label for="alt_identity_issued_on">Ngày cấp</label>
																	</div>
																</div>
																<div class="col-sm-4">
																	<div class="mda-form-group label-floating">
																		<select name="alt_identity_issued_by" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched select">
																			<option value="" selected=""></option>
																			<option value="VIP15">Cục CSĐKQLCT&amp;DLQGVDC</option>
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
																		<label for="alt_identity_issued_by">Nơi cấp</label>
																	</div>
																</div>
															</div><!-- /.identity_number,identity_issued_on,identity_issued_by -->

														</form>

														<div id="call_notes_content" class="col-sm-12">
															<div class="form-group" style="width:100%;">
																<textarea rows="3" id="call_notes" name="call_notes" class="form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched textarea note-editor note-editor-margin" style="resize:none; width: 100%;"></textarea>
																<label for="call_notes">Call Notes</label>
															</div>
														</div>


														<!-- NOTIFICATIONS -->
														<!--<div id="notifications_list">
	<div class="output-message-success" style="display:none;">
		<div class="alert alert-success alert-dismissible" role="alert">
		  <strong>Success!</strong> Successfuly updated contact.
		</div>
	</div>
	<div class="output-message-error" style="display:none;">
		<div class="alert alert-danger alert-dismissible" role="alert">
		  <strong>Error!</strong> Something went wrong please see input data on form or if agent already exists.
		</div>
	</div>
	<div class="output-message-incomplete" style="display:none;">
		<div class="alert alert-danger alert-dismissible" role="alert">
		  Please fill-up all the fields correctly and do not leave any highlighted fields blank.
		</div>
	</div>
</div>-->

													</fieldset>
												</div>

												<!-- END CONTENT -->
											</div><!-- /.box-body -->
										</div><!-- /.list-tab -->

										<div id="application_detail_tab" role="tabpanel" class="tab-pane">
											<!-- TAB CONTENT -->
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
																		<a class="nav-link active done" href="#step-1">
																			AF <br />Chọn sản phẩm
																		</a>
																	</li>
																	<li>
																		<a class="nav-link  done" href="#step-2">
																			AF1 <br />Thông tin cơ bản
																		</a>
																	</li>
																	<li>
																		<a class="nav-link  done" href="#step-3">
																			AF2 <br />Thông tin chi tiết
																		</a>
																	</li>
																	<li>
																		<a class="nav-link  done" href="#step-4">
																			AF3 <br />Thông tin thu nhập
																		</a>
																	</li>
																	<li>
																		<a class="nav-link  done" href="#step-5">
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
																	<div class="tab-content" style="height: unset !important;">
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
																						<h3 class="text-light-blue">
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
																								<div class="col-xl-4 col-lg-8">
																									<input type="range" name="range_loan_tenor" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" value="0" min="0" max="50" oninput="changeLoanTennor(this);">
																								</div>
																								<div class="col-xl-4 col-lg-4">
																									<input type="number" onblur="checkminmax(this)" step="1" name="loan_tenor" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" min="0" value="0" max="50" oninput="changeLoanTennorRange(this);" required="">
																								</div>
																							</div>
																						</div>
																					</div>
																					<div class="row">
																						<div class="col-xl-4 col-lg-12">
																							<label class="form_label" class="form_label" for="loan_amount"><?= $lh->translationFor('loan_amount') ?></label>
																							<div class="row">
																								<div class="col-xl-4 col-lg-8">
																									<input type="range" step="500000" name="range_loan_amount" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" value="0" min="0" max="999999999999" oninput="changeLoanAmount(this);">
																								</div>
																								<div class="col-xl-4 col-lg-4">
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
																						<input maxlength="100" type="text" name="tem_address" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
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
																						<input maxlength="100" type="text" name="workplace_name" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
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
																						<input maxlength="100" type="text" name="workplace_address" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
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
																							<input maxlength="50" type="text" name="bank_account" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched">
																							<label class="form_label" for="bank_account"><?= $lh->translationFor('bank_account') ?></label>
																						</div>
																					</div>
																				</div>
																			</div>
																			<div class="row">
																				<div class="col-xl-12 col-lg-12">
																					<div class="mda-form-group label-floating">
																						<input maxlength="80" readonly type="text" name="beneficiary_name" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
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
																							<input maxlength="80" type="text" name="relation_1_name" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
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
																							<input maxlength="80" type="text" name="relation_2_name" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
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
																						<input readonly value="" type="text" name="dsa_agent_code" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
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
																						<div class="col-xl-12 col-lg-12">
																							<div class="col-lg-2">
																								<div class="iconCircle">
																									<i class="fa fa-info fa-2x"></i>
																								</div>
																							</div>
																							<div class="col-lg-10">
																								<h4 class="text-light-blue">
																									UPLOAD CHECK ELIGIBLE
																								</h4>
																							</div>
																						</div>
																					</div>
																				</div>
																				<div class="col-xl-6 col-lg-12">
																					<div class="row">
																						<div class="col-sm-12" style="padding-bottom: 10px;">
																							<label class="form_label" for="img_id_card"><?= $lh->translationFor('img_id_card') ?></label>
																							<input readonly value="" type="text" name="img_id_card" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
																						</div>
																					</div>
																				</div>
																				<div class="col-xl-6 col-lg-12">
																					<div class="row">
																						<div class="col-sm-12" style="padding-bottom: 10px;">
																							<label class="form_label" for="img_selfie"><?= $lh->translationFor('img_selfie') ?></label>
																							<input readonly value="" type="text" name="img_selfie" class="mda-form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched" required>
																						</div>
																					</div>
																				</div>
																			</div>
																			<div class="row" style="margin-bottom: 10px;padding: 20px 10px; border: 1px solid #5cb85c;">
																				<div class="col-xl-6 col-lg-12">
																					<div class="row">
																						<div class="col-xl-12 col-lg-12">
																							<div class="col-lg-2">
																								<div class="iconCircle">
																									<i class="fa fa-envelope fa-2x"></i>
																								</div>
																							</div>
																							<div class="col-lg-10">
																								<h4 class="text-light-blue">
																									UPLOAD CHECK DOCS
																								</h4>
																							</div>
																						</div>
																					</div>
																				</div>
																				<div class="col-sm-12">
																					<div id="product_detail" class="row">
																						<div class="col-xl-12 col-lg-12">
																							<hr style="margin: 5px !important;">
																						</div>
																						<div class="col-xl-12 col-lg-12" id="list_upload_docs">
																							
																						</div>
																					</div>
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
											<!--  -->


										</div><!-- /.application_detail-tab -->
									</div><!-- /.tab-content -->
								</div><!-- /.tab-panel -->
							</div><!-- /.body -->
						</div><!-- /.panel -->
					</div><!-- /.col-lg-9 -->
					<!-- END -->
					<div class="col-lg-3">
						<h3 class="m0 pb-lg">Filters</h3>
						<!-- HIDDEN POSTS -->
						<div class="form-group">
							<label for="campaign_id">Usergroup</label>
							<select class="form-control select2" name="usergroup_id" id="usergroup_id" style="width:100%;">
								<option value="" selected>- - - ALL - - -</option>
								<?php
								for ($i = 0; $i < count($user_groups->user_group); $i++) {
								?>
									<option value="<?php echo $user_groups->user_group[$i]; ?>"><?php echo $user_groups->user_group[$i] . " - " . $user_groups->group_name[$i]; ?></option>
								<?php
								}
								?>
								?>
							</select>
						</div>
						<div class="form-group">
							<label for="list">List</label>
							<select class="form-control select2" name="list_id" id="list_id" style="width:100%;">
								<option value="" selected>- - - ALL - - -</option>
								<?php
								for ($i = 0; $i < count($lists->list_id); $i++) {
									echo '<option value="' . $lists->list_id[$i] . '">' . $lists->list_id[$i] . ' - ' . $lists->list_name[$i] . '</option>';
								}
								?>
						</div>
						
						</select>
					</div>
					<div class="form-group">
								<label for="campaign_id">Lead code</label>
								<select class="form-control select2" name="vendor_lead_code" id="vendor_lead_code_sl" style="width:100%;">
									<option selected disabled></option>
									<option value="ALL">ALL</option>
									<option value="VGA">VGA</option>
									<option value="REN">REN</option>
									<option value="CLT">CLT</option>
									<option value="AMP">AMP</option>
									<option value="VTA">VTA</option>
									<option value="MVT">MVT</option>
									<option value="TUP">TUP</option>
									<option value="MOF">MOF</option>
									<option value="ECL">ECL</option>
								</select>
							</div>
					<div class="form-group">
						<label>Start Date</label>
						<div class="form-group">
							<div class="input-group date" id="datetimepicker1">
								<input type="text" class="form-control" id="start_filterdate" name="start_filterdate" placeholder="<?php echo date("m/d/Y") . " 00:00:00"; ?>" value="<?php echo date("m/d/Y") . " 12:00 AM"; ?>" />
								<span class="input-group-addon">
									<!-- <span class="glyphicon glyphicon-calendar"></span>-->
									<span class="fa fa-calendar"></span>
								</span>
							</div>
						</div>
					</div>
					<!-- /.start date -->

					<div class="form-group">
						<label>End Date</label>
						<div class="form-group">
							<div class="input-group date" id="datetimepicker2">
								<input type="text" class="form-control" id="end_filterdate" name="end_filterdate" placeholder="<?php echo date("m/d/Y H:i:s"); ?>" value="<?php echo date("m/d/Y"); ?> 11:59 PM" />
								<span class="input-group-addon">
									<!-- <span class="glyphicon glyphicon-calendar"></span>-->
									<span class="fa fa-calendar"></span>
								</span>
							</div>
						</div>
					</div>

					<div class="form-group">
						<button id="btn_filter" style="width:100%" type="button" class="btn btn-info btn-view-cf">Filter</button>
					</div>
					<!-- /.end date -->
				</div>
</div>
</div>
<?php
			} else {
				print $ui->calloutErrorMessage($lh->translationFor("you_dont_have_permission"));
			}
?>
</section><!-- /.content -->
</aside><!-- /.right-side -->
<?php print $ui->getRightSidebar($user->getUserId(), $user->getUserName(), $user->getUserAvatar()); ?>
</div><!-- ./wrapper -->

<?php print $ui->standardizedThemeJS(); ?>
<!-- JQUERY STEPS-->
<!-- <script src="js/dashboard/js/jquery.steps/build/jquery.steps.js"></script> -->


<!-- <script src="js/plugins/papaparse/papaparse.min.js"></script> -->

<script type="text/javascript" src="modules/GOagent/js/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="modules/GOagent/js/daterangepicker.css" />
<script src="modules/GOagent/js/jquery.smartWizard.min.js" type="text/javascript"></script>
<script type="text/javascript" src="modules/GOagent/js/pitel/dsa_update_status.js?v=3" defer></script>
<script type="text/javascript" src="modules/GOagent/js/pitel/variable.js" defer></script>
<script type="text/javascript" src="modules/GOagent/js/pitel/bank_code.js" defer></script>
<script type="text/javascript" src="modules/GOagent/js/pitel/sale-application.js?v=53" defer></script>
<script type="text/javascript" src="js/pitel/location_dictionary.js?v=6" defer></script>
<script type="text/javascript" src="js/pitel/bank_dictionary.js?v=2" defer></script>
<!-- <?php print $ui->creamyFooter(); ?> -->
</body>

</html>