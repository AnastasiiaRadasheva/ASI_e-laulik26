<?php
declare(strict_types=1);
?>
<!doctype html>
<html lang="et">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="../style.css" />
  <link rel="stylesheet" href="style.css" />
  <title>Uudised</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <?php require("../nav.php"); ?>
</head>

<body class="uudised-page">

  <div class="uudised-wrap">

    <div class="uudised-card">
      <div class="kaart-head">
        <div>
          <div style="font-weight:700">Kaart</div>
          <div id="status">Klõpsake maakonnale – paremal avaneb RSS-uudiste loend.</div>
        </div>
        <span class="badge" id="picked">—</span>
      </div>

      <div class="map-holder">
        <canvas id="mapCanvas"></canvas>
      </div>

      <img id="mapImg" src="/uudised/estonia.PNG" alt="map" style="display:none" loading="eager" decoding="async">
    </div>

    <div class="uudised-card">
      <div style="font-weight:700;margin-bottom:10px">Uudised</div>
      <div id="news">Vali maakond kaardil...</div>
    </div>

  </div>

  <?php require("../footer.php"); ?>
  <script src="java.js"></script>
</body>
</html>
