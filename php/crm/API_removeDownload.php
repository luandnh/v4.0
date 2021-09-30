<?php

/**
 * @file        API_getLeads.php
 * @brief       Handles requests for displaying leads in the CRM
 * @copyright   Copyright (c) 2018 Pitel Inc.
 * @author		Demian Lizandro A, Biscocho
 * @author      Alexander Jim H. Abenoja
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
$api = \creamy\APIHandler::getInstance();
$file_name = $_POST['file_name'];
$file_path = $_POST['file_path'];
try {
    $output = $api->API_removeDownnload($file_name, $file_path);
    if ($output->result == "success"){
        echo "success";
    }else{
        echo $output->message;
    }
} catch (\Throwable $th) {
    echo $th->getMessage();
}

