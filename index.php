<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge"> -->
        <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
        <!--<title>The Altamont Enterprise</title>-->
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <!--Roboto google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
        <link href="css/bootstrap.css" rel="stylesheet">       
        <link href="css/font-awesome.css" rel="stylesheet">        
        <link href="css/style.css" rel="stylesheet">  
        <style type="text/css">
            /* textarea needs a line-height for the javascript to work */
            .ta {
                width: 176.24px;
                font-size: 7.5pt;
                text-indent: 11px;
                text-align: justify;
                line-height: 7.6pt;
                font-family: MyWebFont;
            }
            @font-face {
                font-family: 'MyWebFont';
                src: url('demo/HelveticaNeue.ttf'); 
            }
        </style>
    </head>   
    <body>
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
                                <div class="panel-title">Advertise in The Enterprise</div>
                            </div>  
                            <div class="panel-body row" >
                                <div class="col-md-6 col-sm-6">
                                    <form enctype="multipart/form-data" method="post" action="result.php" data-toggle="validator" role="form">
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Publish <span class="error">*</span></label>
                                            <div class="controls col-md-8 ">

                                                <div class="row">
                                                    <img id="successMessage" src="images/loading.gif" alt="">
                                                    <div class="col-md-6">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="radio" id="terms" class="bordered-display-ad"  name="Publish" value="bordered">
                                                                Bordered display ad
                                                            </label>
                                                            <div class="help-block with-errors"></div>
                                                        </div>

                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="radio" class="Announcement" value="announcement" name="Publish">
                                                                Announcement
                                                            </label>
                                                            <div class="help-block with-errors"></div>
                                                        </div>

                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="radio" id="other"  value="other" name="Publish">
                                                                Other
                                                            </label>
                                                            <div class="help-block with-errors"></div>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="radio" id="terms" data-error="Classified listing" value="classifiedlisting" name="Publish">
                                                                Classified listing
                                                            </label>
                                                            <div class="help-block with-errors"></div>
                                                        </div>

                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="radio" name="Publish" value="legalnotice"  class="legal-notice">
                                                                Legal notice
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
                                                <input type="text" class="form-control" name="fname" placeholder="" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-4">Last name </label>
                                            <div class="controls col-md-8 ">
                                                <input type="text" class="form-control" name="lname" placeholder="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-4">Company </label>
                                            <div class="controls col-md-8 ">
                                                <input type="text" class="form-control" name="company" placeholder="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-4">Phone </label>
                                            <div class="controls col-md-8 ">
                                                <input type="text" class="form-control" name="phone" placeholder="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-4">Email <span class="error">*</span></label>
                                            <div class="controls col-md-8 ">
                                                <input type="email" class="form-control"  name="email" placeholder="" required>
                                            </div>
                                        </div>
                                        <div class="form-group legal_note_affd" style="display: none;">
                                            <label class="control-label col-md-4"></label>
                                            <div class="controls col-md-8 ">
                                                <div class="note">
                                                Note: Please add your address where Affidavit will be sent
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Billing address <span class="error">*</span> </label>
                                            <div class="controls col-md-8 ">
                                                <input type="text" class="form-control"  name="billingaddress" placeholder="" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-4">City <span class="error">*</span> </label>
                                            <div class="controls col-md-8 ">
                                                <input type="text" class="form-control"  name="city" placeholder="" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-4">State <span class="error">*</span> </label>
                                            <div class="controls col-md-8 ">
                                                <input type="text" class="form-control"  name="state" placeholder="" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-4">ZIP code <span class="error">*</span> </label>
                                            <div class="controls col-md-8 ">
                                                <input type="text" class="form-control"  name="zipcode" placeholder="" required>
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
                                                    */ ?>
                                                    <div class="mt10 note">
                                                        <p>Add the text you want published as a legal notice in the box below. We will format it and send a proof and cost estimate to your email. Please note, your notice won't be published without an approval email by the Monday before Thursday publication. </p>

                                                        <p>To find out more about legal notices and see examples, visit our <a href="https://altamontenterprise.com/legal-notices" target="_blank">Website</a></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php /* <div class="form-group">
                                              <label class="control-label col-md-4">Number of consecutive runs</label>
                                              <div class="controls col-md-8 ">
                                              <input type="text" class="form-control" name="runs" placeholder="">
                                              </div>
                                              </div> */ ?>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Number of consecutive runs</label>
                                                <div class="controls col-md-8 ">
                                                    <select name="advertise_duration" class="form-control">
                                                        <option value="One-week legal notice">One-week legal notice</option>
                                                        <option value="Two-week legal notice">Two-week legal notice</option>
                                                        <option value="Three-week legal notice">Three-week legal notice</option>
                                                        <option value="Four-week legal notice">Four-week legal notice</option>
                                                        <option value="Six-week legal notice">Six-week legal notice</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Legal notice</label>
                                                <div class="controls col-md-8 ">
                                                    <textarea class="form-control ta" id="taTemp" placeholder='OMIT THE WORDS "LEGAL NOTICE"' name="legalnotice"></textarea>										<small><div id="lines"></div></small>	    
                                                </div>
                                            </div>

                                        </div>

                                        <!-- Announcement  Data-->
                                        <div class="announcement-data" style="display: none;">
                                            <div class="form-group">
                                                <label class="control-label col-md-4"></label>		
                                                <div class="controls col-md-8 ">						    <p>Use one or all of these uploaders to send us your photos, ads, or anything else you want to show us.</p>
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

                                        <div class="form-group">
                                            <label class="control-label col-md-4">Note</label>
                                            <div class="controls col-md-8 ">
                                                <textarea class="form-control" name="note"></textarea>
                                                <small>Make a note, ask a question, or tell us more about what you're trying to do with your business.</small>
                                            </div>
                                        </div>

                                        <div class="form-group"> 		                            
                                            <div class="controls col-md-12 text-center">
                                                <input type="hidden" name="leganoticLinesCount" id="leganoticLinesCount" value="0" />
                                                <input type="submit" name="Signup" value="Submit" class="btn btn-primary btn btn-info" />
                                                <img id="buttonsubmitImage" src="images/loading.gif" alt="">
                                            </div>
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
        <textarea class="form-control ta" id="ta" name="note" style="color: white;    box-shadow: white 0px 1px 1px inset;border-color: white;"></textarea>
        <script>
                                                                $(document).ready(function () {
                                                                    $('#myForm').validator();
                                                                });

                                                                // Affidavit Address Checkbox
                                                                function valueChanged()
                                                                {
                                                                    if ($('.AffidavitAddress').is(":checked")) {
                                                                        $(".answer").show();
                                                                        $(".answer input").attr('required', true);
                                                                    }
                                                                    else {
                                                                        $(".answer").hide();
                                                                        $(".answer input").removeAttr('required');
                                                                    }
                                                                }
                                                                // Bordered Display ad Checkbox
                                                                $(document).ready(function () {

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
                                                                            $(".legal-notice-data").show();
                                                                            $(".legal_note_affd").show();
                                                                        } else {
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

                                                                    document.getElementById("lines").innerHTML = "there are " +
                                                                            numberOfLines + " lines in the Legal Notes";
                                                                    $("#leganoticLinesCount").val(numberOfLines);
                                                                };

                                                                $(document).ready(function () {

                                                                    $('#taTemp').on('keyup', function () {
                                                                        $("#ta").val($.trim($("#taTemp").val()).replace(/\s*[\r\n]+\s*/g, '\n')
                                                                                .replace(/(<[^\/][^>]*>)\s*/g, '$1')
                                                                                .replace(/\s*(<\/[^>]+>)/g, '$1'));
                                                                        calculateHeight();
                                                                    });

                                                                });
        </script>
    </body>
</html>