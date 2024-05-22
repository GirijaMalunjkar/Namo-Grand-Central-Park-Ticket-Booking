<?php include('Crypto.php');
include ('../db.php');
include ('../config.php');
include ('../vars.php');
include ('../security.php');?>
<?php

	error_reporting(0);
	
	$workingKey='FFEA1154FE6961B72AE45794508F90EB';		
	$encResponse=$_POST["encResp"];			
	$rcvdString=decrypt($encResponse,$workingKey);	
	// $order_status ="";
	$decryptValues=explode('&', $rcvdString);
	$dataSize=sizeof($decryptValues);
	echo "<center>";

	for($i = 0; $i < $dataSize; $i++) 
	{
		$information=explode('=',$decryptValues[$i]);
		if($i==3)	$order_status=$information[1];
		if($i==2)	$bank_ref_no=$information[1];
		if($i==1)	$tracking_id=$information[1];
		if($i==0)	$order_id=$information[1];
	}

	if($order_status==="Success")
	{
		// echo "<br>Thank you for shopping with us. Your credit card has been charged and your transaction is successful. We will be shipping your order to you soon.";
		// entry in database.

	}
	else if($order_status==="Aborted")
	{
		// echo "<br>Thank you for shopping with us.We will keep you posted regarding the status of your order through e-mail";
	
		// entry in database.
	}
	else if($order_status==="Failure")
	{
		// echo "<br>Thank you for shopping with us.However,the transaction has been declined.";
		// entry in database.
	}
	else
	{
		echo "<br>Security Error. Illegal access detected";
	
	}

	 $sql1 = "UPDATE orderdetails SET payment_status ='".$order_status."', booking_status='".$order_status."',payment_txndetails_id='".$tracking_id."',bank_ref_no='".$bank_ref_no."', barcode ='".$barcodes."' WHERE bookingnumber='$order_id'";
    // print_r($sql1);


try {
	    if (mysqli_query($conn, $sql1)) 
	    { 

	    	 $sql2 = mysqli_query($conn, "SELECT * FROM `orderdetails` WHERE `bookingnumber` = '$order_id'");
	    	//  print_r($sql2);
	            while($row=mysqli_fetch_array($sql2)){
	               		$id=$row['orderdetails_id'];
	                    $visitdate = $_SESSION['cdate'];
	                    $url = GENURL."WebTicketBooking";
	                    $ORGANIZATIONCODE = ORGANIZATIONCODE;
	                    $ISSUER = ISSUER;
	                    $VERSION = VERSION;
	                    $BOOKINGNUMBER = $order_id;
						$BARCODE = $barcodes;
	                    $BOOKINGDATE = date('d-m-Y');
	                    $LOCCODE = "NGCP";
	                    $NAME = $row['custname'];   //fromdb
	                    $IDENTITYPROOFTYPE = "";
	                    $IDENTITYPROOFNO = "";
	                    $CONTACTNO =  $row['contactno']; //fromdb
	                    $CUSTLOCATION =  $row['custlocation']; //fromdb
	                    $AGENTCODE = "NGCP_WEB";
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
	                    
	                    // $cartcount = count($cart);
	                }

	                    $bookingtickets = array();
	                    // echo "SELECT * FROM order_ticket_details as otd ,orderdetails as od WHERE otd.orderdeatils_id=od.orderdetails_id AND od.bookingnumber='".$order_id."'";
	                    //from orderdetails table 
	                	$query2= mysqli_query($conn,"SELECT * FROM order_ticket_details WHERE orderdeatils_id='".$id."'");
	                     while($row=mysqli_fetch_array($query2)){
	                        $disc = 0;
	                        $object = new stdClass();
	                        $object->PRICECARDCODE = $row['pricecardcode'];  //fromdb
	                        $object->NOOFTICKETS = $row['nooftickets']; //fromdb
	                        $object->RATE = $row['rate']; //fromdb
	                        $object->AMOUNT = $row['amount']; //fromdb
	                        $object->TICKETDESCRIPTION = $row['description']; //fromdb
	                        $object->DISCOUNT_AMOUNT = $row['discount_amount']; //fromdb

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
	                        "BARCODE" => $barcodes,
	                        "BOOKINGDATE" => $BOOKINGDATE,
	                        "LOCCODE" => $LOCCODE,
	                        "NAME" => $NAME,
	                        "IDENTITYPROOFTYPE" => $IDENTITYPROOFTYPE,
	                        "IDENTITYPROOFNO" => $IDENTITYPROOFNO,
	                        "CONTACTNO" => $CONTACTNO,
	                        "CUSTLOCATION" => $CUSTLOCATION,
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
	                  	$result_data1 = json_decode($result, true);
// print_r($param);
	                    $jsonstring = json_encode($result_data1);
// print_r($result_data1);
	                   if (isset($result_data1['TicketsBarcode']) && is_array($result_data1['TicketsBarcode'])) {
				        foreach ($result_data1['TicketsBarcode'] as $barcodeData) {
				            $barcode[] = $barcodeData['BARCODE'];
				        }
				        } else {
				            echo "No TicketsBarcode found in the response";
				        }
	                    curl_close($ch);
						        $_SESSION['barcodes'] = implode(',',$barcode);

								$sql2 = "UPDATE orderdetails SET barcode ='". $_SESSION['barcodes']."' WHERE bookingnumber='$order_id'";
								// print_r($sql1);
								$re=mysqli_query($conn, $sql2); 
								
						        // print_r($_SESSION);
								// echo "Array ( [barcodes] => " . $_SESSION['barcodes'] . " )";

			echo '<script>window.location.href = "../step-5.php?orderid=' . $order_id.'&barcodes='.implode(',',$barcode).'";</script>'; 
	      } else {
	        echo 'Errors';
	    }
	} catch (Exception $ee) {
		//  print_r($_SESSION);
  	  echo 'AFSFSD'.$ee->getMessage(); 
	}

?>
