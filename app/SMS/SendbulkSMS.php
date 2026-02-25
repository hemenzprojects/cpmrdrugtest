<?php

namespace App\SMS;

    class SendbulkSMS{

        public static function sendBulkMessage($message,$phoneNumber){

            $senderName = config('sms.bulk.sender_name');
            $apiKey = config('sms.bulk.api_key');
            $endpoint = config('sms.bulk.api_url');

            // Build URL with API key as query parameter
            $url = $endpoint . '?key=' . $apiKey;

            // mNotify API parameters (recipient must be an array)
            $recipients = is_array($phoneNumber) ? $phoneNumber : [$phoneNumber];

            $data = [
                'recipient' => $recipients,
                'sender' => $senderName,
                'message' => $message,
                'is_schedule' => false,
                'schedule_date' => ''
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $server_output = curl_exec($ch);
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
