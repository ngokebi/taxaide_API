<?php

require_once '../config/header.php';
require_once '../config/validate.php';
include_once '../config/database.php';
include_once '../classes/Loans.php';


$database = new Database();
$db = $database->getConnection();

$eligibility = new Loans($db);

$data = json_decode(file_get_contents("php://input"));
$datas = (array) json_decode(file_get_contents("php://input"), true);

$eligibility->email = $data->email;
$eligibility->dob = $data->dob;
$eligibility->tenor = $data->tenor;
$eligibility->gender = $data->gender;
$eligibility->dependents = $data->dependents;
$eligibility->education = $data->education;
$eligibility->netsalary = $data->netsalary;

$rating = $eligibility->get_customer_rate();

$check_eligibility =  $rating[0]['Max_Loan_Amount'];

$optionalfields = array();
$expectedFields = array(
    "email",
    "dob",
    "tenor",
    "gender",
    "dependents",
    "education",
    "netsalary"
);


$DataMissing =   Utility::ValidateEmpty($datas, $expectedFields, $optionalfields);
if ($statuses == 'Access') {
if ($DataMissing == 200 || $DataMissing == "") {
    $eligibility->respondMethodAllowed('POST');

    if (($eligibility->get_customer_rate()) && ($check_eligibility != 0)) {

        http_response_code(200);
        echo json_encode($rating);
    } else {
        http_response_code(400);
        echo json_encode($rating);
        exit;
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "" . $DataMissing . " Field is Empty."));
    exit;
}
}

