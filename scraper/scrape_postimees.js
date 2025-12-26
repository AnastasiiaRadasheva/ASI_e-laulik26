const axios = require("axios");
const cheerio = require("cheerio");
const fs = require("fs");
const path = require("path");

async function scrapePostimeesKultuur() {
    try {
        // URL раздела Kultuur (поддомен kultuur.postimees.ee)
        const url = "https://kultuur.postimees.ee/";
        const response = await axios.get(url);
        const $ = cheerio.load(response.data);

        let news = [];

        // Находим все ссылки внутри заголовков новостей
        $("a").each((i, el) => {
            const title = $(el).text().trim();
            const href = $(el).attr("href");
            if (title && href && href.includes("/")) {
                news.push({
                    title,
                    link: href.startsWith("http") ? href : "https://kultuur.postimees.ee" + href,
                    source: "Postimees Kultuur"
                });
            }
        });

        // Оставляем только первые 10 уникальных записей
        news = news.filter((v, i, a) => a.findIndex(t => t.title === v.title) === i).slice(0, 10);

        if (news.length === 0) {
            console.log("Новости не найдены — возможно селектор требует уточнения.");
            return;
        }

        // Путь к папке data
        const dataDir = path.join(__dirname, "../data");
        if (!fs.existsSync(dataDir)) fs.mkdirSync(dataDir);

        const filePath = path.join(dataDir, "news.json");
        fs.writeFileSync(filePath, JSON.stringify(news, null, 2), "utf-8");

        console.log("Uudised uuendatud:", news);
    } catch (err) {
        console.error("Viga:", err.message);
    }
}

scrapePostimeesKultuur();
