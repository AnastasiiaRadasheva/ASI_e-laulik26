<?php
declare(strict_types=1);

header('Content-Type: text/html; charset=utf-8');

$county = isset($_GET['county']) ? trim((string)$_GET['county']) : '';
if ($county === '') {
  http_response_code(400);
  echo "Parameeter 'county' puudub";
  exit;
}

$COUNTY_ALIASES = [
  'north_pink'    => 'Harju maakond',
  'east_red'      => 'Ida-Viru maakond',
  'center_blue'   => 'Viljandi maakond',
  'south_green'   => 'Tartu maakond',
  'west_beige'    => 'Saare maakond',
  'center_purple' => 'Pärnu maakond',
];

if (isset($COUNTY_ALIASES[$county])) {
  $county = $COUNTY_ALIASES[$county];
}

$RSS_BY_COUNTY = [
  'Harju maakond' => [
    'https://www.postimees.ee/rss',
    'https://kultuur.err.ee/rss',
    'https://www.ohtuleht.ee/rss'
  ],
  'Ida-Viru maakond' => [
     'https://pohjarannik.postimees.ee/rss',
     'https://www.ohtuleht.ee/teemalehed/narva/rss',

  ],
  'Tartu maakond' => [
    'https://rss.app/feeds/XilNhHBqAq9hm8Lp.xml',
    'https://www.ohtuleht.ee/teemalehed/tartu/rss',
    'https://tartuleht.ee/feed/',
    'https://www.tartu.ee/et/rss'
  ],
  'Saare maakond' => [
     'https://saartehaal.postimees.ee/rss',
     'https://www.ohtuleht.ee/teemalehed/saaremaa/rss'
  ],
  'Pärnu maakond' => [
     'https://parnu.postimees.ee/rss',
     'https://www.ohtuleht.ee/teemalehed/parnu/rss',
     'https://eestiuudised.ee/tag/parnu/feed/'
  ],
  'Viljandi maakond' => [
    'https://sakala.postimees.ee/rss',
    'https://www.ohtuleht.ee/teemalehed/viljandi/rss',
  ],
];

if (!isset($RSS_BY_COUNTY[$county])) {
  http_response_code(404);
  echo "Tundmatu maakond: " . esc($county);
  exit;
}

$feeds = $RSS_BY_COUNTY[$county];
if (!is_array($feeds) || count($feeds) === 0) {
  echo "<div>Selle maakonna RSS-id ei ole seadistatud.</div>";
  exit;
}

$LIMIT_PER_FEED = 4;
$PLACEHOLDER_IMG = 'placeholder.jpg';

echo renderCountyFeeds($feeds, $county, $LIMIT_PER_FEED, $PLACEHOLDER_IMG);

function renderCountyFeeds(array $feeds, string $county, int $limitPerFeed, string $placeholder): string
{
  $out = '';
  $out .= '<div style="margin-bottom:10px;opacity:.8">Maakond: <b>'.esc($county).'</b></div>';

  foreach ($feeds as $feedUrl) {
    $feedUrl = trim((string)$feedUrl);
    if ($feedUrl === '') continue;

    $items = parseFeedItems($feedUrl, $limitPerFeed, $placeholder);

    $out .= '<div style="margin:12px 0 8px; font-weight:700;">Allikas: '.esc($feedUrl).'</div>';

    if (!$items) {
      $out .= '<div style="opacity:.8;margin-bottom:12px">Uudiseid ei ole või RSS-i ei õnnestunud laadida.</div>';
      continue;
    }

    foreach ($items as $n) {
      $title = $n['title'] !== '' ? $n['title'] : 'Pealkiri puudub';
      $link  = $n['link']  !== '' ? $n['link']  : '#';
      $date  = $n['date']  ?? '';
      $img   = $n['image'] ?? $placeholder;

      $out .= '<div class="news-item" style="display:flex;gap:10px;align-items:flex-start;">';

      $out .= '<div style="flex:0 0 92px">';
      $out .= '<img src="'.escAttr($img).'" alt="" style="width:92px;height:64px;object-fit:cover;border-radius:10px;border:1px solid #eee" loading="lazy" onerror="this.onerror=null;this.src=\''.escAttr($placeholder).'\';">';
      $out .= '</div>';

      $out .= '<div style="flex:1 1 auto">';
      $out .= '<div style="font-weight:600;margin-bottom:4px;line-height:1.2"><a target="_blank" rel="noopener" href="'.escAttr($link).'">'.esc($title).'</a></div>';
      if ($date !== '') {
        $out .= '<div style="font-size:12px;opacity:.7;margin-bottom:4px">'.esc($date).'</div>';
      }
      if (!empty($n['desc'])) {
        $out .= '<div style="font-size:14px;opacity:.9">'.esc(mb_strimwidth(strip_tags($n['desc']), 0, 160, '…', 'UTF-8')).'</div>';
      }
      $out .= '</div>';

      $out .= '</div>';
    }
  }

  return $out;
}

