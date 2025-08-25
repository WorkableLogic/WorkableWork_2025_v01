document.addEventListener('DOMContentLoaded', function () {
    const addBtn = document.getElementById('add-ingredient-btn');
    const newCommoditySelect = document.getElementById('new_commodity_id');
    const newAmountInput = document.getElementById('new_amount');
    const ingredientTbody = document.getElementById('ingredient-tbody');
    const recipeForm = document.getElementById('recipe-form');

    // --- Add Ingredient ---
    addBtn.addEventListener('click', function () {
        const selectedOption = newCommoditySelect.options[newCommoditySelect.selectedIndex];
        const amount = newAmountInput.value.trim();

        if (!selectedOption.value || amount === '') {
            alert('Please select an ingredient and enter an amount.');
            return;
        }

        const commId = selectedOption.value;
        const commName = selectedOption.text;
        const commUom = selectedOption.dataset.uom;

        // Hide "no ingredients" row if it exists
        const noIngredientsRow = document.getElementById('no-ingredients-row');
        if (noIngredientsRow) {
            noIngredientsRow.remove();
        }

        // Create new table row
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>
                ${commName}
                <input type="hidden" name="new_comm_ids[]" value="${commId}">
            </td>
            <td class="number">
                <input type="text" name="new_amounts[${commId}]" value="${amount}" class="wd-input-number">
            </td>
            <td>${commUom}</td>
            <td class="actions">
                <button type="button" class="wd-action-btn wd-action-delete" data-tooltip="Delete Ingredient">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </td>
        `;

        ingredientTbody.appendChild(newRow);

        // Remove selected option from dropdown
        selectedOption.remove();

        // Clear input fields
        newCommoditySelect.selectedIndex = 0;
        newAmountInput.value = '';
    });

    // --- Delete Ingredient (Event Delegation) ---
    ingredientTbody.addEventListener('click', function (e) {
        const deleteBtn = e.target.closest('.wd-action-delete');
        if (!deleteBtn) return;

        const rowToDelete = deleteBtn.closest('tr');
        const mapIdInput = rowToDelete.querySelector('input[name="map_ids[]"]');

        // If it's an existing ingredient, mark it for deletion
        if (mapIdInput) {
            const mapId = mapIdInput.value;
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'deleted_map_ids[]';
            hiddenInput.value = mapId;
            recipeForm.appendChild(hiddenInput);
        }

        // Add the ingredient back to the dropdown
        const commId = rowToDelete.dataset.commId;
        const commName = rowToDelete.dataset.commName;
        const commUom = rowToDelete.dataset.uom;

        if (commId && commName) {
             const newOption = new Option(commName, commId);
             newOption.dataset.uom = commUom;
             newCommoditySelect.add(newOption);
        }


        rowToDelete.remove();

        // Show "no ingredients" row if table is empty
        if (ingredientTbody.children.length === 0) {
            const noIngredientsRow = document.createElement('tr');
            noIngredientsRow.id = 'no-ingredients-row';
            noIngredientsRow.innerHTML = '<td colspan="4">This recipe has no ingredients yet.</td>';
            ingredientTbody.appendChild(noIngredientsRow);
        }
    });
});
