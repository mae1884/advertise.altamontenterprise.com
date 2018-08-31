<?php

function APICall($url, $query) {
    $auth = "b5e59f20a9c1aad5435c5854fe3a0fd7";
    $query .= "&authtoken=" . $auth;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $query); // Set the request as a POST FIELD for curl.
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

function object_to_array($data) {
    if (is_array($data) || is_object($data)) {
        $result = array();
        foreach ($data as $key => $value) {
            $result[$key] = object_to_array($value);
        }
        return $result;
    }
    return $data;
}

function uploadAttachementToModule($id, $moduleName = '', $file_path) {
    $auth = "b5e59f20a9c1aad5435c5854fe3a0fd7";
    $file_path = realpath($file_path);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, "https://crm.zoho.com/crm/private/xml/" . $moduleName . "/uploadFile?authtoken=" . $auth . "&scope=crmapi");
    curl_setopt($ch, CURLOPT_POST, true);
    $post = array("id" => $id, "content" => curl_file_create($file_path, 'application/pdf', basename($file_path)));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    $response = curl_exec($ch);

    return $response;
}

class zohoAPIClass {

    private $authtoken;
    private $ch;
    public $invoiceId="";
    public $templateId="";

    function __construct($authtoken) {
        $this->authtoken = $authtoken;
    }

    private function curlInit($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1); //standard i/o streams 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // Turn off the server and peer verification 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set to return data to string ($response) 
        curl_setopt($ch, CURLOPT_POST, 1); //Regular post 

