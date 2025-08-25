document.addEventListener('DOMContentLoaded', function() {
    const menuListContainer = document.getElementById('menu-item-list-container');
    const filterForm = document.getElementById('menu-list-filter-form');

    function fetchMenuList() {
        if (!menuListContainer || !filterForm) {
            console.error("WDError: Could not find required elements: 'menu-item-list-container' or 'menu-list-filter-form'.");
            return;
        }
        menuListContainer.innerHTML = '<p>Loading...</p>';

        const params = new URLSearchParams(new FormData(filterForm));

        fetch(`ajax_get_menu_list.php?${params.toString()}`)
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => { 
                        throw new Error(`Server responded with status ${response.status}: ${text}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                renderMenuList(data);
            })
            .catch(error => {
                console.error('Failed to load menu items:', error);
                if (menuListContainer) {
                    menuListContainer.innerHTML = `<p style="color: red;">Failed to load menu items.</p><p style="font-size: small;">${error.message}</p>`;
                }
            });
    }

    function renderMenuList(items) {
        if (!menuListContainer) return;
        menuListContainer.innerHTML = '';
        if (!items || items.length === 0) {
            menuListContainer.innerHTML = '<p>No menu items found.</p>';
            return;
        }
        items.forEach(item => {
            const div = document.createElement('div');
            div.classList.add('menu-list-item');
            div.dataset.id = item.id;

            // Create a more detailed structure for the list item
            div.innerHTML = `
                <span class="menu-item-type">${item.typeName || ''}</span>
                <span class="menu-item-name">${item.name || ''}</span>
                <span class="menu-item-page">${item.pageName || ''}</span>
            `;

            div.addEventListener('click', () => {
                const event = new CustomEvent('menuItemSelected', { detail: { menuId: item.id } }); // Standardize to menuId
                document.dispatchEvent(event); // Dispatch globally

                document.querySelectorAll('.menu-list-item').forEach(el => el.classList.remove('selected'));
                div.classList.add('selected');
            });
            menuListContainer.appendChild(div);
        });
    }

    function debounce(func, delay) {
        let timeout;
        return function(...args) {
            const context = this;
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(context, args), delay);
        };
    }

    if (filterForm) {
        filterForm.addEventListener('change', fetchMenuList);
        filterForm.addEventListener('keyup', debounce(fetchMenuList, 300));

        // Prevent form submission on Enter key
        filterForm.addEventListener('submit', function(event) {
            event.preventDefault();
        });
    }

    // Initial load
    fetchMenuList();
});
