<?php

require_once '../config/header.php';
require_once '../config/validate.php';
include_once '../config/database.php';
include_once '../classes/Loans.php';


$database = new Database();
$db = $database->getConnection();

$loans = new Loans($db);

$data = json_decode(file_get_contents("php://input"));
$datas = (array) json_decode(file_get_contents("php://input"), true);

$loans->appID = $data->appID;

$stmt = $loans->all_repayment_shedule_cust();
$itemCount = $stmt->rowCount();

$optionalfields = array();
$expectedFields = array(
    "appID"
);


$DataMissing =   Utility::ValidateEmpty($datas, $expectedFields, $optionalfields);
if ($statuses == 'Access') {
    if ($DataMissing == 200 || $DataMissing == "") {
        $loans->respondMethodAllowed('GET');

        if ($itemCount > 0) {
            $record_arr = array();
            $record_arr["customer_record"] = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $record_item = $row;

                array_push($record_arr["customer_record"], $record_item);
            }

            http_response_code(200);
            echo json_encode($record_arr);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "No records found."));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "" . $DataMissing . " Field is Empty."));
        exit;
    }
}
