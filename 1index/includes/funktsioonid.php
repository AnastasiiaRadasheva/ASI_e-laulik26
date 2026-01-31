<?php
function sundmused(string $rss_url, int $limit = 9, int $timeout = 8): void
{
    $xmlString = fetchUrl($rss_url, $timeout);
    if ($xmlString === null) {
        echo '<div class="rss-error">RSS-i ei õnnestunud laadida.</div>';
        return;
    }

    libxml_use_internal_errors(true);
    $xml = simplexml_load_string($xmlString, 'SimpleXMLElement', LIBXML_NOCDATA);
    if ($xml === false || !isset($xml->channel)) {
        echo '<div class="rss-error">RSS on vigases formaadis.</div>';
        return;
    }

    $channel = $xml->channel;

    echo '<section class="events-page rss">';
    echo '<div class="events-grid">';

    $count = 0;
    foreach ($channel->item as $item) {
        if ($count >= $limit) break;
        $count++;

        $itemTitle = trim((string)($item->title ?? ''));
        $itemLink  = trim((string)($item->link ?? ''));
        $imageUrl  = getImageUrl($item);

        if ($itemLink === '') $itemLink = '#';

        echo '<article class="event-card">';

        echo '<a class="event-media" href="'.e($itemLink).'" target="_blank" rel="noopener">';
        if ($imageUrl) {
            echo '<img src="'.e($imageUrl).'" alt="'.e($itemTitle).'" loading="lazy">';
        } else {
            echo '<span>Pilt puudub</span>';
        }
        echo '</a>';

        echo '<div class="event-body">';
        echo '<h3 class="event-title"><a href="'.e($itemLink).'" target="_blank" rel="noopener">'.e($itemTitle).'</a></h3>';
        echo '</div>';

        echo '</article>';
    }

    echo '</div>';
    echo '</section>';
}


function getImageUrl(SimpleXMLElement $item): string
{
    $media = $item->children('http://search.yahoo.com/mrss/');
    if ($media) {
        if (isset($media->content)) {
            foreach ($media->content as $c) {
                $a = $c->attributes();
                if (!empty($a['url'])) return (string)$a['url'];
            }
        }
        if (isset($media->thumbnail)) {
            foreach ($media->thumbnail as $t) {
                $a = $t->attributes();
                if (!empty($a['url'])) return (string)$a['url'];
            }
        }
    }

    if (isset($item->enclosure)) {
        foreach ($item->enclosure as $enc) {
            $a = $enc->attributes();
            if (!empty($a['url'])) return (string)$a['url'];
        }
    }

    $itunes = $item->children('http://www.itunes.com/dtds/podcast-1.0.dtd');
    if ($itunes && isset($itunes->image)) {
        $a = $itunes->image->attributes();
        if (!empty($a['href'])) return (string)$a['href'];
    }

    $content = $item->children('http://purl.org/rss/1.0/modules/content/');
    if ($content && isset($content->encoded)) {
        $html = (string)$content->encoded;
        if ($html && preg_match('~<img[^>]+src=["\']([^"\']+)["\']~i', $html, $m)) {
            return trim((string)$m[1]);
        }
    }

    $desc = (string)($item->description ?? '');
    if ($desc && preg_match('~<img[^>]+src=["\']([^"\']+)["\']~i', $desc, $m)) {
        return trim((string)$m[1]);
    }

    return '';
}

function fetchUrl(string $url, int $timeout = 8): ?string
{
    if (!filter_var($url, FILTER_VALIDATE_URL)) return null;

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT => $timeout,
        CURLOPT_CONNECTTIMEOUT => $timeout,
        CURLOPT_USERAGENT => 'PHP RSS Reader/1.0',
        CURLOPT_SSL_VERIFYPEER => true,
    ]);

    $data = curl_exec($ch);
    $http = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($data === false || $http < 200 || $http >= 300) {
        return null;
    }
    return $data;
}

function e(string $s): string
{
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
