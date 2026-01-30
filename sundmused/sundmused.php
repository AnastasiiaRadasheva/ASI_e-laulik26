
<!DOCTYPE html>
<html lang="et">
<head>
<meta charset="UTF-8">
<title>Sündmused</title>
  <link rel="stylesheet" href="../style.css" />
</head>
<body>
<?php
require("../nav.php");
?>

<h1>Sündmused</h1>

<h2>Siin saad valida, millisele üritusele või kontserdile minna, ning näha, millal ja kus see toimub!</h2>

<?php
require_once __DIR__ . '/funktsioonid.php';
sundmused(
    'https://rss.app/feeds/WUq5V2J0HhXFVRm6.xml',
    9
);
sundmused(
    'https://rss.app/feeds/BeAdQRVL29RIrGYe.xml',
    9
);
?>

<?php
require("../footer.php");
?>

</body>
</html>
