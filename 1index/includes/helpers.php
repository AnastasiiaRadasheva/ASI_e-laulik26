<?php
// includes/helpers.php

function ensure_dir(string $dir): void {
  if (!is_dir($dir)) {
    @mkdir($dir, 0775, true);
  }
}

function safe(string $s): string {
  return htmlspecialchars($s, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

function normalize_text(string $s): string {
  $s = html_entity_decode($s, ENT_QUOTES | ENT_HTML5, 'UTF-8');
  return mb_strtolower($s, 'UTF-8');
}

function contains_any(string $haystack, array $needles): bool {
  $h = normalize_text($haystack);
  foreach ($needles as $n) {
    $n = trim((string)$n);
    if ($n === '') continue;
    if (mb_strpos($h, normalize_text($n), 0, 'UTF-8') !== false) return true;
  }
  return false;
}

function curl_get(string $url, int $timeout = 12): ?string {
  $ch = curl_init($url);
  curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_MAXREDIRS      => 5,
    CURLOPT_CONNECTTIMEOUT => $timeout,
    CURLOPT_TIMEOUT        => $timeout,
    CURLOPT_USERAGENT      => 'Mozilla/5.0 (RSS Culture Estonia; +https://example.local)',
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => 0,
  ]);
  $data = curl_exec($ch);
  $code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);

  if ($data === false || $code < 200 || $code >= 400) return null;
  return $data;
}
