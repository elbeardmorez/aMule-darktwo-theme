<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <title>aMule shared files</title>
    <meta http-equiv="content-type" content="text/html; charset=utf8">
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
    <div style="width: 95%; margin: auto;">
      <table style="width: 100%; margin: auto;">
        <tr>
          <td colspan="3"><p class="p-heading">:: shared files ::</p>
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
          <td class="tableborder tableborder-top-middle"></td>
          <td class="tableborder tableborder-top-right"></td>
        </tr>
        <tr class="layoutcolours">
          <td class="tableborder tableborder-left"></td>
          <td style="width: 100%; margin: auto;">
            <div style="height: 35px; width: 90px; margin: 5px auto 0px auto;">
              <form name="mainform" action="amuleweb-shared.php" method="post">
                <acronym title="Reload shared files">
                  <a href="javascript:formCommandSubmit('reload');" target="mainFrame">
                    <img src="actionbutton-refresh.png" name="reload" alt="Reload" style="float: left;"></a></acronym>
                <acronym title="Increase priority">
                  <a href="javascript:formCommandSubmit('prioup');" target="mainFrame">
                    <img src="actionbutton-up.png" name="up" alt="Prio Up" style="float: left;"></a></acronym>
                <acronym title="Decrease priority">
                  <a href="javascript:formCommandSubmit('priodown');" target="mainFrame">
                    <img src="actionbutton-down.png" name="down" alt="Prio Down" style="float: left;"></a></acronym>
                  <input type="hidden" name="command">&nbsp;
              </form>
            </div>
            <table class="tablelayout table-row-border">
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

                //                // perform command before processing content
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
                  echo '<td style="height: 30px; white-space: normal; text-align: left;">', $file->name, '</td>';
                  echo '<td height="30" align="center">', CastToXBytes($file->xfer), ' / (', CastToXBytes($file->xfer_all) ,')</td>';
                  echo '<td height="30" align="center">', $file->req, ' / (', $file->req_all ,')</td>';
                  echo '<td height="30" align="center">', $file->accept, ' / (', $file->accept_all ,')</td>';
                  echo '<td height="30" align="center">', CastToXBytes($file->size), '</td>';
                  echo '<td height="30" align="center">', PrioString($file), '</td>';
                  echo "<td style=\"width: 55px; min-width: 55px; height: 30px; text-align: center; white-space: nowrap;\"><acronym title=\"ED2K Link\"><img src=\"l_ed2klink.png\" style=\"float: left; border: none;\" alt=\"ED2K Link\" onclick=\"alert('", $file->link, "');\"></acronym>";
                  if ($_SESSION["guest_login"] == 0)
                  {
                    echo "<acronym title=\"Increase Priority\"><a href=\"amuleweb-shared.php?command=prioup&file=", $file->hash, "\"><img src=\"l_up.png\" style=\"float: left; border: none;\" alt=\"Increase Priority\"></a></acronym><acronym title=\"Decrease Priority\"><a href=\"amuleweb-shared.php?command=priodown&file=", $file->hash, "\"><img src=\"l_down.png\" style=\"float: left; border: none;\" alt=\"Decrease Priority\"></a></acronym></td>";
                  } else
                  {
                    echo "</td>";
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
          <td class="tableborder tableborder-bottom-middle"></td>
          <td class="tableborder tableborder-bottom-right"></td>
        </tr>
      </table>
    </div>
  </body>
</html>
