<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<body class="index">
	
	
	<div class="loginbut">

								<div class="loginimg">
									<button onclick='login();return false;'>
										Login
									</button>
								</div>

							</div>

							<div id="fb-root"></div>
							<script type="text/javascript">
							//<![CDATA[
							
							window.fbAsyncInit = function() {
								FB.init({
									appId      : '182741145117428', // App ID

									status     : true, // check login status
									cookie     : true, // enable cookies to allow the server to access the session
									oauth      : true, // enable OAuth 2.0
									xfbml      : false  // parse XFBML
								});
												
						
							};
						
							// logs the user in the application and facebook
							function login(){
								FB.getLoginStatus(function(r){
								 if(r.status === 'connected'){
										window.location.href = 'fbconnect.php';
								 }else{
									FB.login(function(response) {
										if(response.authResponse) {
										  //if (response.perms) {
												window.location.href = 'fbconnect.php';
										} else {
										  // user is not logged in
										}
									  },{scope:'email,publish_actions'});
								  }
							  });
							}
						
							// logs the user out of the application and facebook
							
						
							// Load the SDK Asynchronously
							(function() {
							var e = document.createElement('script'); e.async = true;
							e.src = document.location.protocol 
							+ '//connect.facebook.net/en_US/all.js';
							document.getElementById('fb-root').appendChild(e);
							}());
						//]]>
						</script>
	
	
</body>
</html>