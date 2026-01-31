<?php require("nav.php"); ?>
<!doctype html>
<html lang="et">
<head>
  <meta charset="utf-8">
  <title>Eesti rahvustoit – Koidulauliku E-laulik</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css" />
</head>

<body>

<main class="container museums-page">

<header class="museums-hero">
  <div class="museums-hero__card">
    <h1 class="museums-hero__title">Kus maitsta päris Eesti toitu?</h1>
    <p class="museums-hero__text">
      Eesti köök on lihtne, looduslähedane ja hooajaline — rukkileib, kala, metsamarjad,
      kartul, hapukapsas ja kodused road. Need kohad annavad kõige parema pildi Eesti maitsest.
    </p>
    <p class="museums-hero__hint">
      Igal kaardil on oma asukoht — saad kohe vaadata, kus restoran asub.
    </p>
  </div>
</header>

<?php
$foods = [
  [
    "name" => "Farm Restaurant",
    "place" => "Tallinn (Vanalinn)",
    "url" => "https://farmrestoran.ee/",
    "img" => "https://res.cloudinary.com/vabalaud/image/upload/c_fill,dpr_3.0,f_auto,g_auto,h_225,q_auto,w_400/c_fill,h_225,w_400/9Y9A7202_ffk7j1?pgw=1",
    "tag" => "Moodne Eesti köök • kohalik tooraine",
    "why" => "Farm ühendab traditsioonilise Eesti köögi ja kaasaegse serveerimise. Väga hea koht, et näha, kuidas rahvustoit elab tänapäeval.",
    "map_embed" => "https://www.google.com/maps?q=Farm%20Restaurant%20Tallinn&output=embed",
    "map_link" => "https://www.google.com/maps?q=Farm%20Restaurant%20Tallinn"
  ],
  [
    "name" => "Kolu Kõrts (Vabaõhumuuseum)",
    "place" => "Tallinn",
    "url" => "https://evm.ee/kuluaarid-ja-soogikohad/kolu-korts",
    "img" => "https://media.voog.com/0000/0048/7241/photos/EVM_Kolu_k%C3%B5rtsituba.jpeg",
    "tag" => "Talutoad • päris rahvustoit",
    "why" => "Siin saab maitsta klassikalisi Eesti roogasid: mulgipuder, hernesupp, kama. Atmosfäär on nagu vanas talukõrtsis.",
    "map_embed" => "https://www.google.com/maps?q=Kolu%20K%C3%B5rts&output=embed",
    "map_link" => "https://www.google.com/maps?q=Kolu%20K%C3%B5rts"
  ],
  [
    "name" => "Leib Resto & Aed",
    "place" => "Tallinn (Vanalinn)",
    "url" => "https://leibresto.ee/",
    "img" => "https://www.leibresto.ee/wp-content/uploads/2014/10/Garden-2.jpg",
    "tag" => "Rukkileib • hooajaline menüü",
    "why" => "Leib keskendub kohalikule toorainele ja traditsioonilistele maitsetele. Väga populaarne eestlaste seas.",
    "map_embed" => "https://www.google.com/maps?q=Leib%20Resto%20Tallinn&output=embed",
    "map_link" => "https://www.google.com/maps?q=Leib%20Resto%20Tallinn"
  ],
  [
    "name" => "Hõlm",
    "place" => "Tartu",
    "url" => "https://holm.ee/",
    "img" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQxpSC03hQviOAr9uMvxlmGCNT4F6iTKlzDUA&s",
    "tag" => "Fine dining • Eesti maitsed",
    "why" => "Hõlm näitab, kuidas Eesti köök võib olla kõrgel tasemel fine dining stiilis, säilitades rahvuslikud maitsed.",
    "map_embed" => "https://www.google.com/maps?q=Restaurant%20H%C3%B5lm%20Tartu&output=embed",
    "map_link" => "https://www.google.com/maps?q=Restaurant%20H%C3%B5lm%20Tartu"
  ],
  [
    "name" => "Vehverments Bar & Tostadas (rahvuslikud joogid ja snäkid)",
    "place" => "Tallinn",
    "url" => "https://www.facebook.com/vehverments/",
    "img" => "https://lh3.googleusercontent.com/gps-cs-s/AHVAweou6-leGe6I0G0qHWSLIU7s3BsL48ocxoXd3rxRM8NDYLxUlQSkhRn4Ljb8srQiOZWtwr9WCnzzyDjbG6n9wlGiSLpK1qRwLk5ncPLSQcQGGZDSQ5oeahnqSaQe4kEEdhSGWWpR=s1360-w1360-h1020-rw",
    "tag" => "Käsitööjoogid • Eesti maitsed",
    "why" => "Hea koht tutvuda Eesti käsitööjookide ja kohalike maitsetega kaasaegses vormis.",
    "map_embed" => "https://www.google.com/maps?q=Vehverments%20Tallinn&output=embed",
    "map_link" => "https://www.google.com/maps?q=Vehverments%20Tallinn"
  ],
  [
    "name" => "Maikrahv",
    "place" => "Tallinn (Raekoja plats)",
    "url" => "https://maikrahv.ee/",
    "img" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTaYNwoe6wxOGhr0ZrYaF1BzZ0TrPKavQhXEQ&s",
    "tag" => "Keskaegne köök • Eesti ajalugu",
    "why" => "Võimalus kogeda vana Tallinna ja ajaloolisi maitseid samas kohas.",
    "map_embed" => "https://www.google.com/maps?q=Maikrahv%20Tallinn&output=embed",
    "map_link" => "https://www.google.com/maps?q=Maikrahv%20Tallinn"
  ],
  [
    "name" => "Werner Café",
    "place" => "Tartu",
    "url" => "https://werner.ee/",
    "img" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTLfqyFw2X9PmZ6UFriQqxQWTlY3Vid6hmCGg&s",
    "tag" => "Kohvikukultuur • Eesti magustoidud",
    "why" => "Legendaarne Tartu kohvik. Eesti kohvikukultuuri sümbol.",
    "map_embed" => "https://www.google.com/maps?q=Werner%20Cafe%20Tartu&output=embed",
    "map_link" => "https://www.google.com/maps?q=Werner%20Cafe%20Tartu"
  ]
];
?>

<section class="museums-grid">

<?php foreach ($foods as $f): ?>
<article class="museum-card">

  <div class="museum-card__media">
    <img src="<?= htmlspecialchars($f["img"]) ?>" alt="<?= htmlspecialchars($f["name"]) ?>" loading="lazy">
    <div class="museum-card__chip"><?= htmlspecialchars($f["place"]) ?></div>
  </div>

  <div class="museum-card__body">

    <h2 class="museum-card__title"><?= htmlspecialchars($f["name"]) ?></h2>
    <div class="museum-card__tag"><?= htmlspecialchars($f["tag"]) ?></div>
    <p class="museum-card__text"><?= htmlspecialchars($f["why"]) ?></p>

    <div class="museum-card__map">
      <iframe
        class="museum-card__iframe"
        src="<?= htmlspecialchars($f["map_embed"]) ?>"
        loading="lazy"
        allowfullscreen>
      </iframe>
    </div>

    <div class="museum-card__actions">
      <a class="museum-btn" href="<?= htmlspecialchars($f["url"]) ?>" target="_blank">
        Ametlik leht →
      </a>
      <a class="museum-btn ghost" href="<?= htmlspecialchars($f["map_link"]) ?>" target="_blank">
        Ava Google Mapsis
      </a>
    </div>

  </div>
</article>
<?php endforeach; ?>

</section>

</main>

<?php require("footer.php"); ?>
</body>
</html>
