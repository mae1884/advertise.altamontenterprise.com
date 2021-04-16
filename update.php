<?php
ini_set("display_errors",'1');
require 'functions.php';
require 'vendor/autoload.php';
define('AUTHTOKEN_BOOK', 'cb432401a8e8e4386cb71cf465fc0596');
define('BOOK_ORGID', '55454760');
$invoicesID=isset($_GET['id']) ? base64_decode($_GET['id']):"";
$zohoBokObj = new zohoAPIClass(AUTHTOKEN_BOOK);
$response=$zohoBokObj->getInvoiceById(BOOK_ORGID,$invoicesID);
if(empty($response)){
$siteUrl="https://altamontenterprise.com";
header("location: " . $siteUrl);
}
$customfiled=isset($response->invoice->custom_fields) ? $response->invoice->custom_fields:array();
$cf_note="";
$cf_notice="";
$cf_full_llc="";
$cf_filing_date="";
$cf_type="";
$cf_email_affidavit="";
$cf_advertise_duration="";
$cf_start_date="";
$cf_frequency="";
if(!empty($customfiled)){
foreach($customfiled as $ky=>$val){

	foreach($val as $vk=>$vl){
              
			   if($vk=="placeholder" && $vl=="cf_note"){
				    $cf_note=$val->value;
                
			   }
			   if($vk=="placeholder" && $vl=="cf_full_llc"){
				   $cf_full_llc=$val->value;
                
			   }
			   if($vk=="placeholder" && $vl=="cf_filing_date"){
				   $cf_filing_date=$val->value;
                
			   }
			   if($vk=="placeholder" && $vl=="cf_type"){
				   $cf_type=$val->value;
                
			   }
			   if($vk=="placeholder" && $vl=="cf_email_affidavit"){
				   $cf_email_affidavit=$val->value;
                
			   }
			   if($vk=="placeholder" && $vl=="cf_advertise_duration"){
				   $cf_advertise_duration=$val->value;
                
			   }

			  if($vk=="placeholder" && $vl=="cf_start_date"){
				   $cf_start_date=$val->value;
                
			   }
			  if($vk=="placeholder" && $vl=="cf_frequency"){
				   $cf_frequency=$val->value;
                
			   }
			   if($vk=="placeholder" && $vl=="cf_notice"){
				   $cf_notice=$val->value;
                
			   }


			 

	}


}
}

$customerid=isset($response->invoice->customer_id) ? $response->invoice->customer_id:"";
$contresp=$zohoBokObj->getContactByID($customerid,BOOK_ORGID);
/*echo "<pre>";
print_r($contactarray);*/
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge"> -->
        <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
        <!--<title>The Altamont Enterprise</title>-->
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <meta name="keywords" content="legal notices" />
        <!--Roboto google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
        <link href="css/bootstrap.css" rel="stylesheet">       
        <link href="css/font-awesome.css" rel="stylesheet">        
        <link href="css/style.css" rel="stylesheet">  
        <style type="text/css">
            /* textarea needs a line-height for the javascript to work */
            .has-error-notice label {
                color: #a94442;
            }
            .has-error-notice textarea.form-control {
                border-color: #a94442;
            }
            .ta {
                width: 176.24px;
                font-size: 7.5pt;
                text-indent: 11px;
                text-align: justify;
                line-height: 7.6pt;
                font-family: HelveticaNeue;
            }

@font-face {
  font-family: 'HelveticaNeue';
  src: url('fonts/HelveticaNeue.eot') format('embedded-opentype');
  font-weight: normal;
  font-style: normal;
}

@font-face {
  font-family: 'HelveticaNeue';
  src:  url('fonts/HelveticaNeue.woff') format('woff'), 
  url('fonts/HelveticaNeue.ttf')  format('truetype'), 
  url('fonts/HelveticaNeue.svg#HelveticaNeue') format('svg');
  font-weight: normal;
  font-style: normal;
}



        </style>
    </head>   
    <body>

<script type="text/javascript">
var $zoho=$zoho || {};$zoho.salesiq = $zoho.salesiq || 
{widgetcode:"e4165e99289f47b1befb515bc52ea857f765643631fbd0db60322c1ec257a9b83d63947e372f35865608e8c57ce516ec", values:{},ready:function(){}};
var d=document;s=d.createElement("script");s.type="text/javascript";s.id="zsiqscript";s.defer=true;
s.src="https://salesiq.zoho.com/widget";t=d.getElementsByTagName("script")[0];t.parentNode.insertBefore(s,t);d.write("<div id='zsiqwidget'></div>");
</script>

        <header>
            <div class="container">
                <div class="row">
                    <div class="text-center">
                        <h1>The Altamont Enterprise</h1>
                    </div>
                </div>
            </div>
        </header>           

        <section>
            <div class="container">    
                <div class="mainbox col-md-12">
                    <div class="form-horizontal">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="panel-title">
					<?php echo "Publish a legal notice"; ?>
				</div>
                            </div>  
                            <div class="panel-body row" >
                                <div class="alert alert-warning" id="noticAdBlock" style="display: none;">
  <strong>Warning:</strong> THIS FORM DOES NOT WORK WITH AD BLOCKERS.
