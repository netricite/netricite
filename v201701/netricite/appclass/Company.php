<?php
namespace Netricite\AppClass;

use Netricite\Framework as fw;
/**
 * @author jp
 * @version 2016-14
 *
 * company information is located in config.ini
 */

class Company  extends appObject {
    
    private $info;
    /*
    company.name = "Le traineau - Les Gets"
    company.address = rue du centre\n74260 Les Gets
    company.phone = 0685461562
    company.email = contact@letraineau-lesgets.com
    company.website = www.letraineau-lesgets.com
    company.admin = jp
    company.language = en
    company.currency = EUR
    company.TaxReference = FR888777666
    company.number = R.C.S. Bonneville B 000 000 007
    */
    
    /**
     * constructor
     */
    public function __construct(){
        parent::__construct();
    }
    
    public function get($param){
        return fw\fwconfiguration::get($param);
    }
    
    public function __toString(){
        appTrace(debug_backtrace());
        /*
         $pdf->addSociete( "Le Traineau",
                  "Rue du centre\n" .
                  "Les Gets\n".
                  "R.C.S. Bonneville B 000 000 007\n" .
                  "Capital : 18000 " . EURO );
         */
        $text=$this->get('company.address'). "\n" .
            $this->get('company.city'). "\n" .
            $this->get('company.phone'). "\n" .
            $this->get('company.website'). "\n" .
            $this->get('company.legalRegistry');
        
        return $text;
    }
}
