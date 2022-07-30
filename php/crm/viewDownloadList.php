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
	if (isset($_POST['pageTitle']) && $pageTitle != "call_export_report") {
		$pageTitle = $_POST['pageTitle'];
		$pageTitle = stripslashes($pageTitle);
	}
	$postfields = array(
		'goAction' => 'goListsDownload',		
	);
	$output = $api->API_getListsDownload($postfields);
	if ($output->result == "success") {
/*		echo '<div class="animated slideInLeft">';
			echo '<div>'.$output->TOPsorted_output.'</div>';
		echo '</div>';
		
		echo '<div class="animated slideInRight">';
			echo '<div>'.$output->BOTsorted_output.'</div>';
		echo '</div>';
*/
        $list_download_table = "";
        $list_download_table .= '
				<div>
					<table class="display responsive no-wrap table table-striped table-bordered table-hover" id="list_download_table">
						<thead>
							<tr>
                                <th>Name</th>
                                <th>User</th>
                                <th>File name</th>
                                <th>Modified Date</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Time Export</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
				';
                if ($output->TOPsorted_output != NULL) {
			foreach($output->TOPsorted_output as $row){
		                $list_download_table .= $row;
			}
                }else{
 	               $list_download_table .= "";
                }

     	        $list_download_table .= '</tbody>';
                $list_download_table .= '</table></div>';
		
		echo '<div class="animated slideInLeft">';
			echo '<div>'.$list_download_table.'</div>';
		echo '</div>';
	//	var_dump($output->TOPsorted_output);
        }

?>
