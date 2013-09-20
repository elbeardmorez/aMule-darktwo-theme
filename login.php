<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <title>aMule web service control</title>
    <meta http-equiv="content-type" content="text/html; charset=utf8">
    <link rel="stylesheet" type="text/css" href="amuleweb.css"/>
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
  </head>

  <body onload="login_init();">
    <table class="tablelayout">
      <tr>
        <td style="height: 130px;">
        </td>
      </tr>
      <tr>
        <td>
          <div class="tablelayout" style="width: 100%; height: 100%; margin: auto; vertical-align: middle;">
            <div style="width: 260px; margin: auto; vertical-align: bottom;">
              <a href="http://www.amule.org/" target="_blank"><img src="phpamule.png"></a>
              <table class="tablelayout">
                <tr>
                  <td style="height: 25px; text-align: center; vertical-align: middle;">
                    <p style="font-size: 1.2em; font-weight: bold;">web service control</p>
                  </td>
                </tr>
                <tr>
                  <td style="height: 20px; text-align: center; vertical-align: middle;">
                    <p style="font-size: 1.2em;">enter your password here</p>
                  </td>
                </tr>
                <tr>
                  <td style="height: 50px; text-align: center">
                    <form action="" method="post" name="login">
                      <input name="pass" size="35" style="border-width: 0px;" value="" type="password"><br><br>
                      <input type="submit" class="form_button" value="login">
                    </form>
                  </td>
                </tr>
                <tr>
                  <td style="height: 20px; text-align: center;">
                    <p id="login_error" class="error">
                      <?php
                        if ($_SESSION["login_error"] != "")
                        {
                          echo $_SESSION["login_error"];
                        }
                      ?>
                    </p>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td style="height: 50px; text-align: right;">
        </td>
      </tr>
    </table>
  </body>
</html>
