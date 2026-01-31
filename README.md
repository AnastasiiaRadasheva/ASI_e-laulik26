# Koidulauliku E-laulik — Eesti kultuuri veebirakendus

Projekt: ASI 2026 koduvoor — “Koidulauliku E-laulik”  
Tüüp: Veebirakendus (PHP + HTML/CSS, XML/RSS, JS)  

## Lühikirjeldus
“Koidulauliku E-laulik” on lihtne veebirakendus, mis aitab kasutajal (Koidulauliku vaimul) tutvuda Eesti nüüdisaegse kultuuri ja infoga ühest kohast.  
Rakenduses on koondatud erinevad lehed (uudised, sündmused, galerii, mängud) ning osa sisust võetakse veebiallikatest (nt RSS/XML).
For some, an [RSS generator](https://rss.app/rss-feed/rss-builder) was used.

## Käivitamine (kohalikult)
1. Ava brauseris:
   - https://ekoidula.ee/
Rakendus on hostitud zone.ee serveris.
Hindajatel ei ole vaja ligipääsu hostingule.
Avalik link on piisav testimiseks.

## Kasutamine
- Navigeeri menüü kaudu lehtede vahel.
- Uudiste lehel valitakse piirkond/allikas ning rakendus kuvab RSS-ist saadud artiklid.
- Sündmuste ja galerii lehtedel kuvatakse vastav sisu projekti failidest/allikatest.

1) Veebirakendus ja navigeerimine
- Avaleht / Kodu
- Ühtne navigeerimismenüü (nav.php)
- Ühtne stiil (style.css)

2) Veebiandmete kasutamine
- RSS / XML põhine uudiste leht (nt `uudised` / `sundmused`)
- Sisu laadimine välisest allikast ning kuvamine veebilehel

3) Sisu lehed
## Kodu
Avaleht, mis tutvustab projekti eesmärki ja ideed.
<img width="1895" height="1128" alt="image" src="https://github.com/user-attachments/assets/c0233eaf-de8b-45c1-8142-1ba6030563f8" />

## Uudised
Võimaldab valida piirkonna või allika ning kuvab uudised RSS/XML voogudest. Pealkirjale vajutades avaneb originaallugu.

## Sündmused
Kuvab kultuuriürituste ja sündmuste info ühel lehel.

## Galerii
Näitab visuaalset sisu Eesti kultuuri teemadel.

## Mängud
Sisaldab interaktiivseid lehti meelelahutuseks ja õppimiseks.

## Muuseumid
Esitab 10 Eesti muuseumi nimekirja koos lühikirjeldusega.

## Rahvustoit
Tutvustab Eesti traditsioonilisi toite.

## Viited ja allikad
Sisaldab kasutatud allikate ja RSS-voogude infot.


## Projekti struktuur
Olulisemad failid/kaustad :

- `index.php` — avaleht (Kodu)
- `nav.php` — navigatsioonimenüü (kasutatakse mitmel lehel)
- `footer.php` — jalus (kui kasutusel)
- `style.css` — ühine kujundus
- `sundmused/` — sündmuste lehed
- `1index/public/` — galerii (kui kasutusel)
- `asi_mangud/` — mängude lehed
- `muuseumid.php` — 10 muuseumi, mis aitavad Eestit päriselt mõista
-  `soo.php` —  Eesti rahvustoit
-  `viitet.php` — Viited & allikad

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
