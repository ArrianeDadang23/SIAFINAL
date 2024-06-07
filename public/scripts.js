document.addEventListener('DOMContentLoaded', function() {
    fetch('/all-data')
        .then(response => response.json())
        .then(data => {
            // Populate weather data
            const weatherData = data.weather;
            document.getElementById('weather-data').innerText = `
                Temperature: ${weatherData.current.temperature}°C
                Description: ${weatherData.current.weather.description}
            `;

            // Populate news data
            const newsData = data.news.articles;
            const newsContainer = document.getElementById('news-data');
            newsData.forEach(article => {
                const newsItem = document.createElement('div');
                newsItem.innerHTML = `<h3>${article.title}</h3><p>${article.description}</p>`;
                newsContainer.appendChild(newsItem);
            });

            // Populate quote data
            const quoteData = data.quote;
            document.getElementById('quote-data').innerText = `
                "${quoteData.quote}" - ${quoteData.author}
            `;
        })
        .catch(error => console.error('Error fetching data:', error));
});
