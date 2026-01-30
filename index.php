<?php
// index.php
?>
<?php require("nav.php"); ?>
<!doctype html>
<html lang="et">
<head>
  <meta charset="utf-8">
  <title>Kodu – Koidulauliku E-laulik</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css" />
</head>

<body>

<main class="container home-page">
  <div class="home-grid">

    <section class="home-card" id="home-intro" aria-label="Tervitus ja eesmärk">
      <h2 class="home-title">Tere tulemast!</h2>
      <p class="home-text">
        <b>Koidulauliku E-laulik</b> on lihtne ja kiire veebirakendus, mis aitab “Koidulauliku vaimul”
        tutvuda Eesti nüüdisaegse kultuuriga ühest kohast — ilma, et peaks minema paljudele eri lehtedele.
      </p>
    </section>

    <aside class="home-card" id="home-start" aria-label="Alusta siit">
      <h2 class="home-title">Alusta siit</h2>
      <ul class="checklist">
        <li><a href="/uudised/index.php"><b>Uudised</b></a> – kiire ülevaade, mis toimub.</li>
        <li><a href="/sundmused/sundmused.php"><b>Sündmused</b></a> – vaata, mis on tulemas ja kuhu minna.</li>
        <li><a href="/index/public/index.php"><b>Galerii</b></a> – pildid sinu projekti galerii vaatest.</li>
        <li><a href="/asi_mangud/index.php"><b>Mängud</b></a> – lihtne vahepala sinu mängude vaatest.</li>
      </ul>

      <p class="home-note">
        Soovitus: alusta “Sündmused” vaatest, kui tahad kiiresti leida, kuhu minna.
      </p>
    </aside>
<section class="home-card" id="home-museums">
  <h2 class="home-title">Avasta Eesti muuseumid</h2>

  <p class="home-text">
    Parim viis Eestit tundma õppida on külastada muuseume, kus on koos ajalugu,
    rahvakultuur ja kaasaegsed näitused.
  </p>

  <a href="/muuseumid.php" class="home-btn">
    Vaata muuseume →
  </a>
</section>
  <img class = "card-img"src="https://visitestonia.com/content-images/653136/muuseumid-en-001-visit-estonia.jpg" alt="Testpilt 6">


<section class="home-card" id="home-museums">
  <h2 class="home-title">Eesti rahvustoidud!</h2>

  <p class="home-text">
   Oleme välja valinud 7 parimat kohta Eestis, kus saad hea hinnaga tutvuda Eesti köögiga.
  </p>
  <a href="/soo.php" class="home-btn">
    Vaata  rahvustoidud→
  </a>
</section>

  <img class = "card-img"src="https://visitestonia.com/images/701064/restoran-maikrahv-016-visit-estonia.png" alt="Testpilt 6">



  </div>
</main>
<?php require("footer.php"); ?>

</body>
</html>
