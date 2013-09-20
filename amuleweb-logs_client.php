<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <title>aMule client logs</title>
    <meta http-equiv="content-type" content="text/html; charset=utf8">
    <link rel="stylesheet" type="text/css" href="amuleweb.css" />
  </head>
  <body class="layoutcolours">
    <table border=0 width="100%" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="left">
          <font face="Lucida Console">
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
  </body>
</html>
