<?php
namespace Netricite\Payment;

use Netricite\Framework as fw;
use Netricite\Payment as payment;
/**
 * The purpose of this class is to parse the callback parameters and return
 * a usefull response object from which your business logic can get information
 * for the decisions it needs to make.
 *
 * @author "Emanuel Holm Greisen" <phpclientapi@pensio.com>
 */
class callbackHandler
{
   /**
    * 
    * @param SimpleXMLElement $xml  : Body part of the merchantAPI.response
    * @throws Exception
    */
    public function parseXmlResponse($xml)
    {
        appTrace(debug_backtrace());
        if(!($xml instanceof \SimpleXMLElement))
        {
            $xml = new \SimpleXMLElement($xml);
        }
        //echo $xml->asXML();
        $this->verifyXml($xml);

        // This is not a perfect way of figuring out what kind of response would be appropriate
        // At some point we should have a more direct link between something in the header
        // and the way the result should be interpreted.
        $authType = $xml->Body[0]->Transactions[0]->Transaction[0]->AuthType;
        
        //debug
        $version = (string)$xml['version'];
        $date = (string)$xml->Header->Date;
        $path = (string)$xml->Header->Path;
        $errorCode = (string)$xml->Header->ErrorCode;
        $errorMessage = (string)$xml->Header->ErrorMessage;
        $result = (string) $xml->Body[0]->result;
        $PaymentRequestId = (string) $xml->Body[0]->PaymentRequestId;
        
        $response=array();
        $response['authType']=$authType;
        $response['version']=$version;
        $response['date']=$date;
        $response['path']=$path;
        $response['errorCode']=$errorCode;
        $response['errorMessage']=$errorMessage;

        
        appWatch($response,"xml response",get_class($this));
        
        throw new Exception("breakpoint 'authType': (".$authType.")");
        
        switch($authType)
        {
            case 'payment':
            case 'paymentAndCapture':
            case 'recurring':
            case 'subscription':
            case 'verifyCard':
                return $xml;   //new PensioReservationResponse($xml);
            case 'subscriptionAndCharge':
            case 'recurringAndCapture':
                return $xml;    //new PensioCaptureRecurringResponse($xml);
            default:
                throw new Exception("Unsupported 'authType': (".$authType.")");
        }
    }

    private function verifyXml(\SimpleXMLElement $xml)
    {
        appTrace(debug_backtrace());
        if($xml->getName() != 'APIResponse')
        {
            throw new \Exception("Unknown root-tag <".$xml->getName()."> in XML, should have been <APIResponse>", $xml);
        }
        if(!isset($xml->Header))
        {
            throw new \Exception("No <Header> in response", $xml);
        }
        if(!isset($xml->Header->ErrorCode))
        {
            throw new \Exception("No <ErrorCode> in Header of response", $xml);
        }
        if((string)$xml->Header->ErrorCode !== '0')
        {
            throw new Exception($xml->Header->ErrorMessage.' (Error code: '.$xml->Header->ErrorCode.')');
        }
        if(!isset($xml->Body))
        {
            throw new \Exception("No <Body> in response", $xml);
        }
        if(!isset($xml->Body[0]->Transactions))
        {
            $error = $this->getBodyMerchantErrorMessage($xml);
            throw new \Exception("No <Transactions> in <Body> of response".($error ? ' ('.$error.')' : ''), $xml);
        }
        if(!isset($xml->Body[0]->Transactions[0]->Transaction))
        {
            $error = $this->getBodyMerchantErrorMessage($xml);
            throw new \Exception("No <Transaction> in <Transactions> of response".($error ? ' ('.$error.')' : ''), $xml);
        }
    }

    private function getBodyMerchantErrorMessage(\SimpleXMLElement $xml)
    {
        if(isset($xml->Body[0]->MerchantErrorMessage))
        {
            return (string)$xml->Body[0]->MerchantErrorMessage;
        }
        return false;
    }
}