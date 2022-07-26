<?php
    include_once __DIR__."/../Context/HepsiJetContext.php";
    include_once __DIR__."/../Context/Utilities.php";
    include_once __DIR__."/TokenService.php";
    class DeliveryService extends HepsiJetContext{
        private $tokenService;
        private $utilities;
        public function __construct()
        {
            $this->utilities=new Utilities();
            $this->tokenService=new TokenService();
            $this->setToken($this->tokenService->getToken());
        }
        /**
         * Gönderinin depo ve paketlenme süreci henüz başlamadan önce HepsiJET e gönderi verileceği bilgisinin gönderildiği servistir.
         * Opsiyonel bir servistir.
         */
        public function sendDeliveryAdvance($orderId,$companyCustomerId,$firstName,$lastName,$phone1,$email,$deliverySlot,$desi,$countryName,$cityName,$townName,$districtName,$addressLine1,$companyCompanyId,$companyName,$companyCountyName,$companyCityName,$companyTownName,$companyAddresLine1,$deliveryType="RETAIL",$productCode="HX_STD")
        {
            $this->setApiUrl($this->getUrl()."/rest/advance/sendDeliveryAdvance/v2");
            $this->setMethod("POST");
            $data=array(
                'orderId'   => $orderId,
                'orderDate' => date(DATE_ATOM,time()),
                'receiver'  => array(
                    'companyCustomerId' =>  $companyCustomerId,
                    'firstName'         =>  $firstName,
                    'lastName'          =>  $lastName,
                    'phone1'            =>  $phone1,
                    'email'             =>  $email
                ),
                'deliveries' => array(
                    'deliveryType'  =>  $deliveryType,
                    'deliverySlot'  =>  $deliverySlot,
                    'desi'          =>  $desi,
                    'product'       =>  array(
                        'productCode'   =>  $productCode
                    ),
                    'recipientAddress'  =>  array(
                        'country'   => array(
                            'name'  =>  $countryName,

                        ),
                        'city'   => array(
                            'name'  =>  $cityName,
                            
                        ),
                        'town'   => array(
                            'name'  =>  $townName,
                            
                        ),
                        'district'   => array(
                            'name'  =>  $districtName,
                            
                        ),
                        'addressLine1'  =>  $addressLine1
                    ),
                    'senderCompany' =>  array(
                        'companyCompanyId'  =>  $companyCompanyId,
                        'name'              =>  $companyName
                    ),
                    'senderAddress' =>  array(
                        'country'   => array(
                            'name'  =>  $companyCountyName,

                        ),
                        'city'   => array(
                            'name'  =>  $companyCityName,
                            
                        ),
                        'town'   => array(
                            'name'  =>  $companyTownName,
                            
                        ),
                        'addressLine1'  =>  $companyAddresLine1
                    ),
                    'applicationNo'     =>  ""
                )

            );
            return $this->utilities->sendResponse($this->getApiUrl(),$this->getMethod(),$this->getToken(),$data);
        }

        /**
         * Gönderinin iş ortağının deposunda paketlenmesi ve hepsiJET tarafından alıma hazır olması halinde bu servis, hepsiJET tarafında gönderiyi oluşturur.
         * customerDeliveyNo Her gönderi için unique olmalıdır. Firma isminin baş harfleri ile kodlanmalıdır. 9-16 karakter uzunluğunda olmalıdır
         * companyCustomerId Her yeni teslimat adresi için benzersiz olmalıdır. recipientAddress alanındaki "companyAddressId" ile aynı gönderilebilir. Adres hatalarını önlemek adına başına firma kodu eklenmesi tavsiye edilir
         */
        public function sendDeliveryOrderEnhanced($customerDeliveyNo,$receiverFirstName,$receiverLastName,$receiverPhone1,$receiverEmail,$recipientCountry,$recipientCity,$recipientTown,$recipientAddressLine1,$senderCountry,$senderCity,$senderTown,$senderDistrict,$senderAddressLine1,$companyName,$companyAbbreviationCode,$companyAddressId,$currentDockAbbreviationCode,$deliveryType="RETAIL",$productCode="HX_STD")
        {
            $this->setApiUrl($this->getUrl()."/rest/delivery/sendDeliveryOrderEnhanced");
            $this->setMethod("POST");
            $data=array (
                'company' => 
                array (
                  'name' => $companyName,
                  'abbreviationCode' => $companyAbbreviationCode,
                ),
                'delivery' => 
                array (
                  'customerDeliveryNo' => $customerDeliveyNo,
                  'customerOrderId' => $customerDeliveyNo,
                  'deliveryType' => $deliveryType,
                  'product' => 
                  array (
                    'productCode' => $productCode,
                  ),
                  'receiver' => 
                  array (
                    'companyCustomerId' => $customerDeliveyNo,
                    'firstName' => $receiverFirstName,
                    'lastName' => $receiverLastName,
                    'phone1' => $receiverPhone1,
                    'email' => $receiverEmail,
                  ),
                  'senderAddress' => 
                  array (
                    'companyAddressId' => $companyAddressId,
                    'country' => 
                    array (
                      'name' => $senderCountry,
                    ),
                    'city' => 
                    array (
                      'name' => $senderCity,
                    ),
                    'town' => 
                    array (
                      'name' => $senderTown,
                    ),
                    'district' => 
                    array (
                      'name' => $senderDistrict,
                    ),
                    'addressLine1' => $senderAddressLine1,
                  ),
                  'recipientAddress' => 
                  array (
                    'companyAddressId' => $customerDeliveyNo,
                    'country' => 
                    array (
                      'name' => $recipientCountry,
                    ),
                    'city' => 
                    array (
                      'name' => $recipientCity,
                    ),
                    'town' => 
                    array (
                      'name' => $recipientTown,
                    ),
                    'district' => 
                    array (
                      'name' => null,
                    ),
                    'addressLine1' => $recipientAddressLine1,
                  ),
                  'recipientPerson' => $receiverFirstName." ".$receiverLastName,
                  'recipientPersonPhone1' => $receiverPhone1,
                ),
                'currentXDock' => 
                array (
                  'abbreviationCode' => $currentDockAbbreviationCode,
                ),
            );
            return $this->utilities->sendResponse($this->getApiUrl(),$this->getMethod(),$this->getToken(),$data);
        }

        /**
         * Gönderi iş ortağının deposundan alınmadan önce, henüz ilk statüsündeyken bu servis ile gönderi silinebilir. 
         * Servis kullanımı ile önceden oluşturulan gönderinin kaydı HepsiJET tarafında ‘DELETED’ statüsüne çekilir. 
         * Opsiyonel bir servistir.
         */
        public function deleteDeliveryOrder($customerDeliveryNo,$deleteReason)
        {
            $this->setApiUrl($this->getUrl()."/rest/delivery/deleteDeliveryOrder/".$customerDeliveryNo);
            $this->setMethod("POST");
            $data=array(
                'deleteReason'  => $deleteReason
            );
            return $this->utilities->sendResponse($this->getApiUrl(),$this->getMethod(),$this->getToken(),$data);
        }

        /**
         * Oluşturulan gönderinin takip edilebilmesi için kullanılan iki takip servisinden biridir. 
         * Bu servis detaylı statü bilgilerini sağlar. 
         */
        public function getDeliveryTracking($customerDeliveryNo)
        {
            $this->setApiUrl($this->getUrl()."/rest/deliveryTransaction/getDeliveryTracking");
            $this->setMethod("POST");
            $deliveryNo=array('customerDeliveryNo'    =>  $customerDeliveryNo);

            $data=array(
                'deliveries'    => array(
                    $deliveryNo
                )
                
            );
            return $this->utilities->sendResponse($this->getApiUrl(),$this->getMethod(),$this->getToken(),$data);
        }

        /**
         * Teslimatların geçmiş durumunu döner (Maksimum 2 gün)
         */
        public function getEndOfTheDay()
        {
            $this->setApiUrl($this->getUrl()."/rest/deliveryTransaction/getEndOfTheDay");
            $this->setMethod("POST");
            $data=array(
                'dateStart' =>  date('Y-m-d'),
                'dateEnd'   =>  date('Y-m-d',strtotime("-1 days"))
            );
            return $this->utilities->sendResponse($this->getApiUrl(),$this->getMethod(),$this->getToken(),$data);
        }

        /**
         * getDeliveryTracking e benzer fonksiyondur
         * Bu servisin bir diğer önemli özelliği de takip linki vermesidir.
         */
        public function getDeliveryTrackingWithTrackingUrl(array $barcodes)
        {
            $this->setApiUrl($this->getUrl()."/rest/delivery/integration/track");
            $this->setMethod("POST");
            
            $data=array(
                'barcodes'  =>  $barcodes
            );
            return $this->utilities->sendResponse($this->getApiUrl(),$this->getMethod(),$this->getToken(),$data);
        }

        /**
         * sendDeliveryAdvance/v2 ile oluşturulan ön gönderi bildiriminin silinmesi için kullanılan servistir.
         */
        public function deleteDeliveryAdvance($customerOrderId,$reason)
        {
            $this->setApiUrl($this->getUrl()."/rest/advance/deleteDeliveryAdvance/$customerOrderId");
            $this->setMethod("POST");
            $data=array(
                'deleteReason'  =>  $reason
            );
            return $this->utilities->sendResponse($this->getApiUrl(),$this->getMethod(),$this->getToken(),$data);
        }

        public function deliveryUpdateDesi($customerDeliveryNo,$totalParcel,array $desi)
        {
            $this->setApiUrl($this->getUrl()."/rest/delivery-update");
            $this->setMethod("POST");
            $data=array(
                'deliveryUpdateType'    =>  "TOTAL_PARCEL",
                'customerDeliveryNo'    =>  $customerDeliveryNo,
                'totalParcelInfo'       =>  array(
                    'totalParcel'       =>  $totalParcel,
                    'desi'              =>  $desi
                )
            );
            return $this->utilities->sendResponse($this->getApiUrl(),$this->getMethod(),$this->getToken(),$data);
        }



        public function deliveryUpdateCustomerInfo($customerDeliveryNo,$companyCustomerId,$firstName,$lastName,$email,$gsm1)
        {
            $this->setApiUrl($this->getUrl()."/rest/delivery-update");
            $this->setMethod("POST");
            $data=array(
                'deliveryUpdateType'    =>  "COMPANY_CUSTOMER",
                'customerDeliveryNo'    =>  $customerDeliveryNo,
                'companyCustomerInfo'       =>  array(
                    'companyCustomerId'     =>  $companyCustomerId,
                    'firstName'             =>  $firstName,
                    'lastName'              =>  $lastName,
                    'email'                 =>  $email,
                    'gsm1'                  =>  $gsm1
                )
            );
            return $this->utilities->sendResponse($this->getApiUrl(),$this->getMethod(),$this->getToken(),$data);
        }


        public function deliveryUpdateAddressInfo($customerDeliveryNo,$companyAddressId,$addressLine1,$countryName,$cityName,$townName,$districtName)
        {
            $this->setApiUrl($this->getUrl()."/rest/delivery-update");
            $this->setMethod("POST");
            $data=array(
                'deliveryUpdateType'    =>  "COMPANY_ADDRESS",
                'customerDeliveryNo'    =>  $customerDeliveryNo,
                'companyAddressInfo'      =>  array(
                    'companyAddressId'     =>  $companyAddressId,
                    'addressLine1'         =>  $addressLine1,
                    'countryName'          =>  $countryName,
                    'cityName'             =>  $cityName,
                    'townName'             =>  $townName,
                    'districtName'         =>  $districtName
                )
            );
            return $this->utilities->sendResponse($this->getApiUrl(),$this->getMethod(),$this->getToken(),$data);
        }



        public function deliveryUpdateRecipientInfo($customerDeliveryNo,$recipientPerson,$recipientPersonPhone1,$recipientPersonPhone2,$recipientPersonEmail)
        {
            $this->setApiUrl($this->getUrl()."/rest/delivery-update");
            $this->setMethod("POST");
            $data=array(
                'deliveryUpdateType'    =>  "RECIPIENT_PERSON",
                'customerDeliveryNo'    =>  $customerDeliveryNo,
                'recipientPersonInfo'           =>  array(
                    'recipientPerson'           =>  $recipientPerson,
                    'recipientPersonPhone1'     =>  $recipientPersonPhone1,
                    'recipientPersonPhone2'     =>  $recipientPersonPhone2,
                    'recipientPersonEmail'      =>  $recipientPersonEmail
                )
            );
            return $this->utilities->sendResponse($this->getApiUrl(),$this->getMethod(),$this->getToken(),$data);
        }


        public function ReturnedDays($startDate,$endDate,$city,$town)
        {
            $this->setApiUrl($this->getUrl()."/rest/delivery/findAvailableDeliveryDatesV2?startDate=$startDate&endDate=$endDate&deliveryType=RETURNED&city=$city&town=$town");
            $this->setMethod("GET");
            return $this->utilities->sendResponse($this->getApiUrl(),$this->getMethod(),$this->getToken());
        }

        //URL'nin sonuna sonucun dönmesini istediğiniz PDF,JPEG veya PNG yazılabilir (format=PDF, format=JPEG, format=PNG)
        public function ReturnBarcodesAsBase64Encode(array $barcodes)
        {
            $this->setApiUrl($this->getUrl()."/delivery/barcodes-label?format=PDF");
            $this->setMethod("POST");
            
            $data=array(
                'barcodes'  =>  $barcodes
            );
            return $this->utilities->sendResponse($this->getApiUrl(),$this->getMethod(),$this->getToken(),$data);
        }
    }

?>