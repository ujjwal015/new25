<?php
header('content-type:text/xml');
?>
<Response>
    <Dial callerId="+16477978995"><?php echo $_POST['To'];?></Dial>
</Response>