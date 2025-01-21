<?php
session_start();
include_once('vars.php');
include_once('db.php');
include_once('config.php');
include_once('security.php');


//whether ip is from share internet
if (!empty($_SERVER['HTTP_CLIENT_IP']))   
  {
    $ip_address = $_SERVER['HTTP_CLIENT_IP'];
  }
//whether ip is from proxy
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
  {
    $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }
//whether ip is from remote address
else
  {
    $ip_address = $_SERVER['REMOTE_ADDR'];
  }


$cart;
$user;
$visitdate;
// print_r($_SESSION['ccart']);
if(isset($_SESSION['ccart']))
{
    $cart = $_SESSION['ccart'];
    $cartcount = count($cart);
    if($cartcount == 0)
    {
        header("Location: index.php");
    }
    else
    {
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
}
else
{
    header("Location: index.php");
}

if(isset($_SESSION['cuser']))
{
    $user = $_SESSION['cuser'];
    // echo '<br><br><br>';
}
else
{
    header("Location: step-2.php");
}

if(isset($_SESSION['cdate']))
{
    $visitdate = $_SESSION['cdate'];
    // echo '<br><br><br>';
}
else
{
    header("Location: index.php");
}

    // print_r($_SESSION);
$url = GENURL . "ValidateWebTicketBooking";
$ORGANIZATIONCODE = ORGANIZATIONCODE;
$ISSUER = ISSUER;
$VERSION = VERSION;
$BOOKINGNUMBER = '0';
$BOOKINGDATESQL = date('Y-m-d');
$BOOKINGDATE = date('d-m-Y');
$LOCCODE = "NGCP";
$NAME = $user->full_name;
$IDENTITYPROOFTYPE = "";
$IDENTITYPROOFNO = "";
$CONTACTNO = $user->mobile_no;
$AGENTCODE = "NGCP_WEB";
$EMAILID = $user->email_id;
$VISITDATE = $visitdate;
$datesql = date('Y-m-d', strtotime($VISITDATE));
$date = date('d-m-Y', strtotime($VISITDATE));
$SCHEDULESLABHOUR = 1;
$ONLINEPAID_AMOUNT = 0.00;
$CREDITUSE_AMOUNT = 0;
$combined_str = $ORGANIZATIONCODE . $EMAILID . $BOOKINGNUMBER;
$checksum_hash = md5($combined_str);

// Get the tickets array
$bookingtickets = array();
$cartcount = count($cart);

for ($i = 0; $i < $cartcount; $i++) {
    $object = new stdClass();
    $object->PRICECARDCODE = $cart[$i]->code;
    $object->NOOFTICKETS = $cart[$i]->quantity;
    $object->RATE = $cart[$i]->ticketamount;
    $object->AMOUNT = $cart[$i]->totalamount;
    $object->TICKETDESCRIPTION = $cart[$i]->description;
    $ONLINEPAID_AMOUNT += $cart[$i]->totalamount;
    array_push($bookingtickets, $object);
}

$ch = curl_init($url);

$params = array( 
    "ORGANIZATIONCODE" => $ORGANIZATIONCODE,
    "ISSUER"  => $ISSUER,
    "VERSION" => $VERSION,
    "BOOKINGNUMBER" => $BOOKINGNUMBER,
    "BOOKINGDATE" => $BOOKINGDATE,
    "LOCCODE" => $LOCCODE,
    "NAME" => $NAME,
    "IDENTITYPROOFTYPE" => $IDENTITYPROOFTYPE,
    "IDENTITYPROOFNO" => $IDENTITYPROOFNO,
    "CONTACTNO" => $CONTACTNO,
    "AGENTCODE" => $AGENTCODE,
    "EMAILID" => $EMAILID,
    "VISITDATE" => $date,
    "DISCOUNT_RATE" => 0,
    "ONLINEPAID_AMOUNT" => $ONLINEPAID_AMOUNT,
    "CREDITUSE_AMOUNT" => $CREDITUSE_AMOUNT,
    "SCHEDULESLABHOUR" => $SCHEDULESLABHOUR,
    "PAYMENT_TRANSACTIONID" => '0',
    "CHECKSUM" => $checksum_hash,
    "TicketBookingDetails" => $bookingtickets
);


$param = json_encode($params);
// echo $param;
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
$result_data1 = json_decode($result);
// print_r($result_data1);
curl_close($ch);


// print_r()
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
// echo $BOOKINGNUMBER;

// Add the Cart data to the database
$sql1 = "INSERT INTO orderdetails(organizationcode, issuer, version, bookingnumber, bookingdate, loccode, custname, idprooftype, idproofno, contactno, agentcode, email, visitdate, online_amount, credituse_amount, discount_rate, scheduleslabhour, checksum, payment_status, booking_status, is_agent) VALUES ('$ORGANIZATIONCODE', '$ISSUER', '$VERSION', '$BOOKINGNUMBER', '$BOOKINGDATESQL', '$LOCCODE', '$NAME', '$IDENTITYPROOFTYPE', '$IDENTITYPROOFNO', '$CONTACTNO', '$AGENTCODE', '$EMAILID', '$datesql', '$ONLINEPAID_AMOUNT', '0', '0', '$SCHEDULESLABHOUR', '$checksum_hash', 'pending', 'pending', 'no')";

if (mysqli_query($conn, $sql1)) {
    $last_id = mysqli_insert_id($conn);
    $insertflag = false;
    // print_r($bookingtickets);
      foreach ($bookingtickets as $booking_detail) {
        $pricecardcode = $booking_detail->PRICECARDCODE;
        // echo 'price card code'.$pricecardcode;
        $sql2 = "INSERT INTO order_ticket_details(orderdeatils_id,pricecardcode,nooftickets,rate,amount,discount_amount,description) VALUES('$last_id', '$pricecardcode', '$booking_detail->NOOFTICKETS', '$booking_detail->RATE', '$booking_detail->AMOUNT', '0', '$booking_detail->TICKETDESCRIPTION')";
        if (mysqli_query($conn, $sql2)) {
            $insertflag = true;
        } else {
            $insertflag = false;
            break;
        }
    }

    // echo "insert order details success ". $insertflag;
   if (isset($_SESSION['cpricecard']) && is_array($_SESSION['cpricecard'])) {
            foreach ($_SESSION['cpricecard'] as $key => $object) {
                 if (isset($object->NAME)) {
                    $nameWithoutQuotes = str_replace("'", "", $object->NAME);
                    $_SESSION['cpricecard'][$key]->NAME = $nameWithoutQuotes;
                }
                if (isset($object->DESCRIPTION)) {
                    $descriptionWithoutQuotes = str_replace("'", "", $object->DESCRIPTION);
                    $_SESSION['cpricecard'][$key]->DESCRIPTION = $descriptionWithoutQuotes;
                }
            }
        }
        // print_r($_SESSION['cpricecard']);

        if (isset($_SESSION['ccart']) && is_array($_SESSION['ccart'])) {
            foreach ($_SESSION['ccart'] as $key => $object) {
                if (isset($object->description)) {
                    $descriptionWithoutQuotes2 = str_replace("'", "", $object->description);
                    $_SESSION['ccart'][$key]->description = $descriptionWithoutQuotes2;
                }
            }
        }

        $session_data = json_encode($_SESSION);
        
        //echo $transaction_uuid;
        // echo "<br><br><br>"; 64d1fae2f0ea6
        // // session_start(); // Make sure to start the session
        // print_r($_SESSION['cpricecard']);

        // echo "<br><br><br>";

        $inresp = "INSERT INTO session_info(session_data) VALUES ('$session_data')";
        // echo $inresp;
        // die;
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $result = mysqli_query($conn, $inresp);
        $inserid = mysqli_insert_id($conn);

        $result = mysqli_query($conn, $inresp);
        if (!$result) {
            echo "Query execution failed: " . mysqli_error($conn);
        } else {
            $inserid = mysqli_insert_id($conn);
            // echo "Session inserted. Insert ID: " . $inserid;
        }


}


 if($insertflag)
    {
?>
<form name="frmPayment" id="frmPayment" action="ccavenue/ccavRequestHandler.php" method="POST">
    <input type="hidden" name="tid" id="tid" readonly />
    <input type="hidden" name="merchant_id" value="3195148"/>
    <input type="hidden" name="order_id" value="<?=$BOOKINGNUMBER?>"/>
    <input type="text" name="amount" value="<?=round($ONLINEPAID_AMOUNT, 2)?>"/>
    <input type="text" name="currency" value="INR"/>
    <input type="hidden" name="redirect_url" value="https://booking.namograndcentralpark.com/ccavenue/ccavResponseHandler.php"/>
    <input type="hidden" name="cancel_url" value="https://booking.namograndcentralpark.com/ccavenue/ccavResponseHandler.php"/>
    <input type="hidden" name="language" value="EN"/>
    <input type="submit" id="submitbtn" name="submit">
</form>

<script>
    // Ensure the entire page is fully loaded before submitting the form
        document.addEventListener("DOMContentLoaded", function() {
        var d = new Date().getTime();
        document.getElementById("tid").value = d;

        });

</script>

    <?php
     }   ?>
