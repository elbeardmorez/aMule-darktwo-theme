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
  <table border="0" align="center" cellspacing="0" cellpadding="0">
    <tr>
      <td height="30" colspan="3"><b>&nbsp;&nbsp;&nbsp;:: Server List ::</b>
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
      <td colspan="2" class="tab_top_middle">&nbsp;</td>
      <td class="tab_top_right">&nbsp;</td>
    </tr>
    <tr>
      <td class="tab_left">&nbsp;</td>
      <td>
        <form action="amuleweb-servers.php" method="GET">
          <table border="0" cellpadding="4" cellspacing="0" class="dotted_table">
            <tr>
              <td  colspan="2" align="left" valign="middle"><img src="add_server.png"> <b>Add new ed2k server</b></td>
            </tr>
            <tr>
              <td height="30" valign="middle" align="left">Name: </td>
              <td height="30" align="left"><input name="name" type="text" size="50"></td>
            </tr>
            <tr>
              <td height="30" valign="middle" align="left">IP address: </td>
              <td height="30" align="left"><input name="ip" type="text" size="15" maxlength="15"> : <input name="port" type="text" size="5" maxlength="5"></td>
            </tr>
            <tr>
              <td height="30" colspan="2" valign="middle" align="right">
                <?php
                  if ($_SESSION["guest_login"] == 0)
                  {
                    echo '<input type="submit" value="Add to list" onclick="refresh()">&nbsp;';
                    echo '<input type="submit" value="Refresh list" onclick="refresh()">';
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
          <table border="0" cellpadding="4" cellspacing="0" class="dotted_table">
            <tr>
              <td colspan="2" align="left" valign="middle"><img src="add_server.png"> <b>Bootstrap Kad from node</b></td>
            </tr>
            <tr><td height="30" colspan="2">&nbsp;</td></tr>
            <tr>
              <td height="30" valign="middle" align="left">IP address: </td>
              <td height="30" align="left"><input name="ip" type="text" size="15" maxlength="15"> : <input name="port" type="text" size="5" maxlength="5"></td>
            </tr>
            <tr>
              <td height="30" colspan="2" valign="middle" align="right">
                <?php
                  if ($_SESSION["guest_login"] == 0)
                  {
                    echo '<input type="submit" value="Bootstrap"><input name="cmd" type="hidden" value="bootstrap">';
                  }
                ?>
              </td>
            </tr>
          </table>
        </form>
      </td>
      <td class="tab_right">&nbsp;</td>
    </tr>
    <tr height="10px">
      <td class="tab_left">&nbsp;</td>
      <td colspan="2" align="center">&nbsp;</td>
      <td class="tab_right">&nbsp;</td>
    </tr>
    <tr>
      <td class="tab_left">&nbsp;</td>
      <td colspan="2" align="center">
        <table border="0" cellpadding="0" cellspacing="0" rules="rows">
          <tr>
            <td height="30" align="left"><a href="amuleweb-servers.php?sort=name" target="mainFrame">Name</a></td>
            <td height="30" align="left"><a href="amuleweb-servers.php?sort=desc" target="mainFrame">Description</a></td>
            <td height="30" align="center">Address</td>
            <td height="30" align="center"><a href="amuleweb-servers.php?sort=users" target="mainFrame">Users</a></td>
            <td height="30" align="center"><a href="amuleweb-servers.php?sort=max_users" target="mainFrame">Max Users</a></td>
            <td height="30" align="center"><a href="amuleweb-servers.php?sort=files" target="mainFrame">Files</a></td>
            <?php
              if ($_SESSION["guest_login"] == 0)
              {
                echo '<td height="30" align="center"><b>Actions</b></td>';
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
                    '<img src="l_disconnect.png" border="0" alt="cancel">','</a></acronym>',
                    '<acronym title="Remove server from list">',
                    "<a href=\"amuleweb-servers.php?cmd=remove&amp;ip=", $srv->ip,"&amp;port=", $srv->port, "\" target=\"mainFrame\"
                    onclick=\"return confirm('Are you sure to remove this server from list?');\">",
                    '<img src="l_remove.png" border="0" alt="cancel">','</a></acronym>',
                    '</td>';
                } else
                {
                  echo '<td  align="center" nowrap><acronym title="Connect to server">',
                    '<a href="amuleweb-servers.php?cmd=connect&amp;ip=', $srv->ip,'&amp;port=', $srv->port, '" target="mainFrame" >',
                    '<img src="l_connect.png" border="0" alt="connect">','</a></acronym>',
                    '<acronym title="Remove server from list">',
                    "<a href=\"amuleweb-servers.php?cmd=remove&amp;ip=", $srv->ip,"&amp;port=", $srv->port, "\" target=\"mainFrame\"
                    onclick=\"return confirm('Are you sure to remove this server from list?');\">",
                    '<img src="l_remove.png" border="0" alt="cancel">','</a></acronym>',
                    '</td>';
                }
              }
              echo '</tr>';
            }
            ?>
        </table>
      </td>
      <td class="tab_right">&nbsp;</td>
    </tr>
    <tr>
      <td class="tab_bottom_left">&nbsp;</td>
      <td colspan="2" class="tab_bottom_middle">&nbsp;</td>
      <td class="tab_bottom_right">&nbsp;</td>
    </tr>
  </table>
  </body>
</html>


