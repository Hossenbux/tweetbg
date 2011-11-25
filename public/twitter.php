<script>
    function windowClose(){
        window.opener.fireEvent('authSuccess');
        self.close();
    }
</script>

<?php
    session_start();    
	require_once('../auth/twitterAuth.php');
	try{
    	$connection = new TwitterAuth();
        
        if(isset($_GET['oauth_verifier']))
            $_SESSION['oauth_verifier'] = $_GET['oauth_verifier'];
        
        if(!isset($_SESSION['oauth_token']) || !isset($_SESSION['oauth_verifier']))
    	   $connection->getAuth();
        else {
            $connection->getAccess($_SESSION['oauth_token'],  $_SESSION['oauth_token_secret'], $_SESSION['oauth_verifier']); 
            session_destroy();      
            echo "<SCRIPT LANGUAGE='javascript'>windowClose();</SCRIPT>";
        }
    } catch (Exception $e){
        session_destroy();  
        echo $e->getMessage();
    }
