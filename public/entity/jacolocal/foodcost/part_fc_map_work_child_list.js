// Add a global flag to prevent multiple script executions
if (!window.childListScriptLoaded) {
    window.childListScriptLoaded = true;

    document.addEventListener('DOMContentLoaded', function () {
        const childListBody = document.getElementById('child-list-body');
        const addIngredientBtn = document.getElementById('add-ingredient-btn');
        const ingredientSummary = document.getElementById('ingredient-summary');

        // Exit if the required elements for this script are not on the page
        if (!childListBody || !addIngredientBtn || !ingredientSummary) {
            return;
        }

        let currentMenuId = null;
        let currentMenuPrice = 0;
        let commodities = null; // Will be an array of objects [{id, name}]
        let addIngredientListenerAttached = false; // Flag to prevent multiple listeners

        document.addEventListener('menuItemSelected', function (e) {
            currentMenuId = e.detail.menuId;
            // Directly get the price from the event detail, ensuring it's a number
            currentMenuPrice = parseFloat(e.detail.menuPrice) || 0;

            if (currentMenuId) {
                fetchIngredients(currentMenuId);
                addIngredientBtn.style.display = 'block';
                if (!commodities) { // Fetch only if not already loaded
                    fetchCommodities();
                }
            } else {
                addIngredientBtn.style.display = 'none';
                childListBody.innerHTML = '<p class="wd-placeholder-text">Select a menu item to see its ingredients.</p>';
                currentMenuPrice = 0; // Reset price
                updateIngredientSummary(); // Clear summary
            }
        });

        function fetchCommodities() {
            fetch('ajax_get_commodities.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Assuming data.commodities is an array of objects [{id, name}]
                        commodities = data.commodities;
                        // Attach the listener only after commodities are successfully fetched
                        if (!addIngredientListenerAttached) {
                            addIngredientBtn.addEventListener('click', handleAddIngredientClick);
                            addIngredientListenerAttached = true;
                        }
                    } else {
                        console.error('Failed to fetch commodities');
                    }
                })
                .catch(error => console.error('Error fetching commodities:', error));
        }

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
                updateIngredientSummary(); // Update summary even if no ingredients
                return;
            }

            ingredients.forEach(item => {
                const row = createIngredientRow(item);
                childListBody.appendChild(row);
            });
            updateIngredientSummary(); // Update summary after rendering
        }

        function createIngredientRow(item) {
            const extendedCost = (parseFloat(item.amount) * parseFloat(item.cost_per_uom)).toFixed(2);
            const row = document.createElement('div');
            row.className = 'child-list-item';
            row.dataset.id = item.id;

            const rowContent = `
                <div class="item-data" data-field="commodity_name">${item.commodity_name}</div>
                <div class="item-data" data-field="amount">${item.amount}</div>
                <div class="item-data" data-field="uom">${item.uom}</div>
                <div class="item-data" data-field="cost_per_uom">${item.cost_per_uom}</div>
                <div class="item-data" data-field="extended_cost">${extendedCost}</div>
                <div class="item-actions">
                    <button class="wd-button-small wd-button-edit" data-id="${item.id}">Edit</button>
                    <button class="wd-button-small wd-button-delete" data-id="${item.id}">Delete</button>
                </div>
            `;
            row.innerHTML = rowContent;
            row.originalHTML = rowContent; // Store original content for cancel
            return row;
        }

        childListBody.addEventListener('click', function(e) {
            if (e.target.classList.contains('wd-button-edit')) {
                handleEditClick(e.target);
            } else if (e.target.classList.contains('wd-button-save')) {
                handleSaveClick(e.target);
            } else if (e.target.classList.contains('wd-button-cancel')) {
                handleCancelClick(e.target);
            } else if (e.target.classList.contains('wd-button-delete')) {
                handleDeleteClick(e.target);
            } else if (e.target.classList.contains('wd-button-save-new')) {
                handleSaveNewClick(e.target);
            } else if (e.target.classList.contains('wd-button-cancel-new')) {
                handleCancelNewClick(e.target);
            }
        });

        childListBody.addEventListener('change', function(e) {
            if (e.target.classList.contains('new-comm-select')) {
                const selectElement = e.target;
                const row = selectElement.closest('.new-ingredient-row');
                const selectedId = selectElement.value;
                const selectedCommodity = commodities.find(c => c.id == selectedId);
                const uomCell = row.querySelector('[data-field="uom"]');
                const costCell = row.querySelector('[data-field="cost_per_uom"]');

                if (selectedCommodity) {
                    uomCell.textContent = selectedCommodity.uom;
                    costCell.textContent = selectedCommodity.cost_per_uom;
                } else {
                    uomCell.textContent = '';
                    costCell.textContent = '';
                }
            }
        });

        // Define the handler for adding an ingredient
        function handleAddIngredientClick() {
            if (!commodities) {
                alert('Commodities not loaded yet. Please wait a moment and try again.');
                return;
            }
            // Check if a new-ingredient-row already exists
            if (childListBody.querySelector('.new-ingredient-row')) {
                return; // Don't add another new row if one is already present
            }
            const newRow = createNewIngredientRow();
            childListBody.prepend(newRow);
        }

        function createNewIngredientRow() {
            const row = document.createElement('div');
            row.className = 'child-list-item new-ingredient-row';

            let options = '<option value="">Select Commodity</option>';
            // Iterate over the array of commodity objects
            commodities.forEach(commodity => {
                options += `<option value="${commodity.id}">${commodity.name}</option>`;
            });

            row.innerHTML = `
                <div class="item-data" data-field="commodity_name">
                    <select class="wd-input-select new-comm-select">${options}</select>
                </div>
                <div class="item-data" data-field="amount"><input type="number" placeholder="Amount" class="wd-input-text" style="width: 80px;"></div>
                <div class="item-data" data-field="uom"></div>
                <div class="item-data" data-field="cost_per_uom"></div>
                <div class="item-data" data-field="extended_cost"></div>
                <div class="item-actions">
                    <button class="wd-button-small wd-button-save-new">Save</button>
                    <button class="wd-button-small wd-button-cancel-new">Cancel</button>
                </div>
            `;

            return row;
        }

        function handleCancelNewClick(cancelButton) {
            const row = cancelButton.closest('.new-ingredient-row');
            row.remove();
        }

        function handleSaveNewClick(saveButton) {
            const row = saveButton.closest('.new-ingredient-row');
            const commSelect = row.querySelector('select');
            const amountInput = row.querySelector('input[type="number"]');

            const commId = commSelect.value;
            const amount = amountInput.value;

            if (!commId || !amount || amount <= 0) {
                alert('Please select a commodity and enter a valid amount.');
                return;
            }

            const data = {
                menu_id: currentMenuId,
                comm_id: commId,
                amount: amount
            };

            fetch('ajax_create_ingredient.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    const newRow = createIngredientRow(result.item);
                    // Use childListBody as the parent to ensure the replacement is safe
                    childListBody.replaceChild(newRow, row);
                    updateIngredientSummary(); // Update summary
                } else {
                    alert('Failed to add ingredient: ' + result.message);
                }
            })
            .catch(error => {
                console.error('Error adding ingredient:', error);
                alert('An error occurred while adding the ingredient.');
            });
        }

        function handleEditClick(editButton) {
            const row = editButton.closest('.child-list-item');
            const id = row.dataset.id;

            const commodityName = row.querySelector('[data-field="commodity_name"]').textContent;
            const amount = row.querySelector('[data-field="amount"]').textContent;
            const uom = row.querySelector('[data-field="uom"]').textContent;
            const costPerUom = row.querySelector('[data-field="cost_per_uom"]').textContent;
            const extendedCost = row.querySelector('[data-field="extended_cost"]').textContent;

            row.innerHTML = `
                <div class="item-data" data-field="commodity_name">${commodityName}</div>
                <div class="item-data" data-field="amount"><input type="number" value="${amount}" class="wd-input-text" style="width: 80px;"></div>
                <div class="item-data" data-field="uom">${uom}</div>
                <div class="item-data" data-field="cost_per_uom">${costPerUom}</div>
                <div class="item-data" data-field="extended_cost">${extendedCost}</div>
                <div class="item-actions">
                    <button class="wd-button-small wd-button-save" data-id="${id}">Save</button>
                    <button class="wd-button-small wd-button-cancel" data-id="${id}">Cancel</button>
                </div>
            `;
        }

        function handleCancelClick(cancelButton) {
            const row = cancelButton.closest('.child-list-item');
            row.innerHTML = row.originalHTML;
        }

        function handleSaveClick(saveButton) {
            const row = saveButton.closest('.child-list-item');
            const id = row.dataset.id;
            const amountInput = row.querySelector('input[type="number"]');
            const newAmount = amountInput.value;

            const data = {
                id: id,
                amount: newAmount
            };

            fetch('ajax_update_ingredient.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                // Check if the response is ok and the content type is JSON
                const contentType = response.headers.get("content-type");
                if (response.ok && contentType && contentType.indexOf("application/json") !== -1) {
                    return response.json();
                }
                // Otherwise, handle as text to see the error message from PHP
                return response.text().then(text => {
                    throw new Error('Server returned non-JSON response:\n' + text);
                });
            })
            .then(result => {
                if (result.success) {
                    const updatedItem = result.item;
                    const newRow = createIngredientRow(updatedItem);
                    row.parentNode.replaceChild(newRow, row);
                    updateIngredientSummary(); // Update summary
                } else {
                    // Use the detailed message from the server's JSON response
                    alert('Failed to save: ' + result.message);
                    row.innerHTML = row.originalHTML; // Revert on failure
                }
            })
            .catch(error => {
                console.error('WD Error saving ingredient:', error);
                // Display the detailed error, which might be the raw HTML from PHP
                alert('An error occurred while saving. Please check the console for details.');
                row.innerHTML = row.originalHTML; // Revert on error
            });
        }

        function handleDeleteClick(deleteButton) {
            const row = deleteButton.closest('.child-list-item');
            const id = row.dataset.id;

            if (confirm('Are you sure you want to delete this ingredient?')) {
                fetch('ajax_delete_ingredient.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: id })
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        row.remove();
                        updateIngredientSummary(); // Update summary
                    } else {
                        alert('Failed to delete: ' + result.message);
                    }
                })
                .catch(error => {
                    console.error('Error deleting ingredient:', error);
                    alert('An error occurred while deleting. Please try again.');
                });
            }
        }

        function updateIngredientSummary() {
            const allRows = childListBody.querySelectorAll('.child-list-item');
            let totalCost = 0;

            allRows.forEach(row => {
                const extendedCostCell = row.querySelector('[data-field="extended_cost"]');
                if (extendedCostCell) {
                    totalCost += parseFloat(extendedCostCell.textContent) || 0;
                }
            });

            let percentage = 0;
            if (currentMenuPrice > 0) {
                percentage = (totalCost / currentMenuPrice) * 100;
            }

            if (totalCost > 0) {
                ingredientSummary.textContent = `Total: ${totalCost.toFixed(2)} (${percentage.toFixed(1)}%)`;
            } else {
                ingredientSummary.textContent = '';
            }
        }
    });
}
