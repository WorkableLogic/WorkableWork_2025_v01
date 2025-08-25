document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('menuItemSelected', (event) => {
        const menuId = event.detail.menuId; // Correctly use menuId
        if (menuId) {
            fetchMenuItemDetails(menuId);
        }
    });

    function fetchMenuItemDetails(id) {
        fetch(`ajax_get_menu_item.php?id=${id}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(result => {
                if (result.success) {
                    populateParentForm(result.data);
                } else {
                    console.error('Failed to fetch menu item details:', result.message);
                    alert('Error: Could not load the details for the selected item.');
                }
            })
            .catch(error => {
                console.error('Error fetching menu item details:', error);
                alert('A network error occurred. Please check the console for details.');
            });
    }

    function populateParentForm(item) {
        document.getElementById('fc-menu-id').value = item.id || '';
        document.getElementById('fc-menu-name').value = item.name || '';
        document.getElementById('fc-menu-price').value = item.price || '';
        document.getElementById('fc-menu-type').value = item.typeName || '';
        document.getElementById('fc-menu-page').value = item.pageName || '';
    }
});
