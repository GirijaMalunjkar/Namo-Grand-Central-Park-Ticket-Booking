<?php

session_start(); //start the PHP_session function 
date_default_timezone_set("Asia/Calcutta");

// print_r($cpricecard);

// Default cdate value
$cdate = date("d-m-Y");

// Set cdate in session if not already set
if (!isset($_SESSION['cdate'])) {
    $_SESSION['cdate'] = $cdate;
}

// print_r($_SESSION);

error_reporting(0);

require 'vars.php';

$adults = 0;
$childrens = 0;
$senior = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if($_POST['action'] == "addtocart")
    {
             
        if (isset($_SESSION['ccart']))
        {
            $cart = $_SESSION['ccart'];
            $cartcount = count($cart);
            for ($k = 0; $k < $cartcount; $k++) {
                $ticketType = strtoupper(trim($cart[$k]->tickettype));
                if ($ticketType === 'ADULT') {
                    $adults =intval($adults) +intval($cart[$k]->quantity);
                } elseif ($ticketType === 'CHILD') {
                    $childrens= intval($childrens) +intval($cart[$k]->quantity);
                } elseif ($ticketType === 'SENIOR CITIZEN') {
                    $senior= intval($senior) +intval($cart[$k]->quantity);
                }
            }
           
            $totalallowedchildrens =  ($adults + $senior)*4;
            if($totalallowedchildrens < $childrens && $_POST['tickettype']==='CHILD'){
                $message='4 children’s are allowed along with per Sr. Citizen or per adult ticket booking';
            }else{
                if($_POST['tickettype']==='CHILD' || $_POST['tickettype']==='SENIOR CITIZEN'){
                    $message='Children (Below 15 years) and Sr. Citizens (60 years and above) must carry ID proof issued by Govt.';
                }

                //Do stuff
                $object = new stdClass();
                $object->name = $_POST['cname'];
                $object->code = $_POST['code'];
                $object->description = $_POST['description'];
                $object->ticketamount = $_POST['price'];
                $object->quantity = $_POST['quantity'];
                $object->totalamount = $_POST['total_cost'];
                $object->cgstrate = $_POST['cgst_rate'];;
                $object->cgstamount = $_POST['cgst_amount'];
                $object->sgstrate = $_POST['sgst_rate'];
                $object->sgstamout = $_POST['sgst_amount'];
                $object->category = $_POST['category'];
                $object->class = $_POST['class'];
                $object->subclass = $_POST['subclass'];
                $object->ispriorityticket = $_POST['ispriorityTicket'];
                $object->isprioritypass = $_POST['isprioritypass'];
                $object->tickettype = $_POST['tickettype'];
                $object->morning_evening = $_POST['morning_evening'];
                $object->ticketcount = $_POST['ticketcount'];
                $object->date = $_POST['date'];
                $object->loccode = "MNS";

                $push = true;

                // $cart = $_SESSION['ccart'];
                $_SESSION['collapse'] = $_POST['collapse'];
                // $cartcount = count($cart);
                
                for($i = 0; $i < $cartcount; $i++)
                {
                    if($_POST['morning_evening'] == $cart[$i]->morning_evening){
                        if($_POST['code'] == $cart[$i]->code)
                        {
                            $cart[$i] = $object;
                            $push = false;                        
                            $_SESSION['cdate'] = $_POST['date'];
                            $_SESSION['ccart'] = $cart;
                            $_SESSION['ccartamount'] = $_SESSION['ccartamount'] + $_POST['total_cost'];
                            
                            header("Location: ".$_SERVER['PHP_SELF']);
                            exit();                       
                        
                        }else{
                            $push = false;                       
                            array_push($cart, $object);             
                            $_SESSION['cdate'] = $_POST['date'];
                            $_SESSION['ccart'] = $cart;
                            $_SESSION['ccartamount'] = $_SESSION['ccartamount'] + $_POST['total_cost'];
                            
                            header("Location: ".$_SERVER['PHP_SELF']);
                            exit();                       
                        }
                    }
                    else{
                        $push =false;
                        if($_POST['morning_evening'] == 'CAMERA'){
                            array_push($cart, $object);            
                                $_SESSION['cdate'] = $_POST['date'];
                                $_SESSION['ccart'] = $cart;
                                $_SESSION['ccartamount'] = $_SESSION['ccartamount'] + $_POST['total_cost'];
                                
                                header("Location: ".$_SERVER['PHP_SELF']);
                                exit();
                        }
                        elseif($cartcount == 1 && ($_POST['morning_evening'] == $cart[$i]->morning_evening || $cart[$i]->morning_evening== 'CAMERA')) {
                            array_push($cart, $object);
                            $push =false;
                            $_SESSION['cdate'] = $_POST['date'];
                            $_SESSION['ccart'] = $cart;
                            $_SESSION['ccartamount'] = $_SESSION['ccartamount'] + $_POST['total_cost'];
                            header("Location: ".$_SERVER['PHP_SELF']);
                            exit();
                        }
                        
                    }
                }
            }
        }
        else
        {

            $ticketType = strtoupper(trim($_POST['tickettype']));
                if ($ticketType === 'ADULT') {
                    $adults =intval($adults) +intval($_POST['quantity']);
                } elseif ($ticketType === 'CHILD') {
                    $childrens= intval($childrens) +intval($_POST['quantity']);
                } elseif ($ticketType === 'SENIOR CITIZEN') {
                    $senior= intval($senior) +intval($_POST['quantity']);
                }
            
           
            if($childrens>4 && $_POST['tickettype']==='CHILD'){
                $message='4 children’s are allowed along with per Sr. Citizen or per adult ticket booking';
            }else{
                if($_POST['tickettype']==='CHILD' || $_POST['tickettype']==='SENIOR CITIZEN'){
                    $message='Children (Below 15 years) and Sr. Citizens (60 years and above) must carry ID proof issued by Govt.';
                }
            $cart = array();
            $object = new stdClass();
            $object->name = $_POST['cname'];
            $object->code = $_POST['code'];
            $object->description = $_POST['description'];
            $object->ticketamount = $_POST['price'];
            $object->quantity = $_POST['quantity'];
            $object->totalamount = $_POST['total_cost'];
            $object->cgstrate = $_POST['cgst_rate'];;
            $object->cgstamount = $_POST['cgst_amount'];
            $object->sgstrate = $_POST['sgst_rate'];;
            $object->sgstamout = $_POST['sgst_amount'];
            $object->category = $_POST['category'];
            $object->class = $_POST['class'];
            $object->subclass = $_POST['subclass'];
            $object->ispriorityticket = $_POST['ispriorityTicket'];
            $object->isprioritypass = $_POST['isprioritypass'];
            $object->date = $_POST['date'];
            $object->tickettype = $_POST['tickettype'];
            $object->morning_evening = $_POST['morning_evening'];
            $object->ticketcount = $_POST['ticketcount'];
            $object->collapse = $_POST['collapse'];
            $object->loccode = "MNS";
            array_push($cart, $object);
            $_SESSION['cdate'] = $_POST['date'];
            $_SESSION['ccart'] = $cart;
            $_SESSION['ccartamount'] = $_POST['total_cost'];
            $_SESSION['collapse'] = $_POST['collapse'];
            header("Location: ".$_SERVER['PHP_SELF']);
            }
        }
    }
    else if($_POST['action'] == "removefromcart")
    {
        if(isset($_SESSION['ccart']))
        {
            $cart = $_SESSION['ccart'];
            $newcart = array();
            $removecode = $_POST['code'];
            $cartcount = count($cart);
            $_SESSION['ccartamount'] = $_SESSION['ccartamount'];
            for($i = 0; $i < $cartcount; $i++)
            {
                if($removecode == $cart[$i]->code)
                {
                    $_SESSION['ccartamount'] = round($_SESSION['ccartamount'],2) - round($cart[$i]->totalamount,2);
                }
                else
                {
                    array_push($newcart, $cart[$i]);
                }
            }   
            $_SESSION['ccart'] = $newcart; 
            $_SESSION['collapse'] = '';
            
            if (isset($_SESSION['ccart']) && count($_SESSION['ccart']) == 0) {
                header("Location: delses.php");
            } else {
            }                                           
        }else{
            header("Location: delses.php");                                                  
        
        }
    }
    else if($_POST['action'] == "changedate")
    {
        if(isset($_SESSION['cdate']))
        {
            $postdate = $_POST['date'];
            if($_SESSION['cdate'] == $postdate)
            {
                $_SESSION['cdate'] = $postdate;
                header("Location: ".$_SERVER['PHP_SELF']);
            }
            else
            {
                unset($_SESSION['collapse']);
                unset($_SESSION['ccart']);
                unset($_SESSION['ccartamount']);
                $_SESSION['cdate'] = $postdate;
                header("Location: ".$_SERVER['PHP_SELF']);
            }
        }
        else
        {
            header("Location: delses.php");
        }
    }
}
// print_r($_POST);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ticket Booking</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/favicon.png" type="image/png" sizes="16x16">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
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
    <!-- datepicker styles -->
    <!-- <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/css/bootstrap-datepicker.min.css"> -->
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

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
                <div class="col-12 col-md-1 col-lg-1 col-xl-1">

                </div>
                <div class="col-12 col-md-10 col-lg-10 col-xl-10">
                    <ul class="list-unstyled multi-steps">
                        <li id="step-1" class="is-active">
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
               
                    <div class="col-12 col-md-8 col-lg-8 col-xl-8 emb-ttr-div">
                         <?php

                            $carddate;
                            if(isset($_SESSION['cdate']))
                            {
                                $carddate = $_SESSION['cdate'];
                                $carddate = str_replace('-', '/', $carddate);
                            }
                            else
                            {
                                $_SESSION['cdate'] = date('d-m-Y');
                                $_SESSION['cdate'] = date('d-m-y', strtotime(' +1 day'));
                                $_SESSION['cdate1'] = date('Y-m-d');
                                // $_SESSION['cdate1'] = date('Y-m-d', strtotime(' +1 day'));
                                $carddate = strtotime('+1 day', strtotime(date('d-m-Y')));;
                                $carddate = str_replace('-', '/', $carddate);
                            }
                       
                    $error_msg = "";

                    try{    

                        $url = GENURL."GetPriceCardMasterB2C";
                        $ch = curl_init($url);
                        $params = json_encode(array("ORGANIZATIONCODE" => ORGANIZATIONCODE, "ISSUER" => ISSUER, "DATE" => $carddate));
                        
                        curl_setopt($ch, CURLOPT_VERBOSE, true);
                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $result = curl_exec($ch);
                        if (curl_errno($ch)) {
                            $error_msg = curl_error($ch);
                        }
                        $result_data = json_decode($result);
                        // echo 'data avilable:';
                        //  print "<pre>";
                        // print_r($result_data);
                        // print "</pre>";
                        
                        // var_dump($result); die;
                        curl_close($ch);
                        
                     // echo 'collapse:'.$_SESSION['collapse'];
                    
                        // print_r($_SESSION);
                        $_SESSION['cpricecard'] = $result_data->PriceCard;
                        
                        if(count($result_data->PriceCard) == 0){
                            throw new Exception;
                        }
                        
                        $PriceCardArrayCount = count($result_data->PriceCard);
                        $PriceCardArray = $result_data->PriceCard;

                        $subclasses = array();
                        $subclasses_timing = array();
                        
                        foreach ($result_data->PriceCard as $priceCard) {
                                $subclasses[$priceCard->SUBCLASS][] = $priceCard;
                            }
                            // print_r($subclasses);
                        echo '<div id="accordion">';
                        $j=1;
                        foreach ($subclasses as $subclass => $rows) {
                            // print_r($rows);
                       ?>

                    <!-- Ticket Booking -->
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                <button class="btn sub-btn emb-mb-mt <?php echo $_SESSION['collapse'] == $j ? 'collapsed' : '';?>" data-toggle="collapse" data-target="#collapseOne<?=$j?>" aria-expanded="<?php echo $_SESSION['collapse'] == $j ? 'true':'false';?>" aria-controls="collapseOne">
                                    <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                                        <h4 class="text-body-m wloRE emb-ext">
                                            <!-- Morning -->
                                            <span><?= $subclass?></span>
                                            <span><p class="emb-valtext"><?= isset($rows[0]->SUBCLASS_REMARK) ? $rows[0]->SUBCLASS_REMARK : ''; ?></p></span>
                                        </h4>
                                    </div>
                                </button>
                            </h5>
                        </div>

                        <div id="collapseOne<?=$j?>" class="<?php echo $_SESSION['collapse'] == $j ?  'collapse show in':'collapse';?>" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                                <?php 
                                $i=1;
                               foreach ($rows as $PriceCardArray) { ?>
                                    <?php
                                    $quantity = $totalPrice = 0;
                                    if (isset($_SESSION['ccart'])) {
                                        $cart = $_SESSION['ccart'];
                                        foreach ($cart as $cartitem) {
                                            if ($PriceCardArray->CODE == $cartitem->code) {
                                                $quantity = $cartitem->quantity;
                                                $totalPrice = $cartitem->totalamount;
                                                break;
                                            }
                                        }
                                    }

                                    $ticketdesc = "ticket_decription" . $j.$i;
                                    ?>
                                    <div class="row">
                                        <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                                            <div class="emb-bg">
                                                <div class="row">
                                                    <div class="col-12 col-md-6 col-lg-6 col-sm-6">
                                                        <p id="title<?= $j.$i ?>"><?= $PriceCardArray->NAME?> </p><br/>
                                                        <p id="desc"><?= isset($PriceCardArray->DESCRIPTION) ? $PriceCardArray->DESCRIPTION : "" ?></p>
                                                    </div>
                                                    <div class="col-xs-4 col-md-2 col-lg-2 col-sm-2">
                                                        <h4><i class="fa fa-inr" aria-hidden="true"></i> <span id="cost_per_ticket<?= $j.$i ?>"><?= $PriceCardArray->TICKETAMOUNT ?></span></h4>
                                                    </div>
                                                    <div class="col-xs-8 col-md-4 col-lg-4 col-sm-4">
                                                        <h4 class="text-body-m wloRE emb-ext" style="margin-bottom: 0; margin-top: 0;">
                                                            <span>
                                                                <div class="wloRE">
                                                                    <div class="input-group emb-inc-dec-inp">
                                                                        <span class="input-group-btn">
                                                                            <button type="button" class="btn btn-default btn-number" data-type="minus<?= $j.$i ?>" data-quantity="plus<?= $j.$i ?>" data-field="quantity<?= $j.$i ?>" onclick="minus('<?= $PriceCardArray->CODE ?>',<?= $PriceCardArray->TICKETAMOUNT ?>,<?= $j.$i ?>)">
                                                                                <span class="glyphicon glyphicon-minus"></span>
                                                                            </button>
                                                                        </span>
                                                                        <input type="text" name="quantity<?= $j.$i ?>" id="quantity<?= $j.$i;?>" value="<?= $quantity == 0 ? 0 : $quantity ?>" class="form-control input-number" value="1" min="0" max="10">
                                                                        <span class="input-group-btn">
                                                                            <button type="button" class="btn btn-default btn-number" data-type="plus<?= $j.$i ?>" data-quantity="plus<?= $j.$i ?>" data-field="quantity<?= $j.$i ?>" onclick="plus('<?= $PriceCardArray->CODE ?>',<?= $PriceCardArray->TICKETAMOUNT ?>,<?= $j.$i ?>)">
                                                                                <span class="glyphicon glyphicon-plus"></span>
                                                                            </button>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </span>
                                                        </h4>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-12 col-lg-4 col-sm-12">
                                                    </div>
                                                    <div class="col-xs-12 col-lg-8 col-sm-12">
                                                        <div class="row">
                                                            <div class="col-md-8 col-lg-8">
                                                                <?php if ($quantity != 0) : ?>
                                                                    <p class="text-right text-danger">To update Item, please remove from cart!</p>
                                                                <?php endif ?>
                                                                <div class="totalcost" id="totalcost_8204">
                                                                    Sub total :<span class="total_cost" id="final_total_cost<?= $j.$i ?>"></span>
                                                                    <?php if ($quantity == 0) : ?>
                                                                        <?php echo 0 ?>&nbsp;<i class="fa fa-inr" aria-hidden="true"></i>
                                                                    <?php else : ?>
                                                                        <?= $totalPrice ?>&nbsp;<i class="fa fa-inr" aria-hidden="true"></i> (Including taxes)
                                                                    <?php endif ?>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4">
                                                                <?php if ($quantity != 0) : ?>
                                                                    <button name="add_cart" value="Add to cart" type="button" class="btn sub-btn btn-sm emb-mb-mt showhid2 add-to-cart-class" onclick="RemoveCart('<?= $PriceCardArray->CODE ?>')">Remove to cart</button>
                                                                <?php else : ?>
                                                                    <button name="add_cart" value="Add to cart" type="button" class="btn sub-btn btn-sm emb-mb-mt showhid2 add-to-cart-class" onclick="AddCart(<?= $j.$i ?>,'<?= $PriceCardArray->TICKETAMOUNT ?>','<?= $PriceCardArray->NAME ?>','<?= $PriceCardArray->CODE ?>','<?= $ticketdesc ?>','<?= $PriceCardArray->CGST_RATE ?>','<?= $PriceCardArray->SGST_RATE ?>','<?= $PriceCardArray->CATEGORY ?>','<?= $PriceCardArray->CLASS ?>','<?= $PriceCardArray->SUBCLASS ?>','<?= $PriceCardArray->ISPRIORITYTICKET ?>','<?= $PriceCardArray->ISPRIORITYPASS ?>','<?= $PriceCardArray->TICKETTYPE ?>','<?=$subclass?>','<?=$j?>')">Add to cart</button>
                                                                <?php endif ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php $i++;  }  ?>
                            </div>
                        </div>
                    </div>
                 <?php $j++;}?>
            </div>
                        
                 <?php   } catch(Exception $e) {
                        echo '<h4 style=" text-align: center; padding: 100px; color: red; ">Park is closed on Monday</h4>';
                    }
                        
                    ?>

                </div>
                    <div class="col-12 col-md-4 col-lg-4 col-xl-4 emb-line">
