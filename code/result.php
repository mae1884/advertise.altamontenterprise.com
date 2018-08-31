<?php
require 'functions.php';
$contactName = '';
$contAry = array();
$leadAry = array();

$datActual = json_decode($_POST);
$dataArray = object_to_array($_POST);

if (!empty($dataArray['email'])) {

    $url = "https://crm.zoho.com/crm/private/json/Contacts/getSearchRecords";

    $query = "scope=crmapi&selectColumns=Contacts(Email)&searchCondition=(email|=|" . $dataArray['email'] . ")";
    $contactInfo = json_decode(APICall($url, $query));
    //echo '<pre>';
    //print_r($contactInfo);

    $url1 = "https://crm.zoho.com/crm/private/json/Leads/getSearchRecords";

    $query1 = "scope=crmapi&selectColumns=Leads(Email)&searchCondition=(email|=|" . $dataArray['email'] . ")";
    $leadInfo = json_decode(APICall($url1, $query1));

	if (isset($leadInfo->response->result->Contacts->row->FL)) {
        foreach ($leadInfo->response->result->Contacts->row->FL as $key => $value) {
            $leadAry[$value->val] = $value->content;
        }
    }
	
	
    if (isset($contactInfo->response->result->Contacts->row->FL)) {
        foreach ($contactInfo->response->result->Contacts->row->FL as $key => $value) {
            $contAry[$value->val] = $value->content;
        }
    }

    
    ///echo '<pre>';
    //print_r($contAry); exit;

	if(isset($_POST['checkbox'])){
		$bordered = 'true';
	}else{
		$bordered = '';
	}
	
	if(isset($_POST['classified'])){
		$classified = 'true';
	}else{
		$classified = '';
	}
	
	if(isset($_POST['announcement'])){
		$announcement = 'true';
	}else{
		$announcement = '';
	}
	
	if(isset($_POST['legal'])){
		$legal = 'true';
	}else{
		$legal = '';
	}
	
	if(isset($_POST['other'])){
		$other = 'true';
	}else{
		$other = '';
	}
	
	
	if(isset($_POST['affidavit'])){
		$affidavitaddress = 'true';
	}else{
		$affidavitaddress = '';
	}

	
	if($_POST['imagelink'] != ''){
		$imagelink = $_POST['imagelink'];
	}else{
		$imagelink = '';
	}
	
    if ($leadAry['Email'] == $dataArray['email']) {
		// Create Lead
        $xmlData = '<Leads>
			<row no="1">
				<FL val="Lead Status">Contacted</FL>
				<FL val="Bordered display ad">'.$bordered.'</FL>
				<FL val="Announcement">'.$announcement.'</FL>
				<FL val="Other">'.$other.'</FL>
				<FL val="Classified listing">'.$classified.'</FL>
				<FL val="Legal notice">'.$legal.'</FL>
				<FL val="First Name">'.$_POST['firstname'].'</FL>
				<FL val="Last Name">'.$_POST['lastname'].'</FL>
				<FL val="Company">'.$_POST['company'].'</FL>
				<FL val="Phone">'.$_POST['phone'].'</FL>
				<FL val="Email">'.$_POST['email'].'</FL>
				<FL val="Address line 2">'.$_POST['billingaddress'].'</FL>
				<FL val="City">'.$_POST['city'].'</FL>
				<FL val="State">'.$_POST['state'].'</FL>
				<FL val="Zip Code">'.$_POST['zipcode'].'</FL>
				<FL val="Affidavit address">'.$affidavitaddress.'</FL>
				<FL val="Send affidavit address">'.$_POST['sendaffidavit'].'</FL>
				<FL val="Number of consecutive runs">'.$_POST['number'].'</FL>
				
				<FL val="Description">'.$_POST['legalnotice'].'</FL>
				<FL val="Image link">'.$imagelink.'</FL>
			</row>
		</Leads>';

        $url = "https://crm.zoho.com/crm/private/xml/Leads/updateRecords";
        $query = "scope=crmapi&leadId=" . $leadAry['CONTACTID'] . "&xmlData=" . $xmlData;
        $responseUpdate = APICall($url, $query);
		
		if(!empty($_FILES['filesToUpload']['name'])){
			$total = count($_FILES['filesToUpload']['name']);
			$tmpFilePath = $_FILES['filesToUpload']['tmp_name'];
			if ($tmpFilePath != ""){
				$newFilePath = "./uploadFiles/" . $_FILES['filesToUpload']['name'];
				if(move_uploaded_file($tmpFilePath, $newFilePath)) {
					if (isset($xml->result->recorddetail->FL[0])) {
						$ID = $xml->result->recorddetail->FL[0];
					}
				  $uploadInfo = uploadAttachementToModule($ID, 'Leads', $newFilePath);
				}
			  }
		}
		
		
		if(!empty($_FILES['filesToUpload']['name'])){
			$total = count($_FILES['filesToUpload']['name']);
			$tmpFilePath = $_FILES['filesToUpload']['tmp_name'];
			if ($tmpFilePath != ""){
				$newFilePath = "./uploadFiles/" . $_FILES['filesToUpload']['name'];
				if(move_uploaded_file($tmpFilePath, $newFilePath)) {
					if (isset($xml->result->recorddetail->FL[0])) {
						$ID = $xml->result->recorddetail->FL[0];
					}
				  $uploadInfo = uploadAttachementToModule($ID, 'Leads', $newFilePath);
				}
			  }
		}
		
		if(!empty($_FILES['imagelinkupload']['name'])){
			$total = count($_FILES['imagelinkupload']['name']);
			$tmpFilePath = $_FILES['imagelinkupload']['tmp_name'];
			if ($tmpFilePath != ""){
				$newFilePath = "./uploadFiles/" . $_FILES['imagelinkupload']['name'];
				if(move_uploaded_file($tmpFilePath, $newFilePath)) {
					if (isset($xml->result->recorddetail->FL[0])) {
						$ID = $xml->result->recorddetail->FL[0];
					}
				  $uploadInfo = uploadAttachementToModule($ID, 'Leads', $newFilePath);
				}
			  }
		}
		
    } elseif ($contAry['Email'] == $dataArray['email']) {
        // Create Contact

        $xmlData = '<Contacts>
			<row no="1">
				<FL val="Lead Source">Contacted</FL>
				<FL val="Bordered display ad">'.$bordered.'</FL>
				<FL val="Announcement">'.$announcement.'</FL>
				<FL val="Other">'.$other.'</FL>
				<FL val="Classified listing">'.$classified.'</FL>
				<FL val="Legal notice">'.$legal.'</FL>
				<FL val="First Name">'.$_POST['firstname'].'</FL>
				<FL val="Last Name">'.$_POST['lastname'].'</FL>
				<FL val="Company">'.$_POST['company'].'</FL>
				<FL val="Phone">'.$_POST['phone'].'</FL>
				<FL val="Email">'.$_POST['email'].'</FL>
				<FL val="Mailing Street">'.$_POST['billingaddress'].'</FL>
				<FL val="Mailing City">'.$_POST['city'].'</FL>
				<FL val="Mailing State">'.$_POST['state'].'</FL>
				<FL val="Mailing Zip">'.$_POST['zipcode'].'</FL>
				<FL val="Affidavit address">'.$affidavitaddress.'</FL>
				<FL val="Send affidavit address">'.$_POST['sendaffidavit'].'</FL>
				<FL val="Number of consecutive runs">'.$_POST['number'].'</FL>
				<FL val="Description">'.$_POST['legalnotice'].'</FL>
				<FL val="Image link">'.$imagelink.'</FL>
			</row>
		</Contacts>';

        $url = "https://crm.zoho.com/crm/private/xml/Contacts/updateRecords";
        $query = "scope=crmapi&leadId=" . $contAry['CONTACTID'] . "&xmlData=" . $xmlData;
        $responseUpdate = APICall($url, $query);
		
		if(!empty($_FILES['filesToUpload']['name'])){
			$total = count($_FILES['filesToUpload']['name']);
			$tmpFilePath = $_FILES['filesToUpload']['tmp_name'];
			if ($tmpFilePath != ""){
				$newFilePath = "./uploadFiles/" . $_FILES['filesToUpload']['name'];
				if(move_uploaded_file($tmpFilePath, $newFilePath)) {
					if (isset($xml->result->recorddetail->FL[0])) {
						$ID = $xml->result->recorddetail->FL[0];
					}
				  $uploadInfo = uploadAttachementToModule($ID, 'Leads', $newFilePath);
				}
			  }
		}
		
		
		if(!empty($_FILES['filesToUpload']['name'])){
			$total = count($_FILES['filesToUpload']['name']);
			$tmpFilePath = $_FILES['filesToUpload']['tmp_name'];
			if ($tmpFilePath != ""){
				$newFilePath = "./uploadFiles/" . $_FILES['filesToUpload']['name'];
				if(move_uploaded_file($tmpFilePath, $newFilePath)) {
					if (isset($xml->result->recorddetail->FL[0])) {
						$ID = $xml->result->recorddetail->FL[0];
					}
				  $uploadInfo = uploadAttachementToModule($ID, 'Leads', $newFilePath);
				}
			  }
		}
		
		if(!empty($_FILES['imagelinkupload']['name'])){
			$total = count($_FILES['imagelinkupload']['name']);
			$tmpFilePath = $_FILES['imagelinkupload']['tmp_name'];
			if ($tmpFilePath != ""){
				$newFilePath = "./uploadFiles/" . $_FILES['imagelinkupload']['name'];
				if(move_uploaded_file($tmpFilePath, $newFilePath)) {
					if (isset($xml->result->recorddetail->FL[0])) {
						$ID = $xml->result->recorddetail->FL[0];
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
				<FL val="Bordered display ad">'.$bordered.'</FL>
				<FL val="Announcement">'.$announcement.'</FL>
				<FL val="Other">'.$other.'</FL>
				<FL val="Classified listing">'.$classified.'</FL>
				<FL val="Legal notice">'.$legal.'</FL>
				<FL val="First Name">'.$_POST['firstname'].'</FL>
				<FL val="Last Name">'.$_POST['lastname'].'</FL>
				<FL val="Company">'.$_POST['company'].'</FL>
				<FL val="Phone">'.$_POST['phone'].'</FL>
				<FL val="Email">'.$_POST['email'].'</FL>
				<FL val="Address line 2">'.$_POST['billingaddress'].'</FL>
				<FL val="City">'.$_POST['city'].'</FL>
				<FL val="State">'.$_POST['state'].'</FL>
				<FL val="Zip Code">'.$_POST['zipcode'].'</FL>
				<FL val="Affidavit address">'.$affidavitaddress.'</FL>
				<FL val="Send affidavit address">'.$_POST['sendaffidavit'].'</FL>
				<FL val="Number of consecutive runs">'.$_POST['number'].'</FL>
				
				<FL val="Description">'.$_POST['legalnotice'].'</FL>
				<FL val="Image link">'.$imagelink.'</FL>
			</row>
		</Leads>';

        $url = "https://crm.zoho.com/crm/private/xml/Leads/insertRecords";
        $query = "scope=crmapi&leadId=" . $leadAry['CONTACTID'] . "&xmlData=" . $xmlData;
        $responseUpdate = APICall($url, $query);
		
		if(!empty($_FILES['filesToUpload']['name'])){
			$total = count($_FILES['filesToUpload']['name']);
			$tmpFilePath = $_FILES['filesToUpload']['tmp_name'];
			if ($tmpFilePath != ""){
				$newFilePath = "./uploadFiles/" . $_FILES['filesToUpload']['name'];
				if(move_uploaded_file($tmpFilePath, $newFilePath)) {
					if (isset($xml->result->recorddetail->FL[0])) {
						$ID = $xml->result->recorddetail->FL[0];
					}
				  $uploadInfo = uploadAttachementToModule($ID, 'Leads', $newFilePath);
				}
			}
		}
		
		
		if(!empty($_FILES['filesToUpload']['name'])){
			$total = count($_FILES['filesToUpload']['name']);
			$tmpFilePath = $_FILES['filesToUpload']['tmp_name'];
			if ($tmpFilePath != ""){
				$newFilePath = "./uploadFiles/" . $_FILES['filesToUpload']['name'];
				if(move_uploaded_file($tmpFilePath, $newFilePath)) {
					if (isset($xml->result->recorddetail->FL[0])) {
						$ID = $xml->result->recorddetail->FL[0];
					}
					$uploadInfo = uploadAttachementToModule($ID, 'Leads', $newFilePath);
				}
			  }
		}
		
		
		
		if(!empty($_FILES['imagelinkupload']['name'])){
			$total = count($_FILES['imagelinkupload']['name']);
			$tmpFilePath = $_FILES['imagelinkupload']['tmp_name'];
			if ($tmpFilePath != ""){
				$newFilePath = "./uploadFiles/" . $_FILES['imagelinkupload']['name'];
				if(move_uploaded_file($tmpFilePath, $newFilePath)) {
					if (isset($xml->result->recorddetail->FL[0])) {
						$ID = $xml->result->recorddetail->FL[0];
					}
					$uploadInfo = uploadAttachementToModule($ID, 'Leads', $newFilePath);
				}
			  }
		}
		
    }
}
?>