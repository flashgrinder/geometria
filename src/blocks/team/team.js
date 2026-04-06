/**
 * Проверка на мобильное устройство
 */
function isMobile() {
    return window.innerWidth <= 1180;
}

/**
 * Инициализация сетки команды
 */
function initTeamGrid() {
    const gridContainer = document.getElementById('teamGrid');
    
    if (!gridContainer) return;

    const cards = Array.from(gridContainer.querySelectorAll('.team-card'));

    if (cards.length === 0) return;

    // На мобильных не создаем колонки - карточки останутся в контейнере
    if (isMobile()) {
        // Убираем колонки если они были созданы
        const existingColumns = gridContainer.querySelectorAll('.team__column');
        if (existingColumns.length > 0) {
            gridContainer.innerHTML = '';
            cards.forEach(card => gridContainer.appendChild(card));
        }
        return;
    }

    // На десктопе создаем колонки
    const existingColumns = gridContainer.querySelectorAll('.team__column');
    if (existingColumns.length > 0) return; // Колонки уже созданы

    const columnLeft = document.createElement('div');
    columnLeft.classList.add('team__column');
    columnLeft.classList.add('team__column--left');

    const columnRight = document.createElement('div');
    columnRight.classList.add('team__column');
    columnRight.classList.add('team__column--right');

    cards.forEach((card, index) => {
        if (index % 2 === 0) {
            columnLeft.appendChild(card);
        } else {
            columnRight.appendChild(card);
        }
    });

    gridContainer.innerHTML = '';
    gridContainer.appendChild(columnLeft);
    gridContainer.appendChild(columnRight);
}

/**
 * Пересчет при изменении размера окна
 */
let resizeTimeout;
window.addEventListener('resize', () => {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(() => {
        initTeamGrid();
    }, 250);
});

// Инициализация при загрузке
document.addEventListener('DOMContentLoaded', initTeamGrid);