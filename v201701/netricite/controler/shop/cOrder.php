<?php
namespace  Netricite\Controler\Shop;

use Netricite\Framework as fw;
use Netricite\Model\Shop as shop;
use Netricite\Model\Login as login;
use Netricite\AppClass as app;

/**
 * @author jp
 * @version 2016-14
 *
 * shop controler
 */
class cOrder extends fw\fwControlerFilter {

  /**
   * constructor
   */
  public function __construct() {
  	appTrace(debug_backtrace()); 
  	$this->model = new shop\mOrder();
    $this->mUser = new login\mUser();
    $this->mOrderDetail = new shop\mOrderDetail();
    $this->mShopProduct = new shop\mShopProduct();
    $this->mCart = new shop\mCart();
  }

  /**
   *
   * display all records of the model
   *
   * {@inheritDoc}
   * @see \Netricite\Framework\fwControler::index()
   */
  public function index() {
      appTrace(debug_backtrace());
      // get user, orders
      //$this->generateView(array('userdata' => $this->mUser->getRecord($_SESSION['userid'],"id"),
      //    'data'=> $this->model->get(array("conditions"=> "clientid=" .$_SESSION['userid']) ) ) );
      $this->generateView($this->getAppData() );
  }
   
 /**
   * Get application data
   * {@inheritDoc}
   * @see \Netricite\Framework\fwControler::getAppData()
   * @return array of application data
   */
  public function getAppData() {
      appTrace(debug_backtrace());
      // get orders and user
      $appdata=array("data"=>$this->model->get(array("conditions"=> "clientid=" .$_SESSION['userid'])),
          "userdata"=>$this->mUser->getRecord($_SESSION['userid'],"id"));
      return $appdata;
  }
  
  /**
   * Generate an order and then a payment
   * @throws \Exception
   */
  public function payment() {
      if (!empty($_SESSION["userid"])) {
          if (!$this->generateOrder()) throw new \Exception('cannot record order');
          appTrace(debug_backtrace(), $_SESSION['cart']);
          echo fw\fwConfiguration::get("shop.payment.mode");
          switch (fw\fwConfiguration::get("shop.payment.mode")) {
              case "altapay":
                  if (!$this->altapayPayment()) throw new \Exception("Opération non terminée, veuillez recommencer");
                  break;
              case "paypal":
                  if (!$this->paypalPayment())throw new \Exception("Opération non terminée, veuillez recommencer");
                  break;
              case "nopayment":
                  if (!$this->noPayment()) throw new \Exception("Opération non terminée, veuillez recommencer");
                  break;
              default:
                  info ("E", "payment mode not implemented yet");
                  throw new \Exception("payment mode not implemented yet");
          }
          $_SESSION['cart']=array();
          $_SESSION['order']=array();
          appTrace(debug_backtrace(), $_SESSION['cart']);
          $this->refreshPage();
      } else {
          info("I", "Merci de vous logger, avant de commander.");
          $this->forceLogin();
      }
  
  }
  
  /**
   * Generate an order based on the cart info
   * @throws \Exception
   * @return TRUE
   */
  public function generateOrder() {
      appTrace(debug_backtrace());
  
      //get order details from cart
      $data = $this->mCart->getRecords();
      //var_dump($data);
      //var_dump($_SESSION['cart']);
  
      //create a new order
      $record=array("clientid"=>$_SESSION['userid'],"amount"=>number_format($_SESSION['order']['netamount'],2,',',' '), "reference"=>generateToken($_SESSION['pseudo'],16));
      if (!$this->model->save($record)) throw new \Exception('cannot record order');
  
      //create associated order details out of cart info
      foreach ($data as $item){
          $quantity=$_SESSION['cart'][$item['id']];
          $totalHT=$item['unitPrice'] * $quantity;
          $totalTTC=$totalHT * fw\fwConfiguration::get('tax.code.1');           //1.196 ;
          $detail=array("orderid"=>$this->model->id, "productid"=>$item['id'] ,
              "unitPrice"=>$item['unitPrice'], "quantity"=>$quantity,
              "grossamount"=>$totalHT, "netamount"=>$totalTTC, "taxcode"=>"1");
          if (!$this->mOrderDetail->save($detail)) throw new \Exception('cannot record order detail');
      }
      return TRUE;
  }
  
  public function noPayment() {
      appTrace(debug_backtrace());
      echo "Creating NONE payment";
      $info=$this->model->getRecord($this->model->id);
      info("I", "Operation sans paiement " . number_format($_SESSION['order']['netamount'],2,',',' '));
      return TRUE;
  }
  
