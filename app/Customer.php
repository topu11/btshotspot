<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    function __construct() {

	}

	private $API_KEY = 'C20005715f8a8ffc091679.76463480';
	private $SENDER_ID = "8809612440702";
	private $type = 'text';
	private $RESPONSE_TYPE = 'json';

	public function sendSMS($OTP, $mobileNumber){		
		$isError = 0;
		$errorMessage = true;

		//Your message to send, Adding URL encoding.
	    $message = "Welcome to BTS-Hotspot, Your OTP is : $OTP";
	 

	    //Preparing post parameters
	    $postData = array(
	        'api_key' => $this->API_KEY,
	        'contacts' => $mobileNumber,
	        'msg' => $message,
	        'senderid' => $this->SENDER_ID,
	        'type' => $this->type
	    );
	 
	    $url = "http://bulksms.netcomsolutionbd.com/smsapi";
	 
	    $ch = curl_init();
	    curl_setopt_array($ch, array(
	        CURLOPT_URL => $url,
	        CURLOPT_RETURNTRANSFER => true,
	        CURLOPT_POST => true,
	        CURLOPT_POSTFIELDS => $postData
	    ));
	 
	 
	    //Ignore SSL certificate verification
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	 
	 
	    //get response
	    $output = curl_exec($ch);
	 
	    //Print error if any
	    if (curl_errno($ch)) {
	    	$isError = true;
	        $errorMessage = curl_error($ch);
	    }
	    curl_close($ch);
	    if($isError){
	    	return array('error' => 1 , 'message' => $errorMessage);
	    }else{
	    	return array('error' => 0 );
	    }
	}
}
