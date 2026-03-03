<?php
        session_start();

        include("include.php");

        include('config.php');
        
        include('hybridauth/Hybrid/Auth.php');
	
        require_once "User.class.php";
        
        if(isset($_GET['provider']))
        {
        	$provider = $_GET['provider'];
        	
        	try{
        	
        	$hybridauth = new Hybrid_Auth($config);
        	
        	$authProvider = $hybridauth->authenticate($provider);

	        $user_profile = $authProvider->getUserProfile();
	        
	        
			if($user_profile && isset($user_profile->identifier))
	        {
	        	
                    //// Initialize User class
                    $user = new User();
     
                    // Getting user profile info 
                	$sess_id = md5(microtime());
                	$etat = 1;
                    
                    $userData = array(); 
                    $userData['oauth_uid']    = !empty($user_profile->identifier)?$user_profile->identifier :''; 
                    $userData['prenom']       = !empty($user_profile->firstName)?$user_profile->firstName :''; 
                    $userData['nom']          = !empty($user_profile->lastName)?$user_profile->lastName  :''; 
                    $userData['email']        = !empty($user_profile->email)?$user_profile->email:''; 
                    $userData['oauth_provider'] = $provider; 
                    $userDataS = $user->checkUser($userData);
                    // Storing user data in the session 
                    $_SESSION['userData'] = $userDataS; 
                    //print_r($_SESSION['userData']);
                    //print_r($_SESSION['userData']['id']);
                			  $_SESSION['client_id']=$_SESSION['userData']['id']; 
                			  $_SESSION['client_login']=$_SESSION['userData']['email'];
                			  $_SESSION['client_nom']=$_SESSION['userData']['nom'];
                			  $_SESSION['sess_id'] = $sess_id;
	        	
	        }	        

			}
			catch( Exception $e )
			{ 
			
				 switch( $e->getCode() )
				 {
                        case 0 : echo "Unspecified error."; break;
                        case 1 : echo "Hybridauth configuration error."; break;
                        case 2 : echo "Provider not properly configured."; break;
                        case 3 : echo "Unknown or disabled provider."; break;
                        case 4 : echo "Missing provider application credentials."; break;
                        case 5 : echo "Authentication failed. "
                                         . "The user has canceled the authentication or the provider refused the connection.";
                                 break;
                        case 6 : echo "User profile request failed. Most likely the user is not connected "
                                         . "to the provider and he should to authenticate again.";
                                 $twitter->logout();
                                 break;
                        case 7 : echo "User not connected to the provider.";
                                 $twitter->logout();
                                 break;
                        case 8 : echo "Provider does not support this feature."; break;
                }

                // well, basically your should not display this to the end user, just give him a hint and move on..
                echo "<br /><br /><b>Original error message:</b> " . $e->getMessage();

                echo "<hr /><h3>Trace</h3> <pre>" . $e->getTraceAsString() . "</pre>";

			}
        
        }
?>