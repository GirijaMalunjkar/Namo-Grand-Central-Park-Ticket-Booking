<?php

session_start();

$otp = rand(100000, 999999);

$mobileNumber = $_GET['phone'];

$curl = curl_init();

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
                        "to" => "91".$mobileNumber 
                    )
                ),
                "text" => "Dear Visitor, OTP for your mobile verification is ".$otp.". Thank you for visiting website. -Kalpataru",
                "regional" => array(
                    "indiaDlt" => array(
                        "principalEntityId" => "1101596160000018848",
                        "contentTemplateId" => "1107170927802591866"
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

if(curl_errno($curl)){
    // echo 'Curl error: ' . curl_error($curl);
}

curl_close($curl);

// echo $response;
echo $otp;
?>
