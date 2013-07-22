<?php
$handlerUrl = 'http://' . $_SERVER['HTTP_HOST']
    . dirname($_SERVER['REQUEST_URI'])
    . '/?call=%s';
?>
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Telefonwählscheibe registrieren</title>
  <meta http-equiv="pragma" content="no-cache" />
  <meta http-equiv="cache-control" content="no-cache" />
  <style type="text/css">
   body {
       margin: 0px;
       padding: 0px;
   }
   #content {
       margin: 10px;
   }
  </style>
 </head>
 <body>
  <div id="topheader">
   <iframe name="nrnav" id="nrnav" frameborder="0" border="0" height="30px" width="100%"
    scrolling="no" src="https://www.netresearch.de/corpnav-intern/telefon/">
    netresearch navigation
   </iframe>
  </div>
  <div id="content">

   <h1>Telefonwählscheibe registrieren</h1>
   <p>
    Der Browser fragt dich, ob du <tt>tel:</tt>-Links mit der Wählscheibe öffnen willst.
   </p>
   <script type="text/javascript">
    var reg = false;
    if (window.navigator.isProtocolHandlerRegistered) {
        reg = window.navigator.isProtocolHandlerRegistered('tel', <?php echo json_encode($handlerUrl);?>);
    }
    if (!reg) {
        window.navigator.registerProtocolHandler('tel', <?php echo json_encode($handlerUrl);?>, 'Telefonwählscheibe');
    }
   </script>
   <a href="./">zurück</a>
  </div>
 </body>
</html>