        return $ch;
    }

    private function curlPostFields($query) {

        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $query); // Set the request as a POST FIELD for curl. 
        //Execute cUrl session 
        $response = curl_exec($this->ch);

        return $response;
    }

    private function curlInitUpdate($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1); //standard i/o streams 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // Turn off the server and peer verification 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set to return data to string ($response) 


        return $ch;
    }

    private function closeCurl() {
        curl_close($this->ch);
    }

    private function getCurlError() {
        echo 'Curl Error:<pre>';
        print_r(curl_error($this->ch));
        echo '<pre>';

        $this->closeCurl();
    }

    /**
     * $postString zoho post string
     * $moduleName zoho module name
     */
    public function makeCURLRequest($postString, $moduleName, $returnResponse = false) {
        $response = '';
        //manual curl call
        $url = 'https://crm.zoho.com/crm/private/xml/' . $moduleName . '/insertRecords';
        $xmlData = '<' . $moduleName . '> <row no="1">' . $postString . ' </row> </' . $moduleName . '>';

        $xmlData2 = urlencode($xmlData);

        $query = "newFormat=1&authtoken={$this->authtoken}&scope=crmapi&xmlData={$xmlData2}";

        $this->ch = $this->curlInit($url);
        $results = $this->curlPostFields($query);

        $responseContacts = simplexml_load_string($results);

        if ($returnResponse) {
            $this->closeCurl();
            return $responseContacts;
        }
        $id = (string) $responseContacts->result->recorddetail->FL[0];

        if (!empty($id)) {
            $this->closeCurl();
            return $id;
        } else {
            return '';
        }
    }

    /**
     * Search module
     */
    public function searchModule($moduleName, $criteria) {
        //manual curl call
        $url = 'https://crm.zoho.com/crm/private/xml/' . $moduleName . '/searchRecords';

        $query = "authtoken={$this->authtoken}&scope=crmapi&selectColumns=All&criteria={$criteria}&fromIndex=1&toIndex=20&newFormat=1";

        $this->ch = $this->curlInit($url);
        $results = $this->curlPostFields($query);

        $response = simplexml_load_string($results);

        $this->closeCurl();

        if (!empty($response)) {
            return $response;
        } else {
            return '';
        }
    }

    /**
     * Search module
     */
    public function convertLead($moduleName, $leaseId, $xmlData) {
        //manual curl call
        $url = 'https://crm.zoho.com/crm/private/xml/' . $moduleName . '/convertLead';

        $query = "authtoken={$this->authtoken}&scope=crmapi&leadId={$leaseId}&newFormat=1&xmlData={$xmlData}";

        $this->ch = $this->curlInit($url);
        $results = $this->curlPostFields($query);

        $response = simplexml_load_string($results);

        $this->closeCurl();

        if (!empty($response)) {
            return $response;
        } else {
            return '';
        }
    }

    /**
     * $postString zoho post string
     * $moduleName zoho module name
     */
    public function makeBookRequest($postArray, $moduleName, $orgId, $returnResponse = false) {
        //manual curl call
        $url = 'https://books.zoho.com/api/v3/' . $moduleName;

        $jsonString = json_encode($postArray);

        $query = "authtoken={$this->authtoken}&organization_id={$orgId}&JSONString={$jsonString}";

        $this->ch = $this->curlInit($url);
        $results = $this->curlPostFields($query);

        $response = json_decode($results);
//        echo "<pre>";
//        print_r($response);exit;
        // $this->getCurlError();

        if ($returnResponse) {
            return $response;
        }

        if ($response->code == 0) {
            $id = '';
            if ($moduleName == 'contacts') {
                $id = (string) $response->contact->contact_id;
            } else if ($moduleName == 'invoices') {
                $id = (string) $response->invoice->invoice_id;
            } else if ($moduleName == 'salesorders') {
                $id = (string) $response->salesorder->salesorder_id;
            } else if ($moduleName == 'items') {
                $id = (string) $response->item->item_id;
            } else if ($moduleName == 'customerpayments') {
                $id = (string) $response->payment->payment_id;
            }
            return $id;
        } else {
            return '';
        }
    }
    
     public function changeInvoiceStatus($invoiceId, $orgId, $status,$returnResponse=false) {
        //manual curl call
        $url = 'https://books.zoho.com/api/v3/invoices/'.$invoiceId.'/status/'.$status;

        $jsonString = json_encode($postArray);

        $query = "authtoken={$this->authtoken}&organization_id={$orgId}";

        $this->ch = $this->curlInit($url);
        $results = $this->curlPostFields($query);

        $response = json_decode($results);
        // $this->getCurlError();

        if ($returnResponse) {
            return $response;
        }
        return "";
    }
    /**
     * $postString zoho post string
     * $moduleName zoho module name
     */
    public function updateSalesOrderRequest($postArray, $moduleName, $orgId, $returnResponse = false, $salesOrderID) {
        //manual curl call

        $url = 'https://books.zoho.com/api/v3/' . $moduleName . '/' . $salesOrderID;

        $jsonString = json_encode($postArray);
        $query = "authtoken={$this->authtoken}&organization_id={$orgId}&JSONString={$jsonString}";

        $this->ch = $this->curlInitUpdate($url);
        $results = $this->curlPostFields($query);

        $response = json_decode($results);
        // print_r($response);
        // $this->getCurlError();

        if ($returnResponse) {
            return $response;
        }

        if ($response->code == 0) {
            $id = '';
            if ($moduleName == 'salesorders') {
                $id = (string) $response->salesorder->salesorder_id;
            }
            return $id;
        } else {
            return '';
        }
    }

    /**
     * $postString zoho post string
     * $moduleName zoho module name
     */
    public function updateInvoiceRequest($postArray, $moduleName, $orgId, $returnResponse = false, $invoiceID) {

        $url = 'https://books.zoho.com/api/v3/' . $moduleName . '/' . $invoiceID;

        $jsonString = json_encode($postArray);
        $query = "authtoken={$this->authtoken}&organization_id={$orgId}&JSONString={$jsonString}";

        $this->ch = $this->curlInitUpdate($url);
        $results = $this->curlPostFields($query);

        $response = json_decode($results);
        // print_r($response);
        // $this->getCurlError();

        if ($returnResponse) {
            return $response;
        }

        if ($response->code == 0) {
            $id = '';
            if ($moduleName == 'invoices') {

                $id = (string) $response->invoice->invoice_id;
            }
            return $id;
        } else {
            return '';
        }
    }

    /**
     * $postString zoho post string
     * $moduleName zoho module name
     */
    public function updatePaymentRequest($postArray, $moduleName, $orgId, $returnResponse = false, $paymentID) {

        $url = 'https://books.zoho.com/api/v3/' . $moduleName . '/' . $paymentID;

        $jsonString = json_encode($postArray);
        $query = "authtoken={$this->authtoken}&organization_id={$orgId}&JSONString={$jsonString}";

        $this->ch = $this->curlInitUpdate($url);
        $results = $this->curlPostFields($query);

        $response = json_decode($results);
        // print_r($response);
        // $this->getCurlError();

        if ($returnResponse) {
            return $response;
        }

        if ($response->code == 0) {
            $id = '';
            if ($moduleName == 'customerpayments') {
                $id = (string) $response->payment->payment_id;
            }
            return $id;
        } else {
            return '';
        }
    }

    public function deletePaymentRequest($moduleName, $orgId, $returnResponse = false, $paymentID) {

        $api_request_url = 'https://books.zoho.com/api/v3/' . $moduleName . '/' . $paymentID . '?organization_id=' . $orgId . '&authtoken=' . $this->authtoken;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($ch, CURLOPT_URL, $api_request_url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $api_response = curl_exec($ch);
        curl_close($ch);
        //echo '<pre>';
        //print_r(json_decode($api_response,true)); exit;
        $result = json_decode($api_response, true);
        if ($result['code'] == '0') {
            if ($moduleName == 'customerpayments') {
                return $result['message'];
            }
        }
    }

    public function addAttachmentToInvoice($invoiceId, $attachFile, $returnResponse = false) {
        $file_path = realpath($attachFile);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, "https://books.zoho.com/api/v3/invoices/$invoiceId/attachment?authtoken=$this->authtoken&organization_id=$orgId");
        curl_setopt($ch, CURLOPT_POST, true);
        $post = array("can_send_in_mail"=>"true","attachment" => curl_file_create($file_path, 'application/pdf', basename($file_path)));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $response = curl_exec($ch);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
            return '';
        } else {
            $response = json_decode($response);
//            echo "<pre>";
//            print_r($response);
//            exit;
            if ($returnResponse) {
                return $response;
            }
            return '';
        }
    }
    public function sendEmailToInvoice($orgId) {
        $file_path = realpath($attachFile);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, "https://books.zoho.com/api/v3/invoices/$this->invoiceId/email?authtoken=$this->authtoken&organization_id=$orgId&email_template_id=144886000001931009");
        curl_setopt($ch, CURLOPT_POST, true);
