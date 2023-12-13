<?php

class Loans
{
    // Connection
    public $conn;

    // Table
    private $customer_table = "OC_reapplications";
    private $db_table = "Banks";
    private $loan_table = "Loans";
    private $cust_table = "Customers";
    private $offer_table = "OfferLetterLogs";

    // Customer Columns
    public $email;
    public $title;
    public $surname;
    public $firstname;
    public $middlename;
    public $mobile;
    public $dependents;
    public $maritalstatus;
    public $residencestate;
    public $education;
    public $referral;
    public $lga;

    public $dob;
    public $gender;
    public $bvn;

    public $residentialaddress;
    public $idtype;
    public $idnumber;
    public $issuedate;
    public $expdate;
    public $nextofkin;
    public $nextofkinphone;
    public $nextofkinrelationship;

    public $employer;
    public $employmentstartdate;
    public $netsalary;
    public $amount;
    public $tenor;
    public $monthly_repayment;
    public $obligations;
    public $email_official;
    public $currentaddress;

    public $bankname;
    public $accounttype;
    public $accountnumber;
    public $disbursementBankName;
    public $disbursementAccountNumber;

    public $buybackaccount;
    public $buybackbank;
    public $buybackamount;

    public $ticketid;
    public $ticketpassword;

    public $statement;
    public $govtID;
    public $staffID;
    public $appID;
    public $repayment_id;


    public $loan_status;
    public $status;



    public function __construct($db)
    {
        $this->conn = $db;
    }


    public function get_customer_rate()
    {

        $curl = curl_init();

        $params = array(
            "merchID" => "webapp",
            "key" => "ej1Y}f:cF@rCt;vJoi%Ooysw1C*`(vvIN=xN.Zm|?OU#H{Z$5!zi1f_to0!:smw",
            "reqType" => "get_cust_rating",
            "dob" => $this->dob,
            "ten" => $this->tenor,
            "gen" => $this->gender,
            "dep" => $this->dependents,
            "edu" => $this->education,
            "inc" => $this->netsalary,
            "comp" => 11465,
        );
        $request = json_encode(array("vser" => [$params]));

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://ibank.pagefinancials.com/CustRating/vservice2.php/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $request,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $result = json_decode($response, true);
        $cust_rating =  $result['Statement'];
        return $cust_rating;
    }

