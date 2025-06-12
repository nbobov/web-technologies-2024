if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init)
} else {
    init()
}

function init() {
    initMenu(document.getElementById('list-items'));

    function initMenu(menuContainer) {
        const parents = menuContainer.querySelectorAll('[data-parent]');

        parents.forEach(parent => {
            const open = parent.querySelector('[data-open]');

            if (open) {
                open.addEventListener('click', () => toggleItems(parent));
            }
        });

        function toggleItems(parent) {
            parent.classList.toggle('list-item_open');
        }
    }
}