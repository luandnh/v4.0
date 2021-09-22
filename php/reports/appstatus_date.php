<?php
/**
 * @file        inboundreport.php
 * @brief       Handles report requests
 * @copyright   Copyright (c) 2018 Pitel Inc.
 * @author      Alexander Jim H. Abenoja
 *		John Ezra D. Gois
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
*/

	require_once('APIHandler.php');
	
	$api 										= \creamy\APIHandler::getInstance();
	$fromDate 									= date('Y-m-d 00:00:01');
	$toDate 									= date('Y-m-d 23:59:59');
	$campaign_id 								= NULL;
	$request									= NULL;
	$userID										= NULL;
	$userGroup									= NULL;
	$vendor_code									= NULL;
	
	if (isset($_POST['pageTitle']) && $pageTitle != "call_export_report") {
		$pageTitle = $_POST['pageTitle'];
		$pageTitle = stripslashes($pageTitle);
	}
			
	if (isset($_POST["fromDate"])) {
		$fromDate = date('Y-m-d H:i:s', strtotime($_POST['fromDate']));
	}
	
	if ($_POST["toDate"] != "" && $_POST["fromDate"] != "") {
		$toDate = date('Y-m-d H:i:s', strtotime($_POST['toDate']));
	}
	
	if (isset($_POST["userID"])) {
		$userID = $_POST["userID"];
		$userID = stripslashes($userID);
	}
	if (isset($_POST["userGroup"])) {
		$userGroup = $_POST["userGroup"];
		$userGroup = stripslashes($userGroup);
	}
		
	if (isset($_POST["vendor_code"])) {
		$vendor_code = $_POST["vendor_code"];
		$vendor_code = stripslashes($vendor_code);
	}
		
	$postfields = array(
		'goAction' => 'goGetAppStatusByDate',		
		'pageTitle' => $pageTitle,
		'fromDate' => $fromDate,
		'toDate' => $toDate,
		'userGroup'=>$userGroup,
		'vendorCode'=>$vendor_code,
		'userId' => $userID,
		'request' => $request
	);

	$output = $api->API_getReports($postfields);

	if ($output->result == "success") {
/*		echo '<div class="animated slideInLeft">';
			echo '<div>'.$output->TOPsorted_output.'</div>';
		echo '</div>';
		
		echo '<div class="animated slideInRight">';
			echo '<div>'.$output->BOTsorted_output.'</div>';
		echo '</div>';
*/

                $appstatus_report .= '
				<div>
						<legend><small><em class="fa fa-arrow-right"></em><i>App Status By Date</i></small></legend>
								<table class="display responsive no-wrap table table-striped table-bordered table-hover" id="appstatus">
										<thead>
											<tr>
												<th>MODIFIED DATE</th>
												<th>FAIL_MANUAL_KYC</th>
												<th>FAIL_EKYC</th>
												<th>NOT_ELIGIBLE</th>
												<th>SYSTEM_ERROR</th>
												<th>DUPLICATED</th>
												<th>NOT_SUITABLE_OFFER</th>
												<th>CANCELED</th>
												<th>REJECTED</th>
												<th>VALIDATED</th>
												<th>APPROVED</th>
												<th>SIGNED</th>
												<th>ACTIVATED</th>
												<th>TERMINATE</th>
												<th>DISBURSED</th>
											</tr>
										</thead>
										<tbody>
				';
                if ($output->TOPsorted_output != NULL) {
			foreach($output->TOPsorted_output as $row){
		                $appstatus_report .= $row;
			}
                }else{
 	               $appstatus_report .= "";
                }

     	        $appstatus_report .= '</tbody>';
                $appstatus_report .= '</table></div>';
		
		echo '<div class="animated slideInLeft">';
			echo '<div>'.$appstatus_report.'</div>';
		echo '</div>';
	//	var_dump($output->TOPsorted_output);
        }

?>
