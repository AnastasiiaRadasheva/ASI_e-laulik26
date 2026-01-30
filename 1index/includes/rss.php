<?php
// includes/rss.php
require_once __DIR__ . '/helpers.php';

function parse_rss_items(string $xml): array {
  libxml_use_internal_errors(true);
  $feed = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
  if (!$feed) return [];

  $items = [];
  // RSS 2.0
  if (isset($feed->channel->item)) {
    foreach ($feed->channel->item as $it) $items[] = $it;
  }
  // Atom (varuvariant)
  if (empty($items) && isset($feed->entry)) {
    foreach ($feed->entry as $it) $items[] = $it;
  }
  return $items;
}

function item_link(SimpleXMLElement $item): string {
  // RSS: <link>...</link>
  if (!empty((string)$item->link)) return (string)$item->link;

  // Atom: <link href="...">
  if (isset($item->link)) {
    foreach ($item->link as $lnk) {
      $attrs = $lnk->attributes();
      if (!empty($attrs['href'])) return (string)$attrs['href'];
    }
  }
  return '#';
}

function item_title(SimpleXMLElement $item): string {
  $t = (string)($item->title ?? '');
  $t = trim(html_entity_decode($t, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
  return $t ?: 'Pealkiri puudub';
}

function item_description(SimpleXMLElement $item): string {
  $d = (string)($item->description ?? '');
  if (!$d && isset($item->summary)) $d = (string)$item->summary;
  $d = strip_tags(html_entity_decode($d, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
  return trim($d);
}

function extract_image_url(SimpleXMLElement $item): ?string {
  // media namespace (mrss)
  $media = $item->children('http://search.yahoo.com/mrss/');
  if ($media) {
    if (isset($media->content)) {
      foreach ($media->content as $c) {
        $attrs = $c->attributes();
        if (!empty($attrs['url'])) return (string)$attrs['url'];
      }
    }
    if (isset($media->thumbnail)) {
      foreach ($media->thumbnail as $t) {
        $attrs = $t->attributes();
        if (!empty($attrs['url'])) return (string)$attrs['url'];
      }
    }
  }

  // enclosure
  if (isset($item->enclosure)) {
    foreach ($item->enclosure as $enc) {
      $attrs = $enc->attributes();
      $type = (string)($attrs['type'] ?? '');
      $url  = (string)($attrs['url'] ?? '');
      if ($url && (stripos($type, 'image/') === 0 || preg_match('~\.(jpg|jpeg|png|webp)(\?.*)?$~i', $url))) {
        return $url;
      }
    }
  }

  // description HTML: <img src="">
  $desc = (string)($item->description ?? '');
  if ($desc && preg_match('~<img[^>]+src=["\']([^"\']+)["\']~i', $desc, $m)) {
    return $m[1];
  }

  return null;
}

/**
 * Põhifunktsioon: tagastab kaartide massiivi [title, link, img]
 */
function load_culture_estonia_cards(
  array $feeds,
  array $cultureKeywords,
  array $estoniaKeywords,
  string $cacheDir,
  string $cacheFile,
  int $cacheTtlSeconds,
  int $maxItems
): array {
  ensure_dir($cacheDir);

  // vahemälu lugemine
  if (is_file($cacheFile) && (time() - filemtime($cacheFile) < $cacheTtlSeconds)) {
    $json = @file_get_contents($cacheFile);
    $data = $json ? json_decode($json, true) : null;
    if (is_array($data)) return $data;
  }

  $all = [];
  foreach ($feeds as $url) {
    $xml = curl_get($url);
    if (!$xml) continue;

    $items = parse_rss_items($xml);
    foreach ($items as $it) {
      $title = item_title($it);
      $link  = item_link($it);
      $desc  = item_description($it);
      $img   = extract_image_url($it);

      if (!$img) continue;

      $blob = $title . " " . $desc;
      if (!contains_any($blob, $cultureKeywords)) continue;
      if (!contains_any($blob, $estoniaKeywords)) continue;

      $all[] = ['title' => $title, 'link' => $link, 'img' => $img];
    }
  }

  // eemaldame duplikaadid lingi järgi
  $uniq = [];
  foreach ($all as $x) {
    $k = $x['link'] ?? '';
    if ($k === '') continue;
    if (!isset($uniq[$k])) $uniq[$k] = $x;
  }

  $data = array_values($uniq);
  $data = array_slice($data, 0, $maxItems);

  @file_put_contents(
    $cacheFile,
    json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
  );

  return $data;
}