</div>
                                <div class="col-md-6 col-sm-6">
				<p><?php 
					  $choice = "legalnotice";
					
				?></p>
                                    <form id="formMrcl" enctype="multipart/form-data" method="post" action="resultupdate.php" data-toggle="validator" role="form">
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Publish <span class="error">*</span></label>
                                            <div class="controls col-md-8 ">

                                                <div class="row">
                                                    <img id="successMessage" src="images/loading.gif" alt="">
                                                    <div class="col-md-6">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="radio" id="terms" class="bordered-display-ad"  name="Publish" value="bordered" <?php echo strcmp($choice, 'bordered')?'':'checked' ?> >
                                                                Bordered display ad <?php echo strcmp($choice, 'bordered')?'':'checked' ?>
                                                            </label>
                                                            <div class="help-block with-errors"></div>
                                                        </div>

                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="radio" class="Announcement" value="announcement" name="Publish" <?php echo strcmp($choice, 'announcement')?'':'checked' ?> >
                                                                Announcement  <?php echo strcmp($choice, 'announcement')?'':'checked' ?>
                                                            </label>
                                                            <div class="help-block with-errors"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <?php /*<div class="checkbox">
                                                            <label>
                                                                <input type="radio" id="terms" data-error="Classified listing" value="classifiedlisting" name="Publish">
                                                                Classified listing
                                                            </label>
                                                            <div class="help-block with-errors"></div>
                                                        </div>*/ ?>

                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="radio" name="Publish" value="legalnotice"  class="legal-notice" <?php echo strcmp($choice, 'legalnotice')?'':'checked' ?>>
                                                                Legal notice <?php echo strcmp($choice, 'legalnotice')?'':'checked' ?>
                                                            </label>
                                                            <div class="help-block with-errors"></div>
                                                        </div>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="radio" id="other"  value="other" name="Publish" <?php echo strcmp($choice, 'other')?'':'checked' ?>>
                                                                Other <?php echo strcmp($choice, 'other')?'':'checked' ?>
                                                            </label>
                                                            <div class="help-block with-errors"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputName" class="control-label col-md-4">First name <span class="error">*</span></label>
                                            <div class="controls col-md-8 ">
                                                <input type="text" class="form-control" value="<?php echo isset($contresp->contact->first_name) ? $contresp->contact->first_name:""; ?>" name="fname" placeholder="" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-4">Last name </label>
                                            <div class="controls col-md-8 ">
                                                <input type="text" class="form-control" value="<?php echo isset($contresp->contact->last_name) ? $contresp->contact->last_name:""; ?>" name="lname" placeholder="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-4">Company </label>
                                            <div class="controls col-md-8 ">
                                                <input type="text" class="form-control" value="<?php echo isset($contresp->contact->company_name) ? $contresp->contact->company_name:""; ?>" name="company" placeholder="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-4">Phone </label>
                                            <div class="controls col-md-8 ">
                                                <input type="text" class="form-control" value="<?php echo isset($response->invoice->phone) ? $response->invoice->phone:""; ?>" name="phone" placeholder="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-4">Email <span class="error">*</span></label>
                                            <div class="controls col-md-8 ">
                                                <input type="email" class="form-control"  value="<?php echo isset($contresp->contact->email) ? $contresp->contact->email:""; ?>" readonly="readonly" name="email" placeholder="" required>
                                            </div>
                                        </div>
                                         
										  <div class="form-group">
                                                <label class="control-label col-md-4">Type<?php echo $cf_type; ?></label>
                                                <div class="controls col-md-8 ">
                                                    <select name="advertise-type" class="form-control">
                                                        <option <?php if ($cf_type=="Domestic") { ?>selected="selected"<?php } ?> value="Domestic" >Domestic</option>
                                                        <option <?php if ($cf_type=="Foreign") { ?>selected="selected"<?php } ?>  value="Foreign">Foreign</option>
                                                        <option <?php if ($cf_type=="Public") { ?>selected="selected"<?php } ?>  value="Public">Public</option>
                                                    </select>
                                                </div>
                                          </div>
										  <div class="form-group" name="company-notice-div">
                                            <label class="control-label col-md-4">Full LLC/LP name <span class="error">*</span></label>
                                            <div class="controls col-md-8 ">
                                                <input type="text" class="form-control" value="<?php echo isset($cf_full_llc) ? $cf_full_llc:""; ?>" name="company-notice" placeholder="" required>
                                            </div>
                                        </div>
                                        <div class="form-group" name="filing-date">
                                            <label class="control-label col-md-4">Filing Date <span class="error">*</span></label>
                                            <div class="controls col-md-8 ">
                                                <input type="text" class="form-control" value="<?php echo isset($cf_filing_date) ? $cf_filing_date:""; ?>"  name="filing-date" placeholder="" required>
                                            </div>
                                        </div>
                                         
                                        <div class="form-group legal_note_affd" style="display: none;">
                                            <label class="control-label col-md-4"></label>
                                            <div class="controls col-md-8 ">
                                                <div class="note">
                                                    Note: Below, use mailing address for the affidavit.
                                                </div>
                                            </div>
                                        </div>

					<div class="form-group">
                                                <label class="control-label col-md-4"></label>
                                                <div class="controls col-md-8 ">
        	                                        <div class="checkbox">
							<label>
							<input type="checkbox" class="AffidavitAddress" style="position:relative;" id="AffidavitAddress" onchange="valueChanged()" name="AffidavitAddress" checked>
                        	                        Mailing and service address are the same</label>
                                        	        </div>
						</div>
					</div>

                                                      <div class="mt10 answer" style="display: none;">
                                                      <div class="form-group">
                                                      <label class="control-label col-md-4">Service address <span class="error">*</span> </label>
                                                      <div class="controls col-md-8 ">
                                                      <input type="text" class="form-control" value="<?php echo isset($contresp->contact->shipping_address->address) ? $contresp->contact->shipping_address->address:"";  ?>" name="billingaddress_afadd" placeholder="" >
                                                      </div>
                                                      </div>

                                                      <div class="form-group">
                                                      <label class="control-label col-md-4">City <span class="error">*</span> </label>
                                                      <div class="controls col-md-8 ">
                                                      <input type="text" class="form-control" value="<?php echo isset($contresp->contact->shipping_address->city) ? $contresp->contact->shipping_address->city:"";  ?>"  name="city_afadd" placeholder="" >
                                                      </div>
                                                      </div>

                                                      <div class="form-group">
                                                      <label class="control-label col-md-4">State <span class="error">*</span> </label>
                                                      <div class="controls col-md-8 ">
                                                      <input type="text" class="form-control"  value="<?php echo isset($contresp->contact->shipping_address->state) ? $contresp->contact->shipping_address->state:"";  ?>"  name="state_afadd" placeholder="" >
                                                      </div>
                                                      </div>

                                                      <div class="form-group">
                                                      <label class="control-label col-md-4">ZIP code <span class="error">*</span> </label>
                                                      <div class="controls col-md-8 ">
                                                      <input type="text" class="form-control" value="<?php echo isset($contresp->contact->shipping_address->zip) ? $contresp->contact->shipping_address->zip:"";  ?>"  name="zipcode_afadd" placeholder="" >
                                                      </div>
                                                      </div>
                                                      </div>


                                        <div class="form-group">
                                            <label class="control-label col-md-4">
					<?php if ($choice == "legalnotice") { echo "Mail affidavit to:"; } else { echo "Billing address"; } ?>
					<span class="error">*</span> </label>
                                            <div class="controls col-md-8 ">
                                                <input type="text" class="form-control"  value="<?php echo isset($contresp->contact->billing_address->address) ? $contresp->contact->billing_address->address:"";  ?>" name="billingaddress" placeholder="" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-4">City <span class="error">*</span> </label>
                                            <div class="controls col-md-8 ">
                                                <input type="text" class="form-control" value="<?php echo isset($contresp->contact->billing_address->city) ? $contresp->contact->billing_address->city:"";  ?>"  name="city" placeholder="" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-4">State <span class="error">*</span> </label>
                                            <div class="controls col-md-8 ">
                                                <input type="text" class="form-control" value="<?php echo isset($contresp->contact->billing_address->state) ? $contresp->contact->billing_address->state:"";  ?>" name="state" placeholder="" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-4">ZIP code <span class="error">*</span> </label>
                                            <div class="controls col-md-8 ">
                                                <input type="text" class="form-control" value="<?php echo isset($contresp->contact->billing_address->zip) ? $contresp->contact->billing_address->zip:"";  ?>"  name="zipcode" placeholder="" required>
                                            </div>
                                        </div>

                                        <!-- Bordered display ad -->
                                        <div class="bordered-display-ad-data" style="display: none;">
                                            <div class="form-group">
                                                <label class="control-label col-md-4">File upload</label>
                                                <div class="controls col-md-8 ">
                                                    <input type="file" class="form-control" name="fileupload3" id="fileupload3">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Legal notice Data -->
                                        <div class="legal-notice-data" style="display: none;">

                                            <div class="form-group">
                                                <label class="control-label col-md-4"></label>
                                                <div class="controls col-md-8 "> 
                                                <?php /*
                                                      <div class="checkbox">
                                                      <label>
                                                      <input type="checkbox" class="AffidavitAddress" id="terms" onchange="valueChanged()" name="affidavitaddress"> Affidavit address (check if different from above)
                                                      </label>

                                                      </div>
						
                                                      <div class="mt10 answer" style="display: none;">
                                                      <div class="form-group">
                                                      <label class="control-label col-md-4">Billing address <span class="error">*</span> </label>
                                                      <div class="controls col-md-8 ">
                                                      <input type="text" class="form-control"  name="billingaddress_afadd" placeholder="" >
                                                      </div>
                                                      </div>

                                                      <div class="form-group">
                                                      <label class="control-label col-md-4">City <span class="error">*</span> </label>
                                                      <div class="controls col-md-8 ">
                                                      <input type="text" class="form-control"  name="city_afadd" placeholder="" >
                                                      </div>
                                                      </div>

                                                      <div class="form-group">
                                                      <label class="control-label col-md-4">State <span class="error">*</span> </label>
                                                      <div class="controls col-md-8 ">
                                                      <input type="text" class="form-control"  name="state_afadd" placeholder="" >
                                                      </div>
                                                      </div>

                                                      <div class="form-group">
                                                      <label class="control-label col-md-4">ZIP code <span class="error">*</span> </label>
                                                      <div class="controls col-md-8 ">
                                                      <input type="text" class="form-control"  name="zipcode_afadd" placeholder="" >
                                                      </div>
                                                      </div>
                                                      </div>
                                                     */ 
							if ($choice != "legalnotice") { ?>
                                                    <div class="mt10 note">
                                                        <p>Choose the number of weeks of publication below and add the text you want published as a legal notice in the box. <b>Do not enter any text in the box that should not be published (e.g. request letter, instructions, "LEGAL NOTICE")</b> in the box that should not be published. We will format it and email a proof and invoice. <b>Pay the invoice in order to start publication.</b></p>
                                                        <p>Below is an example of a common notice for a six-week domestic LLC, but it may not resemble the kind you need. <b>This is not legal advice.</b> <a href="https://altamontenterprise.com/legal-notices" target="_blank">Click here to find out more about legal notices and see examples.</a></p>
                                                        <p><i>Notice of formation of ABC123, LLC. Art. Of Org. filed with the Sect’yof State of NY (SSNY) on 11/09/18. Office in Albany County. SSNY has been designated as agent of the LLC upon whom process against it may be served. SSNY shall mail process to the LLC, 695 E 4th St Apt 4D Brooklyn, NY, 11230. Purpose: Any lawful purpose.</i></p>
                                                    </div>
							<?php } else { ?>
                                                      <div class="checkbox">
                                                      <label>
                                                      <input type="checkbox" style="position:relative;" id="email-affidavit" name="email-affidavit" checked>
							Email me a scanned affidavit $10
                                                      </label>

                                                      </div>

                                                    <div class="mt10 note">
							<p>The text below is your notice. Review and edit it before clicking "Submit."</p>
							<p>Do not enter any text in the box that should not be published.</p>
							<p>Check your inbox for the invoice. Pay the invoice in order to start publication.</p>
							<p>Below is an example of a common notice for a six-week domestic LLC, but it may not resemble the kind you need. This is not legal advice. <a href="https://www.dos.ny.gov/corps/llccorp.html#artorg" target=_blank>Click here to find out more about legal notices</a>.</p>
                                                    </div>

							<?php } ?>
                                                </div>
                                            </div>

                                            <?php /* <div class="form-group">
                                              <label class="control-label col-md-4">Number of consecutive runs</label>
                                              <div class="controls col-md-8 ">
                                              <input type="text" class="form-control" name="runs" placeholder="">
                                              </div>
                                              </div> */ ?>

                                        

                                            <div class="form-group" name="num-weeks" style="display:none;">
                                                <label class="control-label col-md-4">Number of weeks</label>
                                                <div class="controls col-md-8 ">
                                                    <select name="advertise-duration" class="form-control">
                                                        <option <?php if ($cf_advertise_duration=="One-week legal notice") { ?>selected="selected"<?php } ?>   value="One-week legal notice">One-week legal notice</option>
                                                        <option <?php if ($cf_advertise_duration=="Two-week legal notice") { ?>selected="selected"<?php } ?>  value="Two-week legal notice">Two-week legal notice</option>
                                                        <option <?php if ($cf_advertise_duration=="Three-week legal") { ?>selected="selected"<?php } ?>  value="Three-week legal notice">Three-week legal notice</option>
                                                        <option <?php if ($cf_advertise_duration=="Four-week legal") { ?>selected="selected"<?php } ?>  value="Four-week legal notice">Four-week legal notice</option>
                                                        <option <?php if ($cf_advertise_duration=="Six-week legal notice") { ?>selected="selected"<?php } ?>  value="Six-week legal notice">Six-week legal notice</option>
                                                    </select>
                                                </div>
                                            </div>
                                             <div class="form-group" name="start-date-section" style="display:none">
                                            <label class="control-label col-md-4">Start date</label>
                                            <div class="controls col-md-8 ">
                                                <input type="text" value="<?php echo isset($cf_start_date) ? $cf_start_date:"";  ?>" class="form-control" name="start-date" placeholder="">
                                            </div>
                                        </div>
                                            <div class="form-group" name="frequency-section" style="display:none;">
                                                <label class="control-label col-md-4">Frequency</label>
                                                <div class="controls col-md-8 ">
                                                    <select name="frequency" class="form-control">
                                                        <option <?php if ($cf_frequency=="consecutive") { ?>selected="selected"<?php } ?>   value="consecutive" selected>consecutive</option>
                                                        <option <?php if ($cf_frequency=="every other week") { ?>selected="selected"<?php } ?>  value="every other week">every other week</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group" id="lgnoic_bx">
                                                <label class="control-label col-md-4">Legal notice</label>
                                                <div class="controls col-md-8 ">
                                                    <textarea class="form-control" id="taTemp" placeholder='OMIT THE WORDS "LEGAL NOTICE"' name="legalnotice" style="overflow-y: scroll;"><?php echo isset($cf_notice) ? $cf_notice:""; ?></textarea>
						    <div name="tempnotice-domestic" style="display:none">
							Notice of formation of <label name="company"></label>. Art. Of Org. filed with the Sect’yof State of NY (SSNY) on <label name="filingdate"></label>. Office in Albany County. SSNY has been designated as agent of the LLC upon whom process against it may be served. SSNY shall mail process to the <label name="company1"></label>  <label name="address"></label> <label name="city"></label> <label name="state"></label> <label name="zip"></label>. Purpose: Any lawful purpose.
						    </div>
                                                    <div name="tempnotice-foreign" style="display:none">
