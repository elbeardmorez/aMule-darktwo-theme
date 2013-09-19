<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <title>aMule Shared Files Page</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8">
    <link rel="stylesheet" type="text/css" href="amuleweb.css" />
    <script language="JavaScript" type="text/JavaScript">
      function formCommandSubmit(command)
      {
        <?php
          if ($_SESSION["guest_login"] != 0)
          {
            echo 'alert("You logged in as guest - commands are disabled");';
            echo "return;";
          }
        ?>
        var frm=document.forms.mainform
        frm.command.value=command
        frm.submit()
      }

      function checkAll()
      {
        for (var i=0;i<document.forms[0].elements.length;i++)
        {
          var e=document.forms[0].elements[i];
          if ((e.name != 'allbox') && (e.type=='checkbox'))
          {
            e.checked=document.forms[0].allbox.checked;
          }
        }
      }
    </script>
  </head>
  <body>
  <br>
  <table width="75%" border="0" align="center" cellspacing="0" cellpadding="0" >
    <tr>
      <td height="30" colspan="3"><b>&nbsp;&nbsp;&nbsp;:: shared files ::</b>
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
      <td class="tab_top_middle">&nbsp;</td>
      <td class="tab_top_right">&nbsp;</td>
    </tr>
    <tr class="tab_colour">
      <td class="tab_left">&nbsp;</td>
      <td>
        <form name="mainform" action="amuleweb-shared.php" method="post">
          <table align="center" border="0" cellpadding="0" cellspacing="0" >
            <tr>
              <td width="35" align="center"><acronym title="Reload shared files">
                <a href="javascript:formCommandSubmit('reload');" target="mainFrame"><img src="actionbutton-refresh.png" name="reload" alt="Reload" border="0"></a></acronym>
              </td>
              <td width="35" align="center"><acronym title="Increase priority">
                <a href="javascript:formCommandSubmit('prioup');" target="mainFrame"><img src="actionbutton-up.png" name="up" alt="Prio Up" border="0"></a></acronym>
              </td>
              <td width="35" align="center"><acronym title="Decrease priority">
                <a href="javascript:formCommandSubmit('priodown');" target="mainFrame"><img src="actionbutton-down.png" name="down" alt="Prio Down" border="0"></a></acronym>
              </td>
              <td>
                <input type="hidden" name="command">&nbsp;
              </td>
            </tr>
          </table>
          <br>
          <table width="100%" border="0" cellpadding="0" cellspacing="0" rules="rows" align="center">
            <tr>
              <td height="30"><input type="checkbox" value="on" name="allbox" onclick="checkAll();"/></td>
              <td height="30" nowrap align="left"><a href="amuleweb-shared.php?sort=name" target="mainFrame">Filename</a></td>
              <td height="30" nowrap align="center"><a href="amuleweb-shared.php?sort=xfer" target="mainFrame">Transfer</a> (<a href="amuleweb-shared.php?sort=xfer_all" target="mainFrame">Total</a>)</td>
              <td height="30" nowrap align="center"><a href="amuleweb-shared.php?sort=req" target="mainFrame">Requests</a> (<a href="amuleweb-shared.php?sort=req_all" target="mainFrame">Total</a>)</td>
              <td height="30" nowrap align="center"><a href="amuleweb-shared.php?sort=acc" target="mainFrame">Accepted</a> (<a href="amuleweb-shared.php?sort=acc_all" target="mainFrame">Total</a>)</td>
              <td height="30" nowrap align="center"><a href="amuleweb-shared.php?sort=size" target="mainFrame">Size</a></td>
              <td height="30" nowrap align="center"><a href="amuleweb-shared.php?sort=prio" target="mainFrame">Priority</a></td>
              <td height="30" nowrap align="center"><b>Actions</b></td>
            </tr>
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

              function PrioString($file)
              {
                $prionames = array(0 => "Low", 1 => "Normal", 2 => "High", 3 => "Very high", 4 => "Very low", 5=> "Auto", 6 => "Powershare");
                $result = $prionames[$file->prio];
                if ( $file->prio_auto == 1)
                {
                  $result = $result . "(auto)";
                }
                return $result;
              }

              //
              // declare it here, before any function reffered it in "global"
              //
              $sort_order;
              $sort_reverse;

              function my_cmp($a, $b)
              {
                global $sort_order, $sort_reverse;

                switch ($sort_order)
                {
                  case "size": $result = $a->size > $b->size; break;
                  case "name": $result = $a->name > $b->name; break;
                  case "xfer": $result = $a->xfer > $b->xfer; break;
                  case "xfer_all": $result = $a->xfer_all > $b->xfer_all; break;
                  case "acc": $result = $a->accept > $b->accept; break;
                  case "acc_all": $result = $a->acc_all > $b->acc_all; break;
                  case "req": $result = $a->req > $b->req; break;
                  case "req_all": $result = $a->req_all > $b->req_all; break;
                  case "prio": $result = PrioString($a) > PrioString($b); break;
                }

                if ( $sort_reverse )
                {
                  $result = !$result;
                }
                //var_dump($sort_reverse);
                return $result;
              }

              //              // perform command before processing content
              //
              if (($HTTP_GET_VARS["command"] != "") && ($_SESSION["guest_login"] == 0))
              {
                if ($HTTP_GET_VARS["command"] == "reload")
                {
                  amule_do_reload_shared_cmd();
                }
                else
                {
                  amule_do_shared_cmd($HTTP_GET_VARS["file"], $HTTP_GET_VARS["command"]);
                }

                foreach ($HTTP_GET_VARS as $name => $val)
                {
                  // this is file checkboxes
                  if ( (strlen($name) == 32) and ($val == "on") )
                  {
                    amule_do_shared_cmd($name, $HTTP_GET_VARS["command"]);
                  }
                }
              }

              $shared = amule_load_vars("shared");

              $sort_order = $HTTP_GET_VARS["sort"];

              if ( $sort_order == "" )
              {
                $sort_order = $_SESSION["shared_sort"];
              } else
              {
                if ( $_SESSION["sort_reverse"] == "" )
                {
                  $_SESSION["sort_reverse"] = 0;
                } else
                {
                  $_SESSION["sort_reverse"] = !$_SESSION["sort_reverse"];
                }
              }
              //var_dump($_SESSION);
              $sort_reverse = $_SESSION["sort_reverse"];
              if ( $sort_order != "" )
              {
                $_SESSION["shared_sort"] = $sort_order;
                usort(&$shared, "my_cmp");
              }

              foreach ($shared as $file)
              {
                echo '<tr id="list_view">';
                echo '<td height="30" align="center"><input type="checkbox" name="', $file->hash, '" ></td>';
                echo '<td height="30" nowrap>', $file->short_name, '</td>';
                echo '<td height="30" align="center">', CastToXBytes($file->xfer), ' / (', CastToXBytes($file->xfer_all) ,')</td>';
                echo '<td height="30" align="center">', $file->req, ' / (', $file->req_all ,')</td>';
                echo '<td height="30" align="center">', $file->accept, ' / (', $file->accept_all ,')</td>';
                echo '<td height="30" align="center">', CastToXBytes($file->size), '</td>';
                echo '<td height="30" align="center">', PrioString($file), '</td>';
                echo "<td height=\"30\" align=\"center\"><acronym title=\"ED2K Link\"><img src=\"l_ed2klink.png\" border=\"0\" alt=\"ED2K Link\" onclick=\"alert('", $file->link, "');\"></acronym>";
                if ($_SESSION["guest_login"] == 0)
                {
                  echo "<acronym title=\"Increase Priority\"><a href=\"amuleweb-shared.php?command=prioup&file=", $file->hash, "\"><img src=\"l_up.png\" border=\"0\" alt=\"Increase Priority\"></a></acronym><acronym title=\"Decrease Priority\"><a href=\"amuleweb-shared.php?command=priodown&file=", $file->hash, "\"><img src=\"l_down.png\" border=\"0\" alt=\"Decrease Priority\"></a></acronym></td>";
                } else
                {
                  echo "</td>";
                }

                echo '</tr>';
              }
            ?>
        </table>
        </form>
      </td>
      <td class="tab_right">&nbsp;</td>
    </tr>
    <tr>
      <td class="tab_bottom_left">&nbsp;</td>
      <td class="tab_bottom_middle">&nbsp;</td>
      <td class="tab_bottom_right">&nbsp;</td>
    </tr>
  </table>
  </body>
</html>
