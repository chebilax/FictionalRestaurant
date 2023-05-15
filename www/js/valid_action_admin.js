'use strict';

function confirmDeleteProduct(event) {
    const deleteUrl = event.currentTarget.getAttribute('href');
    const confirmation = confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');
    if (confirmation) {
        window.location.href = deleteUrl;
    }
    else
    {
        event.preventDefault();
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const deleteButtons = document.querySelectorAll('.deleteProductButton');
    
    deleteButtons.forEach((deleteButton) => {
        deleteButton.addEventListener('click', confirmDeleteProduct);
    });
});
