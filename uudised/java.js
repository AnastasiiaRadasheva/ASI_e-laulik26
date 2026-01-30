const canvas = document.getElementById("mapCanvas");
const img = document.getElementById("mapImg");
const newsBox = document.getElementById("news");
const picked = document.getElementById("picked");

const ctx = canvas.getContext("2d", { willReadFrequently: true });

const COUNTY_BY_COLOR = [
  [[229, 150, 210], "north_pink", "Roosa (põhi/kesk)"],
  [[154, 36, 68], "east_red", "Punane (ida)"],
  [[150, 223, 116], "south_green", "Roheline (kagu)"],
  [[213, 150, 126], "west_beige", "Beež (saared/lääs)"],
  [[116, 49, 125], "center_purple", "Lilla (lõuna/kesk)"],
  [[104, 103, 192], "center_blue", "Sinine (kesk)"],
];

const MAX_DIST = 70;

function drawMap() {
  if (!img.naturalWidth || !img.naturalHeight) return false;

  canvas.width = img.naturalWidth;
  canvas.height = img.naturalHeight;

  ctx.clearRect(0, 0, canvas.width, canvas.height);
  ctx.drawImage(img, 0, 0);

  return true;
}

function ensureMapLoaded() {
  if (img.complete && img.naturalWidth) {
    if (img.decode) {
      img.decode().then(drawMap).catch(drawMap);
    } else {
      drawMap();
    }
  }
}

img.addEventListener("load", () => drawMap());

img.addEventListener("error", () => {
  if (!img.dataset.retry) {
    img.dataset.retry = "1";
    img.src = img.src.split("?")[0] + "?v=" + Date.now();
  } else {
    newsBox.textContent =
      "Kaardi pilt ei laadinud. Kontrolli faili nime/teekonda (estonia.PNG või estonia.png).";
  }
});

ensureMapLoaded();

canvas.addEventListener("click", async (e) => {
  if (!img.naturalWidth) return;

  const rect = canvas.getBoundingClientRect();
  const x = Math.floor((e.clientX - rect.left) * (canvas.width / rect.width));
  const y = Math.floor((e.clientY - rect.top) * (canvas.height / rect.height));

  const pixel = ctx.getImageData(x, y, 1, 1).data;
  const r = pixel[0], g = pixel[1], b = pixel[2], a = pixel[3];

  if (a < 10 || (r + g + b) < 30) {
    picked.textContent = "—";
    newsBox.textContent = "Klõpsasid taustale. Klõpsa värvilisele alale.";
    return;
  }

  const match = nearestCounty([r, g, b]);
  if (!match) {
    picked.textContent = `rgb(${r},${g},${b})`;
    newsBox.innerHTML = `
      <div>Maakonda ei õnnestunud värvi järgi tuvastada.</div>
      <div style="opacity:.7;margin-top:6px">Tabatud värv: <b>rgb(${r},${g},${b})</b></div>
      <div style="opacity:.7;margin-top:6px">Suurenda MAX_DIST või lisa see värv COUNTY_BY_COLOR listi.</div>
    `;
    return;
  }

  picked.textContent = match.label;
  newsBox.textContent = "Laen uudiseid...";

  try {
    const res = await fetch(`funk.php?county=${encodeURIComponent(match.county)}`, {
      headers: { "X-Requested-With": "fetch" },
      cache: "no-store"
    });

    const html = await res.text();
    if (!res.ok) {
      newsBox.innerHTML = `<div>PHP viga (${res.status}):</div><pre style="white-space:pre-wrap">${escapeHtml(html)}</pre>`;
      return;
    }

    newsBox.innerHTML = html;
  } catch (err) {
    newsBox.textContent = "Võrguviga: " + err;
  }
});

function nearestCounty([r, g, b]) {
  let best = null;

  for (const [rgb, county, label] of COUNTY_BY_COLOR) {
    const d = dist(rgb, [r, g, b]);
    if (best === null || d < best.d) best = { d, county, label };
  }

  if (best && best.d <= MAX_DIST) return { county: best.county, label: best.label };
  return null;
}

function dist(a, b) {
  const dr = a[0] - b[0], dg = a[1] - b[1], db = a[2] - b[2];
  return Math.sqrt(dr * dr + dg * dg + db * db);
}

function escapeHtml(s) {
  return String(s).replace(/[&<>"']/g, m => ({
    "&": "&amp;",
    "<": "&lt;",
    ">": "&gt;",
    '"': "&quot;",
    "'": "&#039;"
  }[m]));
}
