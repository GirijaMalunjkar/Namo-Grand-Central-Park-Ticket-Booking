<?php
session_start(); // Start the PHP session function
include ('../db.php');
include ('../config.php');
include ('../security.php');
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

    $barcodes = explode(',',$_GET['barcodes']); 

    include "phpqrcode/qrlib.php";
    foreach ($barcodes as $key => $value) {
        # code...
    
        $data =$value;
        $qrTempDir = 'phpqrcode/temp/';
        if (!file_exists($qrTempDir)) {
            mkdir($qrTempDir, 0777, true);
        }
        $filename = $qrTempDir . $value.'.png';
        $errorCorrectionLevel = 'H';
        $size = 10;
        QRcode::png($data, $filename, $errorCorrectionLevel, $size);
        // echo '<img src="' . $filename . '" alt="QR Code">';
    }

require 'vars.php';
require 'db.php';

$orderid = isset($_GET["orderid"]) ? $_GET["orderid"] : 0000;
$_SESSION['order_id'] = $orderid;

$bookingstatus = false;

$sql = "SELECT payment_status, booking_status FROM orderdetails WHERE bookingnumber ='".$orderid."'";
// var_dump($orderid); die;
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0)   
{
    while($row = mysqli_fetch_assoc($result)) 
    {
         if($row["payment_status"] ==="Success" && $row["booking_status"] ==="Success")
         {
            $bookingstatus = true;
         }
    }
} 


if(!isset($_SESSION["cart"]))
{
    // header("Location: index.php");
}

if(!isset($_SESSION["user"]))
{
    // header("Location: index.php");
}

