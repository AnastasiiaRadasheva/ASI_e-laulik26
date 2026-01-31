<?php require("nav.php"); ?>
<!doctype html>
<html lang="et">
<head>
  <meta charset="utf-8">
  <title>Muuseumid – Koidulauliku E-laulik</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css" />
</head>

<body>

<main class="container museums-page" id="museums-page">

  <header class="museums-hero" id="museums-hero">
    <div class="museums-hero__card">
      <h1 class="museums-hero__title">10 muuseumi, mis aitavad Eestit päriselt mõista</h1>
      <p class="museums-hero__text">
        Need muuseumid annavad lühikese, aga tugeva pildi Eesti loost, kultuurist ja identiteedist.
        Igal kaardil on ka oma väike kaart — nii näed kohe, kus muuseum asub.
      </p>

    </div>
  </header>

  <?php
  $museums = [
    [
      "name" => "Eesti Rahva Muuseum (ERM)",
      "place" => "Tartu",
      "url" => "https://www.erm.ee/",
      "img" => "https://commons.wikimedia.org/wiki/Special:FilePath/Eesti%20Rahva%20Muuseum.jpg",
      "tag" => "Identiteet • igapäevaelu • rahvakultuur",
      "why" => "ERM aitab mõista, kuidas eesti kultuur ja “meie-lugu” on kujunenud. Kaasaegne ja väga arusaadav näitus.",
      "map_embed" => "https://www.google.com/maps?q=Eesti%20Rahva%20Muuseum&output=embed",
      "map_link"  => "https://www.google.com/maps?q=Eesti%20Rahva%20Muuseum"
    ],
    [
      "name" => "Eesti Vabaõhumuuseum",
      "place" => "Tallinn (Rocca al Mare)",
      "url" => "https://evm.ee/",
      "img" => "https://commons.wikimedia.org/wiki/Special:FilePath/Eesti%20Vaba%C3%B5humuuseum%202313.jpg",
      "tag" => "Talud • külaelu • arhitektuur",
      "why" => "“Päris küla” — talud, kirik, kool ja kõrts. Väga hea, kui tahad Eesti ajalugu kogeda läbi ruumi.",
      "map_embed" => "https://www.google.com/maps?q=Eesti%20Vaba%C3%B5humuuseum&output=embed",
      "map_link"  => "https://www.google.com/maps?q=Eesti%20Vaba%C3%B5humuuseum"
    ],
    [
      "name" => "Kumu kunstimuuseum",
      "place" => "Tallinn (Kadriorg)",
      "url" => "https://kumu.ekm.ee/",
      "img" => "https://kunstimuuseum.ekm.ee/wp-content/uploads/2019/12/Kumu_MT_Tere-Kumu_s%C3%BCndmus_gal4-Foto-Kaido-Haagen_p%C3%A4is-scaled.jpg",
      "tag" => "Eesti kunst • 18. sajand → tänapäev",
      "why" => "Kui tahad “tunda ajastut”, on Kumu ideaalne. Kunst näitab muutusi ühiskonnas ja identiteedis eriti hästi.",
      "map_embed" => "https://www.google.com/maps?q=Kumu%20kunstimuuseum&output=embed",
      "map_link"  => "https://www.google.com/maps?q=Kumu%20kunstimuuseum"
    ],
    [
      "name" => "Eesti Meremuuseum – Lennusadam",
      "place" => "Tallinn",
      "url" => "https://meremuuseum.ee/lennusadam/",
      "img" => "https://commons.wikimedia.org/wiki/Special:FilePath/Stout%20Margaret%20Tower%20-%20Tallinn,%20Estonia%20(22238882884).jpg",
      "tag" => "Meri • tehnika • elamus",
      "why" => "Elamuslik muuseum, mis näitab, miks meri on Eestile oluline: kaitse, kaubandus ja mereline mõtteviis.",
      "map_embed" => "https://www.google.com/maps?q=Lennusadam%20Tallinn&output=embed",
      "map_link"  => "https://www.google.com/maps?q=Lennusadam%20Tallinn"
    ],
    [
      "name" => "Vabamu – Okupatsioonide ja vabaduse muuseum",
      "place" => "Tallinn",
      "url" => "https://vabamu.ee/",
      "img" => "https://lh3.googleusercontent.com/p/AF1QipM_jFvQKTmMCibn4Qmuq2D4lXXvSQ4HJa8_Wq9K=s1360-w1360-h1020-rw",
      "tag" => "Lähiajalugu • isiklikud lood • vabadus",
      "why" => "Parim koht, et kiiresti mõista Eesti 20. sajandi keerulisi aegu ja vabaduse tähendust inimlugude kaudu.",
      "map_embed" => "https://www.google.com/maps?q=Vabamu&output=embed",
      "map_link"  => "https://www.google.com/maps?q=Vabamu"
    ],
    [
      "name" => "Eesti Ajaloomuuseum – Suurgildi hoone",
      "place" => "Tallinn (Vanalinn)",
      "url" => "https://ajaloomuuseum.ee/",
      "img" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRA9WB4bc4PB4BS6gB6AoZVzCwpYFBOGEl4PQ&s",
      "tag" => "11 000 aastat • Eesti lugu • teemaruumid",
      "why" => "Väga hea “põhi”, kui tahad tervikpilti: suured ajastud ja teemaruumid annavad selge raamistiku.",
      "map_embed" => "https://www.google.com/maps?q=Eesti%20Ajaloomuuseum%20Suurgildi%20hoone&output=embed",
      "map_link"  => "https://www.google.com/maps?q=Eesti%20Ajaloomuuseum%20Suurgildi%20hoone"
    ],
    [
      "name" => "Narva Muuseum – Hermanni linnus",
      "place" => "Narva",
      "url" => "https://www.narvamuuseum.ee/",
      "img" => "https://triptoestonia.ee/wp-content/uploads/narvalinnus-2.jpg",
      "tag" => "700+ aastat • piir • kindlus",
      "why" => "Piirilugu ja kindlus teevad võimude vaheldumise arusaadavaks. Väga eriline koht Eesti ajaloo mõistmiseks.",
      "map_embed" => "https://www.google.com/maps?q=Narva%20Muuseum%20Hermanni%20linnus&output=embed",
      "map_link"  => "https://www.google.com/maps?q=Narva%20Muuseum%20Hermanni%20linnus"
    ],
    [
      "name" => "Tartu Linnamuuseum",
      "place" => "Tartu",
      "url" => "https://muuseum.tartu.ee/tartu-linnamuuseum/",
      "img" => "https://lh3.googleusercontent.com/p/AF1QipOcDedv7z6s_QxaA84UK8EOJB9GvcedaZYmc-Xt=s1360-w1360-h1020-rw",
      "tag" => "Linnalugu • Emajõgi • “Meie Tartu”",
      "why" => "Tartu on Eesti kultuuri- ja haridusloo keskpunkt. Linnamuuseum on kiire viis Tartust aru saada.",
      "map_embed" => "https://www.google.com/maps?q=Tartu%20Linnamuuseum&output=embed",
      "map_link"  => "https://www.google.com/maps?q=Tartu%20Linnamuuseum"
    ],
    [
      "name" => "Viljandi Muuseum",
      "place" => "Viljandi",
      "url" => "https://muuseum.viljandimaa.ee/",
      "img" => "https://lh3.googleusercontent.com/p/AF1QipNgka7fvD_1xJibkZ-8M0z4-wJXvMs6dkr2QxNb=s1360-w1360-h1020-rw",
      "tag" => "Viljandimaa • arheoloogia • rahvakultuur",
      "why" => "Hea näide “Eestist väljaspool pealinna”: piirkondlik lugu annab sügavama arusaama pärandist.",
      "map_embed" => "https://www.google.com/maps?q=Viljandi%20Muuseum&output=embed",
      "map_link"  => "https://www.google.com/maps?q=Viljandi%20Muuseum"
    ],
    [
      "name" => "Eesti Teatri- ja Muusikamuuseum",
      "place" => "Tallinn",
      "url" => "https://www.tmm.ee/",
      "img" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRFwiNTIptuAg4nvLj3G6egx8ecXUpwRueFwA&s",
      "tag" => "Teater • muusika • lood",
      "why" => "Koorilaul, heliloojad ja teater on Eesti kultuuri “tuum”. See muuseum aitab seda kiiresti mõista.",
      "map_embed" => "https://www.google.com/maps?q=Eesti%20Teatri-%20ja%20Muusikamuuseum&output=embed",
      "map_link"  => "https://www.google.com/maps?q=Eesti%20Teatri-%20ja%20Muusikamuuseum"
    ],
  ];
  ?>

  <section class="museums-grid" id="museums-grid" aria-label="Muuseumide valik">
    <?php foreach ($museums as $m): ?>
      <article class="museum-card">
        <div class="museum-card__media">
          <img
            src="<?= htmlspecialchars($m["img"]) ?>"
            alt="<?= htmlspecialchars($m["name"]) ?>"
            loading="lazy"
            onerror="this.onerror=null; this.src='https://via.placeholder.com/900x500?text=Muuseum';"
          >
          <div class="museum-card__chip"><?= htmlspecialchars($m["place"]) ?></div>
        </div>

        <div class="museum-card__body">
          <h2 class="museum-card__title"><?= htmlspecialchars($m["name"]) ?></h2>
          <div class="museum-card__tag"><?= htmlspecialchars($m["tag"]) ?></div>
          <p class="museum-card__text"><?= htmlspecialchars($m["why"]) ?></p>

          <div class="museum-card__map">
            <iframe
              class="museum-card__iframe"
              src="<?= htmlspecialchars($m["map_embed"]) ?>"
              title="Kaart: <?= htmlspecialchars($m["name"]) ?>"
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"
              allowfullscreen>
            </iframe>
          </div>

          <div class="museum-card__actions">
            <a class="museum-btn" href="<?= htmlspecialchars($m["url"]) ?>" target="_blank" rel="noopener">
              Ametlik leht →
            </a>
            <a class="museum-btn ghost" href="<?= htmlspecialchars($m["map_link"]) ?>" target="_blank" rel="noopener">
              Ava Google Mapsis
            </a>
          </div>
        </div>
      </article>
    <?php endforeach; ?>
  </section>

</main>

<br><br><br><br><br><br><br>
<?php require("footer.php"); ?>
</body>
</html>
