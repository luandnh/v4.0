<?php
/**
 * @file        AddDisposition.php
 * @brief       Handles Add Disposition Request
 * @copyright   Copyright (c) 2018 Pitel Inc.
 * @author      Alexander Jim Abenoja
 * @author		Demian Lizandro A, Biscocho  
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
	$api 								= \creamy\APIHandler::getInstance();
	if(!isset($_POST['dead_lead'])||$_POST['dead_lead']==""){
		$_POST['dead_lead'] 			= "N";
	} else {
		$_POST['dead_lead'] 			= "Y";
	}
	if(!isset($_POST['sale_category'])||$_POST['sale_category']==""){
		$_POST['sale_category'] 			= "N";
	} else {
		$_POST['sale_category'] 			= "Y";
	}
	if(!isset($_POST['c_tovdad_display'])||$_POST['c_tovdad_display']==""){
		$_POST['c_tovdad_display'] 			= "N";
	} else {
		$_POST['c_tovdad_display'] 			= "Y";
	}
	
	$postfields 						= array(
		'goAction' 							=> 'goAddCategory',
		'userid' 							=> $_POST['userid'],
		'category_id' 						=> $_POST['category_id'],
		'category_name' 					=> $_POST['category_name'],
		'category_description' 				=> $_POST['category_description'],
		'c_tovdad_display'					=> $_POST['c_tovdad_display'],
		'dead_lead'							=> $_POST['dead_lead'],
		'sale_category'						=> $_POST['sale_category']
	);

	$output 							= $api->API_addDisposition($postfields);
	
	if ($output->result=="success") { 
		$status 						= 1; 
	} else { 
		$status 						= $output->result; 
	}
	
	echo json_encode($status);

?>
