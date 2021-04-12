<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Validator,Redirect,Response,File;
use Socialite;
use App\User;
class SocialController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
 
    public function callback($provider)
    {
               
        //$getInfo = Socialite::driver($provider)->user();
  
        // echo $getInfo->token;
       // var_dump($getInfo);

        // $user = $this->createUser($getInfo,$provider);
 
        // auth()->login($user);
 
        // return redirect()->to('/home');



        // $resource = '/v1/people/~:(id,first-name,last-name,headline,picture-url,industry,summary,specialties,positions:(id,title,summary,start-date,end-date,is-current,company:(id,name,type,size,industry,ticker)),educations:(id,school-name,field-of-study,start-date,end-date,degree,activities,notes),associations,interests,num-recommenders,date-of-birth,publications:(id,title,publisher:(name),authors:(id,name),date,url,summary),patents:(id,title,summary,number,status:(id,name),office:(name),inventors:(id,name),date,url),languages:(id,language:(name),proficiency:(level,name)),skills:(id,skill:(name)),certifications:(id,name,authority:(name),number,start-date,end-date),courses:(id,name,number),recommendations-received:(id,recommendation-type,recommendation-text,recommender),honors-awards,three-current-positions,three-past-positions,volunteer)';
        // $params = array('oauth2_access_token' => $getInfo->token, 'format' => 'json');
        // $url = 'https://api.linkedin.com' . $resource . '?' . http_build_query($params);
        // $context = stream_context_create(array('http' => array('method' => 'GET')));
        // $response = file_get_contents($url, false, $context);
        // $data = json_decode($response);
        // var_dump($data);

        if(isset($_GET['code'])){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"https://www.linkedin.com/oauth/v2/accessToken");
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_POSTFIELDS,"grant_type=authorization_code&code=".$_GET['code']."&redirect_uri=".env('LINKEDIN_CALLBACK_URL', null)."&client_id=".env('LINKEDIN_CLIENT_ID', null)."&client_secret=".env('LINKEDIN_CLIENT_SECRET', null)."");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec ($ch);
            curl_close ($ch);
            
        }
        
        if(isset($_GET['code']) && json_decode($server_output)->access_token != ''){
        
             $ch = curl_init();
             curl_setopt($ch, CURLOPT_URL,"https://api.linkedin.com/v2/people/~?oauth2_access_token=".json_decode($server_output)->access_token."&format=json");
             curl_setopt($ch, CURLOPT_POST, 0);
             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
             $server_output2 = curl_exec ($ch);
             curl_close ($ch);

             $user_data = json_decode($server_output2);
        
             print_r($user_data);
            //  var_dump($user_data);
        
        } 
    }
   function createUser($getInfo,$provider){
 
     $user = User::where('provider_id', $getInfo->id)->first();
 
     if (!$user) {
         $user = User::create([
            'name'     => $getInfo->name,
            'email'    => $getInfo->email,
            'provider' => $provider,
            'provider_id' => $getInfo->id
        ]);
      }
      return $user;
   }
}
