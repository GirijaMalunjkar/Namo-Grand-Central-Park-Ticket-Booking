<?php
session_start(); 

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
        $user = $dcd_session_data->cuser;
        $cart = $dcd_session_data->ccart;
        $visitdate = $dcd_session_data->cdate;
        $orderid = $dcd_session_data->order_id;

        $hdfc_order_id = $dcd_session_data->rawbank;

        $_SESSION['cuser']  =  $user;
        $_SESSION['ccart']  =  $cart;
        $_SESSION['cdate']  =  $visitdate;
        $_SESSION['orderid']  =  $orderid;
    }
} 
else 
{
    echo "db error occured";
}

foreach ($cart as $result) {
    
    $emailid = $user->email_id;

}

$resp = $_REQUEST; 

$response = json_encode($resp);

if (isset($_SESSION['hdfc_order_id'])) {

    $hdfc_order_id = $_SESSION['hdfc_order_id'];

} else {

    echo "Transaction UUID not found.";

}

if (isset($_SESSION['successIndicator'])) {

    $successIndicator = $_SESSION['successIndicator'];

} else {

    echo "Transaction UUID not found.";

}

$resultIndicator = isset($resp['resultIndicator']) ? $resp['resultIndicator'] : '';

$sessionVersion = isset($resp['sessionVersion']) ? $resp['sessionVersion'] : '';

if( $successIndicator === $resultIndicator ){

    $paymentResult = 'ACCEPT';
    $sql1 = "UPDATE orderdetails SET payment_status='successful', booking_status='successful' WHERE bookingnumber='$orderid'";
    
    if (mysqli_query($conn, $sql1)) 
    {

        $inresp = "INSERT INTO hdfc_final_response (result_indicator, order_id, session_version, response, session_id)  VALUES ('$resultIndicator', '$hdfc_order_id', '$sessionVersion', '$response', '$session_id')";
        
        $result = mysqli_query($conn, $inresp);

        if ($result) {

            // echo "Response inserted successfully into the database.";

        } else {

            echo "Error inserting response: " . mysqli_error($conn);

        }

            $sql2 = "UPDATE hdfc_txn SET decision='$paymentResult' WHERE reference_number = '$orderid' ";
                
            if (mysqli_query($conn, $sql2)) 
            {
                $status = 'TXN_SUCCESS'; 
            }
            else
            {
               echo "update failed";
            }
            
        
            if($paymentResult == 'ACCEPT')
            {
                if($status != 'TXN_SUCCESS')
                {
                    $sql1 = "UPDATE orderdetails SET payment_status='reject', booking_status='reject' WHERE bookingnumber='$orderid'";
                    if (mysqli_query($conn, $sql1)) 
                    {
                        // echo "<br> status ".$status;
                        
                         $sql2 = mysqli_query($conn, "SELECT * FROM `orderdetails` WHERE `bookingnumber` = '$orderid'");

                        while($row=mysqli_fetch_array($sql2)){
                            echo '<script>window.location.href = "step-5.php?orderid=' . $orderid . '";</script>';
                            // header("Location: https://aquasplashwaterpark.com/bookings/step-5.php?orderid=$orderid");
                            exit;
                        }
                   
                    } else {
                    
                        // echo "reject reject failed";
                        // header("Location: step-5.php?orderid=$orderid");
                        echo '<script>window.location.href = "step-5.php?orderid=' . $orderid . '";</script>';
                        exit;
                    }
                }
            
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
                    $paymenttxnid = $hdfc_order_id;  //fromdb
                    $date = date('d-m-Y', strtotime($VISITDATE)); 
                    $SCHEDULESLABHOUR = 1;
                    $ONLINEPAID_AMOUNT = $row['online_amount'];   //fromdb
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
                    //   echo $param;
                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $result = curl_exec($ch);
                        $result_data1 = json_decode($result);
                        $jsonstring = json_encode($result_data1);
                        // var_dump(json_encode($result_data1));
                        // die;
                        curl_close($ch);
                    // header("Location: step-5.php?orderid=$orderid");
                    echo '<script>window.location.href = "step-5.php?orderid=' . $orderid . '";</script>';
                           
                    exit;

            }
    }
    
}else{

$paymentResult = 'REJECT';
echo $paymentResult;
    $sql1 = "UPDATE orderdetails SET payment_status='reject', booking_status='reject' WHERE bookingnumber='$orderid'";
    
    if (mysqli_query($conn, $sql1)) 
    {

        $inresp = "INSERT INTO hdfc_final_response (result_indicator, order_id, session_version, response, session_id)  VALUES ('$resultIndicator', '$hdfc_order_id', '$sessionVersion', '$response', '$session_id')";
        
        $result = mysqli_query($conn, $inresp);

        if ($result) {

            echo "Reject Response inserted successfully into the database. ";

        } else {

            echo "Error inserting response: " . mysqli_error($conn);

        }
            $sql2 = "UPDATE hdfc_txn SET decision='$paymentResult' WHERE reference_number = '$orderid' ";
            // echo $sql2; 
            
            if (mysqli_query($conn, $sql2)) 
            {
                $status = 'TXN_REJECT'; 
            }
            else
            {
               echo "update failed";
            }

            if($paymentResult == 'REJECT') {
                
                if($status != 'TXN_SUCCESS')
                { 
                    // echo "<br> status ".$status;
                    $sql1 = "UPDATE orderdetails SET payment_status='reject', booking_status='reject' WHERE bookingnumber='$orderid'";
                    if (mysqli_query($conn, $sql1)) 
                    {
                        // echo "<br> status ".$status;
                        
                        $sql2 = mysqli_query($conn, "SELECT * FROM `orderdetails` WHERE `bookingnumber` = '$orderid'");

                        while($row=mysqli_fetch_array($sql2)){
               
                    $visitdate = $_SESSION['cdate'];
                    $url = GENURL."WebTicketBooking";
                    $ORGANIZATIONCODE = ORGANIZATIONCODE;
                    $ISSUER = ISSUER;
                    $VERSION = VERSION;
                    $BOOKINGNUMBER = $orderid;
                    $BOOKINGDATE = date('d-m-Y');
                    $LOCCODE = "MNS";
                    //$NAME = $user->full_name;   //fromdb
                    $NAME = $row['custname'];   //fromdb
                    $IDENTITYPROOFTYPE = "";
                    $IDENTITYPROOFNO = "";
                   //$CONTACTNO = $user->mobile_no;
                    $CONTACTNO =  $row['contactno']; //fromdb
                    $AGENTCODE = "23362";
                    //$EMAILID = $user->email_id;
                    $EMAILID = $row['email']; //fromdb
                    $VISITDATE = $row['visitdate'];  //fromdb
                    $paymenttxnid = $hdfc_order_id;  //fromdb
                    $date = date('d-m-Y', strtotime($VISITDATE)); 
                    $SCHEDULESLABHOUR = 1;
                    $ONLINEPAID_AMOUNT = $row['online_amount'];   //fromdb
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
                        
                        // print_r($params);die;
    
                       $param = json_encode($params);
                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $result = curl_exec($ch);
                        $result_data1 = json_decode($result);
                        $jsonstring = json_encode($result_data1);
                       // var_dump(json_encode($result_data1));die;
                        curl_close($ch);
                        
                        echo '<script>window.location.href = "step-5.php?orderid=' . $orderid . '";</script>';
                        // header("Location: https://aquasplashwaterpark.com/bookings/step-5.php?orderid=$orderid");
                        exit;
                    }
                    else
                    {
                        // echo "reject reject failed";
                        // header("Location: step-5.php?orderid=$orderid");
                        
                         $sql2 = mysqli_query($conn, "SELECT * FROM `orderdetails` WHERE `bookingnumber` = '$orderid'");

                        while($row=mysqli_fetch_array($sql2)){
               
                    $visitdate = $_SESSION['cdate'];
                    $url = GENURL."WebTicketBooking";
                    $ORGANIZATIONCODE = ORGANIZATIONCODE;
                    $ISSUER = ISSUER;
                    $VERSION = VERSION;
                    $BOOKINGNUMBER = $orderid;
                    $BOOKINGDATE = date('d-m-Y');
                    $LOCCODE = "MNS";
                    //$NAME = $user->full_name;   //fromdb
                    $NAME = $row['custname'];   //fromdb
                    $IDENTITYPROOFTYPE = "";
                    $IDENTITYPROOFNO = "";
                   //$CONTACTNO = $user->mobile_no;
                    $CONTACTNO =  $row['contactno']; //fromdb
                    $AGENTCODE = "23362";
                    //$EMAILID = $user->email_id;
                    $EMAILID = $row['email']; //fromdb
                    $VISITDATE = $row['visitdate'];  //fromdb
                    $paymenttxnid = $hdfc_order_id;  //fromdb
                    $date = date('d-m-Y', strtotime($VISITDATE)); 
                    $SCHEDULESLABHOUR = 1;
                    $ONLINEPAID_AMOUNT = $row['online_amount'];   //fromdb
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
                        // print_r($params);die;
                        
                        $param = json_encode($params);
                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $result = curl_exec($ch);
                        $result_data1 = json_decode($result);
                        $jsonstring = json_encode($result_data1);
                      //  var_dump(json_encode($result_data1));die;
                        curl_close($ch);
                        
                        echo '<script>window.location.href = "step-5.php?orderid=' . $orderid . '";</script>';
                        exit;
                    }
                }
            }

        header("Location: step-5.php?orderid=$orderid");
        exit;

    }

}



        
        
        // $result = mysqli_query($conn, $sql);
        // $updatecount = mysqli_affected_rows($conn);


        //echo $updatecount;
    //     if ($updatecount > 0) {

    //      
           
?>


