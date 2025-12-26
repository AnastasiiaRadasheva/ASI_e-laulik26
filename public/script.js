fetch("../data/news.json")
    .then(res => res.json())
    .then(data => {
        const list = document.getElementById("news");
        data.forEach(item => {
            const li = document.createElement("li");
            li.textContent = item.title;
            list.appendChild(li);
        });
    });
