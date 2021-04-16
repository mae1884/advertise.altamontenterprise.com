<?php
//error_reporting(E_ALL ^ E_WARNING);
ini_set("display_errors",'1');
require 'functions.php';
require 'vendor/autoload.php';

//use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
//use zcrmsdk\oauth\ZohoOAuth;
//use zcrmsdk\crm\crud\ZCRMRecord;
//use zcrmsdk\crm\exception\ZCRMException;
//use zcrmsdk\crm\setup\users\ZCRMUser;
//use zcrmsdk\crm\crud\ZCRMModule;


$contactName = '';
$contAry = array();
$leadAry = array();


//if (isset($_POST['affidavitaddress']) && $_POST['affidavitaddress'] != '') {
//    $_POST['billingaddress']=$_POST['billingaddress_afadd'];
//    $_POST['city']=$_POST['city_afadd'];
//    $_POST['state']=$_POST['state_afadd'];
//    $_POST['zipcode']=$_POST['zipcode_afadd'];
//    unset($_POST['billingaddress_afadd'],$_POST['city_afadd'],$_POST['state_afadd'],$_POST['zipcode_afadd']);
//}
$dataActual = json_encode($_POST);
//error_log($dataActual, 0);
$dataArray = object_to_array($_POST);

$client_id = "1000.YBPMJCM3WR875322X9WU8J7OU30BPH";
$client_secret = "9412b7616228dbe49c7dbf46baa1e9abf22c76d12f";

//$configuration=array("client_id"=>$client_id,"client_secret"=>$client_secret,"redirect_uri"=>"https://ame-staging.efsnetworks.com/publish/result.php","currentUserEmail"=>"miaia@altamontenterprise.com","token_persistence_path"=>".");
//ZCRMRestClient::initialize($configuration);
//$oAuthClient = ZohoOAuth::getClientInstance();
//$refreshToken = "1000.2f4415cd23b2850815f4e32b29ef5de1.528d3a449d66b7505eb5271317fa7c7f";
//$rest=ZCRMRestClient::getInstance();
$param_map=array("page"=>1,"per_page"=>1);
//$userEmail="miaia@altamontenterprise.com";
//$oAuthTokens = $oAuthClient->generateAccessTokenFromRefreshToken($refreshToken,$userEmail);
//$moduleIns = $rest->getModuleInstance("Contacts");
//$response = $moduleIns->searchRecordsByEmail("adam@efsnetworks.com",$param_map) ;
//$records = $response->getData();

//$record_instance=$rest->getRecordInstance("contacts","1652825000018446001");
//$data = (array) $record_instance;
//echo $oAuthClient;

