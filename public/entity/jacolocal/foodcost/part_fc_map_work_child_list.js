document.addEventListener('DOMContentLoaded', function () {
    const childListBody = document.getElementById('child-list-body');

    document.addEventListener('menuItemSelected', function (e) {
        console.log('menuItemSelected event received in child list:', e.detail);
        const menuId = e.detail.menuId;
        if (menuId) {
            fetchIngredients(menuId);
        }
    });

    function fetchIngredients(menuId) {
        childListBody.innerHTML = '<p>Loading ingredients...</p>';
        const url = `ajax_get_ingredients.php?menu_item_id=${menuId}`;

        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                renderIngredients(data);
            })
            .catch(error => {
                console.error('Error fetching ingredients:', error);
                childListBody.innerHTML = `<p class="wd-alert wd-alert-danger">Failed to load ingredients. ${error.message}</p>`;
            });
    }

    function renderIngredients(ingredients) {
        childListBody.innerHTML = '';

        if (!ingredients || ingredients.length === 0) {
            childListBody.innerHTML = '<p class="wd-placeholder-text">No ingredients found for this item.</p>';
            return;
        }

        ingredients.forEach(item => {
            const extendedCost = (parseFloat(item.amount) * parseFloat(item.cost_per_uom)).toFixed(2);
            const row = document.createElement('div');
            row.className = 'child-list-item';
            row.innerHTML = `
                <div class="item-data">${item.commodity_name}</div>
                <div class="item-data">${item.amount}</div>
                <div class="item-data">${item.uom}</div>
                <div class="item-data">${item.cost_per_uom}</div>
                <div class="item-data">${extendedCost}</div>
                <div class="item-actions">
                    <button class="wd-button-small wd-button-edit" data-id="${item.id}">Edit</button>
                    <button class="wd-button-small wd-button-delete" data-id="${item.id}">Delete</button>
                </div>
            `;
            childListBody.appendChild(row);
        });
    }
});