Notice of qualification (foreign) of<label name="company"></label>. Application for Authority filed with NY Secretary of State (NS) on <label name="filingdate"></label>, office location: Albany County, <label name="company1"></label> is designated as agent upon whom process may be served, NS shall mail service of process (SOP) to [Company], [Service address] is designated as agent for SOP at [Service address if no agent], purpose: any lawful purpose.
                                                    </div>
                                                    <small class="text-danger" id="lines-error" style="display: none;">Legal notice text insufficient. Notices are typically no less than 5 lines. Turn off any ad blockers.</small>
                                                    <small><div id="lines" style="display:none"></div></small>       
                                                </div>
                                            </div>

                                        

                                        <!-- Announcement  Data-->
                                        <div class="announcement-data" style="display: none;">
                                            <div class="form-group">
	                                                <label class="control-label col-md-4"></label>      
                                                <div class="controls col-md-8 ">                            <p>Use one or all of these uploaders to send us your photos, ads, or anything else you want to show us.</p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-4">File upload</label>
                                                <div class="controls col-md-8 ">
                                                    <input type="file" class="form-control" name="fileupload1" id="fileupload1">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-4">File upload</label>
                                                <div class="controls col-md-8 ">
                                                    <input type="file" class="form-control" name="fileupload2" id="fileupload2">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-4">Image</label>
                                                <div class="controls col-md-8 ">
                                                    <label class="control-label">Link</label>
                                                    <input type="text" class="form-control"  name="link" placeholder="" >
                                                    <label class="control-label">Local Computer</label>
                                                    <input type="file" class="form-control"  name="localcomputer" id="localcomputer" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group note-text-section">
                                            <label class="control-label col-md-4">Note</label>
                                            <div class="controls col-md-8 ">
                                                <textarea class="form-control" name="note"><?php echo isset($cf_note) ? $cf_note:""; ?></textarea>
                                                <small>Make a note, ask a question, or tell us more about what you're trying to do with your business.</small>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="controls col-md-12 text-center">
                                                <input type="hidden" name="leganoticLinesCount" id="leganoticLinesCount" value="0" />
                                                <input type="hidden" name="invoiceid"  value="<?php echo isset($response->invoice->invoice_id) ? $response->invoice->invoice_id:0; ?>" />
												<input type="hidden" name="contactid"  value="<?php echo isset($response->invoice->customer_id) ? $response->invoice->customer_id:0; ?>" />
                                                <input type="submit" name="Signup" value="Submit" class="btn btn-primary btn btn-info" />
                                                <img id="buttonsubmitImage" src="images/loading.gif" alt="">
                                            </div>
                                        </div><br/><br/><br/><br/><br/>
                                        <div class="controls col-md-8 ">
					<!--<textarea class="form-control" spellcheck="false" id="ta" name="note" style="color: white;    box-shadow: white 0px 1px 1px inset;border-color: white;"></textarea>-->
					</div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </section>
        <!--Jquery Libraries Js-->
        <script src="js/jquery.min.js"></script>
        <!--bootstrap Js-->
        <script src="js/bootstrap.js"></script>     
        <script src="js/validator.js"></script> 
        <textarea class="form-control ta" id="ta" name="note" spellcheck="false" style="color: white;box-shadow: white 0px 1px 1px inset;border-color: white;"></textarea>
        <script>
            $(document).ready(function () {
                $('#myForm').validator();
            });

            // Affidavit Address Checkbox
            function valueChanged()
            {
                if (!$('.AffidavitAddress').is(":checked")) {
                    $(".answer").show();
                    $(".answer input").attr('required', true);
                }
                else {
                    $(".answer").hide();
                    $(".answer input").removeAttr('required');
                }

            }

		function qs(key) {
		    key = key.replace(/[*+?^$.\[\]{}()|\\\/]/g, "\\$&"); // escape RegEx meta chars
		    var match = location.search.match(new RegExp("[?&]"+key+"=([^&]+)(&|$)"));
		    return match && decodeURIComponent(match[1].replace(/\+/g, " "));
		}
		/*if (qs('run')==6) {
		    $('select').prop('selectedIndex', 4);
		    $('select').prop("disabled", true);
		}*/
            // Bordered Display ad Checkbox
            $(document).ready(function () {
		if (!$("input[name='Publish']:checked").val()) {
     		         return false;
		    }
		else {
                   var test = $("input[name='Publish']:checked").val();
		   $("input[name='Publish']:checked").parent().parent().parent().parent().parent().parent().hide();
		   if (test == 'bordered') {
                        $(".bordered-display-ad-data").show();
                    } else {
                        $(".bordered-display-ad-data").hide();
                    }
                    if (test == 'announcement') {
                        $(".announcement-data").show();
                    } else {
                        $(".announcement-data").hide();
                    }
                    if (test == 'legalnotice') {
//                        $("#noticAdBlock").show();
                        $(".legal-notice-data").show();
                        //$(".legal_note_affd").show();
                    } else {
                        $("#noticAdBlock").hide();
                        $(".legal-notice-data").hide();
                        $(".legal_note_affd").hide();
                    }
                };

                $("input[name$='Publish']").click(function () {
                    var test = $(this).val();
                    if (test == 'bordered') {
                        $(".bordered-display-ad-data").show();
                    } else {
                        $(".bordered-display-ad-data").hide();
                    }


                    if (test == 'announcement') {
                        $(".announcement-data").show();
                    } else {
                        $(".announcement-data").hide();
                    }


                    if (test == 'legalnotice') {
                        $("#noticAdBlock").show();
                        $(".legal-notice-data").show();
                        $(".legal_note_affd").show();
                    } else {
                        $("#noticAdBlock").hide();
                        $(".legal-notice-data").hide();
                        $(".legal_note_affd").hide();
                    }
                });
            });

            $(document).ready(function () {
                $(".btn").click(function () {

                    $('#buttonsubmitImage').show();
                    setTimeout(function () {
                        $("#buttonsubmitImage").fadeOut(0);
                    }, 2000)
                });
            });

            // Loading Image
            $(function () {
                setTimeout(function () {
                    $("#successMessage").fadeOut(0);
                }, 1000)
                $('.checkbox input[type="radio"]').click(function () {
                    $('#successMessage').show();
                    setTimeout(function () {
                        $("#successMessage").fadeOut(0);
                    }, 1000)
                })
            })
            var calculateContentHeight = function (ta, scanAmount) {
                var origHeight = ta.style.height,
                        height = ta.offsetHeight,
                        scrollHeight = ta.scrollHeight,
                        overflow = ta.style.overflow;
                /// only bother if the ta is bigger than content
                if (height >= scrollHeight) {
                    /// check that our browser supports changing dimension
                    /// calculations mid-way through a function call...
                    ta.style.height = (height + scanAmount) + 'px';
                    /// because the scrollbar can cause calculation problems
                    ta.style.overflow = 'hidden';
                    /// by checking that scrollHeight has updated
                    if (scrollHeight < ta.scrollHeight) {
                        /// now try and scan the ta's height downwards
                        /// until scrollHeight becomes larger than height
                        while (ta.offsetHeight >= ta.scrollHeight) {
                            ta.style.height = (height -= scanAmount) + 'px';
                        }
                        /// be more specific to get the exact height
                        while (ta.offsetHeight < ta.scrollHeight) {
                            ta.style.height = (height++) + 'px';
                        }
                        /// reset the ta back to it's original height
                        ta.style.height = origHeight;
                        /// put the overflow back
                        ta.style.overflow = overflow;
                        return height;
                    }
                } else {
                    return scrollHeight;
                }
            }

            var calculateHeight = function () {
                var ta = document.getElementById("ta"),
                        style = (window.getComputedStyle) ?
                        window.getComputedStyle(ta) : ta.currentStyle,
                        // This will get the line-height only if it is set in the css,
                        // otherwise it's "normal"
                        taLineHeight = parseInt(style.lineHeight, 10),
                        // Get the scroll height of the textarea
                        taHeight = calculateContentHeight(ta, taLineHeight),
                        // calculate the number of lines
                        numberOfLines = Math.ceil(taHeight / taLineHeight) - 2;
                        window.numberOfLines=numberOfLines;
                document.getElementById("lines").innerHTML = "there are " +
                        numberOfLines + " lines in the Legal Notes";
                $("#leganoticLinesCount").val(numberOfLines);
            };

            var recalcLines = function () {
                    if ($.trim($("#taTemp").val()) != "") {
                        $("#ta").val($.trim($("#taTemp").val()).replace(/\s*[\r\n]+\s*/g, '\n')
                                .replace(/(<[^\/][^>]*>)\s*/g, '$1')
                                .replace(/\s*(<\/[^>]+>)/g, '$1'));
                        calculateHeight();
                    } else {
                        document.getElementById("lines").innerHTML="";
                        numberOfLines = 0;
                    }
            };

            $(document).ready(function () {

		updateAll();
                $('#taTemp').on('keyup keypress blur change', function () {
                    recalcLines();
                });

                $( 'input[name="Publish"]' ).click(function(){
                    if ($(this).val()=='legalnotice') {
                        $('.note-text-section').hide();
                    }else{
                        $('.note-text-section').show();
                    }
                });

                $('#formMrcl').submit(function() {
                    recalcLines();
                    if(window.numberOfLines<5 && $("input[name$='Publish']:checked").val()=="legalnotice"){
                      $("#lgnoic_bx").addClass('has-error-notice');
                      alert($("#lines-error").html());
                      // $("#lines-error").show();
                      return false;
                    }else{
                      $("#lgnoic_bx").removeClass('has-error-notice');
                      // $("#lines-error").hide();
                      return true;
                    }
                });
            });
        </script>

