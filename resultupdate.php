<?php
if (isset($_POST['Signup'])){
//error_reporting(E_ALL ^ E_WARNING);
ini_set("display_errors",'1');
require 'functions.php';
require 'vendor/autoload.php';
define('AUTHTOKEN_BOOK', 'cb432401a8e8e4386cb71cf465fc0596');
define('BOOK_ORGID', '55454760');

$contactAry =array("billing_address"=> array(
"address" => $_POST['billingaddress'],
"city" => $_POST['city'],
"state" => $_POST['state'],
"zip" => $_POST['zipcode'],
"phone" => $_POST['phone'],
"country" => ''),
"shipping_address"=> array(
"address" => $_POST['billingaddress_afadd'],
"city" => $_POST['city_afadd'],
"state" => $_POST['state_afadd'],
"zip" => $_POST['zipcode_afadd'],"country" => ''),
"phone" => $_POST['phone'],"company_name"=>$_POST['company']);
$invArr=array("address"=> $_POST['billingaddress'],"city"=> $_POST['city'],"state"=>$_POST['state'],"zip"=>$_POST['zipcode']);
$contactID=isset($_POST['contactid']) ? $_POST['contactid']:"";
$invoicesID=isset($_POST['invoiceid']) ? $_POST['invoiceid']:"";
$zohoBokObj = new zohoAPIClass(AUTHTOKEN_BOOK);
$invoicesAry = array(
 "custom_fields" => [array("api_name"=> "cf_full_llc","value"=>isset($_POST['company-notice']) ? $_POST['company-notice']:""),array("api_name"=> "cf_filing_date","value"=>isset($_POST['filing-date']) ? $_POST['filing-date']:""),array("api_name"=> "cf_type","value"=>isset($_POST['advertise-type']) ? $_POST['advertise-type']:""),array("api_name"=> "cf_email_affidavit","value"=>isset($_POST['AffidavitAddress']) ? true:false),array("api_name"=> "cf_advertise_duration","value"=>isset($_POST['advertise-duration']) ? $_POST['advertise-duration']:""),array("api_name"=> "cf_note","value"=>isset($_POST['note']) ? $_POST['note']:""),array("api_name"=> "cf_notice","value"=>isset($_POST['legalnotice']) ? $_POST['legalnotice']:"")]	

);
$contactArr=$zohoBokObj->updateBookcontacts($contactID, BOOK_ORGID,$contactAry);
$invoiceArr=$zohoBokObj->updateBookinvoice($invoicesID,BOOK_ORGID,$invoicesAry);
$invoiceadd=$zohoBokObj->updateBookinvoiceAddress($invoicesID,BOOK_ORGID,$invArr);
//error_log("=====contactArr=========>".print_r($contactArr,true));
//error_log("=====invoiceArr=========>".print_r($invoiceArr,true));
//error_log("=====invoiceAdd=========>".print_r($invoiceadd,true));
header("location: " . "thankyou.html");

}else {
$siteUrl="https://altamontenterprise.com";
header("location: " . $siteUrl);
}


?>