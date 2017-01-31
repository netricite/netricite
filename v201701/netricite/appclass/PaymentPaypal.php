<?php
namespace Netricite\AppClass;

use Netricite\Framework as fw;
/**
 * @author jp
 * @version 2016-14
 *
 * company information is located in config.ini
 */

class PaymentPaypal  extends Payment {
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
    public function __construct($user=false, $pwd=false,$signature=false,$prod=false) {
        parent::__construct();
        $this->user=fw\fwConfiguration::get('paypal.api.username');
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

/*
 * request: Function to perform the API call to PayPal using API signature
 * @methodName is name of API  method.
 * @params = nvp string.
 * returns an associtive array containing the response from the server.
 */
    public function request($method,$params)
    {
    $this->logger->addDebug($method, debug_backtrace());
    $nvpParams=array_merge($params, array(
          "METHOD"=>$method,
          "USER"=>$this->user,
          "SIGNATURE"=>$this->signature,
          "PWD"=>$this->pwd,
          "VERSION"=>$this->version
    ));
    $this->logger->addInfo($method, $nvpParams);
    //setting the curl parameters.
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL,$this->endpoint);
    curl_setopt($curl, CURLOPT_VERBOSE, 1);

    //turning off the server and peer verification(TrustManager Concept).
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    //curl_setopt($curl, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POST, 1);

    //setting the params as POST FIELD to curl
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($nvpParams));

    //getting response from server
    $response = curl_exec($curl);
    $nvpResponse=array();
    parse_str($response, $nvpResponse);
    $this->logger->addInfo("paypal response", $nvpResponse );

