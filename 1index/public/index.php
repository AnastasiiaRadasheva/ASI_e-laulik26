<?php
// public/index.php

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/helpers.php';
require_once __DIR__ . '/../includes/rss.php';

$cards = load_culture_estonia_cards(
  $FEEDS,
  $CULTURE_KEYWORDS,
  $ESTONIA_KEYWORDS,
  $CACHE_DIR,
  $CACHE_FILE,
  $CACHE_TTL_SECONDS,
  $MAX_ITEMS
);
?>
<?php require("../../nav.php"); ?>

<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../../style.css" />
  <title>Galerii</title>
</head>

<body>
<h1> Galerii</h1>
<h2> 
Siin saad vaadata fotosid hiljutistest kultuuriüritustest ning teada saada, mis üritus toimus ja kuidas see kulges!</h2>
<div class="wrap gallery-page">
  <?php if (empty($cards)): ?>
    <div class="gallery-empty">
       uus
    </div>
  <?php else: ?>
    <div class="gallery-grid">
      <?php foreach ($cards as $item): ?>
        <a class="gallery-card" href="<?= safe($item['link']) ?>" target="_blank" rel="noopener">
          <?php if (!empty($item['img'])): ?>
            <div class="gallery-media">
              <img class="gallery-thumb" src="<?= safe($item['img']) ?>" alt="<?= safe($item['title']) ?>" loading="lazy">
            </div>
          <?php else: ?>
            <div class="gallery-media gallery-media--placeholder">
              <span>Ei ole pildi</span>
            </div>
          <?php endif; ?>

          <div class="gallery-body">
            <div class="gallery-title"><?= safe($item['title']) ?></div>
            <div class="gallery-cta">Ava</div>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

</div>

  <?php require("../../footer.php"); ?>
</body>
</html>
