<?php 
	if(!defined('BASEPATH')) exit('No direct script access allowed');
	if(!function_exists('getTokenRate')) {
  		function getTokenRate() {
            $CI = get_instance();
    		$pairAddress = '0xd793764dc7968715661c9682fff67edb6de1fdac'; // Replace this
            $url = "https://api.dexscreener.com/latest/dex/pairs/bsc/{$pairAddress}";

            $response = file_get_contents($url);
            if ($response === false) {
                die("Failed to fetch data");
            }

            $data = json_decode($response, true);
            
            $price=0;
            if (isset($data['pair']['priceUsd'])) {
                $price = $data['pair']['priceUsd'];
            } 
            if(empty($price)){
                $settings=$CI->setting->getsettings(['name'=>'coin_rate'],'single');
                $price=$settings['value'];
            }
            else{
                $settings=$CI->setting->getsettings(['name'=>'coin_rate'],'single');
                $prevrate=$settings['value'];
                $rate=$price;
                
                // Compare up to 7 decimal places
                if (bccomp($prevrate, $rate, 7) !== 0) {
                    // Save $newRate to DB
                    $data=['id'=>$settings['id'],'value'=>$rate];
                    $result=$CI->setting->updatesetting($data);
                } 
                else{
                    $price=$prevrate;
                }
            }
            return $price;
		}  
	}
    
	if(!function_exists('checkApiStatus')) {
  		function checkApiStatus() {

            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.nowpayments.io/v1/status',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $array=json_decode($response,true);
            if(!empty($array['message']) && strtolower($array['message'])=="ok"){
                return TRUE;
            }
            else{
                return FALSE;
            }
		}  
	}

	if(!function_exists('getAuthToken')) {
  		function getAuthToken($data) {
            $payload=json_encode($data);
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.nowpayments.io/v1/auth',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>$payload,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            $array=json_decode($response,true);
            if(!empty($array['token'])){
                return $array['token'];
            }
            else{
                return '';
            }
		}  
	}

	if(!function_exists('getAvailableCoins')) {
  		function getAvailableCoins() {

            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.nowpayments.io/v1/merchant/coins',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'x-api-key: '.NP_API_KEY
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $array=json_decode($response,true);
            if(!empty($array['selectedCurrencies'])){
                return $array['selectedCurrencies'];
            }
            else{
                return array();
            }
		}  
	}

	if(!function_exists('getMinimumAmount')) {
  		function getMinimumAmount($from,$to,$fixed="False",$userfee="False") {

            $params="currency_from=$from&currency_to=$to&fiat_equivalent=usd&is_fixed_rate=$fixed&is_fee_paid_by_user=$userfee";
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.nowpayments.io/v1/min-amount?'.$params,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'x-api-key: '.NP_API_KEY
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            $array=json_decode($response,true);
            if(!empty($array)){
                return $array;
            }
            else{
                return array();
            }
		}  
	}

	if(!function_exists('getMinimumWithdrawal')) {
  		function getMinimumWithdrawal($coin) {

            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.nowpayments.io/v1/payout-withdrawal/min-amount/'.$coin,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'x-api-key: '.NP_API_KEY
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            $array=json_decode($response,true);
            if(!empty($array)){
                return $array;
            }
            else{
                return array();
            }
		}  
	}

	if(!function_exists('getBalance')) {
  		function getBalance() {

            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.nowpayments.io/v1/balance',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'x-api-key: '.NP_API_KEY
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            $array=json_decode($response,true);
            if(!empty($array)){
                return $array;
            }
            else{
                return array();
            }
		}  
	}

	if(!function_exists('validateAddress')) {
  		function validateAddress($data) {
            $payload=json_encode($data);
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.nowpayments.io/v1/payout/validate-address',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>$payload,
            CURLOPT_HTTPHEADER => array(
                'x-api-key: '.NP_API_KEY,
                'Content-Type: application/json'
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            $array=json_decode($response,true);
            
            if(empty($array) && strtolower($response)=='ok'){
                return TRUE;
            }
            else{
                return FALSE;
            }
		}  
	}

	if(!function_exists('createPayout')) {
  		function createPayout($authdata,$data) {
            $payload=json_encode($data);
            $curl = curl_init();

            $token=getAuthToken($authdata);

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.nowpayments.io/v1/payout',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>$payload,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$token,
                'x-api-key: '.NP_API_KEY,
                'Content-Type: application/json'
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            $array=json_decode($response,true);

            if(!empty($array)){
                return $array;
            }
            else{
                return array();
            }
		}  
	}