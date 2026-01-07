<?php

namespace App\SMS;

    class SendbulkSMS{

        public static function sendBulkMessage($message,$phoneNumber){

            $senderName = config('sms.bulk.sender_name');
            $clientId = config('sms.bulk.client_id');
            $apiKey = config('sms.bulk.api_key');
            $headers = ['Content-Type: application/json'];
            $baseurl = config('sms.bulk.api_url');
            $details = 
               'clientId='.$clientId.'&'.
               'phoneNumbers='.$phoneNumber.'&'.
               'messages='.$message.'&'.
               'senderName='.$senderName.'&'.
               'apiKey='.$apiKey;
                parse_str($details,$details);
                $details = json_encode($details);
               // dd($details);
                $ch = curl_init($baseurl);                                                                      
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
            curl_setopt($ch, CURLOPT_POSTFIELDS, $details); // $data is the request payload                                                                  
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
            $server_output = curl_exec ($ch);
          //  dd($server_output);
            $err = curl_error($ch);
            
            curl_close($ch);
            if($err){
               return null;
            }else{ 
              $resp = json_decode($server_output);
              return $resp;  
            }
             
} 
        
      // public static function sendCustomerMessage()

       public static function status($result){
                  switch($result){
                                 case "1000":
                                             return "success";
                                 break;
                                 case "1002":
                                             return "SMS sending failed. Might be due to server error or other reason";
                                 break;
                                 case "1003":
                                             return "Insufficient SMS balance";
                                 break;
                                 case "1004":
                                             return "Invalid API key";
                                 break;
                                 case "1005":
                                             return "Invalid Recipient's Phone Number";
                                 break;
                                 case "1006":
                                             return "Invalid Sender ID. Sender ID must not be more than 11 Characters. Characters include white space.";
                                 break;
                                 case "1007":
                                             return "Message scheduled for later delivery";
                                 break;
                                 case "1008":
                                             return "Empty Message";
                                 break;
                                 case "1009":
                                             return "MNotify URL Down";
                                 break;
                                 default:
                                 return $result;
                                 break;

                              
                              }//End Of Switch Statement
                 }
          }
          



          
   

?>
