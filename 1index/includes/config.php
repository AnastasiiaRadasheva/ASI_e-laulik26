<?php

$FEEDS = [
  'https://rss.app/feeds/RaM1brTtKZoj6Ua0.xml',
  'https://rss.app/feeds/y82Lw6KhPWMa4CDe.xml',
  'http://uudised.err.ee/uudised_rss.php', // ERR новости
];

$CULTURE_KEYWORDS = [
  'festival','fest','concert','kontsert','näitus','exhibition','muuseum','museum',
  'teater','theatre','theater','ooper','opera','tants','dance','kunst','art',
  'film','kino','esietendus','performance','kultuur','culture','laulupidu',
  'jazz','džäss','мероприят','выставк','концерт','театр'
];

$ESTONIA_KEYWORDS = [
  'eesti','estonia','tallinn','tartu','pärnu','narva','viljandi','haapsalu',
  'rakvere','kuressaare','võru','paide','jõhvi','sillamäe','saaremaa','hiiumaa',
  'эстони','эстон','таллин','тарту','нарва','пярну'
];

$CACHE_DIR = __DIR__ . '/../cache';
$CACHE_FILE = $CACHE_DIR . '/rss_cache.json';
$CACHE_TTL_SECONDS = 10 * 60; // 10 минут

$MAX_ITEMS = 60;
