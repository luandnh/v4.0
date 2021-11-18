<?php
/**
 * @file        API_getAgentsMonitoringSummary.php
 * @brief       Displays summary of agents monitoring data and HTML
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
	
	
	
	$api 										= \creamy\APIHandler::getInstance();
	$output 									= $api->API_getVendorLeadsMonitoring();
        
    if (empty($output->data)) {    
		echo '<span class="list-group-item">
			<div class="media-box">
					<div class="media-box-body clearfix">
						<strong class="media-box-heading text-primary">
						- - There are no new leads of vendor - -</strong>
					</div>
				</div>
			</span>
		</div>';

    } else {        
        $max = 0;
	  $css = ["#ff9800","#9e9e9e","#ffc107","#1c4694","#ec362a","#40b87f"];
	if (is_array($output->data)) {    
		foreach ($output->data as $key => $value) {      
			// total	called	not_call	vendor_lead_code	list_id  
			if(++$max > 6) break;
			$total 							= $api->escapeJsonString($value->total);
			$called 							= $api->escapeJsonString($value->called);
			$not_call 							= $api->escapeJsonString($value->not_call);
			$vendor_lead_code 					= $api->escapeJsonString($value->vendor_lead_code);
			$list_id 							= $api->escapeJsonString($value->list_id); 
			$tm =  join(" ",str_split($vendor_lead_code));
			$sessionAvatar 						= "<avatar  username='$tm' :size='32'></avatar>";
			echo '<a class="list-group-item">
				<div class="media-box">
					<div class="pull-left">
						'.$sessionAvatar.'
					</div>            
					<div class="media-box-body clearfix">
						<strong class="media-box-heading text-primary">
						<small style="color: black;" class="text-muted pull-right ml">Called:'.$called.'/'.$total.'</small>
						<b id="" data-id="'.$list_id.'"><span class="'.$class.'"></span>'.$vendor_lead_code.'</b>
						</strong><br/>
						<strong style="">List: '.$list_id.'</strong>
						<small style="color: black;" class="text-muted pull-right ml">NCY:'.$not_call.'</small>
					</div>
				</div>
			</a>';
		}
	}
    }
?>
