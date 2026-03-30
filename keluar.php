<?php
    session_name("pedulisaran_session");
    session_start();
    session_destroy();
    echo '<script>window.location="login.php"</script>'
?>