<?php
namespace Netricite\AppClass;

use Netricite\Framework as fw;
/**
 * @author jp
 * @version 2016-14
 *
 * company information is located in config.ini
 */

class PaymentAltapay  extends Payment {
    private $user; 
    private $pwd;
    private $signature;
    private $endpoint;
    private $errors=array();
    private $version;
    private $prod;
    
    /**
     * constructor
     */
    public function __construct($user=false, $pwd=false,$signature=false,$mode=false) {
        parent::__construct();
        $this->user=fw\fwConfiguration::get('paypal.api.user');
        $this->pwd=fw\fwConfiguration::get('paypal.api.pwd');
        $this->signature=fw\fwConfiguration::get('paypal.api.signature');
        $this->endpoint=fw\fwConfiguration::get('paypal.api.endpoint');
        $this->version=fw\fwConfiguration::get('paypal.api.version');
        $this->prod=fw\fwConfiguration::get('paypal.api.prod');
        
        if ($user) $this->user=$user;
        if ($pwd) $this->pwd=$pwd;
        if ($signature) $this->signature=$signature;
        if ($prod) $this->endpoint=str_replace('sandbox.', '', $this->endpoint);                 //endpoint without 'sandbox.'
     
    }
    

    public function altapayPayment() {
        //appTrace(debug_backtrace());
        $this->logger->addDebug(".altapayPayment", debug_backtrace());
        echo "Creating ALTAPAY payment";
        $merchant=new payment\merchantAPI();
        $merchant->connect("https://testgateway.altapaysecure.com", "jpguilleron@hotmail.com", "JP.lebeau01");
         
        $baseUrl="http://192.168.1.11";
        $config=array();
        $config['callback_form']=$baseUrl ."/netricite/v2016-14/payment.php";
        $config['callback_ok']=$baseUrl ."/netricite/v2016-14/payment.php";
        $config['callback_fail']=$baseUrl ."/netricite/v2016-14/payment.php";
        $config['callback_redirect']=$baseUrl ."/netricite/v2016-14/payment.php";
        $config['callback_open']=$baseUrl ."/netricite/v2016-14/payment.php";
        $config['callback_notification']=$baseUrl ."/netricite/v2016-14/payment.php";
        $config['callback_verify_order']=$baseUrl ."/netricite/v2016-14/payment.php";
         
        $terminal="netricite Test Terminal";
        $orderid=rand(1, 1000);
        echo "Order id:" . $orderid;
        $amount="100.10";
        $currency="EUR";
        $paymentType="paymentAndCapture";
        $transaction_info=array("transaction_info"=>"my first transaction");
         
        $args = array(
            'terminal'=>$terminal,
            'shop_orderid'=>$orderid,
            'amount'=>$amount,
            'currency'=>$currency,
            'type'=>$paymentType,
            'transaction_info'=>$transaction_info,
            'sale_invoice_number'=>$orderid,
            'cookie'=>"my cookie for the payment"
        );
         
        $customer_info=array();
        $customer_info['billing_city']="Les Gets";
        $customer_info['billing_region']="Rhone Alpes";
        $customer_info['billing_country']="FR";
        $customer_info['billing_postal']="74260";
        $customer_info['billing_address']="136 route du Lery";
        $customer_info['billing_lastname']="guilleron";
        $customer_info['billing_firstname']="jp";
        $customer_info['email']="jp.guilleron@gmail.com";
         
        //load arg lists
        $args['config'] = $config;
        $args['customer_info'] = $customer_info;
         
        echo '<p>'.'You are now going to be redirected to AltaPay Payment Gateway'.'</p>';
        $response=$merchant->createPaymentRequest($args);
        //response = xml->Body[0]
        if ($response) {
            appWatch(array("Body.Result"=>(string)$response->Result, "Body.PaymentRequestId"=>(string)$response->PaymentRequestId, "Body.Url"=>(string)$response->Url),
                "back from merchant API", get_class($this));
            $redirectURL=(string)$response->Url;
            $link= '<script type="text/javascript">window.location.href = "'.$redirectURL.'"</script>';
             
            //$redirectURL=(string)$response->DynamicJavascriptUrl;
            //$link='<script type="text/javascript" src="'.$redirectURL.'"></script>';
             
            //$callback=new payment\callbackHandler();
            //$redirectURL=$callback->parseXmlResponse($response);
             
            appWatch(array("redirect"=>$link),"redirect", get_class($this));
            header("HTTP/1.1 302 Found");
            echo $link;
             
            // similar behavior as clicking on a link
            //header("Location: $redirectURL");
            exit;
             
        } else info("E", "merchantAPI returns false");
        return FALSE;
    }
    
    public function callback() {
        //appTrace(debug_backtrace());
        $this->logger->addDebug(".callback", debug_backtrace());
        if (isset($_SERVER['HTTP_COOKIE']))
            appWatch($_SERVER['HTTP_COOKIE'], "cookie", get_class($this));
            echo "altapay callback";
            var_dump($_POST);
            //$this->index();
            /*
             appWatch($_POST['code'], "callback code", get_class($this));
             switch ($_POST['code']) {
             case "form":
             break;
             case "ok":
             break;
             case "fail":
             break;
             case "redirect":
             break;
             case "open":
             break;
             case "notification":
             break;
             case "form":
             break;
             case "verify":
             break;
             default:
             throw new \Exception("Altapay - unknown callback code");
    
             }
             */
    }
    
}