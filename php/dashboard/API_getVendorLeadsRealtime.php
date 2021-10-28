<?php
/**
 * @file        API_getRealtimeAgentsMonitoring.php
 * @brief       Displays realtime monitoring data and HTML
 * @copyright   Copyright (c) 2020 GOautodial Inc.
 * @author		Demian Lizandro A. Biscocho 
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
*/
	
	require_once('APIHandler.php');
	
	$api 											= \creamy\APIHandler::getInstance();
	$output 										= $api->API_getVendorLeadsMonitoring();

    $barracks 										= '[';   
    
    if (is_array($output->data)) {
		foreach ($output->data as $key => $value) {
			$total 							= $api->escapeJsonString($value->total);
			$called 							= $api->escapeJsonString($value->called);
			$not_call 							= $api->escapeJsonString($value->not_call);
			$vendor_lead_code 					= $api->escapeJsonString($value->vendor_lead_code);
			$list_id 							= $api->escapeJsonString($value->list_id);    
			$tm =  join(" ",str_split($vendor_lead_code));
			$sessionAvatar 							= "<div class='media'><avatar username='$tm' :size='32'></avatar></div>";
			
			$barracks 								.= '[';
			$barracks 								.= '"'.$sessionAvatar.'",';
			$barracks 								.= '"<a class=\"text-blue\"><strong>'.$vendor_lead_code.'</strong></a>",'; 
			$barracks 								.= '"<a class=\"text-blue\"><strong>List '.$list_id.'</strong></a>",';    
			$barracks 								.= '"<b>'.$total.'</b>",';    
			$barracks 								.= '"'.$called.'",';         
			$barracks 								.= '"'.$not_call.'"';
			$barracks 								.= '],';
		}    
		
		$barracks 									= rtrim($barracks, ","); 	
    }
    
    $barracks 										.= ']';
	echo json_encode($barracks);
    
?>