    if (curl_errno($curl))
    {
        //CURL Error
        $this->errors=curl_errno($curl) ."/". curl_error($curl);

        //Execute the Error handling module to display errors.
        $this->logger->addError( $this->errors );
        //closing the curl
        curl_close($curl);
        throw new \Exception("curl error: " .  $this->errors);
    }
    else
    {
        //closing the curl
        curl_close($curl);
        $ack = strtoupper($nvpResponse["ACK"]);
        if($ack=="SUCCESS" || $ack=="SUCCESSWITHWARNING")  //if SetExpressCheckout API call is successful
        {
             return $nvpResponse;
        }
        else
        {
            //Display a user friendly Error on the page using any of the following error information returned by PayPal
            $ErrorCode = urldecode($nvpResponse["L_ERRORCODE0"]);
            $ErrorShortMsg = urldecode($nvpResponse["L_SHORTMESSAGE0"]);
            $ErrorLongMsg = urldecode($nvpResponse["L_LONGMESSAGE0"]);
            $ErrorSeverityCode = urldecode($nvpResponse["L_SEVERITYCODE0"]);
        
            $html = $method . " PAYPAL API call request failed. ";
            $html .=  $ErrorLongMsg;
            //$html .=  "Short Error Message: " . $ErrorShortMsg;
            $html .=  " Error Code: " . $ErrorCode;
            $html .=  " Error Severity Code: " . $ErrorSeverityCode;
            $this->logger->addError($ErrorLongMsg, $nvpResponse);
            info("E", $ErrorLongMsg);
            return $nvpResponse;
        }
    }
   
    }

    public function loadParams($appdata) {
        //var_dump($appdata);
        $userdata=$appdata['userdata'];
        $order=$appdata['payment'][0]['order'];
        $products=$appdata['payment'][1];
        $this->logger->addInfo("appdata", $appdata);
        
        $params=array(
            "PAYMENTREQUEST_0_AMT" => $order['netamount'],
            "PAYMENTREQUEST_0_CURRENCYCODE"=>fw\fwConfiguration::get('company.currency'),
            "PAYMENTREQUEST_0_SHIPPINGAMT"=>0,
            "PAYMENTREQUEST_0_ITEMAMT"=>$order['grossamount'],
            "PAYMENTREQUEST_0_TAXAMT"=>$order['tax'],
            "PAYMENTREQUEST_0_SHIPTOSTREET" =>$userdata['address'],
            "PAYMENTREQUEST_0_SHIPTOSTREET2" =>"",
            "PAYMENTREQUEST_0_SHIPTOCITY" =>$userdata['city'],
            "PAYMENTREQUEST_0_SHIPTOSTATE" =>"",
            "PAYMENTREQUEST_0_SHIPTOZIP" =>$userdata['zipcode'],
            "PAYMENTREQUEST_0_SHIPTOCOUNTRYNAME" =>$userdata['country'],
            "PAYMENTREQUEST_0_SHIPTOPHONENUM" =>$userdata['phone'],
            "L_PAYMENTREQUEST_FIRSTNAME"=>$userdata['firstname'],
            "L_PAYMENTREQUEST_LASTNAME"=>$userdata['lastname'],
            "EMAIL"=>$userdata['email'],
            "LOGOIMG"=>"http://localhost/netricite/v201701/public/img/leTraineau/logo-letraineau.png",
            "PAYMENTREQUEST_0_PAYMENTACTION"=>"Sale"
        );
        $params=$this->loadProducts($params, $products);
        
        $this->logger->addInfo("params", $params);
        return $params;
    }
    
    public function loadProducts($params, $products) {
        $this->logger->addInfo("products", $products);
        foreach($products as $k => $product) {
            //var_dump($product, $k);
            $params["L_PAYMENTREQUEST_0_AMT$k"]=number_format($product['unitPrice'],2,'.',' ');
            $params["L_PAYMENTREQUEST_0_NAME$k"]=$product['name'];
            $params["L_PAYMENTREQUEST_0_DESC$k"]=$product['desc'];
            $params["L_PAYMENTREQUEST_0_QTY$k"]=$product['quantity'];
            $this->logger->addInfo("params", $params);
         } 
         return $params;
     }    
    public function SetExpressCheckout($appdata) {
        $this->logger->addDebug("SetExpressCheckout", debug_backtrace());
        $this->logger->addInfo("data", $appdata);
        
        $params=$this->loadParams($appdata);
        $params["RETURNURL"]="http://localhost/netricite/v201701/index.php?application=shop&class=order&action=paypalReturn";
        $params["CANCELURL"]="http://localhost/netricite/v201701/index.php?application=shop&class=order&action=paypalCancel";

        $this->logger->addInfo("params", $params);
        
        
        // SetExpressCheckout
        $response=$this->request("SetExpressCheckout", $params);
        $ack = strtoupper($response["ACK"]);
        if($ack=="SUCCESS" || $ack=="SUCCESSWITHWARNING")  //if SetExpressCheckout API call is successful
        {
            //confirm to PAYPAL
            $confirmUrl=fw\fwConfiguration::get('paypal.api.checkout') . $response["TOKEN"] ;
            $this->logger->addInfo($ack, array("confirmURL"=>$confirmUrl));
            //Paypal callback
            header("Location:".$confirmUrl);
        }
        else
        {
            $this->logger->addError("SetExpressCheckout error", $response);
            $this->paymentError($response, "SetExpressCheckout " . $response["L_LONGMESSAGE0"]);
            return false;
        }
    
        return TRUE;
    }
    
    public function paypalReturn() {
        $this->logger->addDebug("return", debug_backtrace());
        $this->logger->addInfo("GET", $_GET);
        
        if (empty($_GET['token'])) throw new \exception("paypalReturn.Invalid response from paypal");

        $params=array(
            "token" =>$_GET['token']
        );
        $this->logger->addInfo("return", $_GET);
        $_SESSION['order']['token']=$_GET['token'];

        if(!isset($_SESSION['payer_id']))
        {
            $_SESSION['order']['payer_id'] =	$_GET['PayerID'];
        }

        /*
         * Calls the GetExpressCheckoutDetails API call
         */
        $response=$this->request("GetExpressCheckoutDetails", $params);
        $this->logger->addInfo("GetExpressCheckoutDetails", $response);
        $ack = strtoupper($response["ACK"]);
        if($ack=="SUCCESS" || $ack=="SUCCESSWITHWARNING")  //if SetExpressCheckout API call is successful
        {
            //store in session
            $_SESSION['order']['payer_id'] 		 = $response["PAYERID"]; // ' Unique PayPal customer account identification number.
            $_SESSION['order']['correlation_id'] = $response["CORRELATIONID"]; // ' The ID unique to this response message. PayPal recommends you log this ID.
            $_SESSION['order']['checkoutStatus'] = $response["CHECKOUTSTATUS"]; // ' Status of the checkout session.
            /* CHECKOUTSTATUS:
                //PaymentActionNotInitiated
                //PaymentActionFailed
                //PaymentActionInProgress
                //PaymentActionCompleted
             */
            /*
             * Verify if the payment is not already done
             */
            $this->logger->addInfo("Paiement status: " . $_SESSION['order']['checkoutStatus']);
            if ($_SESSION['order']['checkoutStatus'] == "PaymentActionCompleted") {
                info ("E", "Paiement déjà effectué");
                $this->logger->addError("GetExpressCheckoutDetails. Payment already done, transaction aborted", $response);
                $this->paymentError($response, "Paiement déjà effectué (GetExpressCheckoutDetails)");
                return false;
            }
            /*
             * Verify if the payment amount stored in session is the same as the one returned from GetExpressCheckoutDetails API call
             * Checks whether the session has been compromised
             */          
            //mandatory info for DoExpressCheckoutPayment
            $totalAmt   	= $response["PAYMENTREQUEST_0_AMT"];       // ' Total Amount to be paid by buyer
            $currencyCode   = $response["CURRENCYCODE"];               // 'Currency being used
            
            if(number_format($_SESSION['order']['netamount'],2,'.',' ') != $totalAmt || $_SESSION['order']['currency'] != $currencyCode) {
                info ("E", "Parameters in session do not match those in PayPal API calls");
                $this->logger->addError("GetExpressCheckoutDetails. amount/currency in session != Paypal response", $response);
                $this->logger->addError("GetExpressCheckoutDetails. session info: " . $_SESSION['order']['netamount'] ."/". $_SESSION['order']['currency']);
                $this->paymentError($response, "Divergences des informations de session (GetExpressCheckoutDetails)");
                return false;
            }
            $this->DoExpressCheckoutPayment($response);
        } else {
            info ("E", "GetExpressCheckoutDetails failure");
            $this->logger->addError("GetExpressCheckoutDetails failure", $response);
            $this->paymentError($response, "Failure: Voir erreur ci-dessous (GetExpressCheckoutDetails)");
            return false;
        }
        return TRUE;
    }
    public function DoExpressCheckoutPayment($responseCheckoutDetail) {
        $this->logger->addDebug("DoExpressCheckoutPayment", debug_backtrace());
        $this->logger->addInfo("responseCheckoutDetail", $responseCheckoutDetail);
       
        //get order info
        $appdata=$this->getAppData(); 
        $payment=$this->generateOrder($appdata);

        $appdata=array_merge($appdata, $payment);
        $this->logger->addInfo("appdata", $appdata);
        
        //generate order params for DoExpressCheckoutPayment
        $params=$this->loadParams($appdata);
    
        //mandatory parameters for DoExpressCheckoutPayment
        $params["TOKEN"] = $_GET['token'];
        $params["PAYERID"] = $_GET['PayerID'];
        
        //load amount and currency from GetExpressCheckoutDetails response
        $params["PAYMENTREQUEST_0_AMT"] = $responseCheckoutDetail["PAYMENTREQUEST_0_AMT"];
        $params["PAYMENTREQUEST_0_CURRENCYCODE"] = $responseCheckoutDetail["CURRENCYCODE"];
        $params["PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE"] = $responseCheckoutDetail['COUNTRYCODE'];

        $this->logger->addInfo("params", $params);
        
        $response=$this->request("DoExpressCheckoutPayment", $params);
        $ack = strtoupper($response["ACK"]);
        if($ack=="SUCCESS" || $ack=="SUCCESSWITHWARNING")  //if SetExpressCheckout API call is successful
        {
            //confirm to USER                                  
            $_SESSION['order']['correlation_id'] = $response["CORRELATIONID"]; // ' The ID unique to this response message. PayPal recommends you log this ID.
            $_SESSION['order']['transaction_id'] = $response["PAYMENTINFO_0_TRANSACTIONID"]; // ' returned only after a successful DoExpressCheckout transaction.
            $_SESSION['order']['date_created'] 	= $response["PAYMENTINFO_0_ORDERTIME"];  //' Time/date stamp of payment
            $this->logger->addNotice("date_created: " . $_SESSION['order']['date_created']);
            if (!$this->saveOrder($appdata)) throw new \Exception('Order cannot be recorded');
            
            $this->paymentReport($response, $responseCheckoutDetail);
            //unset cart & order
            $_SESSION['cart']=array();
            $_SESSION['order']=array();
            
        }
        else
        {
            $this->logger->addError("DoExpressCheckoutPayment failure", $response);
            $this->paymentError($response, "Failure: Voir erreur ci-dessous (DoExpressCheckoutPayment)");
            return false;
        }
        return TRUE;
    }
    public function paypalCancel() {
        $this->logger->addDebug("paypalCancel", debug_backtrace());
        $this->logger->addInfo("data",$_GET);
        $this->paymentError($_GET, "Opération ref:" . $_GET['token']. " annulée au niveau de PAYPAL");
        return FALSE;
    }
    
    public function paymentReport($response, $responseCheckoutDetail) {
        /*
         * The information that is returned by the GetExpressCheckoutDetails call should be integrated by the partner into his Order Review
         * page
         */
        $firstname      = $responseCheckoutDetail["FIRSTNAME"]; // ' Payer's first name.
        $lastname       = $responseCheckoutDetail["LASTNAME"]; // ' Payer's first name.
        $email 			= $responseCheckoutDetail["EMAIL"]; // ' Email address of payer.
        $payerStatus	= $responseCheckoutDetail["PAYERSTATUS"]; // ' Status of payer. Character length and limitations: 10 single-byte alphabetic characters.
        $cntryCode		= $responseCheckoutDetail["COUNTRYCODE"]; // ' Payer's country of residence in the form of ISO standard 3166 two-character country codes.
        $shipToName		= $responseCheckoutDetail["PAYMENTREQUEST_0_SHIPTONAME"]; // ' Person's name associated with this address.
        $shipToStreet	= $responseCheckoutDetail["PAYMENTREQUEST_0_SHIPTOSTREET"]; // ' First street address.
        $shipToCity		= $responseCheckoutDetail["PAYMENTREQUEST_0_SHIPTOCITY"]; // ' Name of city.
        //$shipToState	= $response["PAYMENTREQUEST_0_SHIPTOSTATE"]; // ' State or province
        $shipToCntryCode= $responseCheckoutDetail["PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE"]; // ' Country code.
        $shipToZip		= $responseCheckoutDetail["PAYMENTREQUEST_0_SHIPTOZIP"]; // ' U.S. Zip code or other country-specific postal code.
        $addressStatus 	= $responseCheckoutDetail["ADDRESSSTATUS"]; // ' Status of street address on file with PayPal
        $shippingAmt    = $responseCheckoutDetail["PAYMENTREQUEST_0_SHIPPINGAMT"]; // 'Shipping amount
        
        //mandatory info for DoExpressCheckoutPayment
        $totalAmt   	= $responseCheckoutDetail["PAYMENTREQUEST_0_AMT"]; // ' Total Amount to be paid by buyer
        $currencyCode   = $responseCheckoutDetail["CURRENCYCODE"]; // 'Currency being used
        
        $transactionId		= $response["PAYMENTINFO_0_TRANSACTIONID"]; // ' Unique transaction ID of the payment. Note:  If the PaymentAction of the request was Authorization or Order, this value is your AuthorizationID for use with the Authorization & Capture APIs.
        $transactionType 	= $response["PAYMENTINFO_0_TRANSACTIONTYPE"]; //' The type of transaction Possible values: l  cart l  express-checkout
        $paymentType		= $response["PAYMENTINFO_0_PAYMENTTYPE"];  //' Indicates whether the payment is instant or delayed. Possible values: l  none l  echeck l  instant
        $amt				= $response["PAYMENTINFO_0_AMT"];  //' The final amount charged, including any shipping and taxes from your Merchant Profile.
        $currencyCode		= $response["PAYMENTINFO_0_CURRENCYCODE"];  //' A three-character currency code for one of the currencies listed in PayPay-Supported Transactional Currencies. Default: USD.
        /*
         * Status of the payment:
         * Completed: The payment has been completed, and the funds have been added successfully to your account balance.
         * Pending: The payment is pending. See the PendingReason element for more information.
         */
        
        $paymentStatus	= $response["PAYMENTINFO_0_PAYMENTSTATUS"];
        
        /*
         * The reason the payment is pending
         */
        $pendingReason	= $response["PAYMENTINFO_0_PENDINGREASON"];
        
        /*
         * The reason for a reversal if TransactionType is reversal
         */
        $reasonCode		= $response["PAYMENTINFO_0_REASONCODE"];
       
        
        $html="<p>" . $firstname . " " . $lastname . "	, Merci pour votre commande </p>";
            			
		$html.= "<h4> Détails de la transaction: </h4>";
		$html.= $shipToName."<br>";
		$html.= $shipToStreet."<br>";
		$html.= $shipToCity."<br>";
		$html.= $shipToZip."</p>";
		$html.= "<p>ID de la transaction PAYPAL: <strong>" . $_SESSION['order']['transaction_id']."</strong></p>";
		$html.= "<p>Type de transaction: <strong>". $transactionType."<strong></p>";
		$html.= "<p>Montant de la transaction: <strong>". $amt."<strong></p>";
		$html.= "<p>Devise: <strong>".$currencyCode."<strong></p>";
		$html.= "<p>Etat du paiement: <strong>".$paymentStatus."<strong></p>";
		$html.= "<p>Type de paiement: <strong>".$paymentType."<strong></p>";
		$html.= "<p>  <a href='index.php'>retour à l'acceuil</a> </p>";
		$html.= "<p>  <a class='pull-right' href='https://www.sandbox.paypal.com/fr/cgi-bin/webscr?cmd=%5faccount&nav=0%2e0'>Detail de la transaction disponible sur votre compte PAYPAL</a> </p>";
		
		$page=new fw\fwView("error");
		$page->displayPage("Paypal success", $html);
    }
    public function paymentError($response, $message) {
        
        //$page->$title="Paypal error";

		$html= "<h4> Opération de paiement interrompue</h4>";
		$html.= "<p><strong>Erreur: </strong><em>" . $message . "</em></p>";
		$html.= "<p>L'opération n'a pu aboutir, vous ne serez pas débité. </p>";
		$html.= "<p>Nous vous prions de bien vouloir nous excuser pour la gêne occasionnée. </p>";
		$html.= "<p>  <a class='pull-right' href='index.php'>retour à l'acceuil</a> </p>";
	    $html.= "<p>Transmettez le message d'erreur à votre administrateur</p>";
	    $html.= "<pre>" . json_encode($response) . "</pre>";
	    $page=new fw\fwView("error");
	    $page->displayPage("Paypal error", $html);
	    //errorMessage("Opération annulée au niveau PAYPAL");
   }
}    
