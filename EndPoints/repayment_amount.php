<?php

require_once '../config/header.php';
require_once '../config/validate.php';
include_once '../config/database.php';
include_once '../classes/Loans.php';


$database = new Database();
$db = $database->getConnection();

$repayment_amount = new Loans($db);

$data = json_decode(file_get_contents("php://input"));
$datas = (array) json_decode(file_get_contents("php://input"), true);


$repayment_amount->amount = $data->loan_amount;
$repayment_amount->tenor = $data->tenor;

$result = $repayment_amount->check_repayment_amount();

$optionalfields = array();
$expectedFields = array(
    "loan_amount",
    "tenor"
);


$DataMissing =   Utility::ValidateEmpty($datas, $expectedFields, $optionalfields);
if ($statuses == 'Access') {
    if ($DataMissing == 200 || $DataMissing == "") {
        $repayment_amount->respondMethodAllowed('GET');

        if ($result) {
            http_response_code(200);
            echo json_encode(array("repayment_amount" => $result));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "" . $DataMissing . " Field is Empty."));
        exit;
    }
}