<!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Include Bootstrap Datepicker plugin -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<div class="emb-bg">
    <h4 class="emb-ext">Select Your Booking Dates</h4>
    <!-- Date Picker -->
       <div class="form-group date-module mb-4">

        <div class="">
           <input type="text" name="ticket_date" id="datepicker" onchange="" class="form-control" autocomplete="off" value="<?php echo $_SESSION['cdate']; ?>" min="<?php echo $_SESSION['cdate']; ?>" >
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-6 col-lg-6 col-sm-6">
            <button class="btn sub-btn emb-mb-mt" onclick="changedate()">Continue</button>
        </div>
        <div class="col-12 col-md-6 col-lg-6 col-sm-6">
            <a class="btn sub-btn-1" href="delses.php">Reset</a>
        </div>
    </div>

<!-- Include jQuery library --> 
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Include Bootstrap JS -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<!-- Include Bootstrap Datepicker JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script> 

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<?php if (isset($_SESSION['ccartamount'])) : ?>
    <div class="emb-bg mt-25">
        <h4 class="emb-ext">Total Amount</h4>
        <?php
        $cart = $_SESSION['ccart'];
        $totalAmount = 0.00;
        $flag = false;
        $ticketcount = 0;

foreach ($cart as $item) {
    $totalAmount += (float)$item->totalamount;
    $totalquantity += (float)$item->quantity;

    if ($flag == false) {
        if (strtoupper(trim($item->tickettype)) == strtoupper('CHILD')) {
            $_SESSION['kids_timing'] = $item->morning_evening;
        }
        if (strtoupper(trim($item->tickettype)) != strtoupper('CHILD') && strtoupper(trim($item->tickettype)) == strtoupper('ADULT')) {
            $flag = true;
            if (!empty($_SESSION['kids_timing'])) {
                if (strtoupper(trim($item->morning_evening)) == strtoupper(trim($_SESSION['kids_timing']))) {
                    $flag = true;
                } else {
                    $flag = false;
                }
            }
        }
    }

    if (strtoupper(trim($item->tickettype)) != strtoupper('CHILD') && strtoupper(trim($item->tickettype)) == strtoupper('ADULT')) {
        $flag = true;
    }
    // if (strtoupper(trim($item->tickettype)) == strtoupper('CHILD') && strtoupper(trim($item->tickettype)) != strtoupper('ADULT')) {
    //     $message = "Children (Below 15 years) and Sr. Citizens (60 years and above) must carry ID proof issued by Govt.";
    // }

    // if (strtoupper(trim($item->tickettype)) == strtoupper('ADULT') && intval($item->quantity) > 0) {
    //     $quantity = intval($item->quantity);
    //     for ($i = 0; $i < $quantity; $i++) {
    //         $ticketcount++;
    //         $flagCount++;
    //         $flag = true;
    //         $message = "Children (Below 15 years) and Sr. Citizens (60 years and above) must carry ID proof issued by Govt.";
    //     }
    // } else { 
    //     $flag = false;
    //     $message = "4 children are allowed along with each senior citizen or each adult ticket booking.";
    // }

?>
<h4 class="text-body-m wloRE emb-ext" style="display: flex; flex-direction: row;">
    <span><?= $item->name.'   ('.$item->quantity.')';?></span>
    <span><?= $item->ticketamount ?><i class="fa fa-inr" aria-hidden="true"></i></span>
    <button name="remove_cart" value="Delete to cart" type="button" class="btn sub-btn btn-sm emb-mb-mt showhid2 add-to-cart-class" onclick="RemoveCart('<?= $item->code ?>')" style="width:10%"><i class="fa fa-trash"></i></button>
</h4>
<?php //endforeach; ?>
<?php } ?>

        <hr class="emb-hr"> 