if(!isset($_SESSION["date"])){
    // header("Location: index.php");
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
            <span style="font-size: x-large;
    font-weight: 600;
    color: #d82b6e;">NaMo Grand Central Park Online Booking Platform</span>
        </div>
    </div>

   

    <div class="stepper-wrapper">
        <div class="container">
            <div class="row">

                <div class="col-md-12" >
                    <a class="btn back-btn" href="delses.php">Back</a>
                        <span style="margin-right: 76%;"></span>
                    <a class="btn back-btn" href="https://namograndcentralpark.com/">Visit Our Site</a>
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
                        <li id="step-3">
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
                        <li id="step-5" class="is-active">
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
                <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="center-align">
                        <img class="emd-md-img" src="<?php if($bookingstatus == true) { echo('images/check-circle.png'); }  else { echo('images/mark.png'); }  ?>" alt="">
                            <h2 style="padding: 0;"><?php if($bookingstatus == true) { echo "BOOKING SUCCESSFUL"; } else { echo "Your Transaction failed!"; }  ?></h2>
                            <p style="padding: 0;"><?php if($bookingstatus == true) { /*echo "Cash collect on the counter.";*/ } else { echo "Your transaction has failed, please try again."; }  ?></p>
                    </div>
                </div> 
            </div> 
            <div class="row">
    <div class="col-12 col-md-12 col-lg-12 col-xl-12">
        <h4 class="text-body-m wloRE-1 emb-ext">
            <span style="display: flex;
                flex-direction: column;">YOUR TICKET NO : <?php echo "#".$orderid ?></span>
           
            <span>
                <button class="btn sub-btn" id="downbtn" onclick="printAndDownload()">PRINT / DOWNLOAD</button>
            </span>
        </h4>
    </div> 
</div>

<script>
    function printAndDownload() {
        $('.stepper-wrapper').css('display','none');
        $('#downbtn').css('display','none');
        // Print functionality
        window.print();

        // Download functionality
        var contentToDownload = document.documentElement.outerHTML; // Entire HTML content
        var blob = new Blob([contentToDownload], { type: 'text/html' });
    //    var a = document.createElement('a');
    //    a.href = URL.createObjectURL(blob);
    //    a.download = 'downloaded_content.html';
    //    a.click();
        $('.stepper-wrapper').css('display','block');
        $('#downbtn').css('display','block');

    }
</script>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="emb-bg">
                        <h4 class="text-body-m wloRE emb-ext" value="<?php echo $_SESSION['cdate']; ?>" min="<?php echo $_SESSION['cdate']; ?>">
                            <span>Booking Date</span>
                            <span id="dateDisplay"><?php echo $_SESSION['cdate']; ?></span>
                        </h4>
                    </div>
                    <div class="emb-bg mt-25">
                        <h4 class="text-body-m wloRE">
                            <span>Customer Details</span> 
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
                                <p>Phone No.</p>
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
                        <h4>Order Detail</h4>
                        <div class="row">
                                        <div class="col-md-12">
                                           <table style="border:none">
                                            <tr>
                                                <th>Particular</th>
                                                <th>Qty</th>
                                                <th>Amount</th>
                                            </tr>
                        <?php 
                              $barcodes = explode(',', $_GET['barcodes']); // [1,2,3]
                              $bi=0;
                              // print_r($barcodes);
                              // echo 'barcodes:'.$_GET['barcodes'];
                              $cart = $_SESSION['ccart'];
                              $cartcount = count($cart);
                              $totalfinalamount = 0.00;
                              $total_cgst = 0.00;
                              $total_sgst = 0.00;
                              $subtotal = 0.00;
                              $morning_evening = $cart[0]->morning_evening;
                              $tickettype= $cart[0]->tickettype;
                              for($i = 0; $i < $cartcount; $i++) // adult - 2 , child - 1 
                              {
                                // echo $barcodes[$bi++];
                                $q=$cart[$i]->quantity;
                                for ($k=0; $k <$q; $k++) { // qty - 2 
                                    // code...
                                    // echo $barcodes[$bi];
                                $totalfinalamount = (float)$cart[$i]->totalamount + $totalfinalamount;

                                $productdata .= '
                                    <table style="border-collapse:collapse;background: #2b31743d;" cellspacing="0" cellpadding="0" border="0" width="285px" align="left" bgcolor="#2b31743d">
                                    <tbody>
                                      <tr>
                                        <td style="padding: 15px 15px;" valign="top"> 
                                          
                                           <br> 
                                           <p>'. (string)$cart[$i]->name .'&nbsp; &nbsp;: &nbsp; '. (string)$cart[$i]->description .'</p>
                                           <br> 
                                           <p>Rate &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : &nbsp;' . (string)$cart[$i]->ticketamount .' Rs.</p>
                                           <br> 
                                           <p>Qty &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: &nbsp; 1</p>
                                           <br> 
                                           <p>Total &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : '. (string)$cart[$i]->totalamount .' Rs.</p>
                                        </td>
                                        <td><img src="phpqrcode/temp/'.(string)$barcodes[$bi].'.png" style="width:100px" alt="Barcode"></td>
                                        </tr>
                                    </tbody>
                                    </table>';
                                     ?> 
                                     
                                            <tr>
                                                <td style="width:20%">
                                            <p><?php echo $cart[$i]->name ?></p>
                                        </td>
                                        <td style="width:20%">
                                       
                                            <p>1</p>
                                        </td>
                                        <td style="width:20%">
                                            <p><?php echo $cart[$i]->ticketamount ?> <i class="fa fa-inr" aria-hidden="true"></i></p>
                                        </td>
                                        <td>
                                            <img src="phpqrcode/temp/<?php echo (string)$barcodes[$bi];?>.png" style="width:100px" alt="Barcode">
                                        </td>
                                    </tr>
                              
                            <?php $bi++;} 
                        }
                        
                                               
                        $curl = curl_init();


                           // Function to shorten a URL using the TinyURL API
                            function shortenURL($url) {
                                $api_url = 'http://tinyurl.com/api-create.php?url=' . urlencode($url);
                                return file_get_contents($api_url);
                            }

                            // Original URL
                            $original_url = "https://booking.namograndcentralpark.com/UAT3/ticketDetails.php?orderid=" . $orderid;

                            // Shorten the URL
                            $shortened_url = shortenURL($original_url);

                            // echo "Shortened URL: " . $shortened_url;

                            curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://e1yq9q.api.infobip.com/sms/2/text/advanced',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode(array(
                                "messages" => array(
                                    array(
                                        "from" => "KPNGCP",
                                        "destinations" => array(
                                            array(
                                                "to" => "91".$_SESSION['cuser']->mobile_no
                                            )
                                        ),
                                        "text" => "Welcome To NaMo Grand Central Park, Thane !!! Your ticket number is ".$orderid.". Check your park ticket/s here ".$shortened_url." . Show your QR code at Gate at the entry/exit -Kalpataru",
                                        "regional" => array(
                                            "indiaDlt" => array(
                                                "principalEntityId" => "1101596160000018848",
                                                "contentTemplateId" => "1107170927485607487"
                                            )
                                        )
                                    )
                                )
                            )),
                            CURLOPT_HTTPHEADER => array(
                                'Authorization: App 807525f9210c519b2c604fdf133237aa-a6b17bad-0b64-494a-b191-635500d35468',
                                'Content-Type: application/json',
                                'Accept: application/json'
                            ),
                        ));

                        $response = curl_exec($curl);
                        // echo $response;

                                                
 
                        ?>
                        </table>

                         <hr class="emb-hr-1">
                         <div class="text-body-m wloRE emb-ext">
                                 <h4 class="text-body-m wloRE" style="display: flex; flex-direction: row; gap: 40px;">
                                    <span>TOTAL</span>
                                    <span><?= $_SESSION['ccartamount'] ?> <i class="fa fa-inr" aria-hidden="true"></i></span>
                                 </h4>
                            </div>

                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <!-- <a class="btn btn-success">Back</a> -->
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
                window.location.href = "step-4.html";
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
            // utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.4/js/utils.js"
        });
    </script>