function parseFeedItems(string $url, int $limit, string $placeholder): array
{
  $raw = fetchUrl($url);
  if ($raw === null || $raw === '') return [];

  libxml_use_internal_errors(true);
  $xml = simplexml_load_string($raw, 'SimpleXMLElement', LIBXML_NOCDATA);
  if ($xml === false) return [];

  $namespaces = $xml->getNamespaces(true);

  $items = [];

  if (isset($xml->channel->item)) {
    foreach ($xml->channel->item as $it) {
      $title = (string)$it->title;
      $link  = (string)$it->link;
      $date  = (string)$it->pubDate;
      $desc  = (string)$it->description;

      $img = extractImageFromItem($it, $namespaces, $desc);
      if ($img === '') $img = $placeholder;

      $items[] = [
        'title' => $title,
        'link'  => $link,
        'date'  => $date,
        'desc'  => $desc,
        'image' => $img,
      ];
      if (count($items) >= $limit) break;
    }
    return $items;
  }

  if (isset($xml->entry)) {
    foreach ($xml->entry as $it) {
      $title = (string)$it->title;

      $link = '';
      if (isset($it->link)) {
        $attrs = $it->link->attributes();
        $link = isset($attrs['href']) ? (string)$attrs['href'] : (string)$it->link;
      }

      $date = (string)($it->updated ?? $it->published ?? '');
      $desc = (string)($it->summary ?? '');

      $img = extractImageFromAtomEntry($it, $desc);
      if ($img === '') $img = $placeholder;

      $items[] = [
        'title' => $title,
        'link'  => $link,
        'date'  => $date,
        'desc'  => $desc,
        'image' => $img,
      ];
      if (count($items) >= $limit) break;
    }
  }

  return $items;
}

function extractImageFromItem(SimpleXMLElement $it, array $namespaces, string $descHtml): string
{
  if (isset($namespaces['media'])) {
    $media = $it->children($namespaces['media']);

    if (isset($media->thumbnail)) {
      $a = $media->thumbnail->attributes();
      if (isset($a['url'])) return (string)$a['url'];
    }
    if (isset($media->content)) {
      $a = $media->content->attributes();
      if (isset($a['url'])) return (string)$a['url'];
    }
  }

  if (isset($it->enclosure)) {
    $a = $it->enclosure->attributes();
    if (isset($a['url'])) return (string)$a['url'];
  }

  return extractFirstImgFromHtml($descHtml);
}

function extractImageFromAtomEntry(SimpleXMLElement $entry, string $descHtml): string
{
  if (isset($entry->content)) {
    $img = extractFirstImgFromHtml((string)$entry->content);
    if ($img !== '') return $img;
  }
  return extractFirstImgFromHtml($descHtml);
}

function extractFirstImgFromHtml(string $html): string
{
  if ($html === '') return '';
  if (preg_match('~<img[^>]+src=["\']([^"\']+)["\']~i', $html, $m)) {
    return (string)$m[1];
  }
  return '';
}

function fetchUrl(string $url): ?string
{
  if (function_exists('curl_init')) {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_MAXREDIRS      => 5,
      CURLOPT_CONNECTTIMEOUT => 5,
      CURLOPT_TIMEOUT        => 12,
      CURLOPT_USERAGENT      => 'Mozilla/5.0 (RSS Reader; PHP cURL)',
      CURLOPT_SSL_VERIFYPEER => true,
      CURLOPT_SSL_VERIFYHOST => 2,
    ]);

    $data = curl_exec($ch);
    $err  = curl_error($ch);
    $code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($data !== false && $code >= 200 && $code < 300) {
      return $data;
    }
    error_log("RSS fetch failed: url=$url http=$code err=$err");
  }

  $ctx = stream_context_create([
    'http' => [
      'timeout' => 12,
      'user_agent' => 'Mozilla/5.0 (RSS Reader; PHP)'
    ]
  ]);

  $raw = @file_get_contents($url, false, $ctx);
  if ($raw !== false) return $raw;

  return null;
}

function esc(string $s): string {
  return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function escAttr(string $s): string {
  return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
