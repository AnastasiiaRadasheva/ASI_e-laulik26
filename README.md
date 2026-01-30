# Koidulauliku E-laulik — Eesti kultuuri veebirakendus

Projekt: ASI Karika 2026 koduvoor — “Koidulauliku E-laulik”  
Tüüp: Veebirakendus (PHP + HTML/CSS, XML/RSS, JS)  

## Lühikirjeldus
“Koidulauliku E-laulik” on lihtne veebirakendus, mis aitab kasutajal (Koidulauliku vaimul) tutvuda Eesti nüüdisaegse kultuuri ja infoga ühest kohast.  
Rakenduses on koondatud erinevad lehed (uudised, sündmused, galerii, mängud) ning osa sisust võetakse veebiallikatest (nt RSS/XML).

## Nõuete katvus
1) Veebirakendus ja navigeerimine
- Avaleht / Kodu
- Ühtne navigeerimismenüü (nav.php)
- Ühtne stiil (style.css)

2) Veebiandmete kasutamine
- RSS / XML põhine uudiste leht (nt `uudised` / `XMLphp_project`)
- Sisu laadimine välisest allikast ning kuvamine veebilehel

3) Sisu lehed
- Uudised
- Sündmused
- Galerii
- Mängud

## Käivitamine (kohalikult)
1. Ava brauseris:
   - https://ekoidula.ee/
  

## Kasutamine
- Navigeeri menüü kaudu lehtede vahel.
- Uudiste lehel valitakse piirkond/allikas ning rakendus kuvab RSS-ist saadud artiklid.
- Sündmuste ja galerii lehtedel kuvatakse vastav sisu projekti failidest/allikatest.

## Projekti struktuur
Olulisemad failid/kaustad :

- `index.php` — avaleht (Kodu)
- `nav.php` — navigatsioonimenüü (kasutatakse mitmel lehel)
- `footer.php` — jalus (kui kasutusel)
- `style.css` — ühine kujundus
- `XMLphp_project/` — RSS/XML uudiste loogika ja lehed (kui kasutusel)
- `sundmused/` — sündmuste lehed
- `1index/public/` — galerii (kui kasutusel)
- `asi_mangud/` — mängude lehed

## Kasutatud allikad ja autoriõigused
- Uudiste kuvamiseks kasutatakse RSS/XML veebiandmeid (vastavad feed-id on koodis konfigureeritud).
- Kasutatud on avalikke veebiallikaid ning rakendus kuvab ainult vajaliku info (pealkiri, link, kuupäev, lühikirjeldus), suunates originaalallikale.
(siin on üksikasjad)
https://ekoidula.ee/viitet.php
## Autorid
- Anastasiia Radasheva
- Oleksandra Ryshniak
- Adriana Pikaljov
- Mariia Posvystak
