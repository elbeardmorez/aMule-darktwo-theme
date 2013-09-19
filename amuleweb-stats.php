<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <title>aMule Stats Page</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8">
    <link rel="stylesheet" type="text/css" href="amuleweb.css" />
    <?php
      if ( $_SESSION["auto_refresh"] > 0 )
      {
        echo "<meta http-equiv=\"refresh\" content=\"", $_SESSION["auto_refresh"], '">';
      }

      amule_load_vars("stats_graph");
    ?>
  </head>
  <body>
  <br>
  <table border="0" align="center" cellspacing="0" cellpadding="0">
    <tr>
      <td height="30" colspan="3"><b>&nbsp;&nbsp;&nbsp;:: statistics ::</b>
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
    <tr class="tab_colour">
      <td class="tab_left">&nbsp;</td>
      <td>
        <table border="0" cellpadding="0" cellspacing="0" align="center">
          <tr valign="middle">
            <td rowspan="5" align="center">
              <iframe name="stats" src="amuleweb-stats_tree.php" width="380" height="470" frameborder="0"></iframe>
            </td>
            <td>
              <table align="left">
                <tr>
                  <td width="380" height="220" align="center"><img src="amule_stats_download.png" width="360" height="200" border="0" alt="stats_download"></td>
                  <td width="380" height="220" align="center"><img src="amule_stats_upload.png" width="360" height="200" border="0" alt="stats_upload"></td>
                </tr>
                <tr valign="top">
                  <td align="center" height="30"><b>Download speed</b></td>
                  <td align="center" height="30"><b>Upload speed</b></td>
                </tr>
                <tr valign="middle">
                  <td width="380" height="220" align="center"><img src="amule_stats_conncount.png" width="360" height="200" border="0" alt="stats_conn"></td>
                  <td width="380" height="220" align="center"><img src="amule_stats_kad.png" width="360" height="200" border="0" alt="stats_kad"></td>
                </tr>
                <tr valign="top">
                  <td align="center"><b>Number of ed2k connections</b></td>
                  <td align="center"><b>Number of Kad nodes connections</b></td>
                </tr>
              </table>
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
