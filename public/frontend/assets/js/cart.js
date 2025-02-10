// Save cart to localStorage (debounced)
function saveCart() {
    if (cart.length > 0) {
        localStorage.setItem("cart", JSON.stringify(cart));
    } else {
        localStorage.removeItem("cart");
    }
}

// Add item to cart
function addItem(id, name, price, quantity = 1) {
    let existingItem = cart.find(item => item.id === id);
    if(existingItem) {
        existingItem.quantity += quantity;
    } else {
        cart.push({id: id, name: name, price: price, quantity: quantity});
    }
    saveCart();
}

// Remove item form cart
function removeItem(id) {
    cart = cart.filter(item => item.id !== id);
    saveCart();
}

// Update item quantity
function updateQuantity(id, quantity) {
    if (quantity < 1) {
        removeItem(id); // If quantity is zero or negative, remove item
    } else {
        let existingItem = cart.find(item => item.id === id);
        if (existingItem) {
            existingItem.quantity = quantity;
        }
    }
    saveCart();
}

// Get total price
function getTotalPrice() {
    return cart.reduce((total, item) => total + item.price * item.quantity, 0);
}

// Get cart items
function getCartItems() {
    return cart;
}

// Clear cart
function clearCart() {
    cart = [];
    saveCart();
}

getTotalQuantity = () => cart.reduce((total, item) => total + item.quantity, 0);

// Initialize cart
let cart = JSON.parse(localStorage.getItem("cart")) || [];

// Display cart items
function displayCartItems() {
    let cartItemsContainer = document.getElementById("cart-items");
    if (!cartItemsContainer) return;

    cartItemsContainer.innerHTML = "";
    cart.forEach(item => {
        let cartItem = document.createElement("div");
        cartItem.classList.add("cart-item");
        cartItem.innerHTML = `
            <div class="cart-item__name">${item.name}</div>
            <div class="cart-item__quantity">${item.quantity}</div>
            <div class="cart-item__price">$${item.price.toFixed(2)}</div>
        `;
        cartItemsContainer.appendChild(cartItem);
    });
}