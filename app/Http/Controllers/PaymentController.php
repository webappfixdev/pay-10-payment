<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pay10PGModule;

class PaymentController extends Controller
{
    public function index()
    {
        $pay10_transaction = new Pay10PGModule;

        $global_vars = $GLOBALS['global_vars'];

        //Mandate Fields
        $pay10_transaction->setPayId($global_vars['PAY_ID']);
        $pay10_transaction->setPgRequestUrl($global_vars['PG_REQUEST_URL']);
        $pay10_transaction->setSalt($global_vars['SALT']);
        $pay10_transaction->setReturnUrl($global_vars['RETURN_URL']);
        $pay10_transaction->setCurrencyCode($global_vars['CURRENCY_CODE']);
        $pay10_transaction->setTxnType($global_vars['TXNTYPE']);
        $pay10_transaction->setOrderId(time());
        $pay10_transaction->setCustEmail('dharmesh@gmail.com');
        $pay10_transaction->setCustName('Dharmesh Chauhan');
        $pay10_transaction->setCustStreetAddress1('Rajkot');
        $pay10_transaction->setAmount(1*100); // convert to Rupee from Paisa
        $pay10_transaction->setCustPhone(9999999999);

        //Mandate Fields

        //Optional Fields

        // $pay10_transaction->setCustCity((isset($_REQUEST['CUST_CITY'])?$_REQUEST['CUST_CITY']:''));
        // $pay10_transaction->setCustState((isset($_REQUEST['CUST_STATE'])?$_REQUEST['CUST_STATE']:''));
        // $pay10_transaction->setCustCountry((isset($_REQUEST['CUST_COUNTRY'])?$_REQUEST['CUST_COUNTRY']:''));
        // $pay10_transaction->setCustZip((isset($_REQUEST['CUST_ZIP'])?$_REQUEST['CUST_ZIP']:''));
        // $pay10_transaction->setProductDesc((isset($_REQUEST['PRODUCT_DESC'])?$_REQUEST['PRODUCT_DESC']:''));
        // $pay10_transaction->setCustShipStreetAddress1((isset($_REQUEST['CUST_SHIP_STREET_ADDRESS1'])?$_REQUEST['CUST_SHIP_STREET_ADDRESS1']:''));
        // $pay10_transaction->setCustShipCity((isset($_REQUEST['CUST_SHIP_CITY'])?$_REQUEST['CUST_SHIP_CITY']:''));
        // $pay10_transaction->setCustShipState((isset($_REQUEST['CUST_SHIP_STATE'])?$_REQUEST['CUST_SHIP_STATE']:''));
        // $pay10_transaction->setCustShipCountry((isset($_REQUEST['CUST_SHIP_COUNTRY'])?$_REQUEST['CUST_SHIP_COUNTRY']:''));
        // $pay10_transaction->setCustShipZip((isset($_REQUEST['CUST_SHIP_ZIP'])?$_REQUEST['CUST_SHIP_ZIP']:''));
        // $pay10_transaction->setCustShipPhone((isset($_REQUEST['CUST_SHIP_PHONE'])?$_REQUEST['CUST_SHIP_PHONE']:''));
        // $pay10_transaction->setCustShipName((isset($_REQUEST['CUST_SHIP_NAME'])?$_REQUEST['CUST_SHIP_NAME']:''));

        //Optional Fields

        $postdata = $pay10_transaction->createTransactionRequest();
        $pay10_transaction->redirectForm($postdata);
    }

    public function success(Request $request)
    {
        $input = $request->all();

        $pay10_transaction = new Pay10PGModule;

        $global_vars = $GLOBALS['global_vars'];

        $pay10_transaction->setSalt($global_vars['SALT']);
        $pay10_transaction->setMerchantHostedKey($global_vars['HOSTED_KEY']);
        $string = $pay10_transaction->aes_decryption($_POST['ENCDATA']);
        
        $data = $pay10_transaction->split_decrypt_string($string); 

        dd($data);
    }
}
