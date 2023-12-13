<?php

$headers = apache_request_headers();
$app_key = 'a8e47cedbb34f2e222a921e3b2ca7b07';

$statuses = 'NoAccess';

if (isset($headers['app_id']) && isset($headers['app_key']) && isset($headers['Content-Type'])) {
    if ($headers['app_key'] == $app_key) {
        $statuses = "Access";
    } else {
        http_response_code(401);
        echo json_encode(["message" => "Unauthrorized"]);
        exit;
    }

} else {
    http_response_code(400);
    echo json_encode(["message" => "incomplete authroziation header"]);
    exit;
}