//        $body='<p class="p1">Your invoice '.$this->invoiceNumber.' can be viewed, printed or downloaded as PDF from the link below. You can also choose to pay it online.<br><br><a href="'.$this->invoiceURL.'">Click to view Invoice</a></p><p class="p1">We also need a complete name and address for mailing the affidavit (if you haven\'t already provided it). Duplicate affidavits cost $13.</p>';
        $post = array();
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $response = curl_exec($ch);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
            return '';
        } else {
            $response = json_decode($response);
//            echo "<pre>";
//            echo $body;
//            print_r($response);exit;
            if ($returnResponse) {
                return $response;
            }
            return '';
        }
    }

    /**
     * $postString zoho post string
     * $moduleName zoho module name
     */
    public function searchBookCRM($search, $moduleName, $orgId, $returnResponse = false) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://books.zoho.com/api/v3/$moduleName?authtoken=$this->authtoken&organization_id=$orgId&email=$search",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => FALSE, // Turn off the server and peer verification 
            CURLOPT_SSL_VERIFYHOST => FALSE,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "cache-control: no-cache",
                "content-type: application/json"),
        ));

        $response = curl_exec($curl);

        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            //echo "cURL Error #:" . $err;
            return '';
        } else {
            $response = json_decode($response);

            if (empty($response->$moduleName)) {
                return '';
            }
            // die;
            foreach ($response->$moduleName as $key => $jsonObj) {
                # code...
                if ($jsonObj->email == $search) {
                    $contact_id = (string) $jsonObj->contact_id;
                    return $contact_id;
                }
            }
            return '';
        }
    }
    
    
     public function getContactPersonID($contactId, $orgId, $returnResponse = false) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://books.zoho.com/api/v3/contacts/$contactId?authtoken=$this->authtoken&organization_id=$orgId",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => FALSE, // Turn off the server and peer verification 
            CURLOPT_SSL_VERIFYHOST => FALSE,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "cache-control: no-cache",
                "content-type: application/json"),
        ));

        $response = curl_exec($curl);

        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            //echo "cURL Error #:" . $err;
            return '';
        } else {
            $response = json_decode($response);
            return $response->contact->contact_persons[0]->contact_person_id;
        }
    }
    
    /**
     * $postString zoho post string
     * $moduleName zoho module name
     */
    public function searchBookInvoice($search, $moduleName, $orgId, $returnResponse = false) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://books.zoho.com/api/v3/$moduleName?authtoken=$this->authtoken&organization_id=$orgId&orderno=$search",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => FALSE, // Turn off the server and peer verification 
            CURLOPT_SSL_VERIFYHOST => FALSE,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "cache-control: no-cache",
                "content-type: application/json"),
        ));

        $response = curl_exec($curl);

        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            //echo "cURL Error #:" . $err;
            return '';
        } else {
            $response = json_decode($response);

            if (empty($response->$moduleName)) {
                return '';
            }
            // die;
            foreach ($response->$moduleName as $key => $jsonObj) {
                # code...
                //if ($jsonObj->orderno == $search) {
                $contact_id['invoice_id'] = (string) $jsonObj->invoice_id;
                $contact_id['customer_id'] = (string) $jsonObj->customer_id;
                return $contact_id;
                //}
            }
            return '';
        }
    }

    /**
     * $postString zoho post string
     * $moduleName zoho module name
     */
    public function searchBookCustomerPayment($search, $moduleName, $orgId, $returnResponse = false) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://books.zoho.com/api/v3/$moduleName?authtoken=$this->authtoken&organization_id=$orgId&reference_number=$search",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => FALSE, // Turn off the server and peer verification 
            CURLOPT_SSL_VERIFYHOST => FALSE,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "cache-control: no-cache",
                "content-type: application/json"),
        ));

        $response = curl_exec($curl);

        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            //echo "cURL Error #:" . $err;
            return '';
        } else {
            $response = json_decode($response);

            if (empty($response->$moduleName)) {
                return '';
            }
            // die;
            foreach ($response->$moduleName as $key => $jsonObj) {
                # code...
                $contact_id['payment_id'] = (string) $jsonObj->payment_id;
                $contact_id['reference_number'] = (string) $jsonObj->reference_number;
                return $contact_id;
            }
            return '';
        }
    }

    /**
     * $postString zoho post string
     * $moduleName zoho module name
     */
    public function searchBookSalesOrder($search, $moduleName, $orgId, $returnResponse = false) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://books.zoho.com/api/v3/$moduleName?authtoken=$this->authtoken&organization_id=$orgId&reference_number=$search",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => FALSE, // Turn off the server and peer verification 
            CURLOPT_SSL_VERIFYHOST => FALSE,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "cache-control: no-cache",
                "content-type: application/json"),
        ));

        $response = curl_exec($curl);

        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            //echo "cURL Error #:" . $err;
            return '';
        } else {
            $response = json_decode($response);

            foreach ($response->$moduleName as $key => $jsonObj) {
                if ($jsonObj->reference_number == $search) {
                    $contact_id['salesorder_id'] = (string) $jsonObj->salesorder_id;
                    $contact_id['customer_id'] = (string) $jsonObj->customer_id;
                    $contact_id['reference_number'] = (string) $jsonObj->reference_number;
                    return $contact_id;
                }
            }
            return '';
        }
    }

    public function getRecordIDfromResponse($moduleName, $search) {

        if (empty($search->result)) {
            return '';
        }

        $recordId = '';

        $recordId = (string) $search->result->$moduleName->row->FL[0];

        if (empty($recordId)) {
            $recordId = (string) $search->result->$moduleName->row[0]->FL[0];
        }

        return $recordId;
    }

    public function APICall($url, $query) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query); // Set the request as a POST FIELD for curl
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

}

?>