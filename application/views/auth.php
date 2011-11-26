<script>
    function windowClose(){
        window.opener.fireEvent('authSuccess');
        self.close();
    }
</script>

<?php echo "<SCRIPT LANGUAGE='javascript'>windowClose();</SCRIPT>"; ?>