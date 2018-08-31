<?php
define('AUTHTOKEN_BOOK', '0f07618156a8444d71bc02a19a61d1ce');
define('AUTHTOKEN_CRM', '0a0c682d2e515350ae073fded3f7b16e');
define('BOOK_ORGID', '651274778');

require 'zohoAPIClass.php';

class Zoho extends zohoAPIClass {

    public function initialize($postData) {
        $mail = $postData->billing->email;
        $searchEmail = $this->searchModule('Leads', "(EMAIL:$mail)");
        $leadId = $this->getRecordIDfromResponse('Leads', $searchEmail);
        $contactId = '';
        if (!empty($leadId)) {
            $xmlData = '<Contacts>
                            <row no="1">
                                    <option val="createContact">true</option>
                            </row>
                            <row no="2">
                                    <FL val="First Name">Samplepotential</FL>
                                    <FL val="Last Name">Samplepotential</FL>
                                    <FL val="Email">Samplepotential@mail.com</FL>
                            </row>
                    </Contacts>';
            $convert = $this->convertLead('Leads', $leadId, $xmlData);
            $contactId = $convert->Contact;
        } else {
            echo 'Lead not found.';
        }
    }

}

$zohoBokObj = new Zoho(AUTHTOKEN_BOOK);
$contactID = $zohoBokObj->searchBookCRM($postData->billing->email, 'contacts', BOOK_ORGID);
$response = '';
if (empty($contactID)) {
    $contName = '';
    if (empty($postData->billing->company)) {
        $contName = $postData->billing->first_name . ' ' . $postData->billing->last_name;
    } else {
        $contName = $postData->billing->company;
    }
    $contactAry = array(
        "contact_name" => $contName,
        "company_name" => $postData->billing->company,
        "billing_address" => array(
            "address" => $postData->billing->address_1 . ' ' . $postData->billing->address_2,
            "city" => $postData->billing->city,
            "state" => $postData->billing->state,
            "zip" => $postData->billing->postcode,
            "country" => $postData->billing->country
        ),
        "shipping_address" => array(
            "address" => $postData->shipping->address_1 . ' ' . $postData->shipping->address_2,
            "city" => $postData->shipping->city,
            "state" => $postData->shipping->state,
            "zip" => $postData->shipping->postcode,
            "country" => $postData->shipping->country
        ),
        "contact_persons" => array(array(
                "first_name" => $postData->billing->first_name,
                "last_name" => $postData->billing->last_name,
                "email" => $postData->billing->email,
                "phone" => $postData->billing->phone,
                "is_primary_contact" => true
            )),
        "notes" => $postData->customer_note,
        "email" => $postData->billing->email,
        "is_primary_contact" => true,
        "custom_fields" => array(array(
                "value" => "WooCommerce",
                "index" => 1
            )),
    );
    $contactID = $zohoBokObj->makeBookRequest($contactAry, 'contacts', BOOK_ORGID);
}

if ($postData->status == 'processing' || $postData->status == 'completed' || $postData->status == 'on-hold') {
    if (!empty($contactID)) {
        $lineItems = array();
        $nm = '';
        $ok = true;
        $itemID = array();
        foreach ($postData->line_items as $key => $line_item) {
            $nm = $line_item->name;
            $lineItems[] = array(
                "name" => $nm,
                "description" => $nm,
                "item_order" => $line_item->quantity,
                "rate" => $line_item->price,
                "quantity" => $line_item->quantity,
                "item_total" => $line_item->total
            );
        }
		
		
		//echo '<br />';
		//file_put_contents('log_file.txt', print_r($lineItems, true), FILE_APPEND);


        $url = "https://inventory.zoho.com/api/v1/items?authtoken=0f07618156a8444d71bc02a19a61d1ce&organization_id=651274778";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);

        $items = json_decode($result, true);
		
		//echo '<br />';
		//file_put_contents('log_file.txt', print_r($items, true), FILE_APPEND);

		/* This code is for Name */
        /*foreach ($items['items'] as $key1 => $value1) {
            foreach ($postData->line_items as $key => $value) {
                if ($value->name == $value1['name']) {
                    $lineItems[$key]['item_id'] = $value1['item_id'];
                }
            }
        }*/
		/* This code is for Name */
		
		/* This code is for SKU */
        foreach ($items['items'] as $key1 => $value1) {
            foreach ($postData->line_items as $key => $value) {
                if ($value->sku == $value1['sku']) {
                    $lineItems[$key]['item_id'] = $value1['item_id'];
                }
            }
        }

		/* kuldip last code about shipping */
		if($postData->shipping_total != '0.00'){
			$lineItems[] = array(
					"name" => 'shipping',
					"description" => 'shipping',
					"item_order" => "1",
					"rate" => $postData->shipping_total,
					"quantity" => "1",
					"item_total" => $postData->shipping_total
				);
		}
		/* kuldip last code about shipping */
		
        echo '<br />';
        file_put_contents('log_file.txt', print_r($lineItems, true), FILE_APPEND);
		/* This code is for SKU */
		//exit;
		

		
        $shipping_charge = empty($postData->shipping_total) ? 0 : $postData->shipping_total;
	
        $salesOrderAry = array(
            "customer_id" => $contactID,
            "date" => date('Y-m-d', strtotime($postData->date_created)),
            "discount" => $postData->discount_total,
            "line_items" => $lineItems,
            "notes" => $postData->customer_note,
            //"shipping_charge" => $shipping_charge,
        );
        $salesOrderID = $zohoBokObj->makeBookRequest($salesOrderAry, 'salesorders', BOOK_ORGID, true);
		
        echo '<br />';
        file_put_contents('log_file.txt', print_r($salesOrderID, true), FILE_APPEND);

        foreach ($salesOrderID->salesorder->line_items as $key => $value) {
            $lineItems[$key]['salesorder_item_id'] = $value->line_item_id;
            $lineItems[$key]['item_id'] = $value->item_id;
        }

	if(!empty($lineItems)){
        $invoicesAry = array(
            "customer_id" => $contactID,
            "date" => date('Y-m-d'),
            "discount" => $postData->discount_total,
            "line_items" => $lineItems,
            "sub_total" => $postData->total,
            "tax_total" => $postData->total_tax,
            "total" => $postData->total,
            "currency_code" => $postData->currency,
        );

        $invoicesID = $zohoBokObj->makeBookRequest($invoicesAry, 'invoices', BOOK_ORGID, true);

        echo '<br />';
        file_put_contents('log_file.txt', print_r($invoicesID, true), FILE_APPEND);
		
        $customerpaymentsAry = array(
        "customer_id" => $invoicesID->invoice->customer_id,
        "payment_mode" => "cash",
        "amount" => $invoicesID->invoice->total,
        "date" => date('Y-m-d'),
        "invoices" => array(
            array(
                "invoice_id" => $invoicesID->invoice->invoice_id,
                "amount_applied" => $invoicesID->invoice->total,
            )
        ),
    );
    $customerpaymentsAryRes = $zohoBokObj->makeBookRequest($customerpaymentsAry, 'customerpayments', BOOK_ORGID, true);
}
    } else {
        echo 'Error while creating Contact on Book CRM.';
    }
}
?>