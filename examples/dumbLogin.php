<?php

    // Unless the SSO returned some errors, being here means that the user is authentication on the SSO

    // Extract the SSO token from the request
    // ...

    // Use the token to retrieve user info from the SSO
    // ...

    // Retrieve user from the local database and log him in.
    // ...

    $userData = array (
        'username' => 'foobar',
        'foo' => 'bar',
    );

    // We're done, now we have to inform the calling frame that the user has been authenticated

?>
<!doctype html>
<html>
<head></head>
<body><script type="text/javascript">
parent.jQuery.ssoBgConnect ('finishAuthentication', <?php echo json_encode ($userData) ?>);
</script></body>
</html>


