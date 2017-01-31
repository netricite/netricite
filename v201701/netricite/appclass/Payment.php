<?php
namespace Netricite\AppClass;

use Netricite\Framework as fw;
use Netricite\Model\Shop as shop;
use Netricite\Model\Login as login;
use Netricite\AppClass as app;
/**
 * @author jp
 * @version 2016-14
 *
 * company information is located in config.ini
 */

class Payment  extends appObject {
       
    /**
     * constructor
     */
    public function __construct() {
        parent::__construct();    
        $this->model = new shop\mOrder();
        $this->mUser = new login\mUser();
        $this->mOrderDetail = new shop\mOrderDetail();
        $this->mShopProduct = new shop\mShopProduct();
        $this->mCart = new shop\mCart();
    }
    public function getAppData() {
        $this->logger->addDebug("getAppData", debug_backtrace());
        // get orders and user
        $appdata=array("data"=>$this->model->get(array("conditions"=> "clientid=" .$_SESSION['userid'])),
            "userdata"=>$this->mUser->getRecord($_SESSION['userid'],"id"));
        return $appdata;
    }

    public function payment($appData) { 
        $payment=$this->generateOrder($appData);
        $appdata=array_merge($appData, $payment);
        $this->logger->addInfo("appdata", $appdata);
        
        if (empty($payment)) throw new \Exception('No products in cart');

        $this->logger->addDebug(fw\fwConfiguration::get("shop.payment.mode"), $_SESSION['cart']);

        switch (fw\fwConfiguration::get("shop.payment.mode")) {
            case "altapay":
                $payment= new app\PaymentAltapay();
                if (!$payment->altapayPayment($appdata)) {
                    $this->logger->addError(" Altapay Payment aborted ");
                    info("E", "Altapay, Opération stoppée avant le paiement, veuillez recommencer");
                    return FALSE;
                }
                break;
            case "paypal":
                $payment= new app\PaymentPaypal();
                if (!$payment->SetExpressCheckout($appdata)){
                    info("E", "Paypal, Opération stoppée avant le paiement, veuillez recommencer");
                    return FALSE;
                }
                break;
            case "nopayment":
                if (!$this->noPayment($appdata)) {
                    info("E", "No Payment, Opération stoppée avant le paiement, veuillez recommencer");
                    return FALSE;
                }
                break;
            default:
                info ("E", "payment mode not implemented yet");
                throw new \Exception("payment mode not implemented yet");
        }
        $this->logger->addDebug("checkout completed " . $_SESSION['cart']);
        return TRUE;
    }
    /**
     * Generate an order based on the cart info
     * @throws \Exception
     * @return TRUE
     */
    public function generateOrder($appData) {
        //appTrace(debug_backtrace());
        $this->logger->addDebug(".generateOrder", debug_backtrace());
        
        //get order details from cart
        $products=array();
    
        //store order info
        $orderDetail=array("clientid"=>$_SESSION['userid'],
            "netamount"=>number_format($_SESSION['order']['netamount'],2,'.',' '), 
            "grossamount"=>number_format($_SESSION['order']['grossamount'],2,'.',' '),
            "tax"=>number_format($_SESSION['order']['tax'],2,'.',' '), 
            "reference"=>"",
            "shipment"=>number_format($_SESSION['order']['shipment'],2,',',' '),
            "currency"=>$_SESSION['order']['currency']
        );
        $order=array("order"=>$orderDetail);
    
        //create associated order details out of cart info
        $items=$this->mCart->getRecords();
        foreach ( $items as $key =>$item){                                 
            $quantity=$_SESSION['cart'][$item['id']];
            $totalHT=$item['unitPrice'] * $quantity;
            $totalTTC=$totalHT * fw\fwConfiguration::get('tax.code.1');           //1.196 ;
            //$product=$this->mShopProduct->getRecord($item['id']);
            $product=$item['id'];
            $tax=$totalTTC-$totalHT;
            $detail=array("productid"=>str_pad($item['id'], 8, '0', STR_PAD_LEFT) , 
                "name"=>$item['name'],
                "desc"=>"(" . $item['class'] ."/" . $item['category'] .")",
                "unitPrice"=>number_format($item['unitPrice'],2,'.',' '), 
                "quantity"=>number_format($quantity,0,'.',' '),
                "grossamount"=>$totalHT, "netamount"=>$totalTTC, "tax"=>number_format($tax,0,'.',' '), "taxcode"=>"1");
            $products[$key]=$detail;
            $this->logger->addInfo("products",$products);
        }
        $this->logger->addInfo("products",$products);
        $this->logger->addInfo("order",$order);
        return array("payment"=>array($order, $products));
    }
    
    
    /**
     * Generate an order based on the cart info
     * @throws \Exception
     * @return TRUE
     */
    public function saveOrder($appdata) {
        //appTrace(debug_backtrace());
        $this->logger->addDebug(".saveOrder", debug_backtrace());
    
        //get order details from cart
        $data = $this->mCart->getRecords();
        //var_dump($data);
        //var_dump($_SESSION['cart']);
    
        //create a new order
        $this->logger->addNotice("date_created: " . $_SESSION['order']['date_created']);
        $record=array("clientid"=>$_SESSION['userid'],
            "netamount"=>number_format($_SESSION['order']['netamount'],2,',',' '), 
            "grossamount"=>number_format($_SESSION['order']['grossamount'],2,',',' '),
            "tax"=>number_format($_SESSION['order']['tax'],2,',',' '),
            "shipment"=>number_format($_SESSION['order']['shipment'],2,',',' '),
            "reference"=>"trnid=" . $_SESSION['order']['transaction_id'] . "&corid=". $_SESSION['order']['correlation_id'],
            "currency"=>$_SESSION['order']['currency'], "date_created"=>$_SESSION['order']['date_created'], "status"=>1
        );
        $this->logger->addNotice("data" , $record);
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
        //appTrace(debug_backtrace());
        $this->logger->addDebug(".noPayment", debug_backtrace());
        echo "Creating NONE payment";
        $info=$this->model->getRecord($this->model->id);
        info("I", "Operation sans paiement " . number_format($_SESSION['order']['netamount'],2,',',' '));
        return TRUE;
    }
   /**
   * Generate an invoice.pdf
   */
  public function invoice($parameters) {
      //appTrace(debug_backtrace(), $this->request->parameters);
      $this->logger->addDebug("invoice", debug_backtrace());
      $this->logger->addInfo("parameters", $parameters);
    
      if (!empty($parameters["id"])) {
          //requested invoice
          $order=$this->model->getRecord($parameters["id"]);
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
  
      $company= new app\Company();
      
      $pdf = new \PDF_Invoice( 'P', 'mm', 'A4' );
      $pdf->AddPage();
      $pdf->addSociete( $company->get('company.name'), $company);
      $pdf->fact_dev( "Facture ", str_pad($order['id'], 8, '0', STR_PAD_LEFT));
      $pdf->temporaire( "Original" );
     
      $date = strtotime($order['date_created']);
      $pdf->addDate( date('d/m/Y H:m', $date));
      $pdf->addClient(str_pad($userdata['id'], 5, '0', STR_PAD_LEFT));
      $pdf->addPageNumber("1");
      $pdf->addClientAdresse("Client\n" . $client);
      $pdf->addReglement(strtoupper(fw\fwConfiguration::get('shop.payment.mode')) );

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
          "Remarque" => "Reglement " . $order['date_created'] . " ref( " . strtoupper(fw\fwConfiguration::get('shop.payment.mode')). "-" .$order['reference'] . ")");
      
      $pdf->addTVAs( $params, $tab_tva, $tot_prods);
      $pdf->addCadreEurosFrancs();
      $this->logger->addDebug("invoice output");
      $pdf->Output();
      }
}
