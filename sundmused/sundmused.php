<!DOCTYPE html>
<html lang="et">
<head>
  <meta charset="UTF-8">
  <title>Sündmused</title>
  <link rel="stylesheet" href="../style.css" />
</head>
<body>

<?php require("../nav.php"); ?>

<h1>Sündmused</h1>
<h2>Siin saad valida, millisele üritusele või kontserdile minna, ning näha, millal ja kus see toimub!</h2>

<div class="events-search">
  <input id="eventsSearch" class="events-search__input" type="search"
         placeholder="Otsi sündmuse nime järgi..." autocomplete="off">
  <div id="eventsSearchInfo" class="events-search__info" style="display:none;"></div>
</div>

<?php
require_once __DIR__ . '/funktsioonid.php';

sundmused('https://rss.app/feeds/GzfSkJ0yyImEkkj0.xml', 9);
sundmused('https://rss.app/feeds/Q73ny7X657mRMXTJ.xml', 18);
sundmused('https://rss.app/feeds/2efRnrhZPHm7KCQZ.xml', 17);
sundmused('https://rss.app/feeds/uT16lOkfOxy27rcp.xml', 9);
sundmused('https://rss.app/feeds/2JeTcJgge4SbretO.xml', 9);
?>

<?php require("../footer.php"); ?>

<script>
(function () {
  const input = document.getElementById('eventsSearch');
  const info  = document.getElementById('eventsSearchInfo');
  if (!input) return;

  function normalize(s) {
    return (s || '').toString().trim().toLowerCase();
  }

  function applyFilter() {
    const q = normalize(input.value);
    const cards = document.querySelectorAll('.event-card');
    let visible = 0;

    cards.forEach(card => {
      const titleEl = card.querySelector('.event-title');
      const title = normalize(titleEl ? titleEl.textContent : '');
      const ok = (q === '') || title.includes(q);

      card.style.display = ok ? '' : 'none';
      if (ok) visible++;
    });

    if (q === '') {
      info.style.display = 'none';
      info.textContent = '';
    } else {
      info.style.display = '';
      info.textContent = (visible === 0) ? 'Tulemusi ei leitud.' : ('Leitud: ' + visible);
    }
  }

  input.addEventListener('input', applyFilter);
})();
</script>

</body>
</html>
