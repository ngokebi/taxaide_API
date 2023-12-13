<?php

require_once '../config/header.php';
require_once '../config/validate.php';
include_once '../config/database.php';
include_once '../classes/Loans.php';


$database = new Database();
$db = $database->getConnection();

$loan_process = new Loans($db);

$data = json_decode(file_get_contents("php://input"));
$datas = (array) json_decode(file_get_contents("php://input"), true);

$loan_process->appID = $data->appID;
$loan_process->loan_status = $data->loan_status;

$result = $loan_process->loanProcess();


$optionalfields = array();
$expectedFields = array(
    "appID",
    "loan_status"
);


$DataMissing =   Utility::ValidateEmpty($datas, $expectedFields, $optionalfields);
if ($statuses == 'Access') {
    if ($DataMissing == 200 || $DataMissing == "") {

        $loan_process->respondMethodAllowed('POST');

        if ($result) {

            http_response_code(200);
            echo json_encode(array("message" => $result));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "" . $DataMissing . " Field is Empty."));
        exit;
    }
}
