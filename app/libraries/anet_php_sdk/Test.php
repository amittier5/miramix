<?php
    require_once 'AuthorizeNet.php'; 
    define("AUTHORIZENET_API_LOGIN_ID", "6k4KC4k2");
    define("AUTHORIZENET_TRANSACTION_KEY", "83QDXfq35wmH8m3S");
    //define("AUTHORIZENET_SANDBOX", true);
    $sale = new AuthorizeNetAIM;
    $sale->amount = "0.01";
    $sale->card_num = '4042760173301988';
    $sale->exp_date = '05/13';
    $response = $sale->authorizeAndCapture();
    if ($response->approved) {
       echo $transaction_id = $response->transaction_id;
    }
?>
	