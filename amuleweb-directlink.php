<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <title>aMule Direct Link</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8">
    <link rel="stylesheet" type="text/css" href="amuleweb.css" />
    <script language="JavaScript" type="text/JavaScript">
      function refresh()
      {
        parent.mainFrame.document.location = "amuleweb-transfers.php";
      }
    </script>
  </head>
  <body background="main_topbar.png">
  <br>
  <form name="formlink" method="get" action="amuleweb-directlink.php">
    <table width="" border="0" cellpadding="0" cellspacing="0" align="center">
      <tr valign="middle">
        <td width="130" align="center"><input type="submit" name="Submit" value="Download link" onclick="refresh()"></td>
        <td width="520" align="center"><input name="ed2klink" type="text" id="ed2klink" size="80"></td>
        <td width="50" align="center">
              <select name="selectcat" id="selectcat">
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
        </td>
      </tr>
    </table>
  </form>
  </body>
</html>
