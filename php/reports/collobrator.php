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
	$postfields = array(
		'goAction' => 'goCollabrator',		
		'pageTitle' => $pageTitle,
		'fromDate' => $fromDate,
		'toDate' => $toDate,
		'request' => $request
	);

	$output = $api->API_getReports($postfields);
	if ($output->result == "success") {
                $sale_performance_report .= '
				<div>
					<table class="display responsive no-wrap table table-striped table-bordered table-hover" id="collabrator_table">
						<thead>
							<tr>
								<th>Sale Code</th>
								<th>Partner Code</th>
								<th>Name</th>
								<th>ID Card</th>
								<th>Issue_date</th>
								<th>Referral Code</th>
								<th>Phone</th>
								<th>DOB</th>
								<th>Address</th>
								<th>Front ID Card</th>
								<th>Back ID Card</th>
								<th>Selfie</th>
								<th>Created Date</th>
							</tr>
						</thead>
						<tbody>
				';
                if ($output->TOPsorted_output != NULL) {
			foreach($output->TOPsorted_output as $row){
		                $sale_performance_report .= $row;
			}
                }else{
 	               $sale_performance_report .= "";
                }

     	        $sale_performance_report .= '</tbody>';
                $sale_performance_report .= '</table></div>';
		
		echo '<div class="animated slideInLeft">';
			echo '<div>'.$sale_performance_report.'</div>';
		echo '</div>';
	//	var_dump($output->TOPsorted_output);
        }

?>
