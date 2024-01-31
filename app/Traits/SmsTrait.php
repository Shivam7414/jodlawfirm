<?php
namespace App\Traits;
trait SmsTrait
{
    public function sendSms($otp, $mobile)
    {
        $authkeyUrl = "https://api.authkey.io/request?";
        $paramArray = Array(
                'authkey' => '1d742893f5c45330',
                'name' => 'Shivam Kumar',
                'mobile' => $mobile,
                'otp' => $otp,
                'country_code' => '91',
                'sid' => 10239,
            );
        
        $parameters = http_build_query($paramArray);
        $url = $authkeyUrl . $parameters;
        
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }
}

?>