    public function loan_creation()
    {
        $appID = date('ymd') . rand(1, 100000);
        $Completion_status = 5;
        $new_status = 6;
        $InterestRate = '65.650';
        $companyID = 11465;
        $type = "New Application - Taxaide";

        $sql = "INSERT INTO " . $this->customer_table . "
        SET 
            Title = :Title,
            Surname = :Surname,
            Firstname = :Firstname,
            Middlename = :Middlename,
            Mobile = :Mobile,
            Email = :Email,
            DOB = :DOB,
            CompanyID = :CompanyID,
            Gender = :Gender,
            Dependents = :Dependents,
            MaritalStatus = :MaritalStatus,
            ResidenceState = :ResidenceState,
            Education = :Education,
            Referral = :Referral, 
            LGA = :LGA,
            Type = :Type,
            BVN = :BVN,
            ResidentialAddress = :ResidentialAddress,
            IDType = :IDType,
            IDNumber = :IDNumber,
            IssueDate = :IssueDate,
            Expdate = :Expdate,
            NextOfKin = :NextOfKin,
            NextOfKinPhone = :NextOfKinPhone,
            NextOfKinRelationship = :NextOfKinRelationship,
            EmployerName =:EmployerName,
            EmploymentStartDate = :EmploymentStartDate,
            NetSalary = :NetSalary,
            Amount = :Amount,
            Tenor = :Tenor,
            Obligations = :Obligations,
            Email_Official = :Email_Official,
            CurrentAddress = :CurrentAddress,
            Monthly_Repayment = :Monthly_Repayment,
            BankName = :BankName,
            InterestRate =:InterestRate,
            AccountType = :AccountType,
            AccountNumber = :AccountNumber,
            DisbursementBankName = :DisbursementBankName,
            DisbursementAccountNumber = :DisbursementAccountNumber,
            IPassport = :IPassport,
            StaffID = :StaffID,
            Scanned_Statement = :Scanned_Statement,
            BuyBackAccount = :BuyBackAccount,
            BuyBackBank = :BuyBackBank,
            BuyBackAmount = :BuyBackAmount,
            ticketid = :ticketid,
            Completion_status = :Completion_status,
            Clinic_ID = :Clinic_ID,
            ticketpassword = :ticketpassword";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":Email", $this->email);
        $stmt->bindParam(":Title", $this->title);
        $stmt->bindParam(":Surname", $this->surname);
        $stmt->bindParam(":Firstname", $this->firstname);
        $stmt->bindParam(":Middlename", $this->middlename);
        $stmt->bindParam(":Mobile", $this->mobile);
        $stmt->bindParam(":Email", $this->email);
        $stmt->bindParam(":DOB", $this->dob);
        $stmt->bindParam(":CompanyID", $companyID);
        $stmt->bindParam(":Gender", $this->gender);
        $stmt->bindParam(":Dependents", $this->dependents);
        $stmt->bindParam(":MaritalStatus", $this->maritalstatus);
        $stmt->bindParam(":ResidenceState", $this->residencestate);
        $stmt->bindParam(":Education", $this->education);
        $stmt->bindParam(":Referral", $this->referral);
        $stmt->bindParam(":LGA", $this->lga);
        $stmt->bindParam(":BVN", $this->bvn);
        $stmt->bindParam(":Type", $type);
        $stmt->bindParam(":ResidentialAddress", $this->residentialaddress);
        $stmt->bindParam(":IDType", $this->idtype);
        $stmt->bindParam(":IDNumber", $this->idnumber);
        $stmt->bindParam(":IssueDate", $this->issuedate);
        $stmt->bindParam(":Expdate", $this->expdate);
        $stmt->bindParam(":NextOfKin", $this->nextofkin);
        $stmt->bindParam(":NextOfKinPhone", $this->nextofkinphone);
        $stmt->bindParam(":NextOfKinRelationship", $this->nextofkinrelationship);
        $stmt->bindParam(":EmployerName", $this->employer);
        $stmt->bindParam(":EmploymentStartDate", $this->employmentstartdate);
        $stmt->bindParam(":NetSalary", $this->netsalary);
        $stmt->bindParam(":Amount", $this->amount);
        $stmt->bindParam(":Tenor", $this->tenor);
        $stmt->bindParam(":Obligations", $this->obligations);
        $stmt->bindParam(":Email_Official", $this->email_official);
        $stmt->bindParam(":CurrentAddress", $this->currentaddress);
        $stmt->bindParam(":Monthly_Repayment", $this->monthly_repayment);
        $stmt->bindParam(":BankName", $this->bankname);
        $stmt->bindParam(":InterestRate", $InterestRate);
        $stmt->bindParam(":AccountType", $this->accounttype);
        $stmt->bindParam(":AccountNumber", $this->accountnumber);
        $stmt->bindParam(":DisbursementBankName", $this->disbursementBankName);
        $stmt->bindParam(":DisbursementAccountNumber", $this->disbursementAccountNumber);
        $stmt->bindParam(":ticketid", $this->ticketid);
        $stmt->bindParam(":ticketpassword", $this->ticketpassword);
        $stmt->bindParam(":Clinic_ID", $appID);
        $stmt->bindParam(":Completion_status", $Completion_status);
        $stmt->bindParam(":BuyBackAccount", $this->buybackaccount);
        $stmt->bindParam(":BuyBackBank", $this->buybackbank);
        $stmt->bindParam(":BuyBackAmount", $this->buybackamount);
        $stmt->bindParam(":IPassport", $this->govtID);
        $stmt->bindParam(":StaffID", $this->staffID);
        $stmt->bindParam(":Scanned_Statement", $this->statement);
        $response = $stmt->execute();
        if ($response) {
            $sql = "UPDATE " . $this->customer_table . "
        SET 
            Completion_status = :Completion_status
        WHERE 
            Clinic_ID = :Clinic_ID";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":Completion_status", $new_status);
            $stmt->bindParam(":Clinic_ID", $appID);
            $response = $stmt->execute();
            return $appID;
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Something went wrong. Try again!!!"));
            $arr = $stmt->errorInfo();
            print_r($arr);
            exit;
        }
    }

