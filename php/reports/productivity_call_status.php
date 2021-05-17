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
	$statuses									= NULL;
	
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
	if (isset($_POST["campaignID"])) {
		$campaign_id = $_POST["campaignID"];
		$campaign_id = stripslashes($campaign_id);
	}
	if (isset($_POST["userGroup"])) {
		$userGroup = $_POST["userGroup"];
		$userGroup = stripslashes($userGroup);
	}
		
	if (isset($_POST["statuses"])) {
		$statuses = $_POST["statuses"];
		$statuses = stripslashes($statuses);
	}
		
	$postfields = array(
		'goAction' => 'goProductivityCallStatus',		
		'pageTitle' => $pageTitle,
		'fromDate' => $fromDate,
		'toDate' => $toDate,
		'campaignID'=>$campaign_id,
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

                $inbound_report .= '
				<div>
						<legend><small><em class="fa fa-arrow-right"></em><i> Report by call status</i></small></legend>
								<table class="display responsive no-wrap table table-striped table-bordered table-hover"  id="productivity_call_status">
										<thead>
												<tr>
														<th > Team</th>
														<th > User</th>
														<th > Total call </th>
														<th > Answer</th>
														<th > No Answer </th>
														<th > Congestion </th>
														<th > Busy </th>
														<th > Denied </th>
														<th > Erro Sip</th>
														<th > Cancel </th>
														<th > Unknown </th>
														<th > Answer not in queue </th>
														<th > Answer in queue no agent</th>
												</tr>
										</thead>
										<tbody>
				';
                if ($output->TOPsorted_output != NULL) {
			foreach($output->TOPsorted_output as $row){
		                $inbound_report .= $row;
			}
                }else{
 	               $inbound_report .= "";
                }

     	        $inbound_report .= '</tbody>';
                $inbound_report .= '</table></div>';
		
		echo '<div class="animated slideInLeft">';
			echo '<div>'.$inbound_report.'</div>';
		echo '</div>';
	//	var_dump($output->TOPsorted_output);
        }

?>
