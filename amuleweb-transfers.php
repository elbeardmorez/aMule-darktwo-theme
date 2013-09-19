<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <title>aMule Download Page</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8">
    <link rel="stylesheet" type="text/css" href="amuleweb.css" />
    <?php
      if ( $_SESSION["auto_refresh"] > 0 ) {
        echo "<meta http-equiv=\"refresh\" content=\"", $_SESSION["auto_refresh"], '">';
      }
    ?>
    <script language="JavaScript" type="text/JavaScript">
    function formCommandSubmit(command)
    {
      if ( command == "cancel" )
      {
        var res = confirm("Delete selected files ?")
        if ( res == false )
        {
          return;
        }
      }

      if ( command != "filter" )
      {
        <?php
          if ($_SESSION["guest_login"] != 0)
          {
            echo 'alert("You logged in as guest - commands are disabled");';
            echo "return;";
          }
        ?>
      }
      var frm=document.forms.mainform
      frm.command.value=command
      frm.submit()
    }

    function checkAll()
    {
      for (var i=0;i<document.forms[0].elements.length;i++)
      {
        var e = document.forms[0].elements[i];
        if ((e.name != 'allbox') && (e.type=='checkbox'))
        {
          e.checked=document.forms[0].allbox.checked;
        }
      }
    }

    function timestampToLocale(timeStamp)
    {
      var theDate = new Date(timeStamp * 1000);
      var dateString = theDate.toLocaleString();
      return dateString;
    }

    function changeText()
    {
      var all = document.getElementsByTagName('span');
      //alert (all.length);
      for (var i=0;i<all.length;i++)
      {
        var time = all[i].firstChild.nodeValue;
        if ( time == 0 )
        {
          //alert("Never seen complete yet!" + time);
          document.getElementsByTagName('span')[i].innerHTML = 'Never seen complete yet!';
        } else
        {
          //alert("Last seen complete : " + time) ;
          document.getElementsByTagName('span')[i].innerHTML = timestampToLocale(time);
        }
      }
    }

    </script>
  </head>

  <body onLoad="changeText()">
    <br>
    <form action="amuleweb-transfers.php" method="post" name="mainform">
      <table border="0" cellpadding="1" cellspacing="1" align="center">
        <tr>
          <td width="35" align="center"><acronym title="Resume download"><a href="javascript:formCommandSubmit('resume');" target="mainFrame"><img src="actionbutton-play.png" alt="resume" name="resume" border="0"></a></acronym></td>
          <td width="35" align="center"><acronym title="Pause download"><a href="javascript:formCommandSubmit('pause');" target="mainFrame"><img src="actionbutton-pause.png" alt="pause" name="pause" border="0"></a></acronym></td>
          <td width="35" align="center"><acronym title="Increase priority"><a href="javascript:formCommandSubmit('prioup');" target="mainFrame"><img src="actionbutton-up.png" alt="up" name="up" border="0"></a></acronym></td>
          <td width="35" align="center"><acronym title="Decrease priority"><a href="javascript:formCommandSubmit('priodown');" target="mainFrame"><img src="actionbutton-down.png" alt="down" name="down" border="0"></a></acronym></td>
          <td width="35" align="center"><acronym title="Cancel download"><a href="javascript:formCommandSubmit('cancel');" target="mainFrame"><img src="actionbutton-close.png" alt="delete" name="delete" border="0"></a></acronym></td>
          <td width="250" align="center">
            <?php
              $all_status = array("all", "Waiting", "Paused", "Downloading");

              if ( $HTTP_GET_VARS["command"] == "filter")
              {
                $_SESSION["filter_status"] = $HTTP_GET_VARS["status"];
                $_SESSION["filter_cat"] = $HTTP_GET_VARS["category"];
              }

              if ( $_SESSION["filter_status"] == '') $_SESSION["filter_status"] = 'all';
              if ( $_SESSION["filter_cat"] == '') $_SESSION["filter_cat"] = 'all';

              echo '<select name="status">';
              foreach ($all_status as $s)
              {
                echo (($s == $_SESSION["filter_status"]) ? '<option selected>' : '<option>'), $s, '</option>';
              }
              echo '</select>';

              echo '<select name="category" id="category">';
              $cats = amule_get_categories();
              foreach($cats as $c)
              {
                echo (($c == $_SESSION["filter_cat"]) ? '<option selected>' : '<option>'), $c, '</option>';
              }
              echo '</select>';
            ?>
          </td>
          </td>
          <td width="35" align="center"><acronym title="Filter download">
            <a href="javascript:formCommandSubmit('filter');" target="mainFrame"><img src="actionbutton-filter.png" alt="apply" name="apply" border="0"></acronym></a>
          </td>
          <td>
            <input type="hidden" name="command">
            <?php
              if ($_SESSION["guest_login"] != 0)
              {
                echo '&nbsp;&nbsp;&nbsp;<p class="error"><b>You logged in as guest - commands are disabled</b></p>';
              }
            ?>
          </td>
        </tr>
      </table>
      <br>
      <table width="95%" border="0" align="center" cellspacing="0" cellpadding="0">
        <tr>
          <td height="30" colspan="3"><b>&nbsp;&nbsp;&nbsp;:: Download
          <?php
             $downloads = amule_load_vars("downloads");
             echo '&nbsp;(', count($downloads), ')';
           ?> ::</b></td>
        </tr>
        <tr>
          <td class="tab_top_left">&nbsp;</td>
          <td class="tab_top_middle">&nbsp;</td>
          <td class="tab_top_right">&nbsp;</td>
        </tr>
        <tr>
          <td class="tab_left">&nbsp;</td>
          <td>
            <table border="0" cellpadding="0" cellspacing="0" align="center" rules="rows" width="100%">
              <tr>
                <td height="30"><input type="checkbox" value="on" name="allbox" onclick="checkAll();"/></td>
                <td height="30" nowrap align="left"><a href="amuleweb-transfers.php?sort_download=filename" target="mainFrame">Filename</a></td>
                <td height="30" nowrap align="center"><a href="amuleweb-transfers.php?sort_download=progress">Progress</a></td>
                <td height="30" nowrap align="center"><a href="amuleweb-transfers.php?sort_download=size" target="mainFrame">Size</a></td>
                <td height="30" nowrap align="center"><a href="amuleweb-transfers.php?sort_download=size_done" target="mainFrame">Completed</a></td>
                <td height="30" nowrap align="center"><a href="amuleweb-transfers.php?sort_download=srccount" target="mainFrame">Sources</a></td>
                <td height="30" nowrap align="center"><a href="amuleweb-transfers.php?sort_download=status" target="mainFrame">Status</a></td>
                <td height="30" nowrap align="center"><a href="amuleweb-transfers.php?sort_download=speed" target="mainFrame">Speed</a></td>
                <td height="30" nowrap align="center"><a href="amuleweb-transfers.php?sort_download=prio" target="mainFrame">Priority</a></td>
                <td height="30" nowrap align="center"><b>Last Seen Complete</b></td>
              </tr>
              <?php
                function CastToXBytes($size)
                {
                  if ( $size < 1024 )
                  {
                    $result = $size . " bytes";
                  } elseif ( $size < 1048576 )
                  {
                    $result = ($size / 1024.0) . "KB";
                  } elseif ( $size < 1073741824 )
                  {
                    $result = ($size / 1048576.0) . "MB";
                  } else
                  {
                    $result = ($size / 1073741824.0) . "GB";
                  }
                    return $result;
                }

                function StatusString($file)
                {
                  if ($file->status == 7)
                  {
                    return "Paused";
                  } elseif ( $file->src_count_xfer > 0 )
                  {
                    return "Downloading";
                  } else
                  {
                    return "Waiting";
                  }
                }

                function PrioString($file)
                {
                  $prionames = array(0 => "Low", 1 => "Normal", 2 => "High", 3 => "Very high", 4 => "Very low", 5=> "Auto", 6 => "Powershare");
                  $result = $prionames[$file->prio];
                  if ($file->prio_auto == 1)
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

                  if ( $sort_order == "filename" )
                  {
                    $result = $a->filename > $b->filename;
                  } elseif ( $sort_order == "progress" )
                  {
                    $result = (((float)$a->size_done)/((float)$a->size)) > (((float)$b->size_done)/((float)$b->size));
                  } elseif ( $sort_order == "size" )
                  {
                    $result = $a->size > $b->size;
                  } elseif ( $sort_order == "size_done" )
                  {
                    $result = $a->size_done > $b->size_done;
                  } elseif ( $sort_order == "scrcount" )
                  {
                    $result = $a->src_count > $b->src_count;
                  } elseif ( $sort_order == "status" )
                  {
                    $result = StatusString($a) > StatusString($b);
                  } elseif ( $sort_order == "speed" )
                  {
                    $result = $a->speed > $b->speed;
                  } elseif ( $sort_order == "prio" )
                  {
                    $result = $result = PrioString($a) > PrioString($b);
                  }


                  if ( $sort_reverse )
                  {
                    $result = !$result;
                  }

                  return $result;
                }

                //
                // perform command before processing content
                //
                if (($HTTP_GET_VARS["command"] != "") && ($_SESSION["guest_login"] == 0))
                {
                  foreach ($HTTP_GET_VARS as $name => $val)
                  {
                    // this is file checkboxes
                    if ((strlen($name) == 32) and ($val == "on"))
                    {
                    //var_dump($name);
                      amule_do_download_cmd($name, $HTTP_GET_VARS["command"]);
                    }
                  }

                  //
                  // check "filter-by-status" settings
                  //
                  if ($HTTP_GET_VARS["command"] == "filter")
                  {
                    //var_dump($_SESSION);
                    $_SESSION["filter_status"] = $HTTP_GET_VARS["status"];
                    $_SESSION["filter_cat"] = $HTTP_GET_VARS["category"];
                  }
                }

                if ($_SESSION["filter_status"] == "") $_SESSION["filter_status"] = "all";
                if ($_SESSION["filter_cat"] == "") $_SESSION["filter_cat"] = "all";

                $downloads = amule_load_vars("downloads");

                $sort_order = $HTTP_GET_VARS["sort_download"];

                if ($sort_order == "" )
                {
                  $sort_order = $_SESSION["download_sort"];
                } else
                {
                  if ($_SESSION["download_sort_reverse"] == "")
                  {
                    $_SESSION["download_sort_reverse"] = 0;
                  } else
                  {
                    if ($HTTP_GET_VARS["sort_download"] != '')
                    {
                      $_SESSION["download_sort_reverse"] = !$_SESSION["download_sort_reverse"];
                    }
                  }
                }

                //var_dump($_SESSION);
                $sort_reverse = $_SESSION["download_sort_reverse"];
                if ( $sort_order != "" )
                {
                  $_SESSION["download_sort"] = $sort_order;
                  usort(&$downloads, "my_cmp");
                }

                //
                // Prepare categories index array
                //
                $cats = amule_get_categories();
                foreach($cats as $i => $c)
                {
                  $cat_idx[$c] = $i;
                }

                foreach ($downloads as $file)
                {
                  $filter_status_result = ($_SESSION["filter_status"] == "all") or
                  ($_SESSION["filter_status"] == StatusString($file));

                  $filter_cat_result = ($_SESSION["filter_cat"] == "all") or
                  ($cat_idx[ $_SESSION["filter_cat"] ] == $file->category);

                  if ($filter_status_result and $filter_cat_result)
                  {
                    echo '<tr id="list_view">';
                    echo '<td height="30"><input type="checkbox" name="', $file->hash, '"></td>';
                    echo '<td height="30" nowrap>', $file->short_name, '</td>';
                    echo '<td height="30" align="center">', $file->progress, '</td>';
                    echo '<td height="30" align="center">', CastToXBytes($file->size), '</td>';
                    echo '<td height="30" align="center">', CastToXBytes($file->size_done), '&nbsp;(',((float)$file->size_done*100)/((float)$file->size), '%)</td>';
                    echo '<td height="30" align="center">';
                    if ( $file->src_count_not_curr != 0 )
                    {
                      echo $file->src_count - $file->src_count_not_curr, ' / ';
                    }
                    echo $file->src_count, ' (', $file->src_count_xfer, ')';
                    if ( $file->src_count_a4af != 0 )
                    {
                      echo '+ ', $file->src_count_a4af;
                    }
                    echo '</td>';
                    echo '<td height="30" align="center">', StatusString($file), '</td>';
                    echo '<td height="30" align="center">', ($file->speed > 0) ? (CastToXBytes($file->speed) . '/s') : '-', '</td>';
                    echo '<td height="30" align="center">', PrioString($file), '</td>';
                    echo '<td height="30" align="center"><span>', $file->last_seen_complete, '</span></td>';
                    echo '</tr>';
                  }
                }
          ?>
            </table>
          </td>
          <td class="tab_right">&nbsp;</td>
        </tr>
        <tr>
          <td class="tab_bottom_left">&nbsp;</td>
          <td class="tab_bottom_middle">&nbsp;</td>
          <td class="tab_bottom_right">&nbsp;</td>
        </tr>
      </table>
    </form>
    <br>
    <table width="95%" border="0" align="center" cellspacing="0" cellpadding="0">
      <tr>
        <td height="30" colspan="3"><b>&nbsp;&nbsp;&nbsp;:: Upload
        <?php
           $uploads = amule_load_vars("uploads");
           echo '&nbsp;(', count($uploads), ')';
         ?> ::</b></td>
      </tr>
      <tr>
        <td class="tab_top_left">&nbsp;</td>
        <td class="tab_top_middle">&nbsp;</td>
        <td class="tab_top_right">&nbsp;</td>
      </tr>
      <tr>
        <td class="tab_left">&nbsp;</td>
        <td>
          <table border="0" align="center" cellpadding="0" cellspacing="0" rules="rows" width="100%">
            <tr>
              <td height="30" align="left"><a href="amuleweb-transfers.php?sort_upload=short_name" target="mainFrame">Filename</a></td>
              <td height="30" align="center"><a href="amuleweb-transfers.php?sort_upload=user_name" target="mainFrame">Username</a></td>
              <td height="30" align="center"><a href="amuleweb-transfers.php?sort_upload=xfer_up" target="mainFrame">Transfert Up</a></td>
              <td height="30" align="center"><a href="amuleweb-transfers.php?sort_upload=xfer_down" target="mainFrame">Transfert Down</a></td>
              <td height="30" align="center"><a href="amuleweb-transfers.php?sort_upload=xfer_speed" target="mainFrame">Speed</a></td>
            </tr>
            <?php
              function CastToXBytes($size)
              {
                if ( $size < 1024 )
                {
                  $result = $size . " bytes";
                } elseif ( $size < 1048576 )
                {
                  $result = ($size / 1024.0) . "KB";
                } elseif ( $size < 1073741824 )
                {
                  $result = ($size / 1048576.0) . "MB";
                } else
                {
                  $result = ($size / 1073741824.0) . "GB";
                }
                return $result;
              }

              //
              // declare it here, before any function reffered it in "global"
              //
              $sort_order;$sort_reverse;

              function my_cmp($a, $b)
              {
                global $sort_order, $sort_reverse;

                if ( $sort_order == "short_name" )
                {
                  $result = $a->short_name > $b->short_name;
                } elseif ( $sort_order == "user_name" )
                {
                  $result = $a->user_name > $b->user_name;
                } elseif ( $sort_order == "xfer_up" )
                {
                  $result = $a->xfer_up > $b->xfer_up;
                } elseif ( $sort_order == "xfer_down" )
                {
                  $result = $a->xfer_down > $b->xfer_down;
                } elseif ( $sort_order == "xfer_speed" )
                {
                  $result = $a->xfer_speed > $b->xfer_speed;
                }

                if ( $sort_reverse )
                {
                  $result = !$result;
                }

                return $result;
              }

              $uploads = amule_load_vars("uploads");

              $sort_order = $HTTP_GET_VARS["sort_upload"];

              if ( $sort_order == "" )
              {
                $sort_order = $_SESSION["upload_sort"];
              } else
              {
                if ( $_SESSION["upload_sort_reverse"] == "" )
                {
                  $_SESSION["upload_sort_reverse"] = 0;
                } else
                {
                  if ( $HTTP_GET_VARS["sort_upload"] != '')
                  {
                    $_SESSION["upload_sort_reverse"] = !$_SESSION["upload_sort_reverse"];
                  }
                }
              }

              //var_dump($_SESSION);
              $sort_reverse = $_SESSION["upload_sort_reverse"];
              if ( $sort_order != "" )
              {
                $_SESSION["upload_sort"] = $sort_order;
                usort(&$uploads, "my_cmp");
              }

              foreach ($uploads as $file)
              {
                echo '<tr id="list_view">';
                echo '<td height="30" nowrap align="left">', $file->short_name, '</td>';
                echo '<td height="30" nowrap align="center">', $file->user_name, '</td>';
                echo '<td height="30" nowrap align="center">', CastToXBytes($file->xfer_up), '</td>';
                echo '<td height="30" nowrap align="center">', CastToXBytes($file->xfer_down), '</td>';
                echo '<td height="30" nowrap align="center">', ($file->xfer_speed > 0) ? (CastToXBytes($file->xfer_speed) . '/s') : '-', '</td>';
                echo '</tr>';
              }
            ?>
          </table>
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
