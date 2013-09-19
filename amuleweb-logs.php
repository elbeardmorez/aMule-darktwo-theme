<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <title>aMule Logs Page</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8">
    <link rel="stylesheet" type="text/css" href="amuleweb.css" />
  </head>
  <body>
  <br>
  <table border="0" align="center" cellspacing="0" cellpadding="0">
    <tr>
      <td height="30" colspan="3"><b>&nbsp;&nbsp;&nbsp;:: Logs ::</b>
        <?php
          if ($_SESSION["guest_login"] != 0)
          {
            echo '&nbsp;&nbsp;&nbsp;<p class="error"><b>You logged in as guest - commands are disabled</b></p>';
          }
        ?>
      </td>
    </tr>
    <tr>
      <td class="tab_top_left">&nbsp;</td>
      <td class="tab_top_middle">&nbsp;</td>
      <td class="tab_top_right">&nbsp;</td>
    </tr>
    <tr>
      <td class="tab_left">&nbsp;</td>
      <td>
        <table width="65%" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td>
              <?php
                if ($_SESSION["guest_login"] == 0)
                {
                  echo '<form action="amuleweb-logs.php" method="POST">';
                  echo '<input type="submit" value="Reset">';
                  echo '<input type="hidden" name="rst" value=1>';
                  echo '<input type="hidden" name="log" value=1>';
                  echo '</form>';
                }
              ?>
            </td>
          </tr>
          <tr>
            <td align="left">
              <font color="#000000" face="Lucida Console">
                <?php
                  $strlog = amule_get_log($HTTP_GET_VARS['rst']);
                  echo '<pre>';
                  echo $strlog;
                  echo '</pre>';
                ?>
              </font>
            </td>
          </tr>
        </table>
      </td>
      <td class="tab_right">&nbsp;</td>
    </tr>
    <tr>
      <td class="tab_bottom_left">&nbsp;</td>
      <td class="tab_bottom_middle">&nbsp;</td>
      <td class="tab_bottom_right">&nbsp;</td>
    </tr>
  </table>
  </body>
</html>
