<?php
namespace Netricite\Payment;

use Netricite\Framework as fw;
use Netricite\Payment as payment;

class merchantAPI
{
    private $baseURL, $username, $password;
    private $connected = false ;
    public function __construct()
    {
        $this ->connected = false ;
    }
    public function connect($baseURL, $username, $password)
    {
        $this ->connected = false ;
        $this ->baseURL = $baseURL;
        $this ->username = $username;
        $this ->password = $password;
        // Just any method.
        if ($this ->callAPIMethod('fundingList') !== false )
        {
            $this ->connected = true ;
        }
        else
        {
            throw new \Exception("Connection failed, make sure username and " .
                "password are correct, and you have the 'api' credential");
        }
    }
    private function checkConnection()
    {
        if (!$this ->connected)
        {
            throw new \Exception("Not Connected, invoke connect(...) " .
                "before using any API calls");
        }
    }
    private function createContext(array $args)
    {
        return stream_context_create(array (
            'http' => array (
                'method' => 'POST',
                'header' => sprintf("Authorization: Basic %s\r\n",
                    base64_encode($this ->username.':'.$this ->password)).
                "Content-type: application/x-www-form-urlencoded\r\n",
                'timeout' => 5,
                'ignore_errors' => false ,
                'content' => http_build_query($args),
            ),
        ));
    }
    /**
     * 
     * @param string $method  altapay
     * @param array $args
     * @throws \Exception
     * @return xml.body object 
     */
    private function callAPIMethod($method, array $args = array ())
    {
        appTrace(debug_backtrace(),$args,$this ->baseURL."/merchant/API/".$method);
        
        $context = $this ->createContext($args);
        $xmlResult = @file_get_contents(
            $this ->baseURL."/merchant/API/".$method, false , $context);
        if ($xmlResult !== false )
        {
            $xml = new \SimpleXMLElement($xmlResult);
            
            if (((string)$xml->Header[0]->ErrorCode[0]) != '0')
            {
                throw new \Exception("Error in ".$method.": " .
                    ((string)$xml->Header[0]->ErrorMessage[0]) . ", code: " .
                    ((string)$xml->Header[0]->ErrorCode[0]));
            }
            appWatch(array("xml.body"=>$xml->Body[0]), "", get_class($this));
            return $xml->Body[0];
        }
        else
        {
            appWatch(array(), "merchantAPI returns false", get_class($this));
            return false ;
        }
    }
    public function getFundingListPageCount()
    {
        $this ->checkConnection();
        $body = $this ->callAPIMethod('fundingList');
        $attr = $body->Fundings[0]->attributes();
        $numPages = $attr['numberOfPages'][0];
        return (int)$numPages;
    }
    public function getFundingList($page=1)
    {
        $this ->checkConnection();
        return $this ->callAPIMethod('fundingList');
    }
    public function downloadFundingCSV(\SimpleXMLElement $funding)
    {
        $this ->checkConnection();
        $downloadLink = ((string)$funding->DownloadLink[0]);
        $context = $this ->createContext(array ());
        return file_get_contents($downloadLink, false , $context);
    }
    public function reservationOfFixedAmount(
        $terminal
        , $shop_orderid
        , $amount
        , $currency
        , $credit_card_token)
    {
        $this ->checkConnection();
        return $this ->callAPIMethod(
            'reservationOfFixedAmount',
            array (
                'terminal'=>$terminal,
                'shop_orderid'=>$shop_orderid,
                'amount'=>$amount,
                'currency'=>$currency,
                'credit_card_token'=>$credit_card_token,
                'payment_source'=>'moto'
            )
            );
    }
    public function createPaymentRequest( $args )
    {
        $this ->checkConnection();
        return $this ->callAPIMethod(
            'createPaymentRequest',
            $args
            );
    }
    public function captureReservation($paymentId, $amount=null )
    {
        $this ->checkConnection();
        return $this ->callAPIMethod(
            'captureReservation',
            array (
                'transaction_id'=>$paymentId,
                'amount'=>$amount
            )
            );
    }
    public function releaseReservation($paymentId, $amount=null )
    {
        $this ->checkConnection();
        return $this ->callAPIMethod(
            'releaseReservation',
            array (
                'transaction_id'=>$paymentId
            )
            );
    }

    public function getPayment($paymentId)
    {
        $this ->checkConnection();
        $body = $this ->callAPIMethod(
            'payments',
            array (
                'transaction'=>$paymentId
            )
            );
        if (isset ($body->Transactions[0]))
        {
            return $body->Transactions[0]->Transaction[0];
        }
        return null ;
    }
}