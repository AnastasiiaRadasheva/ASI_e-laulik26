<?php
require_once __DIR__ . '/../includes/funktsioonid.php';
?>
<!DOCTYPE html>
<html lang="et">
<head>
  <meta charset="UTF-8">
  <title>Galerii</title>
  <link rel="stylesheet" href="../../style.css" />
</head>
<body>

<?php require("../../nav.php"); ?>

<h1>Galerii</h1>
<h2>Siin saad vaadata fotosid hiljutistest kultuuriüritustest ning teada saada, mis üritus toimus ja kuidas see kulges!</h2>

<?php
sundmused('http://uudised.err.ee/uudised_rss.php', 9);
sundmused(  'https://kultuur.postimees.ee/rss', 9);
sundmused(  'https://rss.app/feeds/Xq0rwTTaKXmzwIUH.xml', 9);
sundmused(  'https://rss.app/feeds/OpPzQeIKvmg0ATpi.xml', 9);
?>
<?php require("../../footer.php"); ?>



</body>
</html>
