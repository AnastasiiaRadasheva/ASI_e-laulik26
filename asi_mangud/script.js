/* =========================
   NAV
========================= */
const tabs = document.querySelectorAll(".tab");
const screens = document.querySelectorAll(".screen");

function showScreen(id) {
    screens.forEach(s => s.classList.toggle("show", s.id === id));
    tabs.forEach(t => t.classList.toggle("active", t.dataset.screen === id));
}
tabs.forEach(t => t.addEventListener("click", () => showScreen(t.dataset.screen)));

function shuffle(arr) {
    return [...arr].sort(() => Math.random() - 0.5);
}


function dedupeByQuestion(list) {
    const seen = new Set();
    const out = [];
    for (const item of list) {
        const key = (item.q || "").trim().toLowerCase();
        if (!key) continue;
        if (seen.has(key)) continue;
        seen.add(key);
        out.push(item);
    }
    return out;
}


function shuffleOptionsKeepCorrect(q) {
    const correctText = q.o[q.c];
    const shuffled = shuffle(q.o);
    return { ...q, o: shuffled, c: shuffled.indexOf(correctText) };
}

/* =========================
   GAME 1
========================= */
let game1Questions = [
    { q: "Mis on Eesti pealinn?", o: ["Tartu", "Tallinn", "Narva"], c: 1 },
    { q: "Mis värvid on Eesti lipul?", o: ["Sinine-must-valge", "Punane-valge-sinine", "Roheline-kollane"], c: 0 },
    { q: "Mis linn on tuntud ülikooli poolest?", o: ["Pärnu", "Tartu", "Rakvere"], c: 1 },
    { q: "Mis on Eesti rahvuslill?", o: ["Rukkilill", "Roos", "Nartsiss"], c: 0 },
    { q: "Mis meri piirab Eestit?", o: ["Läänemeri", "Must meri", "Vahemeri"], c: 0 },
    { q: "Mis pidu on seotud koorilauluga?", o: ["Laulupidu", "Halloween", "Karneval"], c: 0 },
    { q: "Mis on Eesti rahvusloom?", o: ["Hunt", "Karu", "Rebane"], c: 0 },
    { q: "Milline linn on suvepealinn?", o: ["Pärnu", "Narva", "Tartu"], c: 0 },
    { q: "Mis on Eesti ametlik raha?", o: ["Euro", "Kroon", "Dollar"], c: 0 },
    { q: "Millal on Eesti Vabariigi aastapäev?", o: ["24. veebruar", "20. august", "1. jaanuar"], c: 0 },
    { q: "Mis saar on Eesti suurim?", o: ["Saaremaa", "Kihnu", "Naissaar"], c: 0 },
    { q: "Kus asub Toompea?", o: ["Tallinnas", "Tartus", "Pärnus"], c: 0 },
    { q: "Mis on Jaanipäeva traditsioon?", o: ["Lõkke tegemine", "Suusatamine", "Jäähoki"], c: 0 },

    { q: "Mis kuupäeval tähistatakse taasiseseisvumispäeva?", o: ["20. august", "24. veebruar", "1. jaanuar"], c: 0 },
    { q: "Milline jõgi voolab läbi Tartu?", o: ["Emajõgi", "Narva jõgi", "Pärnu jõgi"], c: 0 },
    { q: "Mis on Eesti rahvuskala?", o: ["Räim", "Lõhe", "Haug"], c: 0 },
    { q: "Kus asub Eesti rahvusmuuseum?", o: ["Tartus", "Tallinnas", "Narvas"], c: 0 },
    { q: "Mis on Eesti kõrgeim mägi?", o: ["Suur Munamägi", "Toomemägi", "Emumägi"], c: 0 },
    { q: "Mis on Eesti tuntud filmifestival?", o: ["PÖFF", "Cannes", "Berlinale"], c: 0 },
    { q: "Mis tähendab lühend PÖFF?", o: ["Pimedate Ööde Filmifestival", "Põhja-Eesti Folk Festival", "Pop-Õhtu Festival"], c: 0 },
    { q: "Mis on Eesti rahvustoit (tuntud)?", o: ["Mulgipuder", "Sushi", "Tacos"], c: 0 },
    { q: "Milline on Eesti traditsiooniline leib?", o: ["Rukkileib", "Baguette", "Pita"], c: 0 },
    { q: "Tallinna vanalinn on...", o: ["UNESCO maailmapärand", "Euroopa suurim kõrb", "Maailma kõrgeim mägi"], c: 0 },
    { q: "Mis pidu on seotud lõkke ja suveööga?", o: ["Jaanipäev", "Isadepäev", "Sõbrapäev"], c: 0 },
    { q: "Mis linn on piirilinn Narva jõe ääres?", o: ["Narva", "Tartu", "Viljandi"], c: 0 }
];

game1Questions = dedupeByQuestion(game1Questions);

const g1 = { list: [], idx: 0, score: 0, answered: false };

const g1Count = document.getElementById("g1-count");
const g1Bar = document.getElementById("g1-bar");
const g1Question = document.getElementById("g1-question");
const g1Answers = document.getElementById("g1-answers");
const g1ResultBox = document.getElementById("g1-result");
const g1ScoreEl = document.getElementById("g1-score");
const g1NoteEl = document.getElementById("g1-note");
const g1Start = document.getElementById("g1-start");
const g1Restart = document.getElementById("g1-restart");

function g1StartGame() {
    if (game1Questions.length < 10) {
        alert("Mäng 1: küsimusi on liiga vähe (vajab vähemalt 10).");
        return;
    }


    g1.list = shuffle(game1Questions).slice(0, 10).map(shuffleOptionsKeepCorrect);

    g1.idx = 0;
    g1.score = 0;
    g1.answered = false;

    g1ResultBox.style.display = "none";
    g1Start.style.display = "none";

    g1ShowQuestion();
}

function g1ShowQuestion() {
    g1.answered = false;
    const q = g1.list[g1.idx];

    g1Count.textContent = `${g1.idx + 1}/10`;
    g1Bar.style.width = `${(g1.idx / 10) * 100}%`;

    g1Question.textContent = `${g1.idx + 1}. ${q.q}`;
    g1Answers.innerHTML = "";

    q.o.forEach((opt, i) => {
        const btn = document.createElement("button");
        btn.textContent = opt;
        btn.addEventListener("click", () => g1Pick(i, btn));
        g1Answers.appendChild(btn);
    });
}

function g1Pick(choiceIndex, clickedBtn) {
    if (g1.answered) return;
    g1.answered = true;

    const q = g1.list[g1.idx];
    const buttons = Array.from(g1Answers.querySelectorAll("button"));

    buttons.forEach((b, i) => { if (i === q.c) b.classList.add("btn-correct"); });

    if (choiceIndex === q.c) g1.score++;
    else clickedBtn.classList.add("btn-wrong");

    setTimeout(() => {
        g1.idx++;
        if (g1.idx < 10) g1ShowQuestion();
        else g1ShowResult();
    }, 600);
}

function g1ShowResult() {
    g1Bar.style.width = `100%`;
    g1Question.textContent = "Valmis!";
    g1Answers.innerHTML = "";

    g1ScoreEl.textContent = `${g1.score} / 10`;
    g1NoteEl.textContent = (g1.score >= 8) ? "Väga hea!" : (g1.score >= 5) ? "Tubli!" : "Proovi uuesti 🙂";

    g1ResultBox.style.display = "block";
    g1Start.style.display = "inline-block";
}

g1Start.addEventListener("click", g1StartGame);
g1Restart.addEventListener("click", g1StartGame);


/* =========================
   GAME 2
========================= */
let game2Questions = [
    { q: "Tallinn on Eesti pealinn.", a: true },
    { q: "Eesti lipp on punane-valge-sinine.", a: false },
    { q: "Laulupidu on oluline osa Eesti kultuurist.", a: true },
    { q: "Tartu on tuntud oma ülikooli poolest.", a: true },
    { q: "Saaremaa on Eesti suurim saar.", a: true },
    { q: "Eesti asub Aasias.", a: false },
    { q: "Eestis kasutatakse eurot.", a: true },
    { q: "Jaanipäeva tähistatakse Eestis suvel.", a: true },
    { q: "Narva jõgi on Eesti ja Venemaa piiril.", a: true },
    { q: "Eesti rahvuslill on roos.", a: false },
    { q: "Pärnu on tuntud kui suvepealinn.", a: true },
    { q: "Eesti riigikeel on soome keel.", a: false },
    { q: "Rukkilill on Eesti rahvuslill.", a: true },

    { q: "Tallinna vanalinn on UNESCO maailmapärandi nimekirjas.", a: true },
    { q: "Eesti iseseisvuspäev on 24. veebruar.", a: true },
    { q: "Eesti taasiseseisvumispäev on 20. august.", a: true },
    { q: "Suur Munamägi asub Eestis.", a: true },
    { q: "Eesti asub Euroopas.", a: true },
    { q: "Eestis kasutatakse endiselt krooni.", a: false },
    { q: "Eestis on palju raba-alasid.", a: true },
    { q: "Eesti rahvuskala on räim.", a: true },
    { q: "PÖFF on Eesti filmifestival.", a: true },
    { q: "Viljandi on tuntud pärimusmuusika festivali poolest.", a: true }
];

game2Questions = dedupeByQuestion(game2Questions);

const g2 = { list: [], idx: 0, score: 0, locked: false };

const g2Count = document.getElementById("g2-count");
const g2Bar = document.getElementById("g2-bar");
const g2Question = document.getElementById("g2-question");
const g2True = document.getElementById("g2-true");
const g2False = document.getElementById("g2-false");
const g2ResultBox = document.getElementById("g2-result");
const g2ScoreEl = document.getElementById("g2-score");
const g2NoteEl = document.getElementById("g2-note");
const g2Start = document.getElementById("g2-start");
const g2Restart = document.getElementById("g2-restart");

function g2StartGame() {
    if (game2Questions.length < 10) {
        alert("Mäng 2: küsimusi on liiga vähe (vajab vähemalt 10).");
        return;
    }

    g2.list = shuffle(game2Questions).slice(0, 10);

    g2.idx = 0;
    g2.score = 0;
    g2.locked = false;

    g2ResultBox.style.display = "none";
    g2Start.style.display = "none";

    g2ShowQuestion();
}

function g2ShowQuestion() {
    g2.locked = false;
    const item = g2.list[g2.idx];

    g2Count.textContent = `${g2.idx + 1}/10`;
    g2Bar.style.width = `${(g2.idx / 10) * 100}%`;

    g2Question.textContent = `${g2.idx + 1}. ${item.q}`;
}

function g2Answer(val) {
    if (g2.locked) return;
    g2.locked = true;

    const item = g2.list[g2.idx];
    const ok = (val === item.a);
    if (ok) g2.score++;

    setTimeout(() => {
        g2.idx++;
        if (g2.idx < 10) g2ShowQuestion();
        else g2ShowResult();
    }, 400);
}

function g2ShowResult() {
    g2Bar.style.width = "100%";
    g2Question.textContent = "Valmis!";

    g2ScoreEl.textContent = `${g2.score} / 10`;
    g2NoteEl.textContent = (g2.score >= 8) ? "Väga hea!" : (g2.score >= 5) ? "Tubli!" : "Proovi uuesti 🙂";

    g2ResultBox.style.display = "block";
    g2Start.style.display = "inline-block";
}

g2True.addEventListener("click", () => g2Answer(true));
g2False.addEventListener("click", () => g2Answer(false));
g2Start.addEventListener("click", g2StartGame);
g2Restart.addEventListener("click", g2StartGame);


/* =========================
   GAME 3: Memory
========================= */
const g3grid = document.getElementById("g3-grid");
const g3msg = document.getElementById("g3-msg");
const g3restart = document.getElementById("g3-restart");

function g3Shuffle(arr) { return [...arr].sort(() => Math.random() - 0.5); }

// Pane pildid kausta: assets/memory/...
const memoryPairs = [
    { id: "tallinn", type: "img", value: "/pildid/tallinn.jpg" },
    { id: "tartu", type: "img", value: "/pildid/tartu.jpg" },
    { id: "parnu", type: "img", value: "/pildid/parnu.jpg" },
    { id: "saaremaa", type: "img", value: "/pildid/saaremaa.jpg" },
    { id: "laulupidu", type: "img", value: "/pildid/laulupidu.jpg" },
    { id: "toompea", type: "img", value: "/pildid/toompea.jpg" },

    { id: "rukkis", type: "text", value: "Rukis" },
    { id: "jaanipaev", type: "text", value: "Jaanipäev" },
    { id: "eesti", type: "text", value: "Eesti" },
    { id: "sauna", type: "text", value: "Saun" }
];

let g3 = { opened: [], matched: 0, lock: false, totalPairs: 0 };

function g3MakeCard(data) {
    const card = document.createElement("div");
    card.className = "card";
    card.dataset.pair = data.id;
    card.dataset.type = data.type;
    card.dataset.value = data.value;

    card.innerHTML = `
    <div class="cardInner">
      <div class="face back">?</div>
      <div class="face front"></div>
    </div>
  `;
    card.addEventListener("click", () => g3Flip(card));
    return card;
}

function g3ShowFront(card) {
    const front = card.querySelector(".front");
    const type = card.dataset.type;
    const value = card.dataset.value;

    front.innerHTML = "";
    if (type === "img") {
        const img = document.createElement("img");
        img.src = value;
        img.alt = card.dataset.pair;
        front.appendChild(img);
    } else {
        front.textContent = value;
        front.style.fontSize = "14px";
        front.style.padding = "8px";
        front.style.textAlign = "center";
        front.style.lineHeight = "1.15";
    }
}

function g3HideFront(card) {
    card.querySelector(".front").innerHTML = "";
}

function g3Build() {
    g3grid.innerHTML = "";
    g3msg.textContent = "";
    g3 = { opened: [], matched: 0, lock: false, totalPairs: memoryPairs.length };

    const cards = g3Shuffle([...memoryPairs, ...memoryPairs]);
    cards.forEach(d => g3grid.appendChild(g3MakeCard(d)));
}

function g3Flip(card) {
    if (g3.lock) return;
    if (card.classList.contains("done") || card.classList.contains("open")) return;

    card.classList.add("open");
    g3ShowFront(card);
    g3.opened.push(card);

    if (g3.opened.length === 2) {
        g3.lock = true;
        const [a, b] = g3.opened;

        if (a.dataset.pair === b.dataset.pair) {
            a.classList.add("done");
            b.classList.add("done");
            g3.matched++;
            g3.opened = [];
            g3.lock = false;

            if (g3.matched === g3.totalPairs) {
                g3msg.textContent = "🎉 Kõik paarid leitud!";
            }
        } else {
            setTimeout(() => {
                [a, b].forEach(x => {
                    x.classList.remove("open");
                    g3HideFront(x);
                });
                g3.opened = [];
                g3.lock = false;
            }, 700);
        }
    }
}

g3restart.addEventListener("click", g3Build);
g3Build();


/* =========================
   GAME 4: Wordle
========================= */
(function initWordleET() {
    const gameEl = document.getElementById('w-game');
    const keyboardEl = document.getElementById('w-keyboard');
    const messageEl = document.getElementById('w-message');
    const restartBtn = document.getElementById('w-restart-btn');

    if (!gameEl || !keyboardEl || !messageEl || !restartBtn) return;

    const ALLOWED = "QWERTYUIOPASDFGHJKLZXCVBNMÕÄÖÜ";


    const WORDS = [
        "TARTU",
        "NARVA",
        "PÄRNU",
        "KEILA",
        "RAPLA",
        "VALGA",
        "PAIDE",
        "JÕHVI",
        "TÕRVA",
        "LOKSA",
        "KEHRA",
        "PÜSSI",
        "KUNDA",
        "SINDI",
        "PÕLVA",
        "PÜHAD",
        "MÕISA",
        "KUNST",
        "OOPER",
        "KADRI",
        "MARDI",
        "TANTS",
        "LAULU",
        "VORST",
        "REGIL",
        "SAUNA",
        "PRAED",
        "KIRIK",
        "JUUST",
        "RUKIS",
        "PÕDER",
        "KÄBID",
        "RABAD",
        "SOODE",
        "KALDA",
        "RANDA",
        "ILVES",
        "JÄNES",
    ];

    let wordle = WORDS[Math.floor(Math.random() * WORDS.length)];


    const keyRows = [
        ['Q','W','E','R','T','Y','U','I','O','P','Õ','Ü','⌫'],
        ['A','S','D','F','G','H','J','K','L','Ä','Ö','ENTER'],
        ['Z','X','C','V','B','N','M']
    ];

    const guessRows = Array.from({ length: 6 }, () => ['', '', '', '', '']);
    let currentRow = 0;
    let currentTile = 0;
    let isGameOver = false;

    function clearUI() {
        gameEl.innerHTML = '';
        keyboardEl.innerHTML = '';
        messageEl.innerHTML = '';
        restartBtn.style.visibility = 'hidden';
        restartBtn.style.opacity = '0';
    }

    function buildBoard() {
        guessRows.forEach((row, r) => {
            const rowEl = document.createElement('div');
            rowEl.className = 'row';
            rowEl.id = 'w-row-' + r;

            row.forEach((_, c) => {
                const tile = document.createElement('div');
                tile.className = 'tile';
                tile.id = `w-${r}-${c}`;
                tile.setAttribute('data', '');
                rowEl.appendChild(tile);
            });

            gameEl.appendChild(rowEl);
        });
    }

    function buildKeyboard() {
        keyboardEl.classList.add('wordle-keyboard');
        keyboardEl.innerHTML = '';

        keyRows.forEach(row => {
            const rowEl = document.createElement('div');
            rowEl.className = 'kb-row';

            row.forEach(key => {
                const btn = document.createElement('button');
                btn.textContent = key;
                btn.id = 'w-key-' + key;
                if (key === 'ENTER' || key === '⌫') btn.classList.add('big');
                btn.addEventListener('click', () => handleKey(key));
                rowEl.appendChild(btn);
            });

            keyboardEl.appendChild(rowEl);
        });
    }

    function showMessage(text, type) {
        messageEl.innerHTML = '';
        const p = document.createElement('p');
        p.textContent = text;

        if (type === 'win') p.style.background = '#1e4620';
        if (type === 'lose') p.style.background = '#4a1c1c';

        messageEl.appendChild(p);
        restartBtn.style.visibility = 'visible';
        restartBtn.style.opacity = '1';
    }

    function addColorToKey(letter, className) {
        const keyBtn = document.getElementById('w-key-' + letter);
        if (!keyBtn) return;

        // ära downgrade-i
        const order = { 'green-overlay': 3, 'yellow-overlay': 2, 'grey-overlay': 1 };
        const current = Array.from(keyBtn.classList).find(c => order[c]);
        if (current && order[current] >= order[className]) return;

        keyBtn.classList.remove('green-overlay','yellow-overlay','grey-overlay');
        keyBtn.classList.add(className);
    }

    function addLetter(letter) {
        if (currentTile < 5 && currentRow < 6) {
            const tile = document.getElementById(`w-${currentRow}-${currentTile}`);
            tile.textContent = letter;
            tile.setAttribute('data', letter);
            guessRows[currentRow][currentTile] = letter;
            currentTile++;
        }
    }

    function removeLetter() {
        if (currentTile > 0) {
            currentTile--;
            const tile = document.getElementById(`w-${currentRow}-${currentTile}`);
            tile.textContent = '';
            tile.setAttribute('data', '');
            guessRows[currentRow][currentTile] = '';
        }
    }

    function handleKey(key) {
        if (isGameOver) return;

        if (key === '⌫') return removeLetter();
        if (key === 'ENTER') return checkRow();
        if (ALLOWED.includes(key)) addLetter(key);
    }

    function checkRow() {
        if (currentTile < 5) return;
        const guess = guessRows[currentRow].join('');

        if (!WORDS.includes(guess)) {
            showMessage("Sõna ei ole nimekirjas", "info");
            setTimeout(() => { messageEl.innerHTML = ''; }, 900);
            return;
        }

        flipTiles();

        if (guess === wordle) {
            isGameOver = true;
            showMessage("Tubli! 🎉", "win");
            return;
        }

        if (currentRow >= 5) {
            isGameOver = true;
            showMessage("Mäng läbi! Sõna oli: " + wordle, "lose");
            return;
        }

        currentRow++;
        currentTile = 0;
    }

    function flipTiles() {
        const tiles = document.querySelectorAll(`#w-row-${currentRow} .tile`);
        let check = wordle;
        const res = [];

        tiles.forEach(tile => {
            res.push({ letter: tile.getAttribute('data'), color: 'grey-overlay' });
        });

        // rohelised
        res.forEach((g, i) => {
            if (g.letter === wordle[i]) {
                g.color = 'green-overlay';
                check = check.replace(g.letter, '');
            }
        });

        // kollased
        res.forEach(g => {
            if (g.color === 'green-overlay') return;
            if (check.includes(g.letter)) {
                g.color = 'yellow-overlay';
                check = check.replace(g.letter, '');
            }
        });

        tiles.forEach((tile, i) => {
            setTimeout(() => {
                tile.classList.add('flip');
                setTimeout(() => {
                    tile.classList.add(res[i].color);
                    addColorToKey(res[i].letter, res[i].color);
                }, 200);
            }, 250 * i);
        });
    }

    function handlePhysicalKeyboard(e) {
        if (isGameOver) return;

        if (e.key === 'Backspace') return handleKey('⌫');
        if (e.key === 'Enter') return handleKey('ENTER');

        const up = e.key.toUpperCase();
        if (up.length !== 1) return;
        if (ALLOWED.includes(up)) handleKey(up);
    }

    function restart() {
        clearUI();
        guessRows.forEach(r => r.fill(''));
        currentRow = 0;
        currentTile = 0;
        isGameOver = false;
        wordle = WORDS[Math.floor(Math.random() * WORDS.length)];
        buildBoard();
        buildKeyboard();
    }

    restartBtn.addEventListener('click', restart);
    window.addEventListener('keydown', handlePhysicalKeyboard);

    restart();
})();
