<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <title>aMule Preferences Page</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8">
    <link rel="stylesheet" type="text/css" href="amuleweb.css" />

    <script language="JavaScript" type="text/JavaScript">
    function formCommandSubmit(command)
    {
      var frm=document.forms.mainform
      frm.command.value=command
      frm.submit()
    }

    var initvals = new Object;

    <?php
      // apply new options before proceeding
      //var_dump($HTTP_GET_VARS);
      if ( ($HTTP_GET_VARS["Submit"] == "Apply") && ($_SESSION["guest_login"] == 0) )
      {
        $file_opts = array("check_free_space", "extract_metadata",
          "ich_en","aich_trust", "preview_prio","save_sources", "resume_same_cat",
          "min_free_space", "new_files_paused", "alloc_full", "upload_full_chunks",
          "new_files_auto_dl_prio", "new_files_auto_ul_prio", "start_next_paused", "first_last_chunks_prio"
        );

        $conn_opts = array("max_line_up_cap","max_up_limit",
          "max_line_down_cap","max_down_limit", "slot_alloc",
          "tcp_port","udp_port","udp_dis","max_file_src","max_conn_total","autoconn_en","reconn_en"
        );

        $webserver_opts = array("use_gzip", "autorefresh_time");

        $all_opts;

        foreach ($conn_opts as $i)
        {
          $curr_value = $HTTP_GET_VARS[$i];
          if ( $curr_value == "on") $curr_value = 1;
          if ( $curr_value == "") $curr_value = 0;
          $all_opts["connection"][$i] = $curr_value;
        }

        foreach ($file_opts as $i)
        {
          $curr_value = $HTTP_GET_VARS[$i];
          if ( $curr_value == "on") $curr_value = 1;
          if ( $curr_value == "") $curr_value = 0;
          $all_opts["files"][$i] = $curr_value;
        }

        foreach ($webserver_opts as $i)
        {
          $curr_value = $HTTP_GET_VARS[$i];
          if ( $curr_value == "on") $curr_value = 1;
          if ( $curr_value == "") $curr_value = 0;
          $all_opts["webserver"][$i] = $curr_value;
        }

        //var_dump($all_opts);
        amule_set_options($all_opts);
      }

      $opts = amule_get_options();
      //var_dump($opts);
      $opt_groups = array("connection", "files", "webserver");
      //var_dump($opt_groups);
      foreach ($opt_groups as $group)
      {
        $curr_opts = $opts[$group];
        //var_dump($curr_opts);
        foreach ($curr_opts as $opt_name => $opt_val)
        {
          echo 'initvals["', $opt_name, '"] = "', $opt_val, '";';
        }
      }
    ?>

    <!-- Assign php generated data to controls -->
    function init_data()
    {
      var frm = document.forms.mainform

      var str_param_names = new Array(
        "max_line_down_cap", "max_line_up_cap",
        "max_up_limit", "max_down_limit", "max_file_src",
        "slot_alloc", "max_conn_total",
        "tcp_port", "udp_port",
        "min_free_space",
        "autorefresh_time"
        )

      for(i = 0; i < str_param_names.length; i++)
      {
        frm[str_param_names[i]].value = initvals[str_param_names[i]];
      }

      var check_param_names = new Array(
        "autoconn_en", "reconn_en", "udp_dis", "new_files_paused",
        "aich_trust", "alloc_full", "upload_full_chunks",
        "check_free_space", "extract_metadata", "ich_en",
        "new_files_auto_dl_prio", "new_files_auto_ul_prio",
        "use_gzip", "preview_prio", "save_sources", "resume_same_cat", "start_next_paused", "first_last_chunks_prio"
        )

      for(i = 0; i < check_param_names.length; i++)
      {
        frm[check_param_names[i]].checked = initvals[check_param_names[i]] == "1" ? true : false;
      }
    }
    </script>
  </head>

  <body onload="init_data();">
  <br>
  <table border="0" align="center" cellspacing="0" cellpadding="0">
    <tr>
      <td height="30" colspan="3"><b>&nbsp;&nbsp;&nbsp;:: preferences ::</b>
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
        <form name="mainform" action="amuleweb-prefs.php" method="post">
          <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
            <tr>
              <td>
                <table width="100%">
                  <tr>
                    <td colspan="3"><b>webserver</b></td>
                  </tr>
                  <tr>
                    <td width="40%">Page refresh interval</td>
                    <td width="10%"><input name="autorefresh_time" type="text" class="form_text" id="autorefresh_time" size="4"></td>
                    <td width="50%">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="3"><input name="use_gzip" type="checkbox" id="use_gzip">Use gzip compression</td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
              <td>
                <table width="100%">
                  <tr>
                    <td colspan="4"><b>line capacity (for statistics only)</b></td>
                  </tr>
                  <tr>
                    <td width="40%">Max download rate</td>
                    <td width="10%"><input name="max_line_down_cap" type="text" class="form_text" id="max_line_down_cap" size="4"></td>
                    <td width="40%">Max upload rate</td>
                    <td width="10%"><input name="max_line_up_cap" type="text" class="form_text" id="max_line_up_cap" size="4"></td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
              <td>
                <table width="100%">
                  <tr>
                    <td colspan="4"><b>bandwidth limits</b></td>
                  </tr>
                  <tr>
                    <td width="40%">Max download rate</td>
                    <td width="10%"><input name="max_down_limit" type="text" class="form_text" id="max_down_limit" size="4"></td>
                    <td width="40%">Max upload rate</td>
                    <td width="10%"><input name="max_up_limit" type="text" class="form_text" id="max_up_limit" size="4"></td>
                  </tr>
                  <tr>
                    <td width="50%" colspan="2">&nbsp;</td>
                    <td width="40%">Slot allocation</td>
                    <td width="10%"><input name="slot_alloc" type="text" class="form_text" id="slot_alloc" size="4"></td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
              <td>
                <table width="100%">
                  <tr>
                    <td colspan="4"><b>connection settings</b></td>
                  </tr>
                  <tr>
                    <td width="40%">Max total connections (total)</td>
                    <td width="10%"><input name="max_conn_total" type="text" class="form_text" id="max_conn_total" size="4"></td>
                    <td width="40%">Max sources per file</td>
                    <td width="10%"><input name="max_file_src" type="text" class="form_text" id="max_file_src" size="4"></td>
                  </tr>
                  <tr>
                    <td colspan="4"><input name="autoconn_en" type="checkbox" id="autoconn_en">Autoconnect at startup</td>
                  </tr>
                  <tr>
                    <td colspan="4"><input name="reconn_en" type="checkbox" id="reconn_en">Reconnect when connection lost</td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
              <td>
                <table width="100%">
                  <tr>
                    <td colspan="4"><b>network settings</b></td>
                  </tr>
                  <tr>
                    <td width="40%">TCP port</td>
                    <td width="10%"><input name="tcp_port" type="text" class="form_text" id="tcp_port" size="5"></td>
                    <td width="40%">UDP port</td>
                    <td width="10%"><input name="udp_port" type="text" class="form_text" id="udp_port" size="5"></td>
                  </tr>
                  <tr>
                    <td colspan="4"><input name="udp_dis" type="checkbox" id="udp_dis">Disab:le UDP connections</td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
              <td>
                <table width="100%">
                  <tr>
                    <td colspan="3"><b>file settings</b></td>
                  </tr>
                  <tr>
                    <td width="50%"><input name="check_free_space" type="checkbox" id="check_free_space">Check free space</td>
                    <td width="40%">Minimum free space (Mb)</td>
                    <td width="10%"><input name="min_free_space" type="text" class="form_text" id="min_free_space" size="4"></td>
                  </tr>
                  <tr>
                    <td colspan="3"><input name="new_files_auto_dl_prio" type="checkbox" id="new_files_auto_dl_prio">Added download files have auto priority</td>
                  </tr>
                  <tr>
                    <td colspan="3"><input name="new_files_auto_ul_prio" type="checkbox" id="new_files_auto_ul_prio">New shared files have auto priority</td>
                  </tr>
                  <tr>
                    <td colspan="3"><input name="ich_en" type="checkbox" id="ich_en">I.C.H. active</td>
                  </tr>
                  <tr>
                    <td colspan="3"><input name="aich_trust" type="checkbox" id="aich_trust">AICH trusts every hash (not recommended)</td>
                  </tr>
                  <tr>
                    <td colspan="3"><input name="upload_full_chunks" type="checkbox" id="upload_full_chunks">Upload full chunks of .part files</td>
                  </tr>
                  <tr>
                    <td colspan="3"><input name="alloc_full" type="checkbox" id="alloc_full">Allocate full disk space for .part files</td>
                  </tr>
                  <tr>
                    <td colspan="3"><input name="new_files_paused" type="checkbox" id="new_files_paused">Add files to download queue in pause mode</td>
                  </tr>
                  <tr>
                    <td colspan="3"><input name="extract_metadata" type="checkbox" id="extract_metadata">Extract metadata tags</td>
                  </tr>
                  <tr>
                    <td colspan="3"><input name="preview_prio" type="checkbox" id="preview_prio">Priority for preview</td>
                  </tr>
                  <tr>
                    <td colspan="3"><input name="save_sources" type="checkbox" id="save_sources">Save 10 sources for rare files (<20 sources)</td>
                  </tr>
                  <tr>
                    <td colspan="3"><input name="resume_same_cat" type="checkbox" id="resume_same_cat">Resume from same category</td>
                  </tr>
                  <tr>
                    <td colspan="3"><input name="start_next_paused" type="checkbox" id="start_next_paused">Start the next paused download</td>
                  </tr>
                  <tr>
                    <td colspan="3"><input name="first_last_chunks_prio" type="checkbox" id="first_last_chunks_prio">Download first and last chunks in priority</td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
              <td align="center">
                <?php
                  if ($_SESSION["guest_login"] == 0)
                  {
                    echo '<input type="submit" class="form_button" name="Submit" value="apply">';
                    echo '<input name="command" type="hidden" id="command">';
                  }
                ?>
              </td>
            </tr>
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
