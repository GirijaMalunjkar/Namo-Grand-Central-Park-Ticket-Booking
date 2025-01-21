

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
<?php
session_start(); // Start the PHP session function
include ('../config.php');
include ('../security.php');
require 'vars.php';
require 'db.php';

$orderid = isset($_GET["orderid"]) ? $_GET["orderid"] : 0000;

$bookingstatus = false;
echo '<table class="table table-stripped">';
echo '<tr><td>custname</td><td>Booking date</td><td>Email</td><td>amount</td><td>Payment status</td><td>booking_status</td></tr>';
$sql = "SELECT * FROM orderdetails";
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
         echo '<tr>';
         echo '<td>'.$row["custname"].'</td>';
         echo '<td>'.$row["bookingdate"].'</td>';
         echo '<td>'.$row["contactno"].'</td>';
         echo '<td>'.$row["email"].'</td>';
         echo '<td>'.$row["online_amount"].'</td>';
         echo '<td>'.$row["payment_status"].'</td>';
         echo '<td>'.$row["booking_status"].'</td>';
         echo '</tr>';

    }
} 


echo '</table>';