</body>

</html>


<?php
require 'cmailtest.php';

// $Vdata = file_get_contents('mailtmp.html');

//var_dump($_SESSION);die;

$user = $_SESSION['cuser'];
$to = $user->email_id;
$currentdate = date('d-m-Y');

// var_dump($user);die;
if($bookingstatus == true)
{

    $Vdata = file_get_contents('mailtmp.html');
    $dateObj = DateTime::createFromFormat('d-m-y', $currentdate);
    $Vdata = str_replace('{{visitdate}}',$_SESSION['cdate'], $Vdata);
    $Vdata = str_replace('{{currentdate}}',$currentdate, $Vdata);
    $Vdata = str_replace('{{orderid}}', $orderid, $Vdata);
    $Vdata = str_replace('{{productsdata}}', $productdata, $Vdata);//$productdata
    // echo $productdata;
    $Vdata = str_replace('{{Subtotal}}', floor($subtotal * 100) / 100, $Vdata);
    // $Vdata = str_replace('{{CGST}}', floor(0 * 100) / 100, $Vdata);
    // $Vdata = str_replace('{{SGST}}', floor(0 * 100) / 100, $Vdata);
    $Vdata = str_replace('{{fullname}}', $user->full_name, $Vdata);
    $Vdata = str_replace('{{emailid}}', $user->email_id, $Vdata);
    $Vdata = str_replace('{{phoneno}}', '(+'.$user->countrycode.') '.$user->mobile_no, $Vdata);
    $Vdata = str_replace('{{morning_evening}}', $morning_evening , $Vdata);
    $Vdata = str_replace('{{tickettype}}', $tickettype , $Vdata); 
    $Vdata = str_replace('{{finalamount}}', floor($totalfinalamount * 100) / 100, $Vdata);
    SendAEmail($Vdata, $to, $admin); 

    $bookingmsg="Thanks for your Booking. Your booking ref no is ".$orderid." dated ".$_SESSION['cdate'];
    //$request2 = "http://173.45.76.227/send.aspx?username=shanku&pass=Shanku@123&route=trans1&senderid=SHANKU&numbers=".urlencode($user->mobile_no)."&message=".urlencode($bookingmsg);
                
    //$smassend2=file($request2);

}


// Unset all of the session variables.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
// print_r($_SESSION);
    unset($_SESSION['ccart']);
    unset($_SESSION['cuser']);
    unset($_SESSION['cdate']);
    unset($_SESSION['ccartamount']);

// Finally, destroy the session.
// session_destroy();

?>

