<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <title>aMule Search Page</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8">
    <link rel="stylesheet" type="text/css" href="amuleweb.css" />
    <script language="JavaScript" type="text/JavaScript">
      function formCommandSubmit(command)
      {
        <?php
          if ($_SESSION["guest_login"] != 0) {
              echo 'alert("You logged in as guest - commands are disabled");';
              echo 'return;';
          }
        ?>
        var frm=document.forms.mainform
        frm.command.value=command
        frm.submit()
      }
    </script>
  </head>
  <body>
  <br>
  <table border="0" align="center" cellspacing="0" cellpadding="0">
    <tr>
      <td height="30" colspan="3"><b>&nbsp;&nbsp;&nbsp;:: search ::</b>
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
      <td class="tab_left"></td>
      <td>&nbsp;</td>
      <td class="tab_right"></td>
    </tr>
    <tr class="tab_colour">
      <td class="tab_left">&nbsp;</td>
      <td>
        <form name="mainform" action="amuleweb-search.php" method="post">
          <table cellpadding="0" cellspacing="0" align="center">
            <tr valign="middle">
              <td align="center">
                <table cellpadding="5" cellspacing="5">
                  <tr>
                    <td colspan="3">
                      <input name="searchval" id="searchval" type="text" class="form_text" size="70">
                    </td>
                    <td align="center">
                      <input name="search" id="search" type="submit" class="form_button" value="search" onClick="javascript:formCommandSubmit('search');">
                      <input type="hidden" name="command" value="">
                    </td>
                  </tr>
                  <tr>
                    <td align="center">
                      <label>Min size :</label>
                      <input name="minsize" id="minsize" type="text" class="form_text" size="5">
                      <select name="minsizeu" id="minsizeu" class="form_text">
                        <option>Byte</option>
                        <option>KByte</option>
                        <option selected>MByte</option>
                        <option>GByte</option>
                      </select>
                    </td>
                    <td align="center">
                      <label>Availability >=</label>
                      <input name="avail" id="avail" type="text" class="form_text" size="6">
                    </td>
                    <td align="center">
                      <label>File extension :</label>
                      <input name="ext" id="ext" type="text" class="form_text" size="4">
                    </td>
                    <td align="center">
                      <input name="reload" id="reload" type="button" class="form_button" value="reload Search" onClick="self.location.href='amuleweb-search.php'">
                    </td>
                  </tr>
                  <tr>
                    <td align="center">
                      <label>Max size :</label>
                      <input name="maxsize" id="maxsize" type="text" class="form_text" size="5">
                      <select name="maxsizeu" id="maxsizeu" class="form_text">
                        <option>Byte</option>
                        <option>KByte</option>
                        <option selected>MByte</option>
                        <option>GByte</option>
                      </select>
                    </td>
                    <td align="center">
                      <label>Search type :</label>
                      <select name="searchtype" id="searchtype" class="form_text">
                        <option value="2" selected>Kad</option>
                        <option value="1">Global</option>
                        <option value="0">Local</option>
                      </select>
                    </td>
                    <td align="center">
                      <label>File type :</label>
                      <select name="filetype" id="filetype" class="form_text">
                        <option selected></option>
                        <option value="Arc">Archive</option>
                        <option value="Audio">Audio</option>
                        <option value="Doc">Document</option>
                        <option value="Image">Image</option>
                        <option value="Iso">Iso File</option>
                        <option value="Pro">Program</option>
                        <option value="Video">Video</option>
                      </select>
                    </td>
                    <td align="center">
                      <input name="clear" id="clear_fields" type="reset" class="form_button" value="clear search" onClick="javascript:formCommandSubmit('clear');">
                    </td>
                  </tr>
                </table>
              </td>
              <td align="center" width="200">
                <table>
                  <tr>
                    <td>
                      <input name="download" id="download" type="submit" class="form_button" value="download" onClick="javascript:formCommandSubmit('download');">
                    </td>
                    <td align="center">
                      <img src="arrow-r.png" width="42" height="23" alt="arrow-r">
                    </td>
                    <td>
                      <select name="targetcat" id="targetcat" class="form_text">
                        <?php
                          $cats = amule_get_categories();
                          foreach($cats as $c)
                          {
                            echo "<option>", $c, "</option>";
                          }
                        ?>
                      </select>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
          <table align="center" rules="rows" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td height="30" width="20">&nbsp;</td>
              <td height="30"><a href="amuleweb-search.php?sort=name" target="mainFrame">Filename</a></td>
              <td height="30" align="center"><a href="amuleweb-search.php?sort=size" target="mainFrame">Size</a></td>
              <td height="30" align="center"><a href="amuleweb-search.php?sort=sources" target="mainFrame">Sources</a></td>
              <?php
                if ($_SESSION["guest_login"] == 0)
                {
                  echo '<td height="30" align="center"><b>Actions</b></td>';
                }
              ?>
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

              if ( $sort_order == "size" )
              {
                $result = $a->size > $b->size;
              } elseif ( $sort_order == "name" )
              {
                $result = $a->name > $b->name;
              } elseif ( $sort_order == "sources" )
              {
                $result = $a->sources > $b->sources;
              }

              if ( $sort_reverse )
              {
                $result = !$result;
              }

              return $result;
            }

            function str2mult($str)
            {
              if ( $str == "Byte" )
              {
                $result = 1;
              } elseif ( $str == "KByte" )
              {
                $result = 1024;
              } elseif ( $str == "MByte" )
              {
                $result = 1012*1024;
              } elseif ( $tr == "GByte" )
              {
                $result = 1012*1024*1024;
              }

              return $result;
            }

            function cat2idx($cat)
            {
              $cats = amule_get_categories();
              $result = 0;
              foreach($cats as $i => $c)
              {
                if ( $cat == $c) $result = $i;
              }
              return $result;
            }

            if ($_SESSION["guest_login"] == 0)
            {
              if ($HTTP_GET_VARS["command"] == "search")
              {
                $min_size = $HTTP_GET_VARS["minsize"] == "" ? 0 : $HTTP_GET_VARS["minsize"];
                $max_size = $HTTP_GET_VARS["maxsize"] == "" ? 0 : $HTTP_GET_VARS["maxsize"];

                $min_size *= str2mult($HTTP_GET_VARS["minsizeu"]);
                $max_size *= str2mult($HTTP_GET_VARS["maxsizeu"]);

                $ext = $HTTP_GET_VARS["ext"] == "" ? "" : $HTTP_GET_VARS["ext"];
                $filetype = $HTTP_GET_VARS["filetype"] == "" ? "" : $HTTP_GET_VARS["filetype"];

                amule_do_search_start_cmd($HTTP_GET_VARS["searchval"], $ext, $filetype, $HTTP_GET_VARS["searchtype"], $HTTP_GET_VARS["avail"], $min_size, $max_size);

              }
              elseif ($HTTP_GET_VARS["command"] == "download")
              {
                foreach ($HTTP_GET_VARS as $name => $val)
                {
                  // this is file checkboxes
                  if ((strlen($name) == 32) and ($val == "on"))
                  {
                    $cat = $HTTP_GET_VARS["targetcat"];
                    $cat_idx = cat2idx($cat);
                    amule_do_search_download_cmd($name, $cat_idx);
                  }
                }
              }
              elseif ($HTTP_GET_VARS["command"] == "download_single")
              {
                $cat = $HTTP_GET_VARS["targetcat"];
                $cat_idx = cat2idx($cat);
                $name = $HTTP_GET_VARS["name"] ;
                amule_do_search_download_cmd($name, $cat_idx);
              }
              elseif ($HTTP_GET_VARS["command"] == "clear")
              {
                amule_do_search_start_cmd("", "", "", "", "", "", "");
              }
            }

            $search = amule_load_vars("searchresult");

            $sort_order = $HTTP_GET_VARS["sort"];

            if ($sort_order == "")
            {
              $sort_order = $_SESSION["search_sort"];
            } else
            {
              if ($_SESSION["search_sort_reverse"] == "")
              {
                $_SESSION["search_sort_reverse"] = 0;
              } else
              {
                $_SESSION["search_sort_reverse"] = !$_SESSION["search_sort_reverse"];
              }
            }

            $sort_reverse = $_SESSION["search_sort_reverse"];
            if ($sort_order != "")
            {
              $_SESSION["search_sort"] = $sort_order;
              usort(&$search, "my_cmp");
            }

            foreach ($search as $file)
            {
              echo '<tr id="list_view">';
              echo '<td height="30"><input type="checkbox" name="', $file->hash, '"></td>';
              echo '<td height="30">', $file->name, '</td>';
              echo '<td height="30" align="center">', CastToXBytes($file->size), '</td>';
              echo '<td height="30" align="center">', $file->sources, '</td>';
              if ($_SESSION["guest_login"] == 0)
              {
                echo "<td height=\"30\" align=\"center\"><acronym title=\"Download File\"><a href=\"amuleweb-search.php?command=download_single&targetcat=all&name=", $file->hash, "\"><img src=\"l_ed2klink.png\" border=\"0\" alt=\"Download File\"></a></acronym></td>";
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
