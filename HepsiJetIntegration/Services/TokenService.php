<?php
    include_once __DIR__."/../Context/HepsiJetContext.php";
    include_once __DIR__."/../Context/Utilities.php";

    class TokenService extends HepsiJetContext{
        private $utilities;
        public function __construct()
        {
            $this->utilities=new Utilities();
            
        }

        public function getToken()
        {
            $this->setApiUrl($this->getUrl()."/auth/getToken");
            $this->setMethod("GET");
            $result=$this->utilities->sendResponse($this->getApiUrl(),$this->getMethod(),null,null,$this->getAuthorization());
            return $result->data->token;
        }

    }


?>