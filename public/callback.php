<script>
	function windowClose(){
		window.opener.fireEvent('authSuccess');
		self.close();
	}
</script>
<?php 
require_once('../auth/twitterAuth.php');

$twitter = new TwitterAuth();
$twitter->getAccess();
echo "<SCRIPT LANGUAGE='javascript'>windowClose();</SCRIPT>";
?>
