<?php
session_start(); //start the PHP_session function

require 'vars.php';
require 'db.php';

$session_id = $_REQUEST['id'];

$fetch_session_data = "SELECT session_data FROM session_info WHERE Id = '$session_id'";
$resultfsd = mysqli_query($conn, $fetch_session_data);
if (mysqli_num_rows($resultfsd ) > 0) 
{
    while($row = mysqli_fetch_assoc($resultfsd)) 
    {
        $session_data = $row['session_data'];
        $dcd_session_data = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $session_data));
        // $dcd_session_data = json_decode($session_data, true);
        
        // echo "<br><br>";
        // var_dump($dcd_session_data);
        // echo "<br><br>";
        $user = $dcd_session_data->cuser;
        $cart = $dcd_session_data->ccart;
        $visitdate = $dcd_session_data->cdate;
        $orderid = $dcd_session_data->order_id;

        $_SESSION['cuser']  =  $user;
        $_SESSION['ccart']  =  $cart;
        $_SESSION['cdate']  =  $visitdate;
        $_SESSION['orderid']  =  $orderid;
    }
} 
else 
{
    echo "db error";
}

// var_dump($cart); exit;

foreach ($cart as $result) {
    
    $emailid = $user->email_id;

}

$resp = $_REQUEST;
$response = json_encode($resp);
$transaction_id = $_REQUEST['transaction_id'];
$decision = $_REQUEST['decision'];
$req_bill_to_phone  = $_REQUEST['req_bill_to_phone'];

$inresp = "INSERT INTO hdfc_final_response(transaction_id, decision, req_bill_to_phone, response) VALUES ('$transaction_id', '$decision', '$req_bill_to_phone', '$response')";

$result = mysqli_query($conn, $inresp);

// var_dump($decision);die;

//Get the last booking number
$sql = "SELECT * FROM orderdetails WHERE email = '$emailid' AND bookingnumber = '$orderid' ORDER BY orderdetails_id DESC LIMIT 1";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) 
{
    while($row = mysqli_fetch_assoc($result)) 
    {
        $last_booking_number = $row["bookingnumber"];
        
        //var_dump($last_booking_number);
        $last_booking_number2 = $last_booking_number;
        $BOOKINGNUMBER = $last_booking_number2;
    }
} 
else 
{
    $BOOKINGNUMBER = '2000000';
}

