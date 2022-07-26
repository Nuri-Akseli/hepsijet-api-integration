<?php
    include_once __DIR__."/../Context/HepsiJetContext.php";
    include_once __DIR__."/../Context/Utilities.php";
    include_once __DIR__."/TokenService.php";
    
    class SettlementService extends HepsiJetContext{
        private $tokenService;
        private $utilities;

        public function __construct()
        {
            $this->utilities=new Utilities();
            $this->tokenService=new TokenService();
            $this->setToken($this->tokenService->getToken());
        }

        /**
         * Hizmet verilen il bilgilerini sağlar
         */
        public function getCities()
        {
            $this->setApiUrl($this->getUrl()."/settlement/cities");
            $this->setMethod("GET");
            return $this->utilities->sendResponse($this->getApiUrl(),$this->getMethod(),$this->getToken());
        }

        /**
         * Hizmet verilen ilçe bilgilerini sağlar
         */
        public function getTowns($cityID)
        {
            $this->setApiUrl($this->getUrl()."/settlement/city/$cityID/towns");
            $this->setMethod("GET");
            return $this->utilities->sendResponse($this->getApiUrl(),$this->getMethod(),$this->getToken());
        }

        /**
         * Hizmet verilen mahalle bilgilerini sağlar
         */
        public function getDistricts($townID)
        {
            $this->setApiUrl($this->getUrl()."/settlement/town/$townID/districts");
            $this->setMethod("GET");
            return $this->utilities->sendResponse($this->getApiUrl(),$this->getMethod(),$this->getToken());
        }
    }



?>