<?php
require_once('./php/UIHandler.php');
require_once('./php/APIHandler.php');
include('./php/Session.php');

$ui = \creamy\UIHandler::getInstance();
$api = \creamy\APIHandler::getInstance();
$user = \creamy\CreamyUser::currentUser();

if (isset($_POST['search_contacts'])) {

  $output = $ui->GetContacts($_SESSION['user'], $_POST['search_contacts'], $_POST['disposition'], $_POST['list'], $_POST['address'], $_POST['city'], $_POST['state'], 500, $_POST['search_customers']);
  echo $output;
}

if (isset($_POST['search_recordings'])) {
  $search_phone = $_POST['search_recordings'];
  $agent_filter = "";
  $list_filter = "";
  $phone_filter = "";
  $identity_filter = "";
  $leadcode_filter = "";
  $leadsubid_filter = "";
  $direction_filter = "";
  $start = "";
  $end = "";

  if (isset($_POST['agent_filter'])) {
    $agent_filter = $_POST['agent_filter'];
  }
  if (isset($_POST['list_filter'])) {
    $list_filter = $_POST['list_filter'];
  }
  if (isset($_POST['phone_filter'])) {
    $phone_filter = $_POST['phone_filter'];
  }
  if (isset($_POST['identity_filter'])) {
    $identity_filter = $_POST['identity_filter'];
  }
  if (isset($_POST['leadcode_filter'])) {
    $leadcode_filter = $_POST['leadcode_filter'];
  }
  if (isset($_POST['leadsubid_filter'])) {
    $leadsubid_filter = $_POST['leadsubid_filter'];
  }
  if (isset($_POST['direction_filter'])) {
    $direction_filter = $_POST['direction_filter'];
  }
  if (isset($_POST['start_filterdate'])) {
    if ($_POST['start_filterdate'] != "") {
      $start = date('Y-m-d H:i:s', strtotime($_POST['start_filterdate']));
    } else {
      $start = "";
    }
  }

  if (isset($_POST['end_filterdate'])) {
    if ($_POST['end_filterdate'] != "") {
      $end = date('Y-m-d H:i:s', strtotime($_POST['end_filterdate']));
    } else {
      $end = "";
    }
  }

  $postfields = array(
    "goAction" => "goGetCallRecordingList",
    "requestDataPhone" => $search_phone,
    //if(!empty($start))
    //"start_filterdate" => $start,
    "end_filterdate" => $end,
    "agent_filter"=> $agent_filter,
    "list_filter"=> $list_filter,
    "phone_filter"=> $phone_filter,
    "identity_filter"=> $identity_filter ,
    "leadcode_filter"=> $leadcode_filter ,
    "leadsubid_filter"=> $leadsubid_filter,
    "direction_filter"=> $direction_filter
  );
  if ($start !== "")
    $postfields["start_filterdate"] = $start;

  $output = $api->API_Request("goCallRecordings", $postfields);
  //  var_dump($postfields);
  // $table_list = $ui->getListAllRecordings($output);
  
  echo json_encode(array("data" => $output->data, "total" => $output->total));
}