foreach ($cart as $result) {
    
    $quantity = $result->quantity;
    $tktammount = $result->ticketamount;
    $code = $result->code;

}

    $sql1 = "UPDATE hdfc_txn SET decision='$decision' WHERE reference_number='$orderid'";

    if (mysqli_query($conn, $sql1)) 
    {
        $status = 'TXN_SUCCESS'; 
    }
    else
    {
       echo "update failed";
    }

    if($decision == 'ACCEPT') {
        
        if($status != 'TXN_SUCCESS')
        {
            $sql1 = "UPDATE orderdetails SET payment_status='reject', booking_status='reject' WHERE bookingnumber='$orderid'";
            if (mysqli_query($conn, $sql1)) 
            {
                // echo "reject reject";
                header("Location: step5.php?orderid=$orderid");
                exit;
            }
            else
            {
                // echo "reject reject failed";
                header("Location: step5.php?orderid=$orderid");
                exit;
            }
        }

        
        
        $result = mysqli_query($conn, $sql);
        $updatecount = mysqli_affected_rows($conn);
        //echo $updatecount;
        if ($updatecount > 0) {

            $sql2 = mysqli_query($conn, "SELECT * FROM `orderdetails` WHERE `bookingnumber` = '$orderid'");

            while($row=mysqli_fetch_array($sql2)){
               
                    $visitdate = $_SESSION['cdate'];
                    $url = GENURL."WebTicketBooking";
                    $ORGANIZATIONCODE = ORGANIZATIONCODE;
                    $ISSUER = ISSUER;
                    $VERSION = VERSION;
                    $BOOKINGNUMBER = $orderid;
                    $BOOKINGDATE = date('d-m-Y');
                    $LOCCODE = "NGCP";
                    //$NAME = $user->full_name;   //fromdb
                    $NAME = $row['custname'];   //fromdb
                    $IDENTITYPROOFTYPE = "";
                    $IDENTITYPROOFNO = "";
                   //$CONTACTNO = $user->mobile_no;
                    $CONTACTNO =  $row['contactno']; //fromdb
                    $AGENTCODE = "NGCP_WEB";
                    //$EMAILID = $user->email_id;
                    $EMAILID = $row['email']; //fromdb
                    $VISITDATE = $row['visitdate'];  //fromdb
                    $paymenttxnid = $txnid;  //fromdb
                    $date = date('d-m-Y', strtotime($VISITDATE)); 
                    $SCHEDULESLABHOUR = 1;
                    $ONLINEPAID_AMOUNT = $txnamount;   //fromdb
                    $CREDITUSE_AMOUNT = 0; 
                    $combined_str = $ORGANIZATIONCODE . $EMAILID . $BOOKINGNUMBER;
                    $checksum_hash = md5($combined_str);

                    $total_ammount = $row['online_amount'];
                    //$disc = $row['discount_rate']; 

                    //Get the tickets array
                    $bookingtickets = array();

                    $cartcount = count($cart);
                }

                    //from orderdetails table 

                    for($i=0; $i < $cartcount; $i++)
                    {
                        $disc = 0;
                        $object = new stdClass();
                        $object->PRICECARDCODE = $cart[$i]->code;  //fromdb
                        $object->NOOFTICKETS = $cart[$i]->quantity; //fromdb
                        $object->RATE = $cart[$i]->ticketamount; //fromdb
                        $object->AMOUNT = $cart[$i]->totalamount; //fromdb
                        $object->TICKETDESCRIPTION = $cart[$i]->description; //fromdb
                        $object->DISCOUNT_AMOUNT = $disc; //fromdb

                        array_push($bookingtickets, $object);
                        //var_dump(array_push($bookingtickets, $object));die;
                    }

                    // var_dump($bookingtickets);die;

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
                        "PAYMENT_TRANSACTIONID" => $paymenttxnid,
                        "CHECKSUM" => $checksum_hash,
                        "TicketBookingDetails" => $bookingtickets
                    );

                   $param = json_encode($params);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $result = curl_exec($ch);
                    $result_data1 = json_decode($result);
                    $jsonstring = json_encode($result_data1);
                    var_dump(json_encode($result_data1));die;
                    curl_close($ch);
                    if($result_data1->TXNSTATUSCODE == "0")
                    {
                        
                        $sql1 = "UPDATE orderdetails SET payment_status='successful', booking_status='successful', dumpshanku='$jsonstring' WHERE bookingnumber='$orderid'";
                        // echo $sql1;die;
                        if (mysqli_query($conn, $sql1)) 
                        {
                            header("Location: step5.php?orderid=$orderid");
                            exit;
                        }
                        else
                        {
                        //   echo "Success update failed";
                           header("Location: step5.php?orderid=$orderid");
                           exit;
                        }
                    }
                    else
                    {
                        $sql1 = "UPDATE orderdetails SET payment_status='successful', booking_status='reject', dumpshanku='$jsonstring' WHERE bookingnumber='$orderid'";
                        if (mysqli_query($conn, $sql1)) 
                        {
                            // echo "success reject";
                            header("Location: step5.php?orderid=$orderid");
                        }
                        else
                        {
                            // echo "success reject failed";
                            header("Location: step5.php?orderid=$orderid");
                        }
                    }
            
        } else {
            // echo "update count 0";
            header("Location: step5.php?orderid=$orderid");
        }
    } else {
        $sql1 = "UPDATE orderdetails SET payment_status='reject', booking_status='reject' WHERE bookingnumber='$orderid'";
        if (mysqli_query($conn, $sql1)) 
        {
            header("Location: step5.php?orderid=$orderid");
            echo "reject reject";
            
        }
        else
        {
            echo "reject reject failed";
            header("Location: step5.php?orderid=$orderid");
        }
    }

?>