    function loan_status()
    {

        $curl = curl_init();

        $params = array(
            "appID" => $this->appID
        );

        $request = json_encode(array("score" => [$params]));

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://51.38.104.66/CustRating/ScoreCust.php',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $request,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $result = json_decode($response, true);
        return $result;
    }

    public function banks()
    {
        $sql = "SELECT bank, sortcode, nsortcode, bankstatement FROM dbCredits." . $this->db_table . " ORDER BY bank";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    public function repayment_shedule()
    {
        $sql = "SELECT Surname as surname,Firstname as firstname,
                (SELECT ID from dbCredits.Statements WHERE LoanID=a.LoanID AND Repayment_Date>=(date(now())) AND Status='0' ORDER BY Repayment_Date ASC LIMIT 1) AS 'repayment_id',
                (SELECT Clinic_ID from dbWebsiteApps.OC_reapplications WHERE LoanID=a.LoanID) AS 'application_id', loan_tenure, monthly_repayments,
                a.DisbursedAmount AS 'loan_amount',
                (SELECT Repayment_Date FROM dbCredits.Statements WHERE LoanID=a.LoanID AND Repayment_Date>=(date(now())) AND Status='0' ORDER BY Repayment_Date ASC LIMIT 1) AS 'next_repayment_date',
                (SELECT Book_Balance FROM dbCredits.Statements WHERE LoanID=a.LoanID AND Repayment_Date>=(date(now())) AND Status='0' ORDER BY Repayment_Date ASC LIMIT 1) AS 'remaining_balance',
                IFNULL((SELECT SUM(Monthly_Repayment) FROM dbCredits.Statements WHERE LoanID=a.LoanID AND Repayment_Date<(date(now())) AND Status='0' ORDER BY Repayment_Date ASC LIMIT 1),0.0) AS 'outstanding_payments'
                FROM dbCredits." . $this->loan_table . " a, dbCredits." . $this->cust_table . " b WHERE a.CustomerID=b.CustomerID AND Loan_Type LIKE '%taxaide%' ORDER BY a.DateDisbursed DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    public function repayment_shedule_cust()
    {
        // $sql = "SELECT Surname as surname,Firstname as firstname,
        //         (SELECT ID from dbCredits.Statements WHERE LoanID=a.LoanID AND Repayment_Date>=(date(now())) AND Status='0' ORDER BY Repayment_Date ASC LIMIT 1) AS 'repayment_id',
        //         (SELECT Clinic_ID from dbWebsiteApps.OC_reapplications WHERE LoanID=a.LoanID) AS 'application_id', loan_tenure, monthly_repayments,
        //         (SELECT Repayment_Date FROM dbCredits.Statements WHERE LoanID=a.LoanID AND Repayment_Date>=(date(now())) AND Status='0' ORDER BY Repayment_Date ASC LIMIT 1) AS 'next_repayment_date',
        //         (SELECT Book_Balance FROM dbCredits.Statements WHERE LoanID=a.LoanID AND Repayment_Date>=(date(now())) AND Status='0' ORDER BY Repayment_Date ASC LIMIT 1) AS 'remaining_balance',
        //         IFNULL((SELECT SUM(Monthly_Repayment) FROM dbCredits.Statements WHERE LoanID=a.LoanID AND Repayment_Date<(date(now())) AND Status='0' ORDER BY Repayment_Date ASC LIMIT 1),0.0) AS 'outstanding_payments'
        //         FROM dbCredits." . $this->loan_table . " a, dbCredits." . $this->cust_table . " b WHERE a.CustomerID=b.CustomerID AND Loan_Type LIKE '%taxaide%' and 
        //         (SELECT Clinic_ID from dbWebsiteApps.OC_reapplications WHERE LoanID=a.LoanID) = :appID";

        $sql = "SELECT c.surname,c.firstname, a.ID as 'repayment_id',
        (SELECT Clinic_ID from dbWebsiteApps.OC_reapplications WHERE LoanID=a.LoanID) AS 'application_id',
        b.DisbursedAmount as 'loan_amount', loan_tenure,monthly_repayment,
        a.Repayment_Date as 'next_repayment_date',
        (SELECT Book_Balance FROM dbCredits.Statements WHERE ID=a.ID  ORDER BY Repayment_Date ASC LIMIT 1) AS 'remaining_balance',
        IFNULL((SELECT SUM(Monthly_Repayment) FROM dbCredits.Statements WHERE LoanID=a.LoanID AND Repayment_Date<(date(now())) AND Status='0' ORDER BY Repayment_Date ASC LIMIT 1),0.0) AS 'outstanding_payments',
        replace(replace(replace(a.Status,'0','Pending_Repayment'),'1','Paid'),'2','Liquidated') as 'status'
        from dbCredits.Statements a, dbCredits.Loans b, dbCredits.Customers c WHERE a.CustomerID=b.CustomerID AND a.CustomerID=c.CustomerID and b.Loan_Type LIKE '%taxaide%' and 
        (SELECT Clinic_ID from dbWebsiteApps.OC_reapplications WHERE LoanID=a.LoanID) = :appID and a.ID = :repayment_id";
                    
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":appID", $this->appID);
        $stmt->bindParam(":repayment_id", $this->repayment_id);
        $stmt->execute();
        return $stmt;
    }

    public function all_repayment_shedule_cust()
    {
        $sql = "SELECT c.surname,c.firstname, a.ID as 'repayment_id',
        (SELECT Clinic_ID from dbWebsiteApps.OC_reapplications WHERE LoanID=a.LoanID) AS 'application_id',
        b.DisbursedAmount as 'loan_amount', loan_tenure,monthly_repayment,
        a.Repayment_Date as 'next_repayment_date',
        (SELECT Book_Balance FROM dbCredits.Statements WHERE ID=a.ID ORDER BY Repayment_Date ASC LIMIT 1) AS 'remaining_balance',
        IFNULL((SELECT SUM(Monthly_Repayment) FROM dbCredits.Statements WHERE LoanID=a.LoanID AND Repayment_Date<(date(now())) AND Status='0' ORDER BY Repayment_Date ASC LIMIT 1),0.0) AS 'outstanding_payments',
        replace(replace(replace(a.Status,'0','Pending_Repayment'),'1','Paid'),'2','Liquidated') as 'status'
        from dbCredits.Statements a, dbCredits.Loans b, dbCredits.Customers c WHERE a.CustomerID=b.CustomerID AND a.CustomerID=c.CustomerID and b.Loan_Type LIKE '%taxaide%' and 
        (SELECT Clinic_ID from dbWebsiteApps.OC_reapplications WHERE LoanID=a.LoanID) = :appID ORDER BY a.ID ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":appID", $this->appID);
        $stmt->execute();
        return $stmt;
    }


    public function respondMethodAllowed($method)
    {
        switch ($method) {
            case 'GET':
                if ($_SERVER["REQUEST_METHOD"] != 'GET') {
                    http_response_code(405);
                    header("Allow: GET");
                    exit;
                }
                break;

            case 'POST':
                if ($_SERVER["REQUEST_METHOD"] != 'POST') {
                    http_response_code(405);
                    header("Allow: POST");
                    exit;
                }
                break;

            case 'DELETE':
                if ($_SERVER["REQUEST_METHOD"] != 'DELETE') {
                    http_response_code(405);
                    header("Allow: DELETE");
                    exit;
                }
                break;
        }
    }

    public function getOfferLetterID()
    {
        $sql = "SELECT a.ID FROM dbCredits." . $this->offer_table . " a INNER JOIN dbWebsiteApps." . $this->customer_table . " b ON a.Email = b.Email WHERE b.Clinic_ID = :Clinic_ID LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":Clinic_ID", $this->appID);
        $stmt->execute();
        $offer_id = $stmt->fetchColumn();
        return $offer_id;
    }

    public function loanProcess()
    {

        $check = "SELECT a.Status FROM dbCredits." . $this->loan_table . " a INNER JOIN dbWebsiteApps." . $this->customer_table . " b ON a.LoanID = b.LoanID WHERE Clinic_ID = :Clinic_ID LIMIT 1";
        $stmt = $this->conn->prepare($check);
        $stmt->bindParam(":Clinic_ID", $this->appID);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $status_declined = $stmt->fetchColumn();
            if ($status_declined  == 0) {
                http_response_code(403);
                echo json_encode(array("message" => "Loan Declined by Risk"));
                exit;
            } else if ($status_declined  == 4) {
                http_response_code(403);
                echo json_encode(array("message" => "Loan has been Closed"));
                exit;
            }
        }

        switch ($this->loan_status) {
            case 'create':
                if ($this->loan_status == 'create') {
                    $check = "SELECT LoanID FROM " . $this->customer_table . " WHERE Clinic_ID = :Clinic_ID LIMIT 1";
                    $stmt = $this->conn->prepare($check);
                    $stmt->bindParam(":Clinic_ID", $this->appID);
                    $stmt->execute();
                    $loan_id = $stmt->fetchColumn();
                    if ($loan_id  != null) {
                        http_response_code(400);
                        echo json_encode(array("message" => "Loan already Exist!!"));
                        exit;
                    } else {
                        $userid = "nikeaba";
                        $sql = "SELECT ID FROM " . $this->customer_table . " WHERE Clinic_ID = :Clinic_ID LIMIT 1";
                        $stmt = $this->conn->prepare($sql);
                        $stmt->bindParam(":Clinic_ID", $this->appID);
                        $stmt->execute();
                        $id = $stmt->fetchColumn();
                        if ($id  == null) {
                            http_response_code(400);
                            echo json_encode(array("message" => "Application ID not Found"));
                            exit;
                        } else {

                            $sql = "UPDATE " . $this->customer_table . "
                            SET 
                                OfferLetter = :OfferLetter
                            WHERE 
                                Clinic_ID = :Clinic_ID";
                            $stmt = $this->conn->prepare($sql);
                            $stmt->bindParam(":OfferLetter", $this->getOfferLetterID());
                            $stmt->bindParam(":Clinic_ID", $this->appID);
                            $response = $stmt->execute();
                            if ($response) {
                                $sql = "SELECT dbCredits.CreateOnlineCustomer(:id, :userid)";
                                $stmt = $this->conn->prepare($sql);
                                $stmt->bindParam(":id", $id);
                                $stmt->bindParam(":userid", $userid);
                                $response = $stmt->execute();
                                if ($response) {
                                    echo json_encode(array("message" => "Loan has been Created"));
                                } else {
                                    http_response_code(503);
                                    $arr = $stmt->errorInfo();
                                    $error = json_encode($arr[2]);
                                    echo json_encode(array("message" => "Something went wrong. Try again!!!", $error));
                                    exit;
                                }
                            } else {
                                http_response_code(503);
                                $arr = $stmt->errorInfo();
                                $error = json_encode($arr[2]);
                                echo json_encode(array("message" => "Did Not update Table", $error));
                                exit;
                            }
                        }
                    }
                }
                break;

            case 'first_approval':
                if ($this->loan_status == 'first_approval') {
                    $status = 2;
                    $sql = "SELECT LoanID FROM " . $this->customer_table . " WHERE Clinic_ID = :Clinic_ID LIMIT 1";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindParam(":Clinic_ID", $this->appID);
                    $stmt->execute();
                    $loan_id = $stmt->fetchColumn();
                    if ($loan_id  == null) {
                        http_response_code(400);
                        echo json_encode(array("message" => "Loan has not been Created"));
                        exit;
                    } else {
                        $sql = "UPDATE dbCredits." . $this->loan_table . "
                            SET 
                                Status = :Status
                            WHERE 
                                LoanID = :LoanID";
                        $stmt = $this->conn->prepare($sql);
                        $stmt->bindParam(":Status", $status);
                        $stmt->bindParam(":LoanID", $loan_id);
                        $response = $stmt->execute();
                        if ($response) {
                            echo json_encode(array("message" => "Loan Has been Approved by the Underwriter"));
                        } else {
                            http_response_code(503);
                            $arr = $stmt->errorInfo();
                            $error = json_encode($arr[2]);
                            echo json_encode(array("message" => "Something went wrong. Try again!!!", $error));
                            exit;
                        }
                    }
                }
                break;

            case 'final_approval':
                if ($this->loan_status == 'final_approval') {
                    $status = 3;
                    $sql = "SELECT LoanID FROM " . $this->customer_table . " WHERE Clinic_ID = :Clinic_ID LIMIT 1";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindParam(":Clinic_ID", $this->appID);
                    $stmt->execute();
                    $loan_id = $stmt->fetchColumn();
                    if ($loan_id  == null) {
                        http_response_code(400);
                        echo json_encode(array("message" => "Loan has not been Created"));
                        exit;
                    } else {
                        $sql = "UPDATE dbCredits." . $this->loan_table . "
                            SET 
                                Status = :Status
                            WHERE 
                                LoanID = :LoanID";
                        $stmt = $this->conn->prepare($sql);
                        $stmt->bindParam(":Status", $status);
                        $stmt->bindParam(":LoanID", $loan_id);
                        $response = $stmt->execute();
                        if ($response) {
                            echo json_encode(array("message" => "Loan Has been Approved for Disbursment"));
                        } else {
                            http_response_code(503);
                            $arr = $stmt->errorInfo();
                            $error = json_encode($arr[2]);
                            echo json_encode(array("message" => "Something went wrong. Try again!!!", $error));
                            exit;
                        }
                    }
                }
                break;
            case 'disbursment':
                if ($this->loan_status == 'disbursment') {
                    $status = 4;
                    $sql = "SELECT LoanID FROM " . $this->customer_table . " WHERE Clinic_ID = :Clinic_ID LIMIT 1";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindParam(":Clinic_ID", $this->appID);
                    $stmt->execute();
                    $loan_id = $stmt->fetchColumn();
                    if ($loan_id  == null) {
                        http_response_code(400);
                        echo json_encode(array("message" => "Loan has not been Created"));
                        exit;
                    } else {
                        $sql = "UPDATE dbCredits." . $this->loan_table . "
                            SET 
                                Status = :Status
                            WHERE 
                                LoanID = :LoanID";
                        $stmt = $this->conn->prepare($sql);
                        $stmt->bindParam(":Status", $status);
                        $stmt->bindParam(":LoanID", $loan_id);
                        $response = $stmt->execute();
                        if ($response) {
                            echo json_encode(array("message" => "Loan Has been DIsbursed"));
                        } else {
                            http_response_code(503);
                            $arr = $stmt->errorInfo();
                            $error = json_encode($arr[2]);
                            echo json_encode(array("message" => "Something went wrong. Try again!!!", $error));
                            exit;
                        }
                    }
                }
                break;

            case 'decline':
                if ($this->loan_status == 'decline') {
                    $status = 0;
                    $sql = "SELECT LoanID FROM " . $this->customer_table . " WHERE Clinic_ID = :Clinic_ID LIMIT 1";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindParam(":Clinic_ID", $this->appID);
                    $stmt->execute();
                    $loan_id = $stmt->fetchColumn();
                    if ($loan_id  == null) {
                        http_response_code(400);
                        echo json_encode(array("message" => "Loan has not been Created"));
                        exit;
                    } else {
                        $sql = "UPDATE dbCredits." . $this->loan_table . "
                            SET 
                                Status = :Status
                            WHERE 
                                LoanID = :LoanID";
                        $stmt = $this->conn->prepare($sql);
                        $stmt->bindParam(":Status", $status);
                        $stmt->bindParam(":LoanID", $loan_id);
                        $response = $stmt->execute();
                        if ($response) {
                            echo json_encode(array("message" => "Loan was Declined"));
                        } else {
                            http_response_code(503);
                            $arr = $stmt->errorInfo();
                            $error = json_encode($arr[2]);
                            echo json_encode(array("message" => "Something went wrong. Try again!!!", $error));
                            exit;
                        }
                    }
                }
                break;
        }
    }

    public function check_repayment_amount()
    {
        $product_name = "Group Loan Taxaide";
        $sql = "SELECT dbCredits.Get_Monthly_Repayments (:loan_amount,:tenor,`INTEREST_RATE`,date_Add(DATE(NOW()), interval 1 month),Product_Name,DATE(NOW())) FROM dbCredits.Products WHERE Product_Name = :Product_Name";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":loan_amount", $this->amount);
        $stmt->bindParam(":tenor", $this->tenor);
        $stmt->bindParam(":Product_Name", $product_name);
        $stmt->execute();
        $repayment_amount = $stmt->fetchColumn();
        if (true) {
            return $repayment_amount;
        } else {
            http_response_code(503);
            $arr = $stmt->errorInfo();
            $error = json_encode($arr[2]);
            return json_encode(array("message" => "Something went wrong. Try again!!!", $error));
            exit;
        }
    }
}
