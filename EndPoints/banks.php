<?php

require_once '../config/header.php';
require_once '../config/validate.php';
include_once '../config/database.php';
include_once '../classes/Loans.php';

$database = new Database();
$db = $database->getConnection();

$banks = new Loans($db);

$stmt = $banks->banks();
$itemCount = $stmt->rowCount();
// echo json_encode($itemCount);


if ($statuses == 'Access') {
    $banks->respondMethodAllowed('GET');
    if ($itemCount > 0) {
        $record_arr = array();
        $record_arr["bank_records"] = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $record_item = $row;

            array_push($record_arr["bank_records"], $record_item);
        }

        http_response_code(200);
        echo json_encode($record_arr);
    } else {
        http_response_code(404);
        echo json_encode(array("message" => "No records found."));
    }
}
