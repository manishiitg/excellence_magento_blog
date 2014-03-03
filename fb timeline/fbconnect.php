<?php

require_once 'src/facebook.php';
$facebook = new Facebook(array(
		'appId'  => '182741145117428',
		'secret' => '2843038e516604e47b9f5890aa9f0680',
));
$user = $facebook->getUser();
if ($user) {
	try {
		// Proceed knowing you have a logged in user who's authenticated.
		$user_profile = $facebook->api('/me');
			/*
			try{
				$params = array('article'=>'http://excellencetechnologies.co.in/fb/article.php?id='.rand(0,100));
				$out = $facebook->api('/me/news.reads','post',$params);
				print_r($out);
			}catch(Exception $e){
			echo $e->getMessage().'<br>';
			}
			*/
			
			/*
			
			try{
				$params = array('movie'=>'http://excellencetechnologies.co.in/fb/movie.php?id='.rand(0,100));
				$out = $facebook->api('/me/video.watches','post',$params);
				print_r($out);
			}catch(Exception $e){
			echo $e->getMessage().'<br>';
			}
			
			*/
			
			try{
				
					$app_id = '182741145117428';
					$app_secret = '2843038e516604e47b9f5890aa9f0680';
				 // Get an App Access Token
				  $token_url = 'https://graph.facebook.com/oauth/access_token?'
					. 'client_id=' .$app_id
					. '&client_secret='.$app_secret
					. '&grant_type=client_credentials';

				  $token_response = file_get_contents($token_url);
				  $params = null;
				  parse_str($token_response, $params);
				  $app_access_token = $params['access_token'];
				  
				 $achievement = 'http://excellencetechnologies.co.in/fb/achievement.php?id='.rand(0,100);
					print('Register a User Achievement<br/>');
					$achievement_display_order = 1;
				$achievement_registration_URL = 'https://graph.facebook.com/'.$app_id.'/achievements';
				$achievement_registration_result=https_post($achievement_registration_URL,
				'achievement=' . $achievement
				  . '&display_order=' . $achievement_display_order
				  . '&access_token=' . $app_access_token
			  );
				
			  
			
					print('Publish a User Achievement<br/>');
				  $achievement_URL = 'https://graph.facebook.com/'.$user_profile['id'].'/achievements';
				  $achievement_result = https_post($achievement_URL,
					'achievement=' . $achievement
					. '&access_token=' . $app_access_token
				  );
				  print('<br/><br/>');
  
  
				$score = 1;
				  // POST a user score
				  print('Publish a User Score<br/>');
				  $score_URL = 'https://graph.facebook.com/' . $user_profile['id'] . '/scores';
				  $score_result = https_post($score_URL,
					'score=' . $score . '&access_token=' . $app_access_token
				  );
				  print('<br/><br/>');
				  
				  
			}catch(Exception $e){
				echo $e->getMessage().'<br>';
			}
			
			
			print_r($user_profile);
			print_r($params);

	} catch (FacebookApiException $e) {
		error_log($e);
		$user = null;
	}
}

function https_post($uri, $postdata) {
    $ch = curl_init($uri);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
  }

?>