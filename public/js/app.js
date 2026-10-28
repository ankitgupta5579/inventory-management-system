// Add a new item row by copying the <template>
function addRow() {
    const template = document.getElementById('row-template');
    const clone = template.content.cloneNode(true);
    document.getElementById('items-body').appendChild(clone);
}

// Remove a row, then recalculate the total
function removeRow(button) {
    button.closest('tr').remove();
    calculateTotal();
}

// Total = sum of (quantity x price) of every row
function calculateTotal() {
    let total = 0;
    document.querySelectorAll('#items-body tr').forEach(row => {
        const qty = parseFloat(row.querySelector('.qty').value) || 0;
        const price = parseFloat(row.querySelector('.price').value) || 0;
        const subtotal = qty * price;
        row.querySelector('.subtotal').textContent = subtotal.toFixed(2);
        total += subtotal;
    });
    document.getElementById('grand-total').textContent = total.toFixed(2);
}

// When a product is selected, fill in its price automatically
function fillPrice(select) {
    const price = select.options[select.selectedIndex].dataset.price || 0;
    select.closest('tr').querySelector('.price').value = price;
    calculateTotal();
}