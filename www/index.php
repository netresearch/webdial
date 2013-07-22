<?php
$number = false;
if (isset($_GET['call'])) {
    $number = str_replace(
        'tel:', '',
        filter_var($_GET['call'], FILTER_SANITIZE_STRING)
    );
    //localize
    $number = preg_replace('/^+49/', '00', $number);

    $callUrl = 'http://asterisk.nr/gemeinschaft/srv/pb-dial.php?n=' . $number;
}
?>
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Telefonwählscheibe</title>
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
   <h1>Telefonwählscheibe</h1>
   <ul>
    <li>
     Zuerst musst du die <a href="register.php">Wählscheibe für
     <tt>tel:</tt>-Links registrieren</a>.
    </li>
    <li>
     Dann musst du auf <a href="http://asterisk.nr/">asterisk.nr</a>
     eingeloggt sein.
    </li>
   </ul>


  <?php if ($number): ?>
   <h2>Anrufen...</h2>
   <p>
    Rufe <?php echo htmlspecialchars($number); ?>:
   </p>
   <iframe src="<?php echo htmlspecialchars($callUrl);?>" height="50" width="200">
    Rufe Asterisk auf..
   </iframe>
  <?php endif; ?>

   <h1>Test</h1>
   <p>
    <a href="tel:12345">tel:12345</a>
   </p>

  </div>
 </body>
</html>
