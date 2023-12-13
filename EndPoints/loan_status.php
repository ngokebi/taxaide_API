<?php

require_once '../config/header.php';
require_once '../config/validate.php';
include_once '../config/database.php';
include_once '../classes/Loans.php';


$database = new Database();
$db = $database->getConnection();

$loan = new Loans($db);

$data = json_decode(file_get_contents("php://input"));
$datas = (array) json_decode(file_get_contents("php://input"), true);

$loan->appID = $data->appID;


$loan_check = $loan->loan_status();


$optionalfields = array();
$expectedFields = array(
    "appID",
);


$DataMissing =   Utility::ValidateEmpty($datas, $expectedFields, $optionalfields);
if ($statuses == 'Access') {
    if ($DataMissing == 200 || $DataMissing == "") {
        $loan->respondMethodAllowed('POST');
        if ($loan->loan_status()) {

            http_response_code(200);
            echo json_encode($loan_check);
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "" . $DataMissing . " Field is Empty."));
        exit;
    }
}
