<?php

require_once '../config/header.php';
require_once '../config/validate.php';
include_once '../config/database.php';
include_once '../classes/Loans.php';

$database = new Database();
$db = $database->getConnection();


$customers = new Loans($db);

$data = json_decode(file_get_contents("php://input"));
$datas = (array) json_decode(file_get_contents("php://input"), true);


$customers->title = $data->Title;
$customers->surname = $data->Surname;
$customers->firstname = $data->Firstname;
$customers->middlename = $data->Middlename;
$customers->mobile = $data->Mobile;

$customers->email = $data->Email;
$customers->dob = $data->DOB;
$customers->gender = $data->Gender;

$customers->dependents = $data->Dependents;
$customers->maritalstatus = $data->MaritalStatus;
$customers->residencestate = $data->ResidenceState;
$customers->education = $data->Education;
$customers->referral = $data->Referral;
$customers->lga = $data->LGA;

$customers->residentialaddress = $data->ResidentialAddress;
$customers->idtype = $data->IDType;
$customers->idnumber = $data->IDNumber;
$customers->issuedate = $data->IssueDate;
$customers->expdate = $data->Expdate;
$customers->nextofkin = $data->NextOfKin;

$customers->nextofkinphone = $data->NextOfKinPhone;
$customers->nextofkinrelationship = $data->NextOfKinRelationship;

$customers->bankname = $data->BankName;
$customers->accounttype = $data->AccountType;
$customers->accountnumber = $data->AccountNumber;

$customers->employer = $data->EmployerName;
$customers->bvn = $data->BVN;
$customers->employmentstartdate = $data->EmploymentStartDate;
$customers->netsalary = $data->NetSalary;
$customers->amount = $data->Amount;
$customers->tenor = $data->Tenor;
$customers->obligations = $data->Obligations;
$customers->email_official = $data->Email_Official;
$customers->currentaddress = $data->CurrentAddress;
$customers->disbursementBankName = $data->DisbursementBankName;
$customers->disbursementAccountNumber = $data->DisbursementAccountNumber;

$customers->buybackaccount = $data->BuyBackAccount;
$customers->buybackbank = $data->BuyBackBank;
$customers->buybackamount = $data->BuyBackAmount;


$customers->ticketid = $data->ticketid;
$customers->ticketpassword = $data->ticketpassword;

$customers->govtID = $data->GovID;
$customers->staffID = $data->StaffID;
$customers->statement = $data->Statement;

$result = $customers->loan_creation();

$optionalfields = array();
$expectedFields = array(
    "Title",
    "Surname",
    "Firstname",
    "Middlename",
    "Mobile",

    "Email",
    "DOB",
    "Gender",

    "Dependents",
    "MaritalStatus",
    "ResidenceState",
    "Education",
    "LGA",

    "ResidentialAddress",
    "IDType",
    "IDNumber",
    "NextOfKin",

    "NextOfKinPhone",
    "NextOfKinRelationship",

    "EmployerName",
    "EmploymentStartDate",
    "NetSalary",
    "Amount",
    "Tenor",
    "Email_Official",
    "CurrentAddress",
    "BVN",
    "DisbursementBankName",
    "DisbursementAccountNumber",

    "GovID",
    "StaffID",
    "Statement"
);


$DataMissing =   Utility::ValidateEmpty($datas, $expectedFields, $optionalfields);
if ($statuses == 'Access') {
    if ($DataMissing == 200 || $DataMissing == "") {

        $customers->respondMethodAllowed('POST');

        if ($result) {

            http_response_code(200);
            echo json_encode(array("message" => " Loan booked Successfully.", "appID" => $result));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "" . $DataMissing . " Field is Empty."));
        exit;
    }
}
