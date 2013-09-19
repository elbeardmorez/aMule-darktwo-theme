<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <title>aMule CVS - Web Control Panel</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <script language="JavaScript" type="text/javascript">
      function breakout_of_frame()
      {
        // see http://www.thesitewizard.com/archive/framebreak.shtml
        // for an explanation of this script and how to use it on your
        // own website
        if (top.location != location)
        {
          top.location.href = document.location.href ;
        }
      }
      function login_init()
      {
        breakout_of_frame();
        document.login.pass.focus();
      }
    </script>
    <!--<link rel="stylesheet" type="text/css" href="amuleweb.css">-->
    <style type="text/css">
      html, body{height:100%;}
      body{color:#ffffff; background-color: #000000; margin:0; padding:0; }
      table{width:100%; vertical-align:middle; }
    </style>
  </head>

  <body onload="login_init();" alink="white" link="white" text="white" vlink="white">
    <table style="height:100%">
      <tr><td style="height:135px"></td></tr>
      <tr>
        <td>
          <table border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td style="height:260px" align="center">
                <a href="http://www.amule.org/" target="_blank"><img src="phpamule.png"></a>
              </td>
            </tr>
            <tr valign="bottom">
              <td style="height:30px" align="center">
                <font style="font-size: 10pt;" face="Verdana"><b>Web Control Panel</b><br></font>
              </td>
            </tr>
            <tr valign="top">
              <td style="height:30px" align="center">
                <font style="font-size: 10pt;" face="Verdana">Login</font>
              </td>
            </tr>
            <tr>
              <td style="height:105px" align="center">
                <form action="" method="post" name="login">
                  <font style="font-size: 10pt;" face="Verdana">&nbsp;<br>Enter your password here<br><br></font>
                  <input name="pass" size="37" style="border: 1px none black;" value="" type="password"><br><br>
                  <input value="login now" type="submit" style="background-color:#cccccc; color: black;">
                </form>
                <?php
                  if ($_SESSION["login_error"] != "")
                  {
                    echo "<font color=#000000 size=+2>";
                    echo $_SESSION["login_error"];
                    echo "</font>";
                  }
                ?>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr><td style="height:50px"></td></tr>
    </table>
  </body>
</html>
