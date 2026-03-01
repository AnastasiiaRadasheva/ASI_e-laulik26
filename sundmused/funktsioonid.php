<?php

function sundmused(string $rss_url, int $limit = 5, int $timeout = 8): void
{
    $xmlString = fetchUrl($rss_url, $timeout);
    if ($xmlString === null) {
        echo '<div class="rss-error">RSS-i ei õnnestunud laadida.</div>';
        return;
    }

    libxml_use_internal_errors(true);
    $xml = simplexml_load_string($xmlString);
    if ($xml === false || !isset($xml->channel)) {
        echo '<div class="rss-error">RSS on vigases formaadis.</div>';
        return;
    }

    $channel = $xml->channel;
    $title = (string)($channel->title ?? 'RSS');
    $link  = (string)($channel->link ?? '#');

    echo '<section class="events-page rss">';

    echo '<div class="events-grid">';

    $count = 0;
    foreach ($channel->item as $item) {
        if ($count >= $limit) break;
        $count++;

        $itemTitle = (string)($item->title ?? '');
        $itemLink  = trim((string)($item->link ?? ''));
        $pubDate   = (string)($item->pubDate ?? '');

        // Autor (dc:creator)
        $creator = '';
        $dc = $item->children('http://purl.org/dc/elements/1.1/');
        if (isset($dc->creator)) {
            $creator = (string)$dc->creator;
        }

        // Pilt (media:content url="")
        $imageUrl = '';
        $media = $item->children('http://search.yahoo.com/mrss/');
        if (isset($media->content)) {
            $attrs = $media->content->attributes();
            if (isset($attrs['url'])) {
                $imageUrl = (string)$attrs['url'];
            }
        }

        $descriptionHtml = (string)($item->description ?? '');

        $dateText = '';
        if ($pubDate && ($ts = strtotime($pubDate))) {
            $dateText = date('d.m.Y H:i', $ts);
        }

        $safeDescription = strip_tags(
            $descriptionHtml,
            '<div><img><br><p><span><strong><em>'
        );

        echo '<article class="event-card">';

        // Meedia (pilt üleval)
        if ($imageUrl) {
            echo '<a class="event-media" href="'.e($itemLink).'" target="_blank" rel="noopener">';
            echo '<img src="'.e($imageUrl).'" alt="'.e($itemTitle).'" loading="lazy">';
            echo '</a>';
        } else {
            echo '<a class="event-media event-media--placeholder" href="'.e($itemLink).'" target="_blank" rel="noopener">';
            echo '<span>Pilt puudub</span>';
            echo '</a>';
        }

        echo '<div class="event-body">';

        // Pealkiri
        echo '<h3 class="event-title"><a href="'.e($itemLink).'" target="_blank" rel="noopener">'.e($itemTitle).'</a></h3>';

        // Meta info
        echo '<div class="event-meta">';
        if ($dateText) echo '<span class="event-date">'.e($dateText).'</span>';
        if ($creator)  echo '<span class="event-dot">•</span><span class="event-creator">'.e($creator).'</span>';
        echo '</div>';

        // Kirjeldus (lühike, CSS teeb ilusaks)
        if (!empty($safeDescription)) {
            echo '<div class="event-desc">'.$safeDescription.'</div>';
        }

        // Nupp
        if ($itemLink !== '') {
            echo '<a class="event-btn" href="'.e($itemLink).'" target="_blank" rel="noopener">Loe rohkem</a>';
        }

        echo '</div>'; // event-body
        echo '</article>';
    }

    echo '</div>'; // events-grid
    echo '</section>'; // events-page
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
    $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
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
