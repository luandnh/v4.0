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
	<title><?php $lh->translateText('portal_title'); ?> - VTA Collabrators</title>
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
				Collabrators
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
					<div class="col-lg-10">
						<div class="panel panel-default">
							<div class="panel-body">
								<legend id="legend_title">VTA Collabrator</legend>
								<div role="tabpanel">
									<!-- <ul role="tablist" class="nav nav-tabs nav-justified">
										<li role="presentation" class="active">
											<a href="#list_app_tab" aria-controls="list_app_tab" role="tab" data-toggle="tab" class="bb0">
												<?php $lh->translateText("list"); ?></a>
										</li>
									</ul> -->
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
									</div><!-- /.tab-content -->
								</div><!-- /.tab-panel -->
							</div><!-- /.body -->
						</div><!-- /.panel -->
					</div><!-- /.col-lg-9 -->
					<!-- END -->
					<div class="col-lg-2">
						<h3 class="m0 pb-lg">Filters</h3>
						<div class="form-group">
							<label>Start Date</label>
							<div class="form-group">
								<div class="input-group date" id="datetimepicker1">
									<input type="text" class="form-control" id="start_filterdate" name="start_filterdate" placeholder="2021-01-01 00:00:00" value="01-01-2021 12:00 AM" />
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
<script type="text/javascript" src="modules/GOagent/js/pitel/collobrator.js?v=53" defer></script>
<script type="text/javascript" src="js/pitel/location_dictionary.js?v=6" defer></script>
<script type="text/javascript" src="js/pitel/bank_dictionary.js?v=2" defer></script>
<!-- <?php print $ui->creamyFooter(); ?> -->
</body>

</html>