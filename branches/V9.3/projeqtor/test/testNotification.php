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

/* ============================================================================
 * Test for Web Notification on system
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" 
  "http://www.w3.org/TR/html4/strict.dtd">
<html style="margin: 0px; padding: 0px;">
<head>
<script type="text/javascript">
var cpt=0;
function notifyMe() {
  // Vérifions si le navigateur prend en charge les notifications
  if (!('Notification' in window)) {
    alert('Ce navigateur ne prend pas en charge la notification de bureau')
  }

  // Vérifions si les autorisations de notification ont déjà été accordées
  else if (Notification.permission === 'granted') {
    // Si tout va bien, créons une notification
    cpt++;
    var type="Alert";
    var type="Warning";
    var type="Information";
    var title="Ticket #4 - test";
    var body="   indicator : respect of planned due date/time";
    body+="\n"+"   target value : 18/03/2021";
    body+="\n"+"   actual value : 18/03/2021 10:00:00";
    body+="\n"+"   warning threshold : 17/03/2021 23:00";
    body+="\n"+"   5th line not displayed";
    var notification = new Notification(title, 
        {body: body,
         icon: "../view/css/images/icon"+type+".png",
         image: "../view/img/title.png",
         tag: "Alert#"+cpt
        });
    notification.requireInteraction=true; // Will not auto close (does not work on FF)
    notification.onclose=function(event) {console.log(event.currentTarget.tag)}; // Most call function to mzark as read
    notification.onclick=function(event) {event.currentTarget.close();}; // Will close on click 
  }

  // Sinon, nous devons demander la permission à l'utilisateur
  else if (Notification.permission !== 'denied') {
    Notification.requestPermission().then((permission) => {
      // Si l'utilisateur accepte, créons une notification
      if (permission === 'granted') {
        const notification = new Notification('Salut toi!')
      }
    })
  }

  // Enfin, si l'utilisateur a refusé les notifications, et que vous
  // voulez être respectueux, il n'est plus nécessaire de les déranger.
}

</script>

</head>

<body class="" style="" >
<button onclick="setTimeout('notifyMe();',5);">Notifie moi !</button>
</body>


