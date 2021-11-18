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
	<title><?php $lh->translateText('portal_title'); ?> - Download Management</title>
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
	<script type="text/javascript" src="js/dashboard/eonasdan-bootstrap-datetimepicker/build/js/moment.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-csv/0.71/jquery.csv-0.71.min.js"></script>
	<!-- FULLLOAN -->
	<link href="modules/GOagent/js/smart_wizard_all.min.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="js/dashboard/js/bootstrap/dist/css/bootstrap-select.min.css">
	<script src="js/dashboard/js/bootstrap/dist/js/bootstrap-select.min.js"></script>
	<!-- DATATABLES EXPORT -->
	<script src="js/plugins/datatables/buttons/dataTables.buttons.min.js" type="text/javascript"></script>
	<script src="js/plugins/datatables/jszip.min.js" type="text/javascript"></script>
	<script type="text/javascript">
		const goAPI = '<?= $goAPI ?>';
	</script>
	<!--  -->
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
				Download Management
			</h1>
			<ol class="breadcrumb">
				<li><a href="./index.php"><i class="fa fa-home"></i> <?php $lh->translateText("home"); ?></a></li>
				<li class="active">Download
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
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-body">
								<button hidden id="start_btn">TEST</button>
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
							</div><!-- /.body -->
						</div><!-- /.panel -->
					</div>
					<div class="col-lg-4">
						<button class="btn bg-red btn-flat" onclick="filterchange();"><i class="fa fa-refresh"></i>  Refresh
						</button>
       				</div>
					<div class="col-lg-8">
						<h4>Download in PROCESS will be DONE in a few seconds.</h4>
						
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
<script type="text/javascript" src="modules/GOagent/js/pitel/admin-download.js?v=1" defer></script>
<!-- <?php print $ui->creamyFooter(); ?> -->
</body>

</html>