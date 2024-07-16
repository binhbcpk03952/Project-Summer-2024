<?php
require_once 'config.php';

// if (isset($_SESSION['id'])) {
//   header("Location: http://localhost/project-summer-2024/client/index.php");
 
// } else {
?>
  <a href='<?= $client->createAuthUrl() ?>' style="text-decoration: none">
    <div id="g_id_onload" data-client_id="458978552911-p25084ai5sim4q3aj3tqn70mjihl62ds.apps.googleusercontent.com" data-context="signin" data-ux_mode="redirect" data-login_uri="http://localhost/project-summer-2024/client/php-google-login/google-login.php" data-auto_prompt="false">
    </div>

    <div style="width: 300px; margin-top: 20px; height: 30px; margin-left: 150px;" class="g_id_signin" data-type="standard" data-shape="pill" data-theme="outline" data-text="signin_with" data-size="medium" data-logo_alignment="left" data-width="200px">
    </div>
  </a>

<?php
// }
?>
<script src="https://accounts.google.com/gsi/client" async></script>