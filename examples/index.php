<?php

require_once 'facebook-sdk/facebook.php';
require_once 'conf.php';

session_start ();
$user = array_key_exists ('user', $_SESSION) ? $_SESSION['user'] : null;

$facebook = new Facebook($conf['facebook']); // Only used to forge URLs

?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
</head>

<body>

  <h1>SSO Background Connect Test</h1>

  <?php if ($user !== null): ?>
    <p>You are connected as "<?php echo $user['name'] ?>" thanks to the <?php echo $user['sso'] ?> SSO</p>
  <?php else: ?>
    <p>You're not connected, if you followed the testing procedure you should be automagicaly connected thanks to the sso-bg-connect plugin</p>
  <?php endif ?>

  <p><b>Testing procedure:</b></p>
  <ol>
    <li>
      If you haven't done it already, you need to allow on or more of our SsoBgConnect clients to access to your basic profile :
      <ul>
        <li><a href="<?php $facebook->getLoginUrl () ?>">Facebook client</a></li>
        <li><a href="https://www.twitter.com/login.php?api_key=<?php echo $conf['twitter']['appId'] ?>" target="_blank">Twitter client</a></li>
      </ul>
    </li>
    <li>
      Logout of all of your SSO providers
      <ul>
        <li><a href="<?php $facebook->getLogoutUrl () ?>">Facebook logout</a></li>
      </ul>
    </li>
    <li>
      <a href="logout.php">Clear your session and cookies</a> from this website, just in case.
      The page will reload and you shouldn't be connected
    </li>
    <li>
      Open a new tab, and connect to one of your SSO provider :
      <a href="https://www.facebook.com" target="_blank">Facebook</a>,
      <a href="https://www.twitter.com" target="_blank">Twitter</a>,
      etc...
    </li>
    <li>
      <a href="index.php">Reload this page</a> you should be connected automagicaly !</a>
    </li>
  </ol>

  <p>This example is just a proof of concept, do not take any attention to the implemention details.</p>

  <?php if ($user === null): ?>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
    <script src="../jquery.sso-bg-connect.js"></script> 
    <script type="text/javascript">
      $.ssoBgConnect ({
        services: [
          /*{
            callback: "http://localhost/jquery.sso-bg-connect/examples/dumbLogin.php",
            service: "https://cas.univ-avignon.fr/?service={%callback%}"
          },*/
          {
            service: 'facebook',
            callback: 'http://code.didry.info/jquery.sso-bg-connect/examples/facebookLogin.php',
            appId: '<?php echo $conf['facebook']['appId'] ?>'
          }
        ],
        success: function (data) {
          alert ('Hi '+data.name+' ! The SsoBgConnect plugin logged you thanks to '+data.sso+'. The page will now reload.');
          document.location.href = document.location.href;
        }
      });
    </script>
  <?php endif ?>
</body>
</html>
