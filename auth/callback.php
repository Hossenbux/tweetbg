<script>
	function windowClose(){
		window.opener.fireEvent('authSuccess');
		self.close();
	}
</script>
<?php 
require_once('twitterAuth.php');

$twitter = new TwitterAuth();
$twitter->getAccess();
echo "<SCRIPT LANGUAGE='javascript'>windowClose();</SCRIPT>";
?>