  public function altapayPayment() {
      appTrace(debug_backtrace());
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
      appTrace(debug_backtrace());
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
  
  public function paypalPayment() {
      appTrace(debug_backtrace(),$_POST);
      echo "Creating PAYPAL payment";
      return TRUE;
  }
  
  /**
   * Generate an invoice.pdf
   */
  public function invoice() {
      appTrace(debug_backtrace(), $this->request->parameters);

      if (!empty($this->request->getParameter("id"))) {
          //requested invoice
          $order=$this->getRecord($this->request->getParameter("id"));
      } else {
          //last invoice
          $order=$this->model->getRecord($_SESSION['userid'], "clientid");  
      }
      //get application data
      $orderDetail=$this->mOrderDetail->get(array("conditions"=> "orderid=" .$order['id']));
      $userdata=$this->mUser->getRecord($_SESSION['pseudo']);
      
      /**
       * Invoice generation
       *
       */
      $base= $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['web.base'];       // "netricite/v2016-14/";
      require( $base . 'vendor/fpdf/invoice.php');

      $client=$userdata['firstname'] . " " . $userdata['lastname'] . "\n" . $userdata['address'] . "\n" . $userdata['zipcode'] . " " . $userdata['city'] . " " . $userdata['country'];
  
      $company= new app\company();
      
      $pdf = new \PDF_Invoice( 'P', 'mm', 'A4' );
      $pdf->AddPage();
      $pdf->addSociete( $company->get('company.name'), $company);
      $pdf->fact_dev( "Facture ", str_pad($order['id'], 8, '0', STR_PAD_LEFT));
      $pdf->temporaire( "Original" );
     
      $date = strtotime($userdata['date_created']);
      $pdf->addDate( date('d/m/Y h:m', $date));
      $pdf->addClient(str_pad($userdata['id'], 5, '0', STR_PAD_LEFT));
      $pdf->addPageNumber("1");
      $pdf->addClientAdresse("Client\n" . $client);
      $pdf->addReglement("Carte Bancaire");

      $pdf->addEcheance(date('d/m/Y', $date));
      $pdf->addNumTVA($company->get('company.taxAccount'));
      $pdf->addReference("Achat par internet");
      $cols=array( "REFERENCE"    => 23,
          "DESIGNATION"  => 78,
          "QUANTITE"     => 22,
          "P.U. HT"      => 26,
          "MONTANT H.T." => 30,
          "TVA"          => 11 );
      $pdf->addCols( $cols);
      $cols=array( "REFERENCE"    => "L",
          "DESIGNATION"  => "L",
          "QUANTITE"     => "C",
          "P.U. HT"      => "R",
          "MONTANT H.T." => "R",
          "TVA"          => "C" );
      $pdf->addLineFormat( $cols);
      $pdf->addLineFormat($cols);
      
      $y    = 109;
      //ORDER LINES
      foreach ($orderDetail as $item) {
          $product=$this->mShopProduct->getRecord($item['productid']);
          $line = array( "REFERENCE"    => str_pad($item['id'], 8, '0', STR_PAD_LEFT),  
              "DESIGNATION"  => $product['name'] ."\n". $product['class'] ."/". $product['category'] ,
              "QUANTITE"     => $item['quantity'],
              "P.U. HT"      => number_format($item['unitprice'],2,',',' '), 
              "MONTANT H.T." => number_format($item['grossamount'],2,',',' '), 
              "TVA"          => $item['taxcode'] );
          $size = $pdf->addLine( $y, $line );
          $y   += $size + 2;
      }
      
      $pdf->addCadreTVAs();
      $tab_tva = array( "1"       => 19.6,
          "2"       => 5.5);
      
      $tot_prods = array();
      foreach ($orderDetail as $item) {
          $product=$this->mShopProduct->getRecord($item['productid']);
          $detail=array ( "px_unit" => $item['unitprice'], "qte" => $item['quantity'], "tva" => 1 );
          array_push($tot_prods, $detail);
      }

      // invoice = array( "px_unit" => value,
      //                  "qte"     => qte,
      //                  "tva"     => code_tva );
      // tab_tva = array( "1"       => 19.6,
      //                  "2"       => 5.5, ... );
      // params  = array( "RemiseGlobale" => [0|1],
      //                      "remise_tva"     => [1|2...],  // {la remise s'applique sur ce code TVA}
      //                      "remise"         => value,     // {montant de la remise}
      //                      "remise_percent" => percent,   // {pourcentage de remise sur ce montant de TVA}
      //                  "FraisPort"     => [0|1],
      //                      "portTTC"        => value,     // montant des frais de ports TTC
      //                                                     // par defaut la TVA = 19.6 %
      //                      "portHT"         => value,     // montant des frais de ports HT
      //                      "portTVA"        => tva_value, // valeur de la TVA a appliquer sur le montant HT
      //                  "AccompteExige" => [0|1],
      //                      "accompte"         => value    // montant de l'acompte (TTC)
      //                      "accompte_percent" => percent  // pourcentage d'acompte (TTC)
      //                  "Remarque" => "texte"              // texte
      $params  = array( "RemiseGlobale" => 0,           
          "remise_tva"     => 0,       // {la remise s'applique sur ce code TVA}
          "remise"         => 0,       // {montant de la remise}
          "remise_percent" => 0,      // {pourcentage de remise sur ce montant de TVA}
          "FraisPort"     => 0,                        
          "portTTC"        => 0,      // montant des frais de ports TTC
          // par defaut la TVA = 19.6 %
          "portHT"         => 0,       // montant des frais de ports HT
          "portTVA"        => 19.6,    // valeur de la TVA a appliquer sur le montant HT
          "AccompteExige" => 0,                         
          "accompte"         => 0,     // montant de l'acompte (TTC)
          "accompte_percent" => 0,    // pourcentage d'acompte (TTC)
          "Remarque" => "Reglement ce jour via Altapay" );
      
      $pdf->addTVAs( $params, $tab_tva, $tot_prods);
      $pdf->addCadreEurosFrancs();
      
      $pdf->Output();
  }
  
}