<script>
const company = document.querySelector("input[name='company-notice']");
var notice = document.querySelector("textarea[name='legalnotice']");
const address = document.querySelector("input[name='billingaddress']");
const city = document.querySelector("input[name='city']");
const state = document.querySelector("input[name='state']");
const zip = document.querySelector("input[name='zipcode']");
const filing = document.querySelector("input[name='filing-date']");
const adtype = document.querySelector("select[name='advertise-type']");
const address_afadd = document.querySelector("input[name='billingaddress_afadd']");
const city_afadd = document.querySelector("input[name='city_afadd']");
const state_afadd = document.querySelector("input[name='state_afadd']");
const zip_afadd = document.querySelector("input[name='zipcode_afadd']");


//const result = document.querySelector("div[name='tempnotice-domestic']");
/*
company.addEventListener('change', updateCompany);
address.addEventListener('change', updateAddress);
city.addEventListener('change', updateCity);
state.addEventListener('change', updateState);
zip.addEventListener('change', updateZip);
filing.addEventListener('change', updateFilingDate);
*/
company.addEventListener('change', updateAll);
address.addEventListener('change', updateAll);
city.addEventListener('change', updateAll);
state.addEventListener('change', updateAll);
zip.addEventListener('change', updateAll);
filing.addEventListener('change', updateAll);
adtype.addEventListener('change', updateAll);
address_afadd.addEventListener('change', updateAll);
city_afadd.addEventListener('change', updateAll);
state_afadd.addEventListener('change', updateAll);
zip_afadd.addEventListener('change', updateAll);


