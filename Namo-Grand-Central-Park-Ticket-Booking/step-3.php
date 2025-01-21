<?php
session_start(); // Start the PHP session function

include_once('db.php');
include_once('config.php');
include_once('security.php');

if (isset($_SESSION['ccart'])) {
    $cart = $_SESSION['ccart'];
    $cartcount = count($cart);
    // print_r($cart);
    // print_r($_SESSION);

    if ($cartcount === 0) {
        header("Location: index.php?error=emptycart");
        exit; // Exit after redirection
    }else{
        if(isset($_SESSION['cpricecard']))
                    {
                        $pricecard = $_SESSION['cpricecard'];
                        $cardcount = count($pricecard);
                        for($i = 0; $i < $cardcount; $i++)
                        {
                            for($j = 0; $j < $cartcount; $j++)
                            {
                                if($pricecard[$i]->CODE == $cart[$j]->code)
                                {
                                    $ticketamount = $pricecard[$i]->TICKETAMOUNT;
                                    $quantity =  $cart[$j]->quantity;
                                    
                                    $total_amount = $ticketamount * $quantity;

                                    $cart[$j]->totalamount = $total_amount;
                                }
                            }
                        }
                    }
    }

   
} else
    {
        header("Location: index.php");
        var_dump("Hi cart isset false");
    }

    if(!isset($_SESSION['cuser']))
    {
        var_dump("Hi user isset false");
        header("Location: step2.php");
    }

    if(!isset($_SESSION['cdate']))
    {
        header("Location: index.php");
        var_dump("Hi date isset false");
        
    }
    $sql = 'SELECT * FROM orderdetails ORDER BY orderdetails_id DESC LIMIT 1';

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $last_booking_number = $row["bookingnumber"];

            $last_booking_number2 = $last_booking_number + 1;
            $BOOKINGNUMBER = $last_booking_number2;
        }
    } else {
        $BOOKINGNUMBER = '2000000';
    }



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = isset($_SESSION['cuser']) ? $_SESSION['cuser'] : new stdClass();

    $user->full_name = $_POST['full_name'];
    $user->email_id = $_POST['email_id'];
    $user->countrycode = $_POST['countrycode'];
    $user->mobile_no = $_POST['mobile_no'];
    $user->area_location = $_POST['area_location'];

    $_SESSION['cuser'] = $user;

    header("Location: step-4.php");
    exit; // Exit after redirection

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ticket Booking</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/favicon.png" type="image/png" sizes="16x16">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/dnSlide.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="css/msdropdown/dd.css" />
    <link rel="stylesheet" type="text/css" href="css/msdropdown/flags.css" />
    <link rel="stylesheet" type="text/css" href="css/animate.css" media="screen">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.1/assets/owl.carousel.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/css/lightbox.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.css">
</head>

