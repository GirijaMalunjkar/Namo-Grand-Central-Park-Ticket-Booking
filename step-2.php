<?php

session_start();

// print_r($_SESSION);

if(isset($_SESSION['ccart'])) {
    $cart = $_SESSION['ccart'];
    $cartcount = count($cart);
    
    if($cartcount == 0) {
        header("Location: index.php?error=emptycart");
        exit();
    } else {
        if(isset($_SESSION['cpricecard'])) {
            $pricecard = $_SESSION['cpricecard'];
            $cardcount = count($pricecard);
            for($i = 0; $i < $cardcount; $i++) {
                for($j = 0; $j < $cartcount; $j++) {
                    if($pricecard[$i]->CODE == $cart[$j]->code) {
                        $ticketamount = $pricecard[$i]->TICKETAMOUNT;
                        $quantity =  $cart[$j]->quantity;
                        $total_amount = $ticketamount * $quantity;
                        $cart[$j]->totalamount = $total_amount;
                    }
                }
            }
        }
    }
} else {
    header("Location: index.php?error=emptycart");
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_SESSION['cuser'])) {
        $user = $_SESSION['cuser'];
        $user->full_name = $_POST['full_name'];
        $user->email_id = $_POST['email_id'];
        $user->mobile_no = $_POST['mobile_no'];
        $user->countrycode = $_POST['countrycode'];
        $user->area_location = $_POST['area_location'];
        $_SESSION['cuser'] = $user;
    } else {
        $user = new stdClass();
        $user->full_name = $_POST['full_name'];
        $user->email_id = $_POST['email_id'];
        $user->mobile_no = $_POST['mobile_no'];
        $user->countrycode = $_POST['countrycode'];
        $user->area_location = $_POST['area_location'];
        $_SESSION['cuser'] = $user;
    }
    header("Location: step-3.php");
    exit();
}
// print_r($_SESSION);
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
                <div class="col-12">
                    <a class="btn back-btn" href="index.php">Back</a>
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
                        <li id="step-2" class="is-active">
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
                <div class="col-12 col-md-3 col-lg-4 col-sm-3">
                      <?php
                    
                            if(isset($_SESSION['cuser']))
                            {
                                $userdetails =  $_SESSION['cuser'];
                            }
                        ?>
                </div>
                <div class="col-12 col-md-6 col-lg-4 col-sm-6">
                    <div class="emb-bg">
                        <form action="step-2.php" method="POST" id="myfrm" onsubmit="return validateForm()">
                        <div class="contact-form dt-form">
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="full_name">Full Name</label>
                                    <input type="text" class="form-control"  name="full_name" required="required" id="full_name" autocomplete="off" oninput="this.value = this.value.replace(/^([0-9][a-zA-Z]*)|([0-9]+)$/g, '').replace(/[$&amp;+,:;=?[\]@#|{}'<>.^*()%!-/]/, '');"
                                        placeholder="Enter your name" value="<?= isset($userdetails->full_name) ? $userdetails->full_name : ''; ?>" maxlength="20">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="email_id">Email Address</label>
                                    <input type="email" class="form-control" name="email_id" id="email_id" placeholder="Enter your email" value="<?= isset($userdetails->email_id) ? $userdetails->email_id : ''; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="mobile_no">Mobile Number</label>
                                    <input type="text" pattern="[789][0-9]{9}" id="mobile_no" class="form-control" placeholder="Enter your Mobile no" name="mobile_no" oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                        minlength="10" maxlength="10" value="<?= isset($userdetails->mobile_no) ? $userdetails->mobile_no : ''; ?>" required>
                                </div>
                                <div class="col-12">
                                    <input id="whatsapp" style="margin-right: 10px;display: none;" type="checkbox" name="consent">
                                    <!-- Share ticket on WhatsApp -->
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="area">Area/ Location</label>
                                    <select class="form-control" id="area" name="area_location" value="<?= isset($userdetails->area_location) ? $userdetails->area_location : ''; ?>" required>
                                        <option value="thane">Thane</option>
                                        <option value="mumbai">Mumbai</option>
                                        <option value="palghar">Palghar</option>
                                        <option value="mumbai_suburban">Mumbai Suburban</option>
                                        <option value="navi_mumbai">Navi Mumbai</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <button class="btn sub-btn" onclick="startCountdown(120, document.querySelector('#countdown'))" id="sendOTP">Continue To Review Order</button>
                                    <!-- id="sendOTP" -->
                                </div>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
                <div class="col-12 col-md-3 col-lg-4 col-sm-3">

                </div>
            </div>
        </div>
    </section>

    <div id="OtpModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
      
          <!-- Modal content-->
          <div class="modal-content">
        
            <div class="modal-body">
              <form class="OtpForm" >
                <div class="form-group row">
                    <div class="col-12">
                        <label for="otp">OTP </label>
                        <input type="text" class="form-control" name="otp" id="otp">
                        <label style="color:green" id="msg"></label>
                    </div>
                </div>
                <div>Please wait : <span id="countdown">05:00</span></div>
              </form>
            </div>
            <div class="modal-footer">
                <button class="btn sub-btn" onClick="matchotp()">Submit</button>
                <button class="btn resend-btn" onclick="startCountdown(120, document.querySelector('#countdown'))" id="sendOTP1">Resend OTP</button>
                <!-- id="sendOTP1" -->
            </div>
          </div>
      
        </div>
      </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        let step = 'step-2';

        const step1 = document.getElementById('step-1');
        const step-2 = document.getElementById('step-2');
        const step-3 = document.getElementById('step-3');
        const step4 = document.getElementById('step-4');
        const step5 = document.getElementById('step-5');

        function next() {
            if (step === 'step1') {
                step = 'step-2';
                step1.classList.remove("is-active");
                $(step1).find('.progress-bar__bar').css('transform', 'translateX(100%)');
                $(step1).find('.progress-bar__bar').css('-webkit-transform', 'translateX(100%)');
                step-2.classList.add("is-active");
            } else if (step === 'step-2') {
                step = 'step-3';
                step-2.classList.remove("is-active");
                $(step-2).find('.progress-bar__bar').css('transform', 'translateX(100%)');
                $(step-2).find('.progress-bar__bar').css('-webkit-transform', 'translateX(100%)');
                step-3.classList.add("is-active");
                window.location.href = "step-3.php";
            } else if (step === 'step-3') {
                step = 'step4';
                step-3.classList.remove("is-active");
                $(step-3).find('.progress-bar__bar').css('-webkit-transform', 'translateX(100%)');
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

    <script>
        // -----Country Code Selection
        $("#mobile_no").intlTelInput({
            initialCountry: "in",
            separateDialCode: true,
            allowDropdown: false,
            onlyCountries: ["in"],
            // utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.4/js/utils.js"
        });

        function openOtpModal() {
        $('#OtpModal').modal('show');
        return false;
    }
    $(document).ready(function(){
        $("#sendOTP1").click(function(){
        var mobileNo = $("#mobile_no").val();
        $.ajax({
            url: 'sendotp.php?phone=' + mobileNo,
            type: 'POST',
            data: {mobile_no: mobileNo},
            success: function(response){
                // Assuming response contains the OTP
                $('#msg').text("OTP resent successfully!");
                otp=response;
            },
            error: function(xhr, status, error) {
            
                console.error(xhr.responseText);
                alert("Error sending OTP. Please try again later.");
            }
        });
    });

        $("#sendOTP").click(function(){
        var mobileNo = $("#mobile_no").val();
        $.ajax({
            url: 'sendotp.php?phone=' + mobileNo,
            type: 'POST',
            data: {mobile_no: mobileNo},
            success: function(response){
                // Assuming response contains the OTP
                $('#msg').text("OTP sent successfully!");
                otp=response;
            },
            error: function(xhr, status, error) {
            
                console.error(xhr.responseText);
                alert("Error sending OTP. Please try again later.");
            }
        });
    });
});
var otp="";
function matchotp() {
    var enteredOTP = document.getElementById('otp').value;
    // Verify OTP
    if (enteredOTP == otp) {
        // window.location = ; 
        // return true;
        document.getElementById('myfrm').submit();
        } else {
        $('#msg').text("Invalid OTP. Please try again.");
    }
}

function startCountdown(duration, display) {
    var timer = duration, minutes, seconds;
    var resendButtons = document.querySelectorAll('.resend-btn');
    resendButtons.forEach(function(button) {
        button.disabled = true; // Initially disable all buttons with the class "resend-btn"
    });

    var countdownInterval = setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 5 ? "0" + minutes : minutes;
        seconds = seconds < 5 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds;

        if (--timer < 0) {
            clearInterval(countdownInterval); // Clear the countdown interval
            display.textContent = "00:00"; // Update display to 00:00
            resendButtons.forEach(function(button) {
                button.disabled = false; // Enable all buttons with the class "resend-btn"
            });
        }
    }, 1000);
}
 </script>
      <script>
        function validateForm() {
            var full_name =  document.getElementById('full_name').value;
            var email_id = document.getElementById('email_id').value;
            var mobile_no = document.getElementById('mobile_no').value;

            if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email_id))
            {
                alert("Invalid Email Format");
                return false;
            }else{

            // if(!/^[0]?[789]\d{9}$/.test(mobile_no))
            // {
            //     alert("Invalid Mobile Number");
            //     return false;
            // }
            
            // if(!/^[0]?[0]\d{9}$/.test(mobile_no))
            // {
            //     alert("Invalid Mobile Number"); //start from 0
            //     return false;
            // }
            //    $('#OtpModal').show();
            }
            return openOtpModal();
        }
      </script>

</body>

</html>