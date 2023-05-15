'use strict';

let total = 0;
let cart = document.getElementById('cart');


function loadDetails() {
    let productId = this.value;
    let url = `index.php?page=order&action=ajax&product_id=${productId}`;
    let xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
          affDetails(JSON.parse(xhr.responseText));
        }
      };
      xhr.send();
    }
    
function affDetails(product) {
    console.log(product);
    let productDescription = document.querySelector('#product_description');
    let productPrice = document.querySelector('#product_price');
    let productImage = document.querySelector('#product_image');
    
    productDescription.textContent = product.description;
    productPrice.textContent = `Prix : ${product.price} €`;
    productImage.innerHTML = `<img src="www/img/products/${product.image}" alt="Product Image" width="240px">`;
    document.getElementById('addCart').style.display = 'inline-block';
  }

function addToCart(event) {
    event.preventDefault();
    let productCode = document.querySelector('#products').value;
    let productName = document.querySelector('#products option:checked').getAttribute('data-name');
    let productPrice = parseFloat(document.querySelector('#product_price').textContent.split(' ')[2]);
    let productQuantity = parseInt(document.querySelector('#quantity').value);

    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let productAlreadyInCart = false;
    for (let i = 0; i < cart.length; i++) {
        if (cart[i].id === productCode) {
            cart[i].quantity += productQuantity;
            productAlreadyInCart = true;
        }
    }
    if (!productAlreadyInCart) {
        cart.push({ id: productCode, name: productName, price: productPrice, quantity: productQuantity });
    }
    localStorage.setItem('cart', JSON.stringify(cart));
    afficherPanier();
}

function afficherPanier() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let tableHtml = `
        <fieldset>
          <legend>Récapitulatif de votre commande</legend>
          <table>
            <thead>
              <tr>
                <th>Quantité</th>
                <th>Produit</th>
                <th>Prix Unitaire</th>
                <th>Prix Total</th>
              </tr>
            </thead>
            <tbody>
      `;
    
    total = 0;
    
    for (let i = 0; i < cart.length; i++) {
    let product = cart[i];
    let prixTotal = product.price * product.quantity;
    total += prixTotal;
    
    if (product.quantity > 0) {
    tableHtml += `
        <tr>
          <td>
            <button onclick="updateQuantity(${i}, -1)">-</button>
            ${product.quantity}
            <button onclick="updateQuantity(${i}, 1)">+</button>
          </td>
          <td>${product.name}</td>
          <td>${product.price} €</td>
          <td>${prixTotal} €</td>
        </tr>
      `;
    } else {
        cart.splice(i, 1);
        localStorage.setItem('cart', JSON.stringify(cart));
        i--;
    }
    }
    
    tableHtml += `
        <tr>
          <td colspan="3">Total :</td>
          <td id="total">${total} €</td>
        </tr>
      </tbody>
    </table>
    </fieldset>
    <button type="submit" id="validCart">Valider la commande</button>
    `;
    
    let panierHtml = document.querySelector('#cart');
    panierHtml.innerHTML = tableHtml;
}
    
function updateQuantity(index, quantity) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let product = cart[index];
    let newQuantity = product.quantity + quantity;

    if (newQuantity <= 0) {
        removeProduct(index);
    } else {
        product.quantity = newQuantity;
        localStorage.setItem('cart', JSON.stringify(cart));
        afficherPanier();
    }
}

function removeProduct(index) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart.splice(index, 1);
    localStorage.setItem('cart', JSON.stringify(cart));
    afficherPanier();
}

function passerCommande(event) {
  event.preventDefault();
  let cart = JSON.parse(localStorage.getItem('cart')) || [];
  console.log(total);
  let params = 'index.php?action=cmdajax&total=' + total + '&commande=' + JSON.stringify(cart);
  
  // Appel Ajax pour enregistrer la commande dans la base de données
  let xhr = new XMLHttpRequest();
  xhr.open('GET', params, true);
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhr.onload = function() {
    if (xhr.status === 200) {
      let message = xhr.responseText;
      validOrder(message);
      alert('Votre commande a été enregistrée avec succès !');
      // window.location.href = 'index.php';
    } else {
      console.log(xhr.responseText);
      alert('Une erreur est survenue lors de l\'enregistrement de votre commande. Veuillez réessayer plus tard.');
    }
  };
  xhr.send();
}

function validOrder(message) {
  // Réinitialisation du tableau global
  cart = [];

  // Vidage du localStorage
  localStorage.removeItem('cart');

  // Mise à jour de l'affichage du panier
  afficherPanier();
}


    
document.addEventListener('DOMContentLoaded', () => {
    let productsSelect = document.querySelector('#products');
    let addCartButton = document.querySelector('#addCart');
    let cartContainer = document.querySelector('#cart');
    
    productsSelect.addEventListener('change', loadDetails);
    addCartButton.addEventListener('click', addToCart);
    afficherPanier();
    document.querySelector('#cart').addEventListener('click', function(event) {
    if (event.target && event.target.id === 'validCart') {
        passerCommande(event);
    }
});

});