<body>

    <div class="main2">
        <div class="container container2">
            <a href="index.php"><img src="images/logo.png"></a>
        </div>
    </div>
   
    <div class="stepper-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <a class="btn back-btn" href="step-2.php">Back</a>
                </div>
            
                <div class="col-12 col-md-1 col-lg-1 col-xl-1">

                </div>
                <div class="col-12 col-md-10 col-lg-10 col-xl-10">
                    <ul class="list-unstyled multi-steps">
                        <li id="step-1">
                            Tickets
                            <div class="progress-bar progress-bar--success">
                                <div class="progress-bar__bar">

                                </div>
                        </li>
                        <li id="step-2">
                            Your Details
                            <div class="progress-bar progress-bar--success">
                                <div class="progress-bar__bar">

                                </div>
                        </li>
                        <li id="step-3" class="is-active">
                            Review Order
                            <div class="progress-bar progress-bar--success">
                                <div class="progress-bar__bar">

                                </div>
                        </li>
                        <li id="step-4">
                            Payments
                            <div class="progress-bar progress-bar--success">
                                <div class="progress-bar__bar">

                                </div>
                        </li>
                        <li id="step-5">
                            Summary
                        </li>
                    </ul>
                </div>
                <div class="col-12 col-md-1 col-lg-1 col-xl-1">

                </div>
            </div>
        </div>
    </div>

    <section class="emb-join-wrap">
        <div class="container">
           <div class="row">
                    <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="emb-bg">
                            <h4 class="text-body-m wloRE">
                                <span>Customer Details</span>
                                <a href="step-2.php" class="edit_info">Edit</a>
                            </h4>
                            <div class="row">
                                <div class="col-5 col-md-5 col-lg-3 col-xl-3">
                                    <p>Full Name</p>
                                </div>
                                <div class="col-7 col-md-7 col-lg-9 col-xl-9">
                                    <p><?php echo isset($_SESSION['cuser']) ? $_SESSION['cuser']->full_name : ''; ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5 col-md-5 col-lg-3 col-xl-3">
                                    <p>Email ID</p>
                                </div>
                                <div class="col-7 col-md-7 col-lg-9 col-xl-9">
                                    <p><?php echo isset($_SESSION['cuser']) ? $_SESSION['cuser']->email_id : ''; ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5 col-md-5 col-lg-3 col-xl-3">
                                    <p>Phone No</p>
                                </div>
                               <div class="col-7 col-md-7 col-lg-9 col-xl-9">
                    <p>
                        (<?php echo isset($_SESSION['cuser']) ? '+91' . $_SESSION['cuser']->countrycode : ''; ?>)
                        <?php echo isset($_SESSION['cuser']) ? $_SESSION['cuser']->mobile_no : ''; ?>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-5 col-md-5 col-lg-3 col-xl-3">
                    <p>Area/Location</p>
                </div>
                <div class="col-7 col-md-7 col-lg-9 col-xl-9">
                    <p><?php echo isset($_SESSION['cuser']) ? $_SESSION['cuser']->area_location : ''; ?></p>
                </div>
            </div>
        </div>
    </div>
                <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="emb-bg">
                        <h4>Review Order</h4>
                        <div class="row">
                            <div class="col-md-4">
                                <h4 class="text-body-m wloRE emb-ext">
                                    <span>Ticket Details</span>
                                </h4>
                            </div>
                            <div class="col-md-4">
                                <h4 class="text-body-m wloRE emb-ext">
                                    <span>Quantity</span>
                                </h4>
                            </div>
                            <div class="col-md-4">
                                <h4 class="text-body-m wloRE emb-ext">
                                    <span>Rate</span>
                                </h4>
                            </div>
                        </div>
                             <?php 
                                                        $cart = $_SESSION['ccart'];
                                                        $user = $_SESSION['cuser'];

                                                        
                                                        $cartcount = count($cart);
                                                        $totalfinalamount = 0.00;
                                                        $total_cgst = 0.00;
                                                        $total_sgst = 0.00;
                                                        $subtotal = 0.00;

                                                        for($i = 0; $i < $cartcount; $i++)
                                                        {
                                                            $totalfinalamount = (float)$cart[$i]->totalamount + $totalfinalamount;
                                                            // $total_cgst = ($totalfinalamount / 120) * (float)$cart[$i]->cgstrate;
                                                            // $total_sgst = ($totalfinalamount / 120) * (float)$cart[$i]->sgstrate;
                                                            
                                                    ?>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            
                                                            <p><?php echo $cart[$i]->name ?></p>
                                                        </div>
                                                        <div class="col-md-4">
                                                           
                                                            <p><?php echo $cart[$i]->quantity;?></p>
                                                        </div>
                                                        <div class="col-md-4">
                                                           
                                                            <p><?php echo $cart[$i]->ticketamount ?> <i class="fa fa-inr" aria-hidden="true"></i></p>
                                                        </div>
                                                    </div>
                                                    <!-- 
                                                      <tr class="odd views-row-first views-row-last">
                                                         <td class="views-field views-field-title-1">
                                                                      
                                                         </td>
                                                         <td class="views-field views-field-nothing-1">
                                                            <div class="data_des"><?php// echo $cart[$i]->description ?></div>
                                                            <span class="Weekend Delight - Experience Bundle"></span>
                                                            <div class="pickup_point_details"></div>
                                                         </td>
                                                         <td class="views-field views-field-commerce-unit-price price center-align">
                                                            <?php //echo $cart[$i]->ticketamount ?>  USD          
                                                         </td>
                                                         <td class="views-field views-field-qty-hotel center-align">
                                                            <span class="qty-nmbr"></span>          
                                                         </td>
                                                         <td class="views-field views-field-commerce-total price">
                                                            <?php// echo $cart[$i]->totalamount ?>  USD          
                                                         </td>
                                                      </tr> -->
                                                    <?php
                                                      }
                                                      $tax_total = $total_cgst + $total_sgst;
                                                      $subtotal = $totalfinalamount - $tax_total;
                                                    ?>

                        <hr class="emb-hr-1">
                        <h4 class="text-body-m wloRE emb-ext">
                            <span>Cart Total</span>
                            <span><?=$totalfinalamount?> <i class="fa fa-inr" aria-hidden="true"></i></span>
                        </h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                   <div class="emb-bg mt-25">

                        <h4 class="emb-ext">Refund & Cancellation Policy :</h4>
                        <p class="emb-policy-text"> 

                    Please be aware that all ticket sales made through our online platform are considered final. Once a ticket purchase is confirmed and processed, no refunds or cancellations will be granted.
                    By proceeding with your ticket purchase, you acknowledge and accept the terms of this no-refund policy. It is important to carefully review all details of your selected event before completing your transaction.

                        </p>
                         <h4 class="emb-ext">Park Rules, Cookie and Privacy Policy :</h4>
                        <p class="emb-policy-text">This document is an electronic record published in accordance under for access or usage of www.namograndcentralpark.com website. User agrees to adhere to the Park Rules, Cookie & Privacy Policy related to the use of www.namograndcentralpark.com (“Website”).</p>

                    <form method="post" action="ccavenue/ccavRequestHandler.php">
                        <input type="hidden" name="tid" id="tid" readonly />
                        <input type="hidden" name="merchant_id" value="3195148"/>
                        <input type="hidden" name="order_id" value="<?=$BOOKINGNUMBER?>"/> 
                        <input type="hidden" name="amount" value="<?=round($totalfinalamount, 2)?>"/>
                        <input type="hidden" name="currency" value="INR"/>
                        <input type="hidden" name="redirect_url" value="https://booking.namograndcentralpark.com/UAT3/ccavenue/ccavResponseHandler.php"/>
                        <input type="hidden" name="cancel_url" value="https://booking.namograndcentralpark.com/UAT3/ccavenue/ccavResponseHandler.php"/>
                        <input type="hidden" name="language" value="EN"/>
                    <p class="simple-reg-terms">
                <label>
                    <span class="checkbox">
                        <input title="Please tick" name="accept_terms" type="checkbox" class="required" id="js-accept-terms" />
                    </span> 
                    <span title="Please tick">
                       I agree and accept the above mentioned Refund & Cancellation Policy, Park Rules, Cookie and Privacy Policy.
                    </span>
                </label>
            </p>
            <div class="row">
            <div class="col-12 col-md-4 col-lg-4 col-xl-4">                      
                <button class="btn sub-btn" type="submit" id="continueBtn" disabled>Continue To Payment</button>
              
            </div>
        </div>
        </form>


            <script>
                window.onload = function() {
                   var d = new Date().getTime();
                   document.getElementById("tid").value = d;
                   };
                    // Function to handle checkbox change
                    function handleCheckboxChange() {
                        var checkbox = document.getElementById('js-accept-terms');
                        var continueBtn = document.getElementById('continueBtn');

                        // Enable or disable button based on checkbox status
                        continueBtn.disabled = !checkbox.checked;
                    }

                // Attach the handleCheckboxChange function to checkbox change event
                document.getElementById('js-accept-terms').addEventListener('change', handleCheckboxChange);
            </script>

                      </div>
                            </div>
                        </div>
                    </div>
                </section>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="https://jacoblett.github.io/bootstrap4-latest/bootstrap-4-latest.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="./js/dnSlide.js"></script>
    <script type="text/javascript" src="js/wow.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.js"></script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.1/owl.carousel.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/js/lightbox.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="./js/numscroller.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput-jquery.min.js"></script>

    <script>
        let step = 'step3';

        const step1 = document.getElementById('step-1');
        const step2 = document.getElementById('step-2');
        const step3 = document.getElementById('step-3');
        const step4 = document.getElementById('step-4');
        const step5 = document.getElementById('step-5');

        function next() {
            if (step === 'step1') {
                step = 'step2';
                step1.classList.remove("is-active");
                $(step1).find('.progress-bar__bar').css('transform', 'translateX(100%)');
                $(step1).find('.progress-bar__bar').css('-webkit-transform', 'translateX(100%)');
                step2.classList.add("is-active");
            } else if (step === 'step2') {
                step = 'step3';
                step2.classList.remove("is-active");
                $(step2).find('.progress-bar__bar').css('transform', 'translateX(100%)');
                $(step2).find('.progress-bar__bar').css('-webkit-transform', 'translateX(100%)');
                step3.classList.add("is-active");
            } else if (step === 'step3') {
                step = 'step4';
                step3.classList.remove("is-active");
                $(step3).find('.progress-bar__bar').css('-webkit-transform', 'translateX(100%)');
                step4.classList.add("is-active");
                window.location.href = "./ccvenue/ccavRequestHandler.php";
            } else if (step === 'step4') {
                step = 'step5';
                step4.classList.remove("is-active");
                $(step4).find('.progress-bar__bar').css('-webkit-transform', 'translateX(100%)');
                step5.classList.add("is-active");
            } else if (step === 'step5') {
                step = 'complete';
                step5.classList.remove("is-active");
            }
        }


    </script>

    <script>
        // -----Country Code Selection
        $("#mobile_code").intlTelInput({
            initialCountry: "in",
            separateDialCode: true,
            allowDropdown: false,
            onlyCountries: ["in"],
            // utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.4/js/utils.js"
        });
        
    </script>


</body>

</html>
