<?php
require 'functions.php';

define('AUTHTOKEN_BOOK', 'cb432401a8e8e4386cb71cf465fc0596');
define('BOOK_ORGID', '55454760');


$zohoBokObj = new zohoAPIClass(AUTHTOKEN_BOOK);
$zohoBokObj->invoiceId=$_POST['invoiceId'];
$zohoBokObj->templateId=$_POST['templateId'];
$zohoBokObj->email_temp=$_POST['emailtemplateid'];
$response=$zohoBokObj->sendEmailToInvoiceData(BOOK_ORGID);
echo json_encode($response);
