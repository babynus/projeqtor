<?php 
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2017 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 * Contributors : -
 *
 * This file is part of ProjeQtOr.
 * 
 * ProjeQtOr is free software: you can redistribute it and/or modify it under 
 * the terms of the GNU Affero General Public License as published by the Free 
 * Software Foundation, either version 3 of the License, or (at your option) 
 * any later version.
 * 
 * ProjeQtOr is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for 
 * more details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * ProjeQtOr. If not, see <http://www.gnu.org/licenses/>.
 *
 * You can get complete code of ProjeQtOr, other resource, help and information
 * about contributors at http://www.projeqtor.org 
 *     
 *** DO NOT REMOVE THIS NOTICE ************************************************/

include_once("../tool/projeqtor.php");
include_once '../tool/formatter.php';

//Param
$user=getSessionUser();
?>

<table style="width:99%;" id="userMenuInterrogation">
  <tr style="height:40px">
    <td style="white-space:nowrap;vertical-align:middle;text-align:center;position:relative;"></td>
      <td>
      <div class="pseudoButton"  title="<?php echo i18n('help');?>" onClick="showHelp();">
        <table style="width:100%">
          <tr>
            <td style="width:24px;padding-top:2px;">
              <div class="iconCatalog22">&nbsp;</div>
            </td>
            <td style="vertical-align:middle;">&nbsp;&nbsp;<?php echo i18n('help');?>&nbsp;&nbsp;</td>
          </tr>
        </table>
      </div>
    </td>
  </tr>
  <tr style="height:40px">
    <td style="white-space:nowrap;vertical-align:middle;text-align:center;position:relative;"></td>
    <td>
      <div class="pseudoButton"  title="<?php echo i18n('keyboardShortcuts');?>" onClick="showHelp('ShortCut');">
        <table style="width:100%">
          <tr>
            <td style="width:24px;padding-top:2px;">
              <div class="iconShortCut">&nbsp;</div>
            </td>
            <td style="vertical-align:middle;">&nbsp;&nbsp;<?php echo i18n('keyboardShortcuts');?>&nbsp;&nbsp;</td>
          </tr>
        </table>
      </div>
    </td>
  </tr>
  <tr style="height:40px">
    <td style="white-space:nowrap;vertical-align:middle;text-align:center;position:relative;"></td>
    <td>
      <div class="pseudoButton"  title="<?php echo i18n('aboutMessage');?>" onClick="showAbout(aboutMessage);">
        <table style="width:100%">
          <tr>
            <td style="width:24px;padding-top:2px;">
              <div class="iconInfo22">&nbsp;</div>
            </td>
            <td style="vertical-align:middle;">&nbsp;&nbsp;<?php echo i18n('aboutMessage');?>&nbsp;&nbsp;</td>
          </tr>
        </table>
      </div>
    </td>
  </tr>
</table>