function updateAll(e) {
    if (document.querySelector("select[name='advertise-type']").value == "Domestic") {
    notice.value = "Notice of formation of " + company.value + ". Art. Of Org. filed with the Secretary of State of NY (SSNY) on " + filing.value;
    notice.value += ". Office in Albany County. SSNY has been designated as agent of the LLC upon whom process against it may be served. SSNY shall mail process to the " + company.value;
    if ($("input[name='AffidavitAddress']:checked").val()) {
        notice.value += ", " + address.value + ", " + city.value + ", " + state.value + " " + zip.value + ". Purpose: Any lawful purpose.";
    } else {
        notice.value += ", " + address_afadd.value + ", " + city_afadd.value + ", " + state_afadd.value + " " + zip_afadd.value + ". Purpose: Any lawful purpose.";
    }

    document.querySelector("div[name='company-notice-div']").style.display = 'block';
    document.querySelector("div[name='num-weeks']").style.display = 'none';
    document.querySelector("div[name='start-date-section']").style.display = 'none';
    document.querySelector("div[name='frequency-section']").style.display = 'none';
    document.querySelector("div[name='filing-date']").style.display = 'block';
    document.querySelector("select[name='advertise-duration']").value = "Six-week legal notice";
    document.querySelector("input[name='filing-date']").required = true;
	$("input[name='company-notice']").attr('required',true);
    recalcLines();
    } else if (document.querySelector("select[name='advertise-type']").value == "Foreign") {
    notice.value = "Notice of qualification (foreign) of " + company.value + ". Application for Authority filed with NY Secretary of State (NS) on " + filing.value;
    notice.value += ", office location: Albany County, " + company.value + " is designated as agent upon whom process may be served, NS shall mail service of process (SOP) to " + company.value;
    if ($("input[name='AffidavitAddress']:checked").val()) {
        notice.value += ", " + address.value + ", " + city.value + ", " + state.value + " " + zip.value + ". Purpose: Any lawful purpose.";
    } else {
        notice.value += ", " + address_afadd.value + ", " + city_afadd.value + ", " + state_afadd.value + " " + zip_afadd.value + ". Purpose: Any lawful purpose.";
    }

    document.querySelector("div[name='company-notice-div']").style.display = 'block';
    document.querySelector("div[name='num-weeks']").style.display = 'none';
    document.querySelector("div[name='start-date-section']").style.display = 'none';
    document.querySelector("div[name='frequency-section']").style.display = 'none';
    document.querySelector("div[name='filing-date']").style.display = 'block';
    document.querySelector("select[name='advertise-duration']").value = "Six-week legal notice";
    document.querySelector("input[name='filing-date']").required = true;
	$("input[name='company-notice']").attr('required',true);
    recalcLines();
    } else {
    notice.value = "";
    document.querySelector("div[name='company-notice-div']").style.display = 'none';
    document.querySelector("div[name='num-weeks']").style.display = 'block';
    document.querySelector("div[name='start-date-section']").style.display = 'block';
    document.querySelector("div[name='frequency-section']").style.display = 'block';
    document.querySelector("div[name='filing-date']").style.display = 'none';
    document.querySelector("input[name='filing-date']").required = false;
	$("input[name='company-notice']").attr('required',false);
    recalcLines();
    }
}

/*
function updateCompany(e) {
    alert(document.querySelector("select[name='advertise-type']").value == "Domestic")
    //document.querySelector("div[name='tempnotice-domestic']");
    target = document.querySelector("label[name='company']");
    target.textContent = e.target.value;
    target = document.querySelector("label[name='company1']");
    target.textContent = e.target.value;
    notice.value = result.textContent.trim();
}

function updateAddress(e) {
    target = document.querySelector("label[name='address']");
    target.textContent = e.target.value;
    notice.value = result.textContent.trim();
}

function updateCity(e) {
    target = document.querySelector("label[name='city']");
    target.textContent = e.target.value;
    notice.value = result.textContent.trim();
}

function updateState(e) {
    target = document.querySelector("label[name='state']");
    target.textContent = e.target.value;
    notice.value = result.textContent.trim();
}

function updateZip(e) {
    target = document.querySelector("label[name='zip']");
    target.textContent = e.target.value;
    notice.value = result.textContent.trim();
}

function updateFilingDate(e) {
    target = document.querySelector("label[name='filingdate']");
    target.textContent = e.target.value;
    notice.value = result.textContent.trim();
}
*/
</script>
    </body>
</html>
