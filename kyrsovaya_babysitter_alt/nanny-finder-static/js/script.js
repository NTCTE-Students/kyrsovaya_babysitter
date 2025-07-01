document.addEventListener('DOMContentLoaded', function() {
    // Простая функция для имитации фильтрации
    document.querySelector('.filter-form button').addEventListener('click', function(e) {
        e.preventDefault();
        alert('Фильтры применены! В реальном приложении здесь будет загрузка данных с сервера.');
    });
    
    // Имитация загрузки данных
    console.log('Сайт загружен. Готов к работе!');
    
    // Можно добавить больше интерактивности
    const nannyCards = document.querySelectorAll('.card');
    nannyCards.forEach(card => {
        card.addEventListener('click', function() {
            // В реальном приложении здесь будет переход на страницу няни
            console.log('Переход на страницу няни');
        });
    });
});