// dark-mode.js
const toggleButton = document.getElementById('toggle-theme');
const body = document.body;

// Проверка сохранённой темы
if (localStorage.getItem('theme') === 'dark') {
    body.classList.add('dark-theme');
}

// При клике — переключаем тему
toggleButton.addEventListener('click', () => {
    body.classList.toggle('dark-theme');

    // Сохраняем выбор
    if (body.classList.contains('dark-theme')) {
        localStorage.setItem('theme', 'dark');
    } else {
        localStorage.removeItem('theme');
    }
});
