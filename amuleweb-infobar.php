<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <title>aMule info toolbar</title>
    <meta http-equiv="content-type" content="text/html; charset=utf8">
    <link rel="stylesheet" type="text/css" href="amuleweb.css" \>
    <?php
      if ( $_SESSION["auto_refresh"] > 0 ) {
        echo "<meta http-equiv=\"refresh\" content=\"", $_SESSION["auto_refresh"], '">';
      }
    ?>
    <script language="JavaScript" type="text/JavaScript">
      function refresh()
      {
        parent.mainFrame.document.location = "amuleweb-transfers.php";
      }
    </script>
  </head>
  <body background="main_topbar.png">
    <div id="infobar">
    <table style="height: 100%;">
      <tr style="height: 100%; vertical-align: middle">
        <td style="width: 20px; margin: auto 5px; text-align: center;">
          <img src="emule.png" style="height: 30px;">
        </td>
        <td style="padding: 0px 5px; margin: 0px 10px;">
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
        <td style="width: 100%; text-align: right; padding: 0px 5px; margin: 0px 10px 0px 20px">
          <form name="formlink" method="get" action="amuleweb-infobar.php">
            <input name="Submit" type="submit" class="form_button" value="download link" onclick="refresh()">
            <input id="ed2klink" name="ed2klink" type="text" class="form_text" style="width:50%; max-width: 450px; min-width: 10px; padding: 2px 5px 2px 2px">
            <select id="selectcat" name="selectcat" class="form_text">
              <?php
                $cats = amule_get_categories();
                if ( $HTTP_GET_VARS["Submit"] != "" )
                {
                  $link = $HTTP_GET_VARS["ed2klink"];
                  $target_cat = $HTTP_GET_VARS["selectcat"];
                  $target_cat_idx = 0;
                        foreach($cats as $i => $c)
                        {
                          if ( $target_cat == $c) $target_cat_idx = $i;
                        }

                        if ( strlen($link) > 0 )
                        {
                          amule_do_ed2k_download_cmd($link, $target_cat_idx);
                        }
                }
                foreach($cats as $c)
                {
                  echo  '<option>', $c, '</option>';
                }
              ?>
            </select>
          </form>
        </td>
      </tr>
    </table>
  </body>
</html>
