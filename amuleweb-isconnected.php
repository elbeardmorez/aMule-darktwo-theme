<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <title>aMule Control Connection Page</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8">
    <link rel="stylesheet" type="text/css" href="amuleweb.css" />
    <?php
      if ( $_SESSION["auto_refresh"] > 0 ) {
        echo "<meta http-equiv=\"refresh\" content=\"", $_SESSION["auto_refresh"], '">';
      }
    ?>
  </head>
  <body background="main_topbar.png">
    <table width="100%" class="isconnected">
      <tr valign="middle">
        <td align="center" width="10">
          <img src="emule.png" height="30">
        </td>
        <td nowrap height="53">
          <?php
            function CastToXBytes($size)
            {
              if ( $size < 1024 ) {
                $result = $size . " bytes";
              } elseif ( $size < 1048576 ) {
                $result = ($size / 1024.0) . "KB";
              } elseif ( $size < 1073741824 ) {
                $result = ($size / 1048576.0) . "MB";
              } else {
                $result = ($size / 1073741824.0) . "GB";
              }
              return $result;
            }

            $stats = amule_get_stats();

            echo '<b>ed2k : </b>';
            if ( $stats["id"] == 0 )
            {
              echo 'Not connected';
            } elseif ( $stats["id"] == 0xffffffff )
            {
              echo 'Connecting ...';
            } else
            {
              echo 'Connected with ', (($stats["id"] < 16777216) ? "Low" : "High"), " ID to \"", $stats["serv_name"],"\"";
            }

            echo "<br><b>Kad Connection : </b>";
              if ( $stats["kad_connected"] == 1 )
            {
              if ( $stats["kad_firewalled"] == 1 )
              {
                echo "Firewalled";
              } else
              {
                echo "OK";
              }
              } else
            {
                echo "Disconnected";
              }

            echo '<br><b>Up Speed : </b>', CastToXBytes($stats["speed_up"]), '/s',
              ' | <b>Down Speed : </b>', CastToXBytes($stats["speed_down"]), '/s',
              '<small> (Limits : ', CastToXBytes($stats["speed_limit_up"]), '/s | ',
              CastToXBytes($stats["speed_limit_down"]), '/s)</small>&nbsp;';
          ?>
        </td>
      </tr>
    </table>
  </body>
</html>
