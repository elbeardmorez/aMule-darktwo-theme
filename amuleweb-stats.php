<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <title>aMule statistics</title>
    <meta http-equiv="content-type" content="text/html; charset=utf8">
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
  <table style="width: 400px; margin: auto;">
    <tr>
      <td colspan="3"><p class="p-heading">:: statistics ::</p>
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
    <tr class="layoutcolours">
      <td class="tableborder tableborder-left"></td>
      <td>
        <table>
          <tr valign="middle">
            <td rowspan="4">
              <iframe name="stats" src="amuleweb-stats_tree.php" style="width: 380px; height: 550px; padding: 5px; border-style: solid; border-width: 0px 1px 0px 0px; border-color: black;"></iframe>
            </td>
            <td>
              <table style="margin: 5px">
                <tr>
                  <td>
                    <p style="font-weight: bold; margin: 5px;">download speed</p>
                    <img src="amule_stats_download.png" alt="stats_download" style="width: 300px;">
                  </td>
                </tr>
                <tr>
                  <td>
                    <p style="font-weight: bold; margin: 5px;">upload speed</p>
                    <img src="amule_stats_upload.png" alt="stats_download" style="width: 300px;">
                  </td>
                </tr>
                <tr>
                  <td>
                    <p style="font-weight: bold; margin: 5px;"># ed2k connections</p>
                    <img src="amule_stats_conncount.png" alt="stats_download" style="width: 300px;">
                  </td>
                </tr>
                <tr>
                  <td>
                    <p style="font-weight: bold; margin: 5px;"># Kad node connections</p>
                    <img src="amule_stats_kad.png" alt="stats_download" style="width: 300px;">
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
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
