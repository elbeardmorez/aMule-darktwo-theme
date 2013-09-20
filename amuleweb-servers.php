<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <title>aMule Server Page</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8">
    <link rel="stylesheet" type="text/css" href="amuleweb.css" />
    <script language="JavaScript" type="text/JavaScript">
      function refresh()
      {
        parent.mainFrame.document.location = "amuleweb-servers.php";
      }
    </script>
  </head>
  <body>
  <br>
  <table style="margin: auto;">
    <tr>
      <td colspan="3"><p class="p-heading">:: server list ::</p>
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
      <td colspan="2" class="tableborder tableborder-top-middle"></td>
      <td class="tableborder tableborder-top-right"></td>
    </tr>
    <tr class="layoutcolours">
      <td class="tableborder tableborder-left"></td>
      <td>
        <form action="amuleweb-servers.php" method="GET">
          <table border="0" cellpadding="4" cellspacing="0">
            <tr>
              <td colspan="2" style="text-align: left; vertical-align: middle;"><img src="add_server.png" style="float: left; margin-right: 5px;" ><p style="font-weight: bold">add new ed2k server</p></td>
            </tr>
            <tr>
              <td height="15" valign="middle" align="left">name: </td>
              <td height="15" align="left"><input name="name" type="text" class="form_text" size="50"></td>
            </tr>
            <tr>
              <td height="15" valign="middle" align="left">ip address: </td>
              <td height="15" align="left"><input name="ip" type="text" class="form_text" size="15" maxlength="15"> : <input name="port" type="text" class="form_text" size="5" maxlength="5"></td>
            </tr>
            <tr>
              <td height="15" colspan="2" valign="middle" align="right">
                <?php
                  if ($_SESSION["guest_login"] == 0)
                  {
                    echo '<input type="submit" class="form_button" value="add to list" onclick="refresh()">&nbsp;';
                    echo '<input type="submit" class="form_button" value="refresh list" onclick="refresh()">';
                    echo '<input name="cmd" type="hidden" value="add">';
                  }
                ?>
              </td>
            </tr>
          </table>
        </form>
      </td>
      <td align="right">
        <form action="amuleweb-servers.php" method="GET">
          <table>
            <tr>
              <td colspan="2" style="text-align: left; vertical-align: middle;"><img src="add_server.png" style="float: left; margin-right: 5px;" ><p style="font-weight: bold;">bootstrap Kad from node</p></td>
            </tr>
            <tr><td height="20" colspan="2">&nbsp;</td></tr>
            <tr>
              <td height="20" valign="middle" align="left">ip address: </td>
              <td height="20" align="left"><input name="ip" type="text" class="form_text" size="15" maxlength="15"> : <input name="port" type="text" class="form_text" size="5" maxlength="5"></td>
            </tr>
            <tr>
              <td height="20" colspan="2" valign="middle" align="right">
                <?php
                  if ($_SESSION["guest_login"] == 0)
                  {
                    echo '<input type="submit" class="form_button" value="bootstrap"><input name="cmd" type="hidden" value="bootstrap">';
                  }
                ?>
              </td>
            </tr>
          </table>
        </form>
      </td>
      <td class="tableborder tableborder-right"></td>
    </tr>
    <tr height="10px" class="layoutcolours">
      <td class="tableborder tableborder-left"></td>
      <td colspan="2" align="center">&nbsp;</td>
      <td class="tableborder tableborder-right"></td>
    </tr>
    <tr class="layoutcolours">
      <td class="tableborder tableborder-left"></td>
      <td colspan="2" align="center">
        <table class="tablelayout table-row-border">
          <tr>
            <td height="30" align="left"><a href="amuleweb-servers.php?sort=name" target="mainFrame">name</a></td>
            <td height="30" align="left"><a href="amuleweb-servers.php?sort=desc" target="mainFrame">description</a></td>
            <td height="30" align="center">address</td>
            <td height="30" align="center"><a href="amuleweb-servers.php?sort=users" target="mainFrame">users</a></td>
            <td height="30" align="center"><a href="amuleweb-servers.php?sort=max_users" target="mainFrame">max users</a></td>
            <td height="30" align="center"><a href="amuleweb-servers.php?sort=files" target="mainFrame">files</a></td>
            <?php
              if ($_SESSION["guest_login"] == 0)
              {
                echo '<td height="30" align="center"><b>actions</b></td>';
              }
            ?>
          </tr>
          <?php
            //
            // declare it here, before any function reffered it in "global"
            //
            $sort_order;$sort_reverse;

            function my_cmp($a, $b)
            {
              global $sort_order, $sort_reverse;

              if ( $sort_order == "name" )
              {
                $result = $a->name > $b->name;
              } elseif ( $sort_order == "desc" )
              {
                $result = $a->desc > $b->desc;
              } elseif ( $sort_order == "users" )
              {
                $result = $a->users > $b->users;
              } elseif ( $sort_order == "max_users" )
              {
                $result = $a->maxusers > $b->maxusers;
              } elseif ( $sort_order == "files" )
              {
                $result = $a->files > $b->files;
              }

              if ( $sort_reverse )
              {
                $result = !$result;
              }
              return $result;
            }

            $servers = amule_load_vars("servers");

            $sort_order = $HTTP_GET_VARS["sort"];

            //
            // perform command before processing content
            //
            if (($HTTP_GET_VARS["cmd"] != "") and ($HTTP_GET_VARS["ip"] != "") and ($HTTP_GET_VARS["port"] != ""))
            {
              if ($_SESSION["guest_login"] == 0)
              {
                amule_do_server_cmd($HTTP_GET_VARS["ip"], $HTTP_GET_VARS["port"], $HTTP_GET_VARS["cmd"]);
              }
            }

            if (($HTTP_GET_VARS["cmd"] == "add") and ($HTTP_GET_VARS["ip"] != "") and ($HTTP_GET_VARS["port"] != "") and ($HTTP_GET_VARS["name"] != ""))
            {
              if ($_SESSION["guest_login"] == 0)
              {
                amule_do_add_server_cmd($HTTP_GET_VARS["ip"], $HTTP_GET_VARS["port"], $HTTP_GET_VARS["name"]);
              }
            }

            if (($HTTP_GET_VARS["cmd"] == "bootstrap") and ($HTTP_GET_VARS["ip"] != "") and ($HTTP_GET_VARS["port"] != ""))
            {
              if ($_SESSION["guest_login"] == 0)
              {
                amule_kad_connect($HTTP_GET_VARS["ip"], $HTTP_GET_VARS["port"]);
              }
            }

            if ($sort_order == "" )
            {
              $sort_order = $_SESSION["servers_sort"];
            } else
            {
              if ($_SESSION["sort_reverse"] == "" )
              {
                $_SESSION["sort_reverse"] = 0;
              } else
              {
                $_SESSION["sort_reverse"] = !$_SESSION["sort_reverse"];
              }
            }

            $sort_reverse = $_SESSION["sort_reverse"];
            if ($sort_order != "")
            {
              $_SESSION["servers_sort"] = $sort_order;
              usort(&$servers, "my_cmp");
            }

            $stats = amule_get_stats();
            $connect_to = $stats["serv_name"];

            foreach ($servers as $srv)
            {
              echo '<tr id="list_view">';
              echo '<td height="30" align="left">', $srv->name, '</td>';
              echo '<td height="30" align="left">', $srv->desc, '</td>';
              echo '<td height="30" align="center">', $srv->addr, '</td>';
              echo '<td height="30" align="center">', $srv->users, '</td>';
              echo '<td height="30" align="center">', $srv->maxusers, '</td>';
              echo '<td height="30" align="center">', $srv->files, '</td>';
              if ($_SESSION["guest_login"] == 0)
              {
                if ( $srv->name == $connect_to)
                {
                  echo '<td  align="center" nowrap><acronym title="Disconnect from server">',
                    '<a href="amuleweb-servers.php?cmd=disconnect&amp;ip=', $srv->ip,'&amp;port=', $srv->port, '" target="mainFrame">',
                    '<img src="l_disconnect.png" alt="cancel" style="width: 15px">','</a></acronym>',
                    '<acronym title="Remove server from list">',
                    "<a href=\"amuleweb-servers.php?cmd=remove&amp;ip=", $srv->ip,"&amp;port=", $srv->port, "\" target=\"mainFrame\"
                    onclick=\"return confirm('Are you sure to remove this server from list?');\">",
                    '<img src="l_remove.png" alt="cancel" style="width: 15px">','</a></acronym>',
                    '</td>';
                } else
                {
                  echo '<td  align="center" nowrap><acronym title="Connect to server">',
                    '<a href="amuleweb-servers.php?cmd=connect&amp;ip=', $srv->ip,'&amp;port=', $srv->port, '" target="mainFrame" >',
                    '<img src="l_connect.png" alt="connect" style="width: 15px">','</a></acronym>',
                    '<acronym title="Remove server from list">',
                    "<a href=\"amuleweb-servers.php?cmd=remove&amp;ip=", $srv->ip,"&amp;port=", $srv->port, "\" target=\"mainFrame\"
                    onclick=\"return confirm('Are you sure to remove this server from list?');\">",
                    '<img src="l_remove.png" alt="cancel" style="width: 15px">','</a></acronym>',
                    '</td>';
                }
              }
              echo '</tr>';
            }
            ?>
        </table>
      </td>
      <td class="tableborder tableborder-right"></td>
    </tr>
    <tr>
      <td class="tableborder tableborder-bottom-left"></td>
      <td colspan="2" class="tableborder tableborder-bottom-middle"></td>
      <td class="tableborder tableborder-bottom-right"></td>
    </tr>
  </table>
  </body>
</html>
