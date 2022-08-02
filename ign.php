<?php
class instagramChecker{
   public function curl($data){
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, "https://accountscenter.instagram.com/api/graphql/");
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_ENCODING, ""); // UNICODE OUTPUT KILLER

      $headers = array(
         "Host: accountscenter.instagram.com",
         'Cookie: ig_did=3BB774EB-4A9A-4D84-8C2B-102CEBAD4015; ig_nrcb=1; mid=YubuHQALAAH0Hzjtq1jyqcziSEoh; csrftoken=KBZrlgVHvXFY9UjdbdNqsKTwVNXqn7g1; ds_user_id=53937350863; sessionid=53937350863%3AeaFTa8GmQeNQYA%3A19%3AAYf0E6LxWNrVwyBDbKSp6WqW9VFAZ2eJOJm7TRSbcg; rur="PRN\05453937350863\0541690838308:01f7b074b201787a0712774d41ddfd4f93734b988864c7408ad5524bb5e34076d6206d5a"; datr=o_HmYjImTZAAJnG5_GPazkmN',
         "Sec-Ch-Ua-Mobile: ?0",
         "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.134 Safari/537.36",
         "Viewport-Width: 1366",
         "X-Fb-Friendly-Name: useFXIMUsernameValidatorBaseQuery",
         "X-Fb-Lsd: UhPwPaPMa8HRuES-10gnZV",
         "Content-Type: application/x-www-form-urlencoded",
         "Sec-Ch-Prefers-Color-Scheme: light",
         "Accept: */*",
         "Origin: https://accountscenter.instagram.com",
         "Sec-Fetch-Site: same-origin",
         "Sec-Fetch-Mode: cors",
         "Sec-Fetch-Dest: empty",
         "Accept-Encoding: gzip, deflate",
         "Accept-Language: en-US,en;q=0.9",
      );
      curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($curl, CURLOPT_POSTFIELDS, "av=17841453965912168&__user=0&__a=1&__dyn=7xeUmwlE7ibwKBWo2vwAxu13w8CewSwMwNw9G2S0lW4o0B-q1ew65xO0FE2awt81sbzo5-0Boy1PwBgao6C0Mo5W3S1lwlEjxG1Pxi4UaEW0D888cobEaU2eU5O0HUvU1aUbodEGdwtU2exa1vwiE4K2e2q48co&__csr=hckWASh9aicyDUixmfACGcwzz9olDyrwwyU-c-22aXUTBxS5E-u799qU8oW4Eb44aBK2u-224QUcUOEnzrwlUSawc6aw3woXhoW9zbBDAyE15WBxe580b2yxN00F1g0Z-07TocE06eqi02kWGh80lVw3Xo9Ed8n9mt2pk04S9E0Gy0uO08Dw1vi13w6TDw1CuU5C0drwnVlw5OQ0OUW0mG6E0w_w0B5w13q0arw5fw1Ke2y&__req=p&__hs=19205.HYP%3Acomet_loggedout_pkg.2.0.0.0.0&dpr=1&__ccg=EXCELLENT&__rev=1005944289&__s=rvziuz%3Abhm1al%3As6bkjt&__hsi=7126936223427375906&__comet_req=3&fb_dtsg=NAcObQ1z7l4G8-_igsnq36toH2FgJO5Oc9H3WhNbWYdG9fQIJ8y1pIg%3A17843683195144578%3A1659302166&jazoest=26040&lsd=UhPwPaPMa8HRuES-10gnZV&__spin_r=1005944289&__spin_b=trunk&__spin_t=1659369148&fb_api_caller_class=RelayModern&fb_api_req_friendly_name=useFXIMUsernameValidatorBaseQuery&variables=%7B%22action_source%22%3A%22EDIT%22%2C%22identity_ids%22%3A%5B%2217841453965912168%22%5D%2C%22username%22%3A%22".$data."%22%2C%22included_app_validations%22%3A%5B%5D%7D&server_timestamps=true&doc_id=5147530792026571");
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
      $resp = curl_exec($curl);
      curl_close($curl);
      return $resp;
   }
   public function RandomString($length = 5){
      $characters = '1234567890abcdefghijklmnopqrstuvwxyz';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;
   }
}
$api = new instagramChecker;
$check = readline('How many user do you want to generate? ');
for($i = 0; $i < $check; $i++){
   $username = $api->RandomString();
   $x = $api->curl($username);
   $c = json_decode($x, true);
   $data = $c['data']['fx_identity_management']['validate_username_v4'];
   $status = $data['status_code'];
   $err = $data['error_message'];
   if(($status != "ERROR_COLLISION") && ($status != "ERROR_GENERIC")){
      echo "Username: ".$username." | Status: ".$status." | Resp: Username is available\n";
   } else {
      echo "Username: ".$username." | Status: ".$status." | Resp: ".$err."\n";
   }
$logs = "$username | $status";
$myfile = file_put_contents('logs.txt', $logs.PHP_EOL , FILE_APPEND | LOCK_EX);
}
?>
