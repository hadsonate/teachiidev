<?php

require 'services/AuthorizeNet/vendor/autoload.php';
require_once('services/AuthNetTest/constants/Constants.php');

use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use services\AuthNetTest\constants\Constants;

define("AUTHORIZENET_LOG_FILE", "phplog");

class Paynow
{
    public function __construct()
    {
    }

    function chargeCreditCard($amount)
    {
        // Common setup for API credentials
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();

        $merchantAuthentication->setName(Constants::MERCHANT_LOGIN_ID);
        $merchantAuthentication->setTransactionKey(Constants::MERCHANT_TRANSACTION_KEY);

        $refId = 'ref' . time();

        // Create the payment data for a credit card
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber("4111111111111111");
        $creditCard->setExpirationDate("1226");
        $creditCard->setCardCode("123");
        $paymentOne = new AnetAPI\PaymentType();
        $paymentOne->setCreditCard($creditCard);
        $order = new AnetAPI\OrderType();
        $order->setDescription("New Item");

        //create a transaction
        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType("authCaptureTransaction");
        $transactionRequestType->setAmount($amount);
        $transactionRequestType->setOrder($order);
        $transactionRequestType->setPayment($paymentOne);
        //Preparing customer information object
        $cust = new AnetAPI\CustomerAddressType();
        $cust->setFirstName('hadrian');
        $cust->setLastName('onate');
        $cust->setAddress('#test Address');
        $cust->setCity('testCity');
        $cust->setState('testState');
        $cust->setCountry('testCountry');
        $cust->setZip('6100');
        $cust->setPhoneNumber('(0917) 505 4429');
        $cust->setEmail("hadrian.onate@gmail.com");

        $transactionRequestType->setBillTo($cust);
        $request = new AnetAPI\CreateTransactionRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setTransactionRequest($transactionRequestType);
        $controller = new AnetController\CreateTransactionController($request);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
        if ($response != null) {
            if ($response->getMessages()->getResultCode() == Constants::RESPONSE_OK) {
                $tresponse = $response->getTransactionResponse();
                if ($tresponse != null && $tresponse->getMessages() != null) {
                    echo " Transaction Response code : " . $tresponse->getResponseCode() . "\n";
                    echo "Charge Credit Card AUTH CODE : " . $tresponse->getAuthCode() . "\n";
                    echo "Charge Credit Card TRANS ID  : " . $tresponse->getTransId() . "\n";
                    echo " Code : " . $tresponse->getMessages()[0]->getCode() . "\n";
                    echo " Description : " . $tresponse->getMessages()[0]->getDescription() . "\n";
                } else {
                    echo "Transaction Failed \n";
                    if ($tresponse->getErrors() != null) {
                        echo " Error code  : " . $tresponse->getErrors()[0]->getErrorCode() . "\n";
                        echo " Error message : " . $tresponse->getErrors()[0]->getErrorText() . "\n";
                    }
                }
            } else {
                echo "Transaction Failed \n";
                $tresponse = $response->getTransactionResponse();
                if ($tresponse != null && $tresponse->getErrors() != null) {
                    echo " Error code  : " . $tresponse->getErrors()[0]->getErrorCode() . "\n";
                    echo " Error message : " . $tresponse->getErrors()[0]->getErrorText() . "\n";
                } else {
                    echo " Error code  : " . $response->getMessages()->getMessage()[0]->getCode() . "\n";
                    echo " Error message : " . $response->getMessages()->getMessage()[0]->getText() . "\n";
                }
            }
        } else {
            echo "No response returned \n";
        }
        return $response;
    }
}
//
$amount = Constants::SAMPLE_AMOUNT;
if (!empty($_POST['amount']))
    $amount = $_POST['amount'];
if (!defined('DONT_RUN_SAMPLES'))
    $this->chargeCreditCard($amount);