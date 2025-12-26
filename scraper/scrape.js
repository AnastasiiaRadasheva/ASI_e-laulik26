const axios = require("axios");
const cheerio = require("cheerio");
const fs = require("fs");
const path = require("path");

async function scrape() {
    try {
        const url = "https://www.err.ee/kultuur";
        const response = await axios.get(url);
        const $ = cheerio.load(response.data);

        let news = [];

        // новый селектор для текущей разметки ERR
        $(".list-item__content a").slice(0, 5).each((i, el) => {
            news.push({
                title: $(el).text().trim(),
                link: "https://www.err.ee" + $(el).attr("href"),
                source: "ERR Kultuur"
            });
        });

        const dataDir = path.join(__dirname, "../data");
        if (!fs.existsSync(dataDir)) fs.mkdirSync(dataDir);

        const filePath = path.join(dataDir, "news.json");
        fs.writeFileSync(filePath, JSON.stringify(news, null, 2), "utf-8");

        console.log("Uudised uuendatud:", news);
    } catch (err) {
        console.error("Error:", err.message);
    }
}

scrape();
