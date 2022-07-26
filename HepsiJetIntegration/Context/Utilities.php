<?php
    class Utilities{
        
        public function sendResponse($formattedUrl,$method,$token=null,$data=null,$authentication=null)
        {
            $header=array();
            $curlInıt=curl_init();
            curl_setopt($curlInıt, CURLOPT_URL, $formattedUrl);
            curl_setopt($curlInıt, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($curlInıt, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curlInıt, CURLOPT_HEADER, false);
            curl_setopt($curlInıt, CURLINFO_HEADER_OUT, true);
            curl_setopt($curlInıt, CURLOPT_TIMEOUT, 20);

            $header[] = 'Content-Type: application/json';

            if($authentication!=null){
                $header[] = 'Authorization: Basic '.base64_encode($authentication);
            }
            
            if($token!=null){
                $header[] = 'X-Auth-Token: '.$token;
            }

            if ($method == 'POST' || $method == 'PUT') {
                if($method == 'POST'){
                    curl_setopt($curlInıt, CURLOPT_POST, 1);
                }
                if( $data!=null){
                    curl_setopt($curlInıt, CURLOPT_POSTFIELDS, json_encode($data));
                }
                
            }

            curl_setopt($curlInıt, CURLOPT_HTTPHEADER,$header);
            $response = trim(curl_exec($curlInıt));
            if (empty($response)) {
                $message="Boş Yanıt Döndü";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }

            $response = json_decode($response);
            curl_close($curlInıt);
            return $response;
        }
    }

?>