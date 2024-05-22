<?php

define('MERCHANT_ID', 'ecoecd0067');
define('PROFILE_ID',  '6A90787B-6552-49C3-AE7D-9333FE9E5EF7');
define('ACCESS_KEY',  '7019da92f557303f863208949cd7cb08');
define('SECRET_KEY',  '777ffa1b82154a6cb119484209615437318c6012ea43403abf12f3ac9b291dc1437de055226141698aa7e12be798e0f93a3293bee0d741c0b7b0c0d99301ad5dcb7e847081d648eba1d42989fa99b83b693f13990e9849ed8d3f77d1b40e2b68dd8c836673264c139ca7ce47b442390b17df8c4052894134b70a89ab9ff755ac');

// DF TEST: 1snn5n9w, LIVE: k8vif92e 
define('DF_ORG_ID', 'k8vif92e');

// PAYMENT URL
define('CYBS_BASE_URL', 'https://secureacceptance.cybersource.com');

define('PAYMENT_URL', CYBS_BASE_URL . '/pay');
//define('PAYMENT_URL', '/sa-sop/debug.php');



define('TOKEN_CREATE_URL', CYBS_BASE_URL . '/token/create');
define('TOKEN_UPDATE_URL', CYBS_BASE_URL . '/token/update');

// EOF