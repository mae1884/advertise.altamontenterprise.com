<?php

require 'functions.php';
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
$datActual = json_decode($_POST);
$dataArray = object_to_array($_POST);

if (!empty($dataArray['email'])) {
    $url1 = "https://crm.zoho.com/crm/private/json/Leads/getSearchRecords";

    $query1 = "scope=crmapi&selectColumns=Leads(Email)&searchCondition=(email|=|" . $dataArray['email'] . ")";
    $leadInfo = json_decode(APICall($url1, $query1));

    if (isset($leadInfo->response->result->Leads->row->FL)) {
        foreach ($leadInfo->response->result->Leads->row->FL as $key => $value) {
            $leadAry[$value->val] = $value->content;
        }
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
        $legalnotiText = '<FL val="Legal_Notice">' . $_POST['legalnotice'] . '</FL>
                        <FL val="Legal Notice Number of Lines">' . $_POST['leganoticLinesCount'] . '</FL>'
                . '<FL val="Advertise duration">' . $_POST['advertise_duration'] . '</FL>';
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



    if ($leadAry['Email'] == $dataArray['email']) {
        // Update Lead
        $xmlData = '<Leads>
			<row no="1">
				<FL val="Lead Status">Contacted</FL>
				<FL val="Bordered display ad">' . $bordered . '</FL>
				<FL val="Announcement">' . $announcement . '</FL>
				<FL val="Other">' . $other . '</FL>
				<FL val="Classified listing">' . $classified . '</FL>
				<FL val="Legal notice">' . $legal . '</FL>
				<FL val="First Name">' . $_POST['fname'] . '</FL>
				<FL val="Last Name">' . $_POST['lname'] . '</FL>
				<FL val="Company">' . $_POST['company'] . '</FL>
				<FL val="Phone">' . $_POST['phone'] . '</FL>
				<FL val="Email">' . $_POST['email'] . '</FL>
				<FL val="Address line 2">' . $_POST['billingaddress'] . '</FL>
				<FL val="City">' . $_POST['city'] . '</FL>
				<FL val="State">' . $_POST['state'] . '</FL>
				<FL val="Zip Code">' . $_POST['zipcode'] . '</FL>
				<FL val="Affidavit address">' . $affidavitaddress . '</FL>
				<FL val="Send affidavit address">' . $_POST['sendaffidavitaddress'] . '</FL>
				<FL val="Number of consecutive runs">' . $_POST['advertise_duration'] . '</FL>
				' . $legalnotiText . '
				<FL val="Description">' . $_POST['legalnotice'] . '</FL>
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
				<FL val="First Name">' . $_POST['fname'] . '</FL>
				<FL val="Last Name">' . $_POST['lname'] . '</FL>
				<FL val="Company">' . $_POST['company'] . '</FL>
				<FL val="Phone">' . $_POST['phone'] . '</FL>
				<FL val="Email">' . $_POST['email'] . '</FL>
				<FL val="Address line 2">' . $_POST['billingaddress'] . '</FL>
				<FL val="City">' . $_POST['city'] . '</FL>
				<FL val="State">' . $_POST['state'] . '</FL>
				<FL val="Zip Code">' . $_POST['zipcode'] . '</FL>
				<FL val="Affidavit address">' . $affidavitaddress . '</FL>
				<FL val="Send affidavit address">' . $_POST['sendaffidavitaddress'] . '</FL>
				<FL val="Number of consecutive runs">' . $_POST['advertise_duration'] . '</FL>
				' . $legalnotiText . '
				<FL val="Description">' . $_POST['note'] . '</FL>
				<FL val="Image link">' . $imagelink . '</FL>
			</row>
		</Leads>';
//echo $xmlData;exit;
        $url = "https://crm.zoho.com/crm/private/xml/Leads/insertRecords";
        $query = "scope=crmapi&xmlData=" . $xmlData;
        $responseUpdate = APICall($url, $query);
        $xml = simplexml_load_string($responseUpdate);
        $json = json_encode($xml);
        $array = json_decode($json, TRUE);

        if ($legal == "true") {
            require_once 'generatePDF.php';
            uploadAttachementToModule($array['result']['recorddetail']['FL'][0], 'Leads', $attachFileName);
        }

        $date = date("d/m/YYYY");
        $Tasks = '<Tasks>
			<row no="1">
				<FL val="Subject">Follow Up New Lead</FL>
				<FL val="Due Date">' . $date . '</FL>
				<FL val="LEADID">' . $array['result']['recorddetail']['FL'][0] . '</FL>
				<FL val="SEID">' . $array['result']['recorddetail']['FL'][0] . '</FL>
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

//var_dump($contactID);
    if ($contactID == "") {
        $contactAry = array(
            "contact_name" => $_POST['fname'] . " " . $_POST['lname'],
            "company_name" => $_POST['company'],
            "billing_address" => array(
                "address" => $_POST['billingaddress'],
                "city" => $_POST['city'],
                "state" => $_POST['state'],
                "zip" => $_POST['zipcode'],
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
    }

    $contactPersonId = $zohoBokObj->getContactPersonID($contactID, BOOK_ORGID);
    /*
     * Create Invoice
     */
    $key_1 = 0;
    $invoiceArray = array();
    $invoiceArray[$key_1]['name'] = $_POST['advertise_duration'];
    $invoiceArray[$key_1]['quantity'] = $_POST['leganoticLinesCount'];
    $key_1++;
    $invoiceArray[$key_1]['name'] = 'Affidavit';
    $invoiceArray[$key_1]['quantity'] = 1;
    $invoicesAry = array(
        "customer_id" => $contactID,
        "date" => date("Y-m-d"),
        "custom_fields" => [array('label' => 'Lead Source', 'value' => 'Form Submission')],
        "line_items" => $invoiceArray,
        "contact_persons" => [$contactPersonId],
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
    $zohoBokObj->changeInvoiceStatus($invoicesID, BOOK_ORGID, 'sent');
    //$zohoBokObj->sendEmailToInvoice(BOOK_ORGID);
}
header("location: thankyouemail.html");
?>