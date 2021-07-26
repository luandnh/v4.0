<?php

/**
 * @file 		callrecordings.php
 * @brief 		Display call recordings
 * @copyright 	Copyright (c) 2018 Pitel Inc. 
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

require_once('./php/UIHandler.php');
require_once('./php/APIHandler.php');
require_once('./php/CRMDefaults.php');
require_once('./php/LanguageHandler.php');
include('./php/Session.php');

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

$perm = $api->goGetPermissions('recordings');
?>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php $lh->translateText("call_recordings"); ?></title>
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

	<?php
	print $ui->standardizedThemeCSS();
	print $ui->creamyThemeCSS();
	print $ui->dataTablesTheme();
	?>

	<!-- Bootstrap Player -->
	<link href="css/bootstrap-player.css" rel="stylesheet" type="text/css" />

	<!-- Datetime picker -->
	<link rel="stylesheet" href="js/dashboard/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css">

	<!-- Date Picker -->
	<script type="text/javascript" src="js/dashboard/eonasdan-bootstrap-datetimepicker/build/js/moment.js"></script>
	<script type="text/javascript" src="js/dashboard/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>

	<!-- CHOSEN-->
	<link rel="stylesheet" src="js/dashboard/chosen_v1.2.0/chosen.min.css">

	<script src="js/pitel/admin_call_recordings.js"></script>

	<style>
		/*
		* CUSTOM CSS for disable function
		*/
		.c-checkbox input[type=checkbox]:disabled+span,
		.c-radio input[type=checkbox]:disabled+span,
		.c-checkbox input[type=radio]:disabled+span,
		.c-radio input[type=radio]:disabled+span {
			border-color: none !important;
			background-color: none !important;
		}

		.c-checkbox input[type=checkbox]:checked+span,
		.c-radio input[type=checkbox]:checked+span,
		.c-checkbox input[type=radio]:checked+span,
		.c-radio input[type=radio]:checked+span {
			border-color: #3f51b5 !important;
			background-color: #3f51b5 !important;
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
	<aside class="right-side content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header content-heading">
			<h1>
				<?php $lh->translateText("call_recordings"); ?>
				<small><?php $lh->translateText("call_recordings"); ?></small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="./index.php"><i class="fa fa-phone"></i> <?php $lh->translateText("home"); ?></a></li>
				<li><?php $lh->translateText("telephony"); ?></li>
				<li class="active"><?php $lh->translateText("call_recordings"); ?>
			</ol>
		</section>
		<!-- Main content -->
		<section class="content">
			<?php
			if ($perm->recordings_display !== 'N') {
				$callrecs = $api->API_getCallRecordingList("", "", "", "");
				// var_dump($callrecs);
				// die();
			?>
				<div class="row">
					<div class="col-lg-9">
						<div class="form-group mb-xl">
							<div class="has-clear">
								<input type="text" placeholder="Search Phone Number, First or Last Name" id="search" class="form-control mb">
								<span class="form-control-clear fa fa-close form-control-feedback"></span>
							</div>
							<div class="clearfix">
								<button type="button" class="pull-left btn btn-default" id="search_button"> <?php $lh->translateText("search"); ?></button>
								<div class="pull-right">
									<label class="checkbox-inline c-checkbox" for="search_recordings">
										<input id="search_recordings" name="table_filter" type="checkbox" checked disabled>
										<span class="fa fa-check"></span><?php $lh->translateText("recordings"); ?>
									</label>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-body">

								<div class="callrecordings_div">
									<!-- Call Recordings panel tab -->
									<legend><?php $lh->translateText("call_recordings"); ?></legend>

									<!--==== Call Recordings ====-->
									<table class="table table-striped table-bordered table-hover" id="table_callrecordings">
										<thead>
											<tr>
												<th nowrap><?php $lh->translateText("date"); ?></th>
												<th nowrap class='hide-on-low'><?php $lh->translateText("customer"); ?></th>
												<th nowrap class='hide-on-low'><?php $lh->translateText("phone_number"); ?></th>
												<th nowrap class='hide-on-medium hide-on-low'><?php $lh->translateText("agent"); ?></th>
												<th nowrap class='hide-on-medium hide-on-low'><?php $lh->translateText("duration"); ?></th>
												<th nowrap><?php $lh->translateText("action"); ?></th>
											</tr>
										</thead>
										<tbody>
											<?php
											for ($i = 0; $i < count($callrecs->uniqueid); $i++) {
												$details = "<strong>" . $lh->translationFor("phone") . "</strong>: <i>" . $callrecs->phone_number[$i] . "</i><br/>";
												$details .= "<strong>" . $lh->translationFor("agent") . "</strong>: <i>" . $callrecs->users[$i] . "</i><br/>";
												$details .= "<strong>" . $lh->translationFor("date") . "</strong>: <i>" . date("M.d,Y h:i A", strtotime($callrecs->end_last_local_call_time[$i])) . "</i><br/>";

												$d1 = strtotime($callrecs->start_last_local_call_time[$i]);
												$d2 = strtotime($callrecs->end_last_local_call_time[$i]);
												$diff = abs($d2 - $d1);
												$action_Call = $ui->getUserActionMenuForCallRecording($callrecs->uniqueid[$i], $callrecs->location[$i], $details);

											?>
												<tr>
													<td nowrap><?php echo date("M.d,Y h:i A", strtotime($callrecs->end_last_local_call_time[$i])); ?></td>
													<td nowrap class='hide-on-low'><?php echo $callrecs->full_name[$i]; ?></td>
													<td nowrap class='hide-on-low'><?php echo $callrecs->phone_number[$i]; ?></td>
													<td nowrap class='hide-on-medium hide-on-low'><?php echo $callrecs->users[$i]; ?></td>
													<td nowrap class='hide-on-medium hide-on-low'><?php echo gmdate('H:i:s', $diff); ?></td>
													<td nowrap><?php echo $action_Call; ?></td>
												</tr>
											<?php
											}
											?>
										</tbody>
									</table>
								</div>
							</div><!-- /.body -->
						</div><!-- /.panel -->
					</div><!-- /.col-lg-9 -->
					<?php
					$agents = $api->API_getAllUsers();
					$lists = $api->API_getAllLists();
					?>
					<div class="col-lg-3">
						<h3 class="m0 pb-lg"><?php $lh->translateText("filters"); ?></h3>
						<form id="search_form">
							<div class="form-group">
								<label><?php $lh->translateText("add_filters"); ?>:</label>
								<div class="mb">
									<div class="add_callrecording_filters">
										<select multiple="multiple" class="select2-3 form-control add_filters2" style="width:100%;">
											<option value="filter_agent" class="contacts_filters"><?php $lh->translateText("agent"); ?> </option>
											<option value="filter_list" class="contacts_filters"><?php $lh->translateText("filter_list_id"); ?></option>
											<option value="filter_phone" class="contacts_filters"><?php $lh->translateText("filter_phone"); ?> </option>
											<option value="filter_identity" class="contacts_filters"><?php $lh->translateText("filter_identity"); ?></option>
											<option value="filter_leadcode" class="contacts_filters"><?php $lh->translateText("filter_leadcode"); ?></option>
											<option value="filter_leadsubid" class="contacts_filters"><?php $lh->translateText("filter_leadsubid"); ?></option>
											<option value="filter_direction" class="contacts_filters"><?php $lh->translateText("filter_direction"); ?></option>
										</select>
									</div>
								</div>
							</div>

							<!-- CALL RECORDINGS FILTER -->
							<div class="all_callrecording_filters">
								<div class="callrecordings_filter_div">
									<div class="agent_filter_div" style="display:none;">
										<div class="form-group">
											<label><?php $lh->translateText("agent"); ?>: </label>
											<div class="mb">
												<select name="agent_filter" id="agent_filter" class="form-control">
													<option value=""> <?php $lh->translateText("all_agents"); ?> </option>
													<?php
													for ($i = 0; $i < count($agents->user_id); $i++) {
														echo '<option value="' . $agents->user[$i] . '"> ' . $agents->user[$i] . ' - ' . $agents->full_name[$i] . ' </option>';
													}
													?>
												</select>
											</div>
										</div>
									</div>
									<div class="list_filter_div" style="display:none;">
										<div class="form-group">
											<label><?php $lh->translateText("list_id"); ?>:</label>
											<div class="mb">
												<select name="list_filter" id="list_filter" class="form-control">
													<option value="">- - - <?php $lh->translateText("-none-"); ?> - - -</option>
													<?php
													for ($i = 0; $i < count($lists->list_id); $i++) {
														echo "<option value='" . $lists->list_id[$i] . "'> " . $lists->list_name[$i] . " </option>";
													}
													?>
												</select>
											</div>
										</div>
									</div>
									<div class="phone_filter_div" style="display:none;">
										<div class="form-group has-clear">
											<label><?php $lh->translateText("phone"); ?>: </label>
											<div class="mb has-clear">
												<input type="text" class="form-control" id="phone_filter" name="phone_filter" placeholder="<?php $lh->translateText("phone"); ?>" />
												<span class="form-control-clear fa fa-close form-control-feedback"></span>
											</div>
										</div>
									</div>
									<div class="identity_filter_div" style="display:none;">
										<div class="form-group has-clear">
											<label><?php $lh->translateText("identity"); ?>: </label>
											<div class="mb has-clear">
												<input type="text" class="form-control" id="identity_filter" name="identity_filter" placeholder="<?php $lh->translateText("identity"); ?>" />
												<span class="form-control-clear fa fa-close form-control-feedback"></span>
											</div>
										</div>
									</div>
									<div class="leadcode_filter_div" style="display:none;">
										<div class="form-group has-clear">
											<label><?php $lh->translateText("leadcode"); ?>: </label>
											<div class="mb has-clear">
												<input type="text" class="form-control" id="leadcode_filter" name="leadcode_filter" placeholder="<?php $lh->translateText("leadcode"); ?>" />
												<span class="form-control-clear fa fa-close form-control-feedback"></span>
											</div>
										</div>
									</div>
									<div class="leadsubid_filter_div" style="display:none;">
										<div class="form-group has-clear">
											<label><?php $lh->translateText("leadsubid"); ?>: </label>
											<div class="mb has-clear">
												<input type="text" class="form-control" id="leadsubid_filter" name="leadsubid_filter" placeholder="<?php $lh->translateText("leadsubid"); ?>" />
												<span class="form-control-clear fa fa-close form-control-feedback"></span>
											</div>
										</div>
									</div>
									<div class="direction_filter_div" style="display:none;">
										<div class="form-group">
											<label><?php $lh->translateText("direction"); ?>: </label>
											<div class="mb">
												<select name="direction_filter" id="direction_filter" class="form-control">
													<option value="inbound"> <?php $lh->translateText("inbound"); ?> </option>
													<option value="outbound"> <?php $lh->translateText("outbound"); ?> </option>
												</select>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label>Start Date:</label>
										<div class="form-group">
											<div class='input-group date' id='datetimepicker3'>
												<input type='text' class="form-control" id="start_filterdate" placeholder="MM/DD/YYYY" />
												<span class="input-group-addon">
													<!-- <span class="glyphicon glyphicon-calendar"></span>-->
													<span class="fa fa-calendar"></span>
												</span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label>End Date:</label>
										<div class="form-group">
											<div class='input-group date' id='datetimepicker4'>
												<input type='text' class="form-control" id="end_filterdate" placeholder="MM/DD/YYYY" value="<?php echo date("m/d/Y H:i:s"); ?>" />
												<span class="input-group-addon">
													<!-- <span class="glyphicon glyphicon-calendar"></span>-->
													<span class="fa fa-calendar"></span>
												</span>
											</div>
										</div>
									</div>
								</div>
							</div>

							<fieldset>
								<!--
							    <div class="campaign_filter_div" style="display:none;">
								    <div class="form-group">
										<label>Campaign: </label>
										<div class="mb">
											<select name="campaign_filter" class="form-control">
												<?php
												/*
													for($i=0; $i < count($campaign->campaign_id);$i++){
														echo "<option value='".$campaign->campaign_id[$i]."'> ".$campaign->campaign_name[$i]." </option>";
													}
												*/
												?>
											</select>
										</div>
									</div>
								</div>
								-->
							</fieldset>

						</form>
						<!--<button type="button" class="pull-left btn btn-default" id="search_button">Apply</button>-->
					</div><!-- ./filters -->
				</div><!-- /. row -->
			<?php
			} else {
				print $ui->calloutErrorMessage($lh->translationFor("you_dont_have_permission"));
			}
			?>
		</section><!-- /.content -->
	</aside><!-- /.right-side -->
	<?php print $ui->getRightSidebar($user->getUserId(), $user->getUserName(), $user->getUserAvatar()); ?>
</div><!-- ./wrapper -->

<!-- Modal -->
<div id="call-playback-modal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-sm">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"><b><?php $lh->translateText("call_recording_playback"); ?></b></h4>
			</div>
			<div class="modal-body">
				<center class="mt"><em class="fa fa-music fa-5x"></em></center>
				<div class="row mt mb">
					<center><span class="voice-details"></span></center>
				</div>
				<br />
				<div class="audio-player" style="width:100%"></div>
				<!-- <audio controls>
				<source src="http://www.w3schools.com/html/horse.ogg" type="audio/ogg" />
				<source src="http://www.w3schools.com/html/horse.mp3" type="audio/mpeg" />
				<a href="http://www.w3schools.com/html/horse.mp3">horse</a>
			</audio> -->
			</div>
			<div class="modal-footer">
				<a href="" class="btn btn-primary download-audio-file" download><?php $lh->translateText("download_file"); ?></a>
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php $lh->translateText("close"); ?></button>
			</div>
		</div>
		<!-- End of modal content -->
	</div>
</div>
<!-- End of modal -->

<?php print $ui->standardizedThemeJS(); ?>

<!-- CHOSEN-->
<script src="js/dashboard/chosen_v1.2.0/chosen.jquery.min.js"></script>
<script type="text/javascript">
	var isClean = true;
	$(document).ready(function() {
		$('body').on('keypress', '#search', function(args) {
			if (args.keyCode == 13) {
				$("#search_button").click();
				return false;
			}
		});

		var init_callrecs_table = $('#table_callrecordings').DataTable({
			"bDestroy": true
		});

		// initialize multiple selecting
		$('.select2-3').select2({
			theme: "bootstrap"
		});
		$.fn.select2.defaults.set("theme", "bootstrap");

		// limits checkboxes to single selecting
		$("input:checkbox").on('click', function() {
			var $box = $(this);
			if ($box.is(":checked")) {
				var group = "input:checkbox[name='" + $box.attr("name") + "']";
				$(group).prop("checked", false);
				$box.prop("checked", true);
			} else {
				$box.prop("checked", false);
			}
		});

		/****
		 ** Change between Contacts and Recordings
		 ****/
		// shows call recordings datatable if Recordings tickbox is checked
		$(document).on('change', '#search_recordings', function() {
			$("#search_recordings").prop("disabled", true);

			if ($('#search_recordings').is(":checked")) {

				$(".callrecordings_div").show(); // show recordings table
				$(".callrecordings_filter_div").show(); // show recording filter

				$(".all_callrecording_filters").show(); // show filters
				$(".add_callrecording_filters").show(); // enable add filter

			} else {
				$(".callrecordings_div").hide();
				$(".all_callrecording_filters").hide();
				$(".add_callrecording_filters").hide(); // disable add filter
			}

		});

		/***
		 ** Add Filters
		 ***/
		// add filters

		$(".add_filters2").change(function() {
			$(".agent_filter_div").fadeIn("slow")[$.inArray('filter_agent', $(this).val()) >= 0 ? 'show' : 'hide']();
			//NEW - LUANDNH
			$(".list_filter_div").fadeIn("slow")[$.inArray('filter_list', $(this).val()) >= 0 ? 'show' : 'hide']();
			$(".phone_filter_div").fadeIn("slow")[$.inArray('filter_phone', $(this).val()) >= 0 ? 'show' : 'hide']();
			$(".direction_filter_div").fadeIn("slow")[$.inArray('filter_direction', $(this).val()) >= 0 ? 'show' : 'hide']();
			$(".identity_filter_div").fadeIn("slow")[$.inArray('filter_identity', $(this).val()) >= 0 ? 'show' : 'hide']();
			$(".leadcode_filter_div").fadeIn("slow")[$.inArray('filter_leadcode', $(this).val()) >= 0 ? 'show' : 'hide']();
			$(".leadsubid_filter_div").fadeIn("slow")[$.inArray('filter_leadsubid', $(this).val()) >= 0 ? 'show' : 'hide']();

		}).change();

		/****
		 ** Call Recording filters
		 ****/

		// ---- DATETIME PICKER INITIALIZATION

		$('#datetimepicker3').datetimepicker({
			icons: {
				time: "fa fa-clock-o",
				date: "fa fa-calendar",
				up: "fa fa-arrow-up",
				down: "fa fa-arrow-down"
			}
		});

		$('#datetimepicker4').datetimepicker({
			useCurrent: false,
			icons: {
				time: "fa fa-clock-o",
				date: "fa fa-calendar",
				up: "fa fa-arrow-up",
				down: "fa fa-arrow-down"
			}
		});

		// ---- DATE FILTERS

		$("#datetimepicker3").on("dp.change", function(e) {
			$('#datetimepicker4').data("DateTimePicker").minDate(e.date);
			// if ($('#search').val() == "") {
			// 	$('#search_button').attr("disabled", false);
			// 	$('#search_button').text('<?php $lh->translateText("searching"); ?>');
			// } else {
			// 	$('#search_button').text('<?php $lh->translateText("searching"); ?>');
			// 	$('#search_button').attr("disabled", true);
			// }
			// if ($('#agent_filter').is(':visible')) {
			// 	var agent_filter_val = $('#agent_filter').val();
			// } else {
			// 	var agent_filter_val = "";
			// }
			// var start_filterdate_val = $('#start_filterdate').val();
			// var end_filterdate_val = $('#end_filterdate').val();
			// $.ajax({
			// 	url: "filter_callrecs.php",
			// 	type: 'POST',
			// 	data: {
			// 		search_recordings: $('#search').val(),
			// 		start_filterdate: start_filterdate_val,
			// 		end_filterdate: end_filterdate_val,
			// 		agent_filter: agent_filter_val
			// 	},
			// 	success: function(data) {
			// 		$('#search_button').text('<?php $lh->translateText("search"); ?>');
			// 		$('#search_button').attr("disabled", false)
			// 		console.log(data);
			// 		if (data != "") {

			// 			$('#table_callrecordings').html(data);
			// 			$('#table_callrecordings').DataTable({
			// 				"bDestroy": true
			// 			});
			// 		} else {
			// 			init_callrecs_table.fnClearTable();
			// 		}
			// 	}
			// });
		});

		$("#datetimepicker4").on("dp.change", function(e) {
			$('#datetimepicker3').data("DateTimePicker").maxDate(e.date);
			// if ($('#search').val() == "") {
			// 	$('#search_button').attr("disabled", false);
			// 	$('#search_button').text('<?php $lh->translateText("searching"); ?>');
			// } else {
			// 	$('#search_button').text('<?php $lh->translateText("searching"); ?>');
			// 	$('#search_button').attr("disabled", true);
			// }

			// if ($('#agent_filter').is(':visible')) {
			// 	var agent_filter_val = $('#agent_filter').val();
			// } else {
			// 	var agent_filter_val = "";
			// }

			// var start_filterdate_val = $('#start_filterdate').val();
			// var end_filterdate_val = $('#end_filterdate').val();

			// $.ajax({
			// 	url: "filter_callrecs.php",
			// 	type: 'POST',
			// 	data: {
			// 		search_recordings: $('#search').val(),
			// 		start_filterdate: start_filterdate_val,
			// 		end_filterdate: end_filterdate_val,
			// 		agent_filter: agent_filter_val
			// 	},
			// 	success: function(data) {
			// 		$('#search_button').text('<?php $lh->translateText("search"); ?>');
			// 		$('#search_button').attr("disabled", false)
			// 		console.log(data);
			// 		if (data != "") {

			// 			$('#table_callrecordings').html(data);
			// 			$('#table_callrecordings').DataTable({
			// 				"bDestroy": true
			// 			});
			// 		} else {
			// 			init_callrecs_table.fnClearTable();
			// 		}
			// 	}
			// });
		});

		// AGENT FILTER
		$(document).on('change', '#agent_filter', function() {
			// if ($('#search').val() == "") {
			// 	$('#search_button').attr("disabled", false);
			// 	$('#search_button').text('<?php $lh->translateText("searching"); ?>');
			// } else {
			// 	$('#search_button').text('<?php $lh->translateText("searching"); ?>');
			// 	$('#search_button').attr("disabled", true);
			// }

			if ($('#agent_filter').is(':visible')) {
				if ($('#agent_filter').is(':visible')) {
					var agent_filter_val = $('#agent_filter').val();
				} else {
					var agent_filter_val = "";
				}
			} else {
				var agent_filter_val = "";
			}
			// var start_filterdate_val = $('#start_filterdate').val();
			// var end_filterdate_val = $('#end_filterdate').val();
			// $.ajax({
			// 	url: "filter_callrecs.php",
			// 	type: 'POST',
			// 	data: {
			// 		search_recordings: $('#search').val(),
			// 		start_filterdate: start_filterdate_val,
			// 		end_filterdate: end_filterdate_val,
			// 		agent_filter: agent_filter_val
			// 	},
			// 	success: function(data) {
			// 		$('#search_button').text('<?php $lh->translateText("search"); ?>');
			// 		$('#search_button').attr("disabled", false)
			// 		console.log(data);
			// 		if (data != "") {

			// 			$('#table_callrecordings').html(data);
			// 			$('#table_callrecordings').DataTable({
			// 				"bDestroy": true
			// 			});
			// 		} else {
			// 			init_callrecs_table.fnClearTable();
			// 		}
			// 	}
			// });

		});

		/****
		 ** Search function
		 ****/
		$(document).on('click', '#search_button', function() {
			//init_contacts_table.destroy();
			isClean = true;
			if ($('#search').val() == "") {
				$('#search_button').attr("disabled", false);
				$('#search_button').text('<?php $lh->translateText("searching"); ?>');
			} else {
				$('#search_button').text('<?php $lh->translateText("searching"); ?>');
				$('#search_button').attr("disabled", true);
			}

			var init_callrecs_table = $('#table_callrecordings').DataTable({
				destroy: true,
				responsive: true,
				stateSave: true,
				processing: true,
				serverSide: true,
				lengthMenu: [
					[10, 25, 50, -1],
					["10", "25", "50", "Show all"],
				],
				iDisplayLength: 10,
				drawCallback: function(settings) {
					var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
					pagination.toggle(this.api().page.info().pages > 1);
				},
				ajax: $.fn.dataTable.pipeline({
					pages: 5,
				}),
				columnDefs: [{
						width: "30%",
						targets: 0
					},
					{
						width: "20%",
						targets: 1
					},
					{
						searchable: false,
						targets: 4
					},
					{
						sortable: false,
						targets: 4
					},
					{
						responsivePriority: 1,
						targets: 4
					},
					{
						responsivePriority: 2,
						targets: 1
					},
					{
						responsivePriority: 2,
						targets: 4
					}
				],
				columns: [{
						data: "start_time"
					},
					{
						data: "full_name"
					},
					{
						data: "phone_number"
					},
					{
						data: "user"
					},
					{
						data: "length_in_sec"
					},
					{
						data: null,
						render: function(data, type, row) {
							return data.location == null ? "" : `<div class='btn-group'>
							<button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown'>Choose Action
							<button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown' style='height: 34px;'>
										<span class='caret'></span>
										<span class='sr-only'>Toggle Dropdown</span>
							</button>
							<ul class='dropdown-menu' role='menu'>
								<li><a class='play_audio' href='#' data-location='${data.location.replace("http://","https://")}' data-details='<strong>Phone</strong>: <i>${data.phone_number}</i><br/><strong>Date</strong>: <i>${data.start_time}</i><br/>'>Play Recording</a></li>
								<li><a class='download-call-recording' href='${data.location.replace("http://","https://")}' download>Download Call Recording</a></li>
								<li><a onClick='delete_call_recording(${data.recording_id})' href='#'>Delete Call Recording</a></li>
							</ul>
						</div>`;
						}
					}
				]
			});

		});
		$.fn.dataTable.pipeline = function(opts) {
			if ($('#search_recordings').is(":checked")) {
				var start_filterdate_val = $('#start_filterdate').val();
				var end_filterdate_val = $('#end_filterdate').val();
				// Agent Filter
				if ($('#agent_filter').is(':visible')) {
					var agent_filter_val = $('#agent_filter').val();
				} else {
					var agent_filter_val = "";
				}
				// List Filter
				if ($('#list_filter').is(':visible')) {
					var list_filter_val = $('#list_filter').val();
				} else {
					var list_filter_val = "";
				}
				// Phone Filter
				if ($('#phone_filter').is(':visible')) {
					var phone_filter_val = $('#phone_filter').val();
				} else {
					var phone_filter_val = "";
				}
				// Identity Filter
				if ($('#identity_filter').is(':visible')) {
					var identity_filter_val = $('#identity_filter').val();
				} else {
					var identity_filter_val = "";
				}
				// LeadCode Filter
				if ($('#leadcode_filter').is(':visible')) {
					var leadcode_filter_val = $('#leadcode_filter').val();
				} else {
					var leadcode_filter_val = "";
				}
				// LeadSubId Filter
				if ($('#leadcode_filter').is(':visible')) {
					var leadsubid_filter_val = $('#leadcode_filter').val();
				} else {
					var leadsubid_filter_val = "";
				}
				// Direction Filter
				if ($('#direction_filter').is(':visible')) {
					var direction_filter_val = $('#direction_filter').val();
				} else {
					var direction_filter_val = "";
				}
			}
			let conf = $.extend({
					pages: 5,
					url: "",
					data: null,
					method: "GET",
				},
				opts
			);
			let cacheLower = -1;
			let cacheUpper = null;
			let cacheLastRequest = null;
			let cacheLastJson = null;
			return (request, callback, settings) => {
				let ajax = false;
				let requestStart = request.start;
				let drawStart = request.start;
				if (isClean){
					requestStart = 0;
					drawStart = 0;
					isClean = false;
				}
				let requestLength = request.length;
				let requestEnd = requestStart + requestLength;

				if (settings.clearCache) {
					ajax = true;
					settings.clearCache = false;
				} else if (
					cacheLower < 0 ||
					requestStart < cacheLower ||
					requestEnd > cacheUpper
				) {
					ajax = true;
				} else if (
					JSON.stringify(request.order) !==
					JSON.stringify(cacheLastRequest.order) ||
					JSON.stringify(request.columns) !==
					JSON.stringify(cacheLastRequest.columns) ||
					JSON.stringify(request.search) !==
					JSON.stringify(cacheLastRequest.search)
				) {
					ajax = true;
				}
				cacheLastRequest = $.extend(true, {}, request);

				if (ajax) {
					if (requestStart < cacheLower) {
						requestStart = requestStart - requestLength * (conf.pages - 1);

						if (requestStart < 0) {
							requestStart = 0;
						}
					}
					cacheLower = requestStart;
					cacheUpper = requestStart + requestLength * conf.pages;
					request.start = requestStart;
					request.length = requestLength * conf.pages;
					if (typeof conf.data === "function") {
						var d = conf.data(request);
						if (d) {
							$.extend(request, d);
						}
					} else if ($.isPlainObject(conf.data)) {
						$.extend(request, conf.data);
					}
					let json = {};
					let out = [];
					let total = 0;
					let offset = request.start;
					let limit = request.length;
					let data_counter = 1;
					$.ajax({
						url: "search.php",
						type: 'POST',
						data: {
							search_recordings: $('#search').val(),
							start_filterdate: start_filterdate_val,
							end_filterdate: end_filterdate_val,
							agent_filter: agent_filter_val,
							list_filter: list_filter_val,
							phone_filter: phone_filter_val,
							identity_filter: identity_filter_val,
							leadcode_filter: leadcode_filter_val,
							leadsubid_filter: leadsubid_filter_val,
							direction_filter: direction_filter_val,
							offset: offset,
							limit: limit,
						},
						dataType: 'json',
						success: function(data) {
							$('#search_button').text("<?php print $lh->translationFor("search"); ?>");
							$('#search_button').attr("disabled", false);
							json.data = data.data;
							if (data.data == null){
								json.data = [];
							}
							if (data.total == null){
								json.total = 0;
							}
							json.recordsTotal = data.total;
							json.recordsFiltered = data.total;
							cacheLastJson = $.extend(true, {}, json);
							if (cacheLower != drawStart) {
								json.data.splice(0, drawStart - cacheLower);
							}
							if (requestLength > 0) {
								json.data.splice(requestLength, json.data.length);
							}
							json.draw = request.draw;
							callback(json);
						}
					});
				} else {
					json = $.extend(true, {}, cacheLastJson);
					json.draw = request.draw; // Update the echo for each response
					json.data.splice(0, requestStart - cacheLower);
					json.data.splice(requestLength, json.data.length);
					callback(json);
				}
			};
		};
		/*****
		 ** For playing Call Recordings
		 *****/
		$(document).on('click', '.play_audio', function() {
			var audioFile = $(this).attr('data-location');
			//audioFile = audioFile.replace("http", "https");
			//console.log(audioFile);
			var voicedetails = "";
			var sourceFile = '<audio class="audio_file" controls style="width:100%">';
			sourceFile += '<source src="' + audioFile + '" type="audio/mpeg" download="true"/>';
			sourceFile += '</audio>';

			if (audioFile === "") {
				voicedetails = "Recording is being processed... Please wait a few minutes and try again.";
				$('.download-audio-file').attr('disabled', true);
			} else {
				voicedetails = $(this).attr('data-details');
				$('.download-audio-file').attr('href', audioFile);
				$('.audio-player').html(sourceFile);
			}

			$('.voice-details').html(voicedetails);
			goAvatar._init(goOptions);

			$('#call-playback-modal').modal('show');

			var aud = $('.audio_file').get(0);
			aud.play();
		});

		$('#call-playback-modal').on('hidden.bs.modal', function() {
			var aud = $('.audio_file').get(0);
			aud.pause();
		});

		$("#search_button").click();
	});
</script>

<?php print $ui->creamyFooter(); ?>
</body>

</html>