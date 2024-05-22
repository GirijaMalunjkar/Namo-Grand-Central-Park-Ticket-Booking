<?php
include ('db.php');
include ('config.php');
include ('security.php');

require 'vars.php';

// Fetch data from the database
$sql = "SELECT od.* FROM orderdetails AS od WHERE  od.bookingnumber='".$_GET['orderid']."';";
// echo $sql;

$result = mysqli_query($conn, $sql);
// print_r($mysqli_fetch_assoc($result));
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $ordertableid=$row['orderdetails_id'];
        $BOOKINGNUMBER =  $row['bookingnumber'];
        $BOOKINGDATE =  $row['bookingdate'];
        $NAME =  $row['custname'];
        $EMAILID =  $row['email'];
        $CONTACTNO =  $row['contactno'];
        $LOCATION =  $row['custlocation'];
        $BARCODE =  $row['barcode'];
        $AMOUNT= $row['online_amount'];
    }
    $barcodes = explode(',',$BARCODE);
} else {
    echo "No results found.";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ticket Booking</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="icon" href="images/favicon.png" type="image/png" sizes="16x16">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/dnSlide.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="main2">
    <div class="container container2">
        <a href="index.php"><img src="images/logo.png"></a>
        <span style="font-size: x-large; font-weight: 600; color: #d82b6e;">NaMo Grand Central Park Online Booking Platform</span>
    </div>
</div>

<div class="stepper-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a class="btn back-btn" href="https://namograndcentralpark.com/">Visit Our Site</a>
            </div>
        </div>
    </div>
</div>

<section class="emb-join-wrap">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                <h4 class="text-body-m wloRE-1 emb-ext">
                    <span style="display: flex; flex-direction: column;">YOUR TICKET NO : <?php echo "#".$BOOKINGNUMBER ?></span>
                </h4>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                <div class="emb-bg">
                    <h4 class="text-body-m wloRE emb-ext">
                        <span>Booking Date</span>
                        <span id="dateDisplay"><?php echo $BOOKINGDATE ?></span>
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
                            <p><?php echo $NAME ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5 col-md-5 col-lg-3 col-xl-3">
                            <p>Email ID</p>
                        </div>
                        <div class="col-7 col-md-7 col-lg-9 col-xl-9">
                            <p><?php echo $EMAILID ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5 col-md-5 col-lg-3 col-xl-3">
                            <p>Phone No.</p>
                        </div>
                        <div class="col-7 col-md-7 col-lg-9 col-xl-9">
                            <p>(<?php echo '+91' ?>) <?php echo $CONTACTNO ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5 col-md-5 col-lg-3 col-xl-3">
                            <p>Area/Location</p>
                        </div>
                        <div class="col-7 col-md-7 col-lg-9 col-xl-9">
                            <p><?php echo $LOCATION ?></p>
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
                                    <th style="padding-right: 15px;">Particular</th>
                                    <th style="padding-right: 15px;">Qty</th>
                                    <th style="padding-right: 15px;">Amount</th>
                                </tr>
                                <?php
                                 $bi=0;
                             
                                $sql = "SELECT * FROM  order_ticket_details WHERE orderdeatils_id='".$ordertableid."';";
                                $result = mysqli_query($conn, $sql);
                                // print_r($mysqli_fetch_assoc($result));
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        
                                $q=$row['nooftickets'];
                                for ($k=0; $k <$q; $k++) { 
                                    
                                    ?>
                                <tr>
                                    <td style="width:20%">
                                        <p><?php echo $row['pricecardcode'] ?></p>
                                    </td>
                                    <td style="width:20%">
                                        <p>1</p>
                                    </td>
                                    <td style="width:20%">
                                        <p><?php echo $row['rate']?> <i class="fa fa-inr" aria-hidden="true"></i></p>
                                    </td>
                                    <td>
                                    <p>
                                        <img src="phpqrcode/temp/<?php echo $barcodes[$bi]?>.png" style="width:100px" alt="Barcode">
                                    </td>
                                </tr>
                                <?php $bi++;}
                                    }
                                }?>
                            </table>
                            <hr class="emb-hr-1">
                            <div class="text-body-m wloRE emb-ext">
                                <h4 class="text-body-m wloRE" style="display: flex; flex-direction: row; gap: 40px;">
                                    <span>TOTAL</span>
                                    <span><?php echo $AMOUNT; ?><i class="fa fa-inr" aria-hidden="true"></i></span>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</body>

</html>


