<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <title>aMule logs</title>
    <meta http-equiv="content-type" content="text/html; charset=utf8">
    <link rel="stylesheet" type="text/css" href="amuleweb.css" />
  </head>
  <body>
  <br>
  <table class="log">
    <tr>
      <td height="30" colspan="3"><b>&nbsp;&nbsp;&nbsp;:: client log ::</b>
        <?php
          if ($_SESSION["guest_login"] != 0)
          {
            echo '&nbsp;&nbsp;&nbsp;<p class="error"><b>You logged in as guest - commands are disabled</b></p>';
          }
        ?>
      </td>
    </tr>
    <tr>
      <td class="tableborder tableborder-top-left"></td>
      <td class="tableborder tableborder-top-middle"></td>
      <td class="tableborder tableborder-top-right"></td>
    </tr>
    <tr valign="middle" class="layoutcolours">
      <td class="tableborder tableborder-left"></td>
      <td height="35">
        <table height=100% cellpadding="5">
          <tr>
            <td>
              <?php
                if ($_SESSION["guest_login"] == 0)
                { 
                  echo '<form action="amuleweb-logs_client.php" method="POST" target="log_client">';
                  echo '<input type="submit" class="form_button" value="reset">';
                  echo '<input type="hidden" name="rst" value=1>';
                  echo '<input type="hidden" name="log" value=1>';
                  echo '</form>';
                }
              ?>
            </td>
          </tr>
        </table>
      </td>
      <td class="tableborder tableborder-right"></td>
    </tr>
    <tr valign="middle" class="layoutcolours">
      <td class="tableborder tableborder-left"></td>
      <td align="center">
        <iframe name="log_client" src="amuleweb-logs_client.php" width="100%" height="200" frameborder="0"></iframe>
      </td>
      <td class="tableborder tableborder-right"></td>
    </tr>
    <tr>
      <td class="tableborder tableborder-bottom-left"></td>
      <td class="tableborder tableborder-bottom-middle"></td>
      <td class="tableborder tableborder-bottom-right"></td>
    </tr>
    <br>
    <tr>
      <td height="30" colspan=3><b>&nbsp;&nbsp;&nbsp;:: server log ::</b>
        <?php
          if ($_SESSION["guest_login"] != 0)
          {
            echo '&nbsp;&nbsp;&nbsp;<p class="error"><b>You logged in as guest - commands are disabled</b></p>';
          }
        ?>
      </td>
    </tr>
    <tr>
      <td class="tableborder tableborder-top-left"></td>
      <td class="tableborder tableborder-top-middle"></td>
      <td class="tableborder tableborder-top-right"></td>
    </tr>
    <tr valign="middle" class="layoutcolours">
      <td class="tableborder tableborder-left"></td>
      <td height="35">
        <table height=100% cellpadding="5">
          <tr>
            <td>
              <?php
                if ($_SESSION["guest_login"] == 0)
                {
                  echo '<form action="amuleweb-log_server.php" method="POST" target="log_server">';
                  echo '<input type="submit" class="form_button" value="reset">';
                  echo '<input type="hidden" name="rst" value=1>';
                  echo '<input type="hidden" name="log" value=1>';
                  echo '</form>';
                }
              ?>
            </td>
          </tr>
        </table>
      </td>
      <td class="tableborder tableborder-right"></td>
    </tr>
    <tr class="layoutcolours">
      <td class="tableborder tableborder-left"></td>
      <td>&nbsp;</td>
      <td class="tableborder tableborder-right"></td>
    </tr>
    <tr valign="middle" class="layoutcolours">
      <td class="tableborder tableborder-left"></td>
      <td align="center">
        <iframe name="log_server" src="amuleweb-logs_server.php" width="100%" height="200" frameborder="0"></iframe>
      </td>
      <td class="tableborder tableborder-right"></td>
    </tr>
    <tr>
      <td class="tableborder tableborder-bottom-left"></td>
      <td class="tableborder tableborder-bottom-middle"></td>
      <td class="tableborder tableborder-bottom-right"></td>
    </tr>
  </table>
  </body>
</html>
