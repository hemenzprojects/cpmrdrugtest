<?php
namespace App\SMS;

class SendSMS{

          public static function sendMessage($message,$phoneNumber){
            try{
             $url ="https://api.wirepick.com/httpsms/send";
                   $param = array('phone'=>'233'.substr($phoneNumber,1),
                  'from'=>'CPMR-SID','client'=>'hemenmike','password'=>'cpmr@321','text'=>urlencode($message));
    
             $rest = '';
                foreach($param as $key=>$value){
                  $rest.=$key.'='.$value.'&';
                 }
                  $rest = substr($rest, 0,-1);
                  $newurl = $url.'?'.$rest;
                   $ch = curl_init($newurl);
                   curl_setopt($ch, CURLOPT_POST, 0);
                   curl_setopt($ch, CURLOPT_VERBOSE, true); 
                   curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                   $result = curl_exec($ch); 
                   $error = curl_error($ch);  
                  //  dd($error);
                
            } catch (\Exception $e) {
           
            }
             
            }
}

?>