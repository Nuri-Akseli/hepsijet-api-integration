<?php
    class HepsiJetContext{
        

        private $userName=""; //HepsiJet Tarafından verilen kullanıcı adı
        private $password=""; //HepsiJet Tarafından verilen parola

        private $method = "GET";
        private $apiUrl;

        //Test Ortamı
        private $url="https://dmzlastmile.hepsiexpress.com:8091";

        //Canlı Ortam
        //private $url="https://integration.hepsijet.com/";

        private $token;

        public function getUserName()
        {
            return $this->userName;
        }
        public function getPassword()
        {
            return $this->password;
        }
        public function setMethod($_method)
        {
            $this->method = $_method;
        }
        public function getMethod()
        {
            return $this->method;
        }
        public function setApiUrl($_apiUrl)
        {
            $this->apiUrl = $_apiUrl;
        }
        public function getApiUrl()
        {
            return $this->apiUrl;
        }
        public function getUrl()
        {
            return $this->url;
        }
        
        public function setToken($_token)
        {
            $this->token = $_token;
        }
        public function getToken()
        {
            return $this->token;
        }

        public function getAuthorization()
        {
            $result= $this->getUserName().":".$this->getPassword();

            return $result;
        }
    }
?>