function cgFilter($val){
    return "<![CDATA[".urlencode($val)."]]>";
}
if (!empty($dataArray['email'])) {
//    $url1 = "https://crm.zoho.com/crm/private/json/Leads/getSearchRecords";
//    $query1 = "scope=crmapi&selectColumns=Leads(Email)&searchCondition=(email|=|" . $dataArray['email'] . ")";
//      $moduleIns = $rest->getModuleInstance("Leads");
      $param_map=array("page"=>1,"per_page"=>1);

      try {
//           $response = $moduleIns->searchRecordsByEmail($dataArray['email'],$param_map) ;
//           $leadInfo = $response->getData();
           //error_log($leadInfo, 0);
      } catch (ZCRMException $ex){
            echo $ex->getMessage(); // To get ZCRMException error message
            echo $ex->getExceptionCode(); // To get ZCRMException error code
            echo $ex->getFile(); // To get the file name that throws the Exception
      }

    if (isset($leadInfo->response->result->Leads->row->FL)) {
        foreach ($leadInfo->response->result->Leads->row->FL as $key => $value) {
            $leadAry[$value->val] = $value->content;
        }
	//error_log($leadInfo, 0);
    }

    if (isset($_POST['Publish']) && $_POST['Publish'] == 'bordered') {
        $bordered = 'true';
    } else {
        $bordered = '';
    }

    if (isset($_POST['Publish']) && $_POST['Publish'] == 'classifiedlisting') {
        $classified = 'true';
    } else {
        $classified = '';
    }

    if (isset($_POST['Publish']) && $_POST['Publish'] == 'announcement') {
        $announcement = 'true';
    } else {
        $announcement = '';
    }

    $legalnotiText = "";
    if (isset($_POST['Publish']) && $_POST['Publish'] == 'legalnotice') {
        $legal = 'true';
        $legalnotiText = '<FL val="Legal_Notice">' . cgFilter($_POST['legalnotice']) . '</FL>
                        <FL val="Legal Notice Number of Lines">' . $_POST['leganoticLinesCount'] . '</FL>'
                . '<FL val="Advertise duration">' . 'Six-week legal notice' . '</FL>';
        $attachFileName = "pdfs/LegalNotic_" . date("His") . ".pdf";
        $leganoticTxtN = $_POST['legalnotice'];
    } else {
        $legal = '';
    }


    if (isset($_POST['Publish']) && $_POST['Publish'] == 'other') {
        $other = 'true';
    } else {
        $other = '';
    }


    if (isset($_POST['affidavitaddress']) && $_POST['affidavitaddress'] != '') {
        $affidavitaddress = 'true';
    } else {
        $affidavitaddress = '';
    }


    if (isset($_POST['link']) && $_POST['link'] != '') {
        $imagelink = $_POST['link'];
    } else {
        $imagelink = '';
    }



    if (isset($leadAry['Email']) && ($leadAry['Email'] == $dataArray['email'])) {
        // Update Lead
        $xmlData = '<Leads>
            <row no="1">
                <FL val="Lead Status">Contacted</FL>
                <FL val="Bordered display ad">' . $bordered . '</FL>
                <FL val="Announcement">' . $announcement . '</FL>
                <FL val="Other">' . $other . '</FL>
                <FL val="Classified listing">' . $classified . '</FL>
                <FL val="Legal notice">' . $legal . '</FL>
                <FL val="First Name">' . cgFilter($_POST['fname']) . '</FL>
                <FL val="Last Name">' . cgFilter($_POST['lname']) . '</FL>
                <FL val="Company">' . cgFilter($_POST['company']) . '</FL>
                <FL val="Phone">' . cgFilter($_POST['phone']) . '</FL>
                <FL val="Email">' . cgFilter($_POST['email']) . '</FL>
                <FL val="Address line 2">' . cgFilter($_POST['billingaddress']) . '</FL>
                <FL val="City">' . cgFilter($_POST['city']) . '</FL>
                <FL val="State">' . cgFilter($_POST['state']) . '</FL>
                <FL val="Zip Code">' . cgFilter($_POST['zipcode']) . '</FL>
                <FL val="Affidavit address">' . cgFilter($affidavitaddress) . '</FL>
//                <FL val="Send affidavit address">' . cgFilter($_POST['sendaffidavitaddress']) . '</FL>
                <FL val="Number of consecutive runs">' . 'Six-week legal notice' . '</FL>
                ' . $legalnotiText . '
                <FL val="Description">' . cgFilter($_POST['legalnotice']) . '</FL>
                <FL val="Image link">' . $imagelink . '</FL>
            </row>
        </Leads>';

        $url = "https://crm.zoho.com/crm/private/xml/Leads/updateRecords";
        $query = "scope=crmapi&id=" . $leadAry['LEADID'] . "&xmlData=" . $xmlData;
        $responseUpdate = APICall($url, $query);

        $xml = simplexml_load_string($responseUpdate);
        $json = json_encode($xml);
        $array = json_decode($json, TRUE);

        if ($legal == "true") {
            require_once 'generatePDF.php';
            uploadAttachementToModule($leadAry['LEADID'], 'Leads', $attachFileName);
        }
        if (!empty($_FILES['fileupload1']['name'])) {
            $tmpFilePath = $_FILES['fileupload1']['tmp_name'];
            if ($tmpFilePath != "") {
                $newFilePath = "./uploadFiles/" . $_FILES['fileupload1']['name'];
                if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                    if (isset($array['result']['recorddetail']['FL'][0])) {
                        $ID = $array['result']['recorddetail']['FL'][0];
                    }
                    $uploadInfo = uploadAttachementToModule($ID, 'Leads', $newFilePath);
                }
            }
        }


        if (!empty($_FILES['fileupload2']['name'])) {
            $tmpFilePath = $_FILES['fileupload2']['tmp_name'];
            if ($tmpFilePath != "") {
                $newFilePath = "./uploadFiles/" . $_FILES['fileupload2']['name'];
                if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                    if (isset($array['result']['recorddetail']['FL'][0])) {
                        $ID = $array['result']['recorddetail']['FL'][0];
                    }
                    $uploadInfo = uploadAttachementToModule($ID, 'Leads', $newFilePath);
                }
            }
        }


        if (!empty($_FILES['fileupload3']['name'])) {
            $tmpFilePath = $_FILES['fileupload3']['tmp_name'];
            if ($tmpFilePath != "") {
                $newFilePath = "./uploadFiles/" . $_FILES['fileupload3']['name'];
                if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                    if (isset($array['result']['recorddetail']['FL'][0])) {
                        $ID = $array['result']['recorddetail']['FL'][0];
                    }
                    $uploadInfo = uploadAttachementToModule($ID, 'Leads', $newFilePath);
                }
            }
        }

        if (!empty($_FILES['localcomputer']['name'])) {
            $tmpFilePath = $_FILES['localcomputer']['tmp_name'];
            if ($tmpFilePath != "") {
                $newFilePath = "./uploadFiles/" . $_FILES['localcomputer']['name'];
                if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                    if (isset($array['result']['recorddetail']['FL'][0])) {
                        $ID = $array['result']['recorddetail']['FL'][0];
                    }
                    $uploadInfo = uploadAttachementToModule($ID, 'Leads', $newFilePath);
                }
            }
        }
    } else {
        //create Lead 


        $xmlData = '<Leads>
            <row no="1">
                <FL val="Lead Status">Contacted</FL>
                <FL val="Bordered display ad">' . $bordered . '</FL>
                <FL val="Announcement">' . $announcement . '</FL>
                <FL val="Other">' . $other . '</FL>
                <FL val="Classified listing">' . $classified . '</FL>
                <FL val="Legal notice">' . $legal . '</FL>
                <FL val="First Name">' . cgFilter($_POST['fname']) . '</FL>
                <FL val="Last Name">' . cgFilter($_POST['lname']) . '</FL>
                <FL val="Company">' . cgFilter($_POST['company']) . '</FL>
                <FL val="Phone">' . $_POST['phone'] . '</FL>
                <FL val="Email">' . $_POST['email'] . '</FL>
                <FL val="Address line 2">' . cgFilter($_POST['billingaddress']) . '</FL>
                <FL val="City">' . cgFilter($_POST['city']) . '</FL>
                <FL val="State">' . cgFilter($_POST['state']) . '</FL>
                <FL val="Zip Code">' . cgFilter($_POST['zipcode']) . '</FL>
                <FL val="Affidavit address">' . cgFilter($affidavitaddress)  . '</FL>
//                <FL val="Send affidavit address">' . 'Six-week legal notice' . '</FL>
                <FL val="Number of consecutive runs">' . 'Six-week legal notice' . '</FL>
                ' . $legalnotiText . '
                <FL val="Description">' . cgFilter($_POST['note']) . '</FL>
                <FL val="Image link">' . $imagelink . '</FL>
            </row>
        </Leads>';
//echo $xmlData;exit;
//        $url = "https://crm.zoho.com/crm/private/xml/Leads/insertRecords";
//        $query = "scope=crmapi&xmlData=" . $xmlData;
//        $responseUpdate = APICall($url, $query);
//	$leadsIns = ZCRMModule::getInstance("Leads", NULL);
        $xml = simplexml_load_string($xmlData);
        $json = json_encode($xml);
        $array = json_decode($json, TRUE);
//	$record = ZCRMRecord::getInstance("Leads", NULL); // To get record instance
	error_log("Record instance created", 0);
//	foreach ($array as $key => $value) {
//	      $record->setFieldValue($key, $value);
//	}
//	$records = array();
//	array_push($records, $record);
//	$response = $leadsIns->createRecords($records);
//	error_log("record created in crm", 0);
//	$leadData = $response->getData();
//	error_log("response data collected", 0);
	//$responses = $leadData->getEntityResponses();
	$leadid = "";
//	if("success" == $response->getStatus()){
//	  $newLead=$response->getData();
//	  $leadid = $newLead->getEntityId();
//	}
//	error_log($leadid, 0);
        if ($legal == "true") {
            require_once 'generatePDF.php';
            uploadAttachementToModule($leadid, 'Leads', $attachFileName);
        }

        $date = date("d/m/YYYY");
        $Tasks = '<Tasks>
            <row no="1">
                <FL val="Subject">Follow Up New Lead</FL>
                <FL val="Due Date">' . $date . '</FL>
                <FL val="LEADID">' . $leadid . '</FL>
                <FL val="SEID">' . $leadid . '</FL>
                <FL val="SEMODULE">Leads</FL>

            </row>
        </Tasks>';
        $urlTasks = "https://crm.zoho.com/crm/private/xml/Tasks/insertRecords";
        $queryTasks = "scope=crmapi&xmlData=" . $Tasks;
        $responseUpdateTasks = APICall($urlTasks, $queryTasks);


        if (!empty($_FILES['fileupload1']['name'])) {
            $tmpFilePath = $_FILES['fileupload1']['tmp_name'];

            if ($tmpFilePath != "") {
                $newFilePath = "./uploadFiles/" . $_FILES['fileupload1']['name'];
                if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                    if (isset($array['result']['recorddetail']['FL'][0])) {
                        $ID = $array['result']['recorddetail']['FL'][0];
                    }
                    $uploadInfo = uploadAttachementToModule($ID, 'Leads', $newFilePath);
                }
            }
        }


        if (!empty($_FILES['fileupload2']['name'])) {
            $tmpFilePath = $_FILES['fileupload2']['tmp_name'];
            if ($tmpFilePath != "") {
                $newFilePath = "./uploadFiles/" . $_FILES['fileupload2']['name'];
                if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                    if (isset($array['result']['recorddetail']['FL'][0])) {
                        $ID = $array['result']['recorddetail']['FL'][0];
                    }
                    $uploadInfo = uploadAttachementToModule($ID, 'Leads', $newFilePath);
                }
            }
        }


        if (!empty($_FILES['fileupload3']['name'])) {
            $tmpFilePath = $_FILES['fileupload3']['tmp_name'];
            if ($tmpFilePath != "") {
                $newFilePath = "./uploadFiles/" . $_FILES['fileupload3']['name'];
                if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                    if (isset($array['result']['recorddetail']['FL'][0])) {
                        $ID = $array['result']['recorddetail']['FL'][0];
                    }
                    $uploadInfo = uploadAttachementToModule($ID, 'Leads', $newFilePath);
                }
            }
        }


        if (!empty($_FILES['localcomputer']['name'])) {
            $tmpFilePath = $_FILES['localcomputer']['tmp_name'];
            if ($tmpFilePath != "") {
                $newFilePath = "./uploadFiles/" . $_FILES['localcomputer']['name'];
                if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                    if (isset($array['result']['recorddetail']['FL'][0])) {
                        $ID = $array['result']['recorddetail']['FL'][0];
                    }
                    $uploadInfo = uploadAttachementToModule($ID, 'Leads', $newFilePath);
                }
            }
        }
    }
}
if ($legal == "true") {
    // Code for Zoho Books


    define('AUTHTOKEN_BOOK', 'cb432401a8e8e4386cb71cf465fc0596');
    define('BOOK_ORGID', '55454760');


    $zohoBokObj = new zohoAPIClass(AUTHTOKEN_BOOK);
    $contactID = $zohoBokObj->searchBookCRM($_POST['email'], 'contacts', BOOK_ORGID);

// var_dump($contactID);exit;
    if ($contactID == "") {
        $contactAry = array(
            "contact_name" => $_POST['fname'] . " " . $_POST['lname'],
			"phone" => $_POST['phone'],
            "company_name" => $_POST['company'],
            "billing_address" => array(
                "address" => $_POST['billingaddress'],
                "city" => $_POST['city'],
                "state" => $_POST['state'],
                "zip" => $_POST['zipcode'],
			    "phone" => $_POST['phone'],
                "country" => ''
            ),
            "contact_persons" => array(array(
                    "first_name" => $_POST['fname'],
                    "last_name" => $_POST['lname'],
                    "email" => $_POST['email'],
                    "phone" => $_POST['phone'],
                    "is_primary_contact" => true
                )),
            "email" => $_POST['email'],
            "is_primary_contact" => true,
        );

        $contactID = $zohoBokObj->makeBookRequest($contactAry, 'contacts', BOOK_ORGID);
    } else {
        $billingAddr = array(
                "address" => $_POST['billingaddress'],
                "city" => $_POST['city'],
                "state" => $_POST['state'],
                "zip" => $_POST['zipcode'],
                "country" => ''
            );
		//$zohoBokObj->setBillingAddress($billingAddr, $contactID, BOOK_ORGID);
        $zohoBokObj->updateBillingAddress($billingAddr, $contactID, BOOK_ORGID);
    }

    $contactPersonId = $zohoBokObj->getContactPersonID($contactID, BOOK_ORGID);
	

    /*
     * Create Invoice
     */
      $_POST['legalnotice']=str_replace('%0D%0A',' ',$_POST['legalnotice']);
      $_POST['legalnotice']=str_replace('%0D',' ', $_POST['legalnotice']);
      $_POST['legalnotice']=str_replace('%0A',' ',$_POST['legalnotice']);
    $key_1 = 0;
    $invoiceArray = array();
    $invoiceArray[$key_1]['name'] = $_POST['advertise-duration'] ?: 'Six-week legal notice';
    $invoiceArray[$key_1]['quantity'] = $_POST['leganoticLinesCount'];
    $invoiceArray[$key_1]['description'] = $_POST['legalnotice'];
    $key_1++;
    $invoiceArray[$key_1]['name'] = 'Affidavit';
    $invoiceArray[$key_1]['quantity'] = 1;
    if (!empty($_POST['email-affidavit'])) {
    $key_1++;
    $invoiceArray[$key_1]['name'] = 'Scan affidavit';
    $invoiceArray[$key_1]['quantity'] = 1;
    }
    $invoicesAry = array(
        "customer_id" => $contactID,
        "date" => date("Y-m-d"),
        "custom_fields" => [array('label' => 'Lead Source', 'value' => 'Form Submission'),array("api_name"=> "cf_full_llc","value"=>isset($_POST['company-notice']) ? $_POST['company-notice']:""),array("api_name"=> "cf_filing_date","value"=>isset($_POST['filing-date']) ? $_POST['filing-date']:""),array("api_name"=> "cf_type","value"=>isset($_POST['advertise-type']) ? $_POST['advertise-type']:""),array("api_name"=> "cf_email_affidavit","value"=>isset($_POST['AffidavitAddress']) ? true:false),array("api_name"=> "cf_advertise_duration","value"=>isset($_POST['advertise-duration']) ? $_POST['advertise-duration']:""),array("api_name"=> "cf_note","value"=>isset($_POST['note']) ? $_POST['note']:""),array("api_name"=> "cf_notice","value"=>isset($_POST['legalnotice']) ? $_POST['legalnotice']:"")],
        "line_items" => $invoiceArray,
        "contact_persons" => [$contactPersonId],
//        "billing_address" => array(
//            "address" => urlencode($_POST['billingaddress']),
//            "city" => urlencode($_POST['city']),
//            "state" => urlencode($_POST['state']),
//            "zip" => urlencode($_POST['zipcode']),
//            "country" => ''
//        ),
        "payment_options" => ["payment_gateways" => array(array("configured" => true,
                    "can_show_billing_address" => false,
                    "additional_field1" => "standard",
                    "is_bank_account_applicable" => false,
                    "gateway_name" => "paypal"), array("configured" => true,
                    "can_show_billing_address" => false,
                    "is_bank_account_applicable" => false,
                    "gateway_name" => "stripe"), array("configured" => true,
                    "can_show_billing_address" => false,
                    "is_bank_account_applicable" => false,
                    "gateway_name" => "wepay"))]
    );
    $invoicesID = $zohoBokObj->makeBookRequest($invoicesAry, 'invoices', BOOK_ORGID);

    $zohoBokObj->addAttachmentToInvoice($invoicesID, $attachFileName);
	$link="https://advertise.altamontenterprise.com/publish/update.php?id=".base64_encode($invoicesID);
    $zohoBokObj->changeInvoiceStatus($invoicesID, BOOK_ORGID, 'sent');
	$zohoBokObj->updateLinkinvoice($invoicesID, BOOK_ORGID, $link);
//    error_log($invoicesID, 0);
//    error_log(BOOK_ORGID, 0);
    $paymentUrl = $zohoBokObj->getInvoiceUrl(BOOK_ORGID, $invoicesID);
//    error_log($paymentUrl, 0);
    //$zohoBokObj->sendEmailToInvoice(BOOK_ORGID);
}
//header("location: thankyouemail.html");
header("location: " . $paymentUrl);
?>