<?php
if ($totalquantity >= 25) {
    $message = "Only 25 Tickets are allowed per Booking";
    // echo $message;
}
?>
                
                <h4 class="text-body-m wloRE" style="display: flex; flex-direction: row;">
                    <span>TOTAL</span>
                    <span><?= $_SESSION['ccartamount'] ?> <i class="fa fa-inr" aria-hidden="true"></i></span>
                </h4>
                <?php if($flag && $totalquantity <= 25): ?>
                <button class="btn sub-btn"  onClick=next()>Continue To Customer Details</button>
                    <?php else :
                            if($totalquantity > 25): ?>
                                <p class="text-danger">Only 25 Tickets are allowed per Booking</p>
                            <?php else:?>
                            <p class="text-danger">Please select at least one adult ticket in the same time slot.
                        <?php endif; ?>

                    <?php endif; ?>
                </div>
                    <?php endif; ?>
                    <h4 style="color:red"><?=$message;?></h4>
                </div>
            </div>
        </div>
    </section>

    <script>
            function addOrNext(allowedChildCount, itemCode) {
        if (allowedChildCount > 0) {
            AddChildToCart(itemCode);
        } else {
            next();
        }
    }
        function checkAdultSelected() {
            var checkboxes = document.getElementsByName('adultTickets[]');
            var checked = Array.prototype.slice.call(checkboxes).some(function (checkbox) {
                return checkbox.checked;
            });

            if (!checked) {
                alert('Please add at least one adult ticket.');
                return false;
            }

            return true;
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://jacoblett.github.io/bootstrap4-latest/bootstrap-4-latest.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script src="./js/dnSlide.js"></script>
    <script type="text/javascript" src="js/wow.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.js"></script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.1/owl.carousel.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/js/lightbox.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript"
        src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/js/bootstrap-datepicker.min.js"></script>
    <script src="./js/numscroller.js"></script>

    <script>
        let step = 'step1';

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
                window.location.href = "step-2.php";
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

    <script type="text/javascript">
        function minus(code,ticket_amt,i){console.log("minus entered")
            var title = $('#title' + i);
                var currentVal = $('#quantity' + i); // This is a jQuery object
                console.log("qty:", currentVal.val()); // Logging the value, not the object

                if (!isNaN(currentVal.val()) && parseFloat(currentVal.val()!=0)) {
                    var newVal = parseFloat(currentVal.val()) - 1; // Correctly parsing and incrementing the value
                    currentVal.val(newVal); // Updating the input with the new value
                    
                    let amount = parseFloat($('#cost_per_ticket' + i).text()); // Getting the cost per ticket
                    let totalCost = amount * newVal; // Using the updated quantity for calculation
                    
                    console.log(totalCost); // Logging the correct total cost
                    
                    $('#total_cost' + i).text(totalCost.toFixed(2)); // Updating the total cost text
                    $('#final_total_cost' + i).text(totalCost.toFixed(2)); // Assuming this should be the same, update accordingly
                } else {
                    currentVal.val(0); // Resetting value if it's not a number
                }

        }

        function plus(code,ticket_amt,i){console.log("plus entered")
                var title = $('#title' + i);
                var currentVal = $('#quantity' + i); 
                console.log("qty:", currentVal.val()); 

                if (!isNaN(currentVal.val())) {
                    var newVal = parseFloat(currentVal.val()) + 1; 
                    currentVal.val(newVal); 
                    
                    let amount = parseFloat($('#cost_per_ticket' + i).text()); 
                    let totalCost = amount * newVal; 
                    
                    console.log(totalCost); 
                    
                    $('#total_cost' + i).text(totalCost.toFixed(2)); 
                    $('#final_total_cost' + i).text(totalCost.toFixed(2)); 
                } else {
                    currentVal.val(0); 
                }

        }
    </script>

    <script>
        $('.btn-number').click(function (e) {
            e.preventDefault();

            fieldName = $(this).attr('data-field');
            type = $(this).attr('data-type');
            var input = $("input[name='" + fieldName + "']");
            var currentVal = parseInt(input.val());
            if (!isNaN(currentVal)) {
                if (type == 'minus') 

                    if (currentVal > input.attr('min')) {
                        input.val(currentVal - 1).change();
                    }
                    if (parseInt(input.val()) == input.attr('min')) {
                        $(this).attr('disabled', true);
                    }

                } else if (type == 'plus') {

                    if (currentVal < input.attr('max')) {
                        input.val(currentVal + 1).change();
                    }
                    if (parseInt(input.val()) == input.attr('max')) {
                        $(this).attr('disabled', true);
                    }

                }
            } else {
                input.val(0);
            }
        );
        $('.input-number').focusin(function () {
            $(this).data('oldValue', $(this).val());
        });
        $('.input-number').change(function () {

            minValue = parseInt($(this).attr('min'));
            maxValue = parseInt($(this).attr('max'));
            valueCurrent = parseInt($(this).val());

            name = $(this).attr('name');
            if (valueCurrent >= minValue) {
                $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
            } else {
                alert('Sorry, the minimum value was reached');
                $(this).val($(this).data('oldValue'));
            }
            if (valueCurrent <= maxValue) {
                $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
            } else {
                alert('Sorry, the maximum value was reached');
                $(this).val($(this).data('oldValue'));
            }


        });
        $(".input-number").keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                // Allow: Ctrl+A
                (e.keyCode == 65 && e.ctrlKey === true) ||
                // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                // let it happen, don't do anything
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });

    </script>

    <script>
        $('.input-group.date').datepicker({ format: "dd.mm.yyyy" }); 
    </script>

    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script src="vendor/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="vendor/jquery-validation/dist/additional-methods.min.js"></script>
    <script src="vendor/jquery-steps/jquery.steps.min.js"></script>
    <script src="vendor/minimalist-picker/dobpicker.js"></script>
    <script src="vendor/jquery.pwstrength/jquery.pwstrength.js"></script>
    <script src="js/main.js"></script>
    <script src="js/rocket-loader.min.js"></script>
    <script src="js/general.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
    <script>
        function AddCart( id, price, name, code, description, cgst_rate, sgst_rate, category, classs, subclass, ispriorityTicket, isprioritypass,tickettype,morning_evening ,collapse) {
            
            
            var quantity = parseFloat($('#quantity'+id).val());
            if(quantity == "0"){
                console.log('value is 0');
                window.location = "index.php?error=emptycart";
                // alert('cart value cant be 0');
            } else {
            var price = parseFloat(price);
            console.log(price);
            var desc = $('#'+desc).text();
            var date = $('#datepicker').val();
            var total_cost = quantity * price;
            var totalqty=$("#totalquantity").val();
            var Gstrate = 100+Number(cgst_rate)+Number(sgst_rate);
            var basic_amount = parseFloat((total_cost/Number(Gstrate))*100);
            var cgst_amount = basic_amount * (parseFloat(cgst_rate)/100);
            var sgst_amount = basic_amount * (parseFloat(sgst_rate)/100);
            var form = $('<form  action="index.php" id="myForm" method="POST">' + 
                '<input type="hidden" name="cname" value="' + name + '">' + 
                '<input type="hidden" name="code" value="' + code + '">' +
                '<input type="hidden" name="price" value="' + price + '">' +
                '<input type="hidden" name="quantity" value="' + quantity + '">' +
                '<input type="hidden" name="total_cost" value="' + total_cost + '">' +
                '<input type="hidden" name="description" value="' + desc + '">' +
                '<input type="hidden" name="cgst_rate" value="' + cgst_rate + '">' +
                '<input type="hidden" name="sgst_rate" value="' + sgst_rate + '">' +
                '<input type="hidden" name="cgst_amount" value="' + cgst_amount + '">' +
                '<input type="hidden" name="sgst_amount" value="' + sgst_amount + '">' +
                '<input type="hidden" name="category" value="' + category + '">' +
                '<input type="hidden" name="class" value="' + classs + '">' +
                '<input type="hidden" name="subclass" value="' + subclass + '">' +
                '<input type="hidden" name="totalquantity" value="' + totalqty + '">' +
                '<input type="hidden" name="ispriorityTicket" value="' + ispriorityTicket + '">' +
                '<input type="hidden" name="isprioritypass" value="' + isprioritypass + '">' +
                '<input type="hidden" name="tickettype" value="' + tickettype + '">' +
                '<input type="hidden" name="morning_evening" value="' + morning_evening + '">' +
                '<input type="hidden" name="date" value="' + date + '">' +
                '<input type="hidden" name="collapse" value="' + collapse + '">' +
                '<input type="hidden" name="action" value="addtocart">' +
                '<input type="submit" style="visibility:hidden;">' +
                '</form>');
                $(document.body).append(form);
                console.log($(form).attr('action'))
                $('input[type="submit"]', form).click();
            }
          
        }

        function RemoveCart(code) {
            var form = $('<form action="index.php" method="POST">' +
            '<input type="hidden" name="code" value="' + code + '">' +
            '<input type="hidden" name="action" value="removefromcart">' +
            '<input type="submit" style="visibility:hidden;">' +
            '</form>');
            $(document.body).append(form);
            $('input[type="submit"]', form).click();
        }
    function changedate(value) {
        var date =  $('#datepicker').val();
        if(date !=''){
            var r = true;
                if (r == true) {
                    var form = $('<form action="index.php" method="POST">' +
                    '<input type="hidden" name="date" value="' + date + '">' +
                    '<input type="hidden" name="action" value="changedate">' +
                    '<input type="submit" style="visibility:hidden;">' +
                    '</form>');
                    $(document.body).append(form);
                    $('input[type="submit"]', form).click();
                } else {

                }
            }else{
                
            }
        }
        
        $( ".ticket-data").show();
        $( ".select_btn #hide").show();
        $( ".select_btn #show").hide();
        
        if(jQuery('.skiptranslate').hasClass('goog-te-gadget')) {
          jQuery('.buttonload').remove();
        }
        $(document).ready(function () {
    // Get today's date
    var today = new Date();

    // Add one day to today's date
    // var nextDay = new Date(today);
    // nextDay.setDate(today.getDate() + 1);

    $("#datepicker").datepicker({
        format: 'dd.mm.yyyy',
        todayHighlight: true,
        startDate: '0d', 
    });
    $("#datepicker").datepicker('setDate', nextDay);
});

</script> 
        
</script>


</body>

</html>