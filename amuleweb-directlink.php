<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <title>aMule Direct Link</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8">
    <link rel="stylesheet" type="text/css" href="amuleweb.css">
    <script language="JavaScript" type="text/JavaScript">
      function refresh()
      {
        parent.mainFrame.document.location = "amuleweb-transfers.php";
      }
    </script>
  </head>
  <body background="main_topbar.png">
  <form name="formlink" method="get" action="amuleweb-directlink.php">
    <table width="" height=85 border="0" cellpadding="0" cellspacing="0" align="right">
      <tr valign="middle">
        <td width="120" align="right"><input type="submit" class="form_button" name="Submit" value="download link" onclick="refresh()"></td>
        <td align="center"><input name="ed2klink" type="text" class="form_text" id="ed2klink" size="60"></td>
        <td width="50" align="left">
          <select name="selectcat" id="selectcat" class="form_text">
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
