// // Save cart to localStorage (debounced)
// function saveCart() {
//     if (cart.length > 0) {
//         localStorage.setItem("cart", JSON.stringify(cart));
//     } else {
//         localStorage.removeItem("cart");
//     }
// }

// // Add item to cart
// function addItem(id, name, price, quantity = 1, image = '', variation = []) {
//     let existingItem = cart.find(item => item.id === id);
//     if(existingItem) {
//        existingItem.quantity +=  Number(quantity);
//     } else {
//         cart.push({id: id, name: name, price: price, quantity: quantity, image: image, variation: variation});
//     }
//     saveCart();
// }

// // Remove item form cart
// function removeItem(id) {
//     cart = cart.filter(item => item.id !== id);
//     saveCart();
// }

// // Update item quantity
// function updateQuantity(id, quantity) {
//     if (quantity < 1) {
//         removeItem(id); // If quantity is zero or negative, remove item
//     } else {
//         let existingItem = cart.find(item => item.id === id);
//         if (existingItem) {
//             existingItem.quantity = Number(quantity);
//         }
//     }
//     saveCart();
// }

// // Get total price
// function getTotalPrice() {
//     return cart.reduce((total, item) => total + item.price * item.quantity, 0);
// }

// // Get cart items
// function getCartItems() {
//     return cart;
// }

// // Clear cart
// function clearCart() {
//     cart = [];
//     saveCart();
// }

// getTotalQuantity = () => cart.reduce((total, item) => total + Number(item.quantity), 0);


// // Initialize cart
// let cart = JSON.parse(localStorage.getItem("cart")) || [];


// function displayCartItems() {
//     let cartItemsContainer = document.querySelector(".offcanvas__cart-products");
//     let subtotalContainer = document.querySelector(".offcanvas__total-price");
    
//     if (!cartItemsContainer || !subtotalContainer) return;

//     cartItemsContainer.innerHTML = "";
//     let subtotal = 0;

//     cart.forEach(item => {
//         let cartItem = document.createElement("div");
//         cartItem.classList.add("offcanvas__cart-product");

//         let variationHTML = "";
//         if (item.variation && typeof item.variation === "object") {
//             variationHTML = Object.entries(item.variation)
//                 .map(([key, value]) => `<span class="variation-item"> ${value}</span>`)
//                 .join("/");
//         } else {
//             variationHTML = "Default";
//         }


//         cartItem.innerHTML = `
//             <div class="offcanvas__cart-product__content__wrapper">
//                 <div class="offcanvas__cart-product__image">
//                     <img src="${item.image}" alt="${item.name}">
//                 </div>
//                 <div class="offcanvas__cart-product__content">
//                     <h3 class="offcanvas__cart-product__title">
//                         <a href="product-details.html">${item.name}</a>
//                     </h3>
//                     <div class="offcanvas__cart-product__variation">${variationHTML}</div>
//                 </div>
//             </div>
//             <div class="offcanvas__cart-product__remove">
//                 <a href="javascript:void(0);" class="offcanvas__cart-product__remove remove-item" data-id="${item.id}">
//                     <i class="fas fa-times"></i>
//                 </a>
//                 <span class="offcanvas__cart-product__quantity">${item.quantity} x $${parseFloat(item.price).toFixed(2)}</span>
//             </div>
//         `;
//         cartItemsContainer.appendChild(cartItem);
//         subtotal += item.quantity * parseFloat(item.price);
//     });

//     subtotalContainer.textContent = `$${subtotal.toFixed(2)}`;
    
//     // Attach event listeners to remove buttons
//     document.querySelectorAll(".remove-item").forEach(button => {
//         button.addEventListener("click", function (e) {
//             e.preventDefault();
//             removeCartItem(this.dataset.id);
//         });
//     });
// }

// function removeCartItem(itemId) {
//     // Find the index of the item to remove
//     let itemIndex = cart.findIndex(item => item.id == itemId);

//     if (itemIndex !== -1) {
//         // Remove item from the cart array
//         cart.splice(itemIndex, 1);
        
//         // Update local storage if you're using it
//         localStorage.setItem("cart", JSON.stringify(cart));

//         // Refresh the cart display
//         displayCartItems();
//         getTotalQuantity();
//     }
// }

// Initialize cart from localStorage
let cart = JSON.parse(localStorage.getItem("cart")) || [];

// Save cart to localStorage
function saveCart() {
    if (cart.length > 0) {
        localStorage.setItem("cart", JSON.stringify(cart));
    } else {
        localStorage.removeItem("cart");
    }
}

// Add item to cart
function addItem(id, name, price, quantity = 1, image = '', variation = {}) {
    let existingItem = cart.find(item => item.id === id);
    if (existingItem) {
        existingItem.quantity += Number(quantity);
    } else {
        cart.push({
            id: id,
            name: name,
            price: parseFloat(price),
            quantity: Number(quantity),
            image: image,
            variation: variation
        });
    }
    saveCart();
}

// Remove item from cart
function removeCartItem(id) {
    cart = cart.filter(item => item.id !== id);
    saveCart();
    displayCartItems();
}

// Update item quantity
function updateQuantity(id, quantity) {
    let existingItem = cart.find(item => item.id === id);

    if (existingItem) {
        let newQuantity = existingItem.quantity + Number(quantity);

        if (newQuantity < 1) {
            removeCartItem(id);
        } else {
            existingItem.quantity = newQuantity;
        }
    }
    saveCart();
}

// Get total price
function getTotalPrice() {
    return cart.reduce((total, item) => total + item.price * item.quantity, 0);
}

// Get total quantity
function getTotalQuantity() {
    return cart.reduce((total, item) => total + Number(item.quantity), 0);
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

// Display cart items
function displayCartItems() {
    let cartItemsContainer = document.querySelector(".offcanvas__cart-products");
    let subtotalContainer = document.querySelector(".offcanvas__total-price");

    if (!cartItemsContainer || !subtotalContainer) return;

    cartItemsContainer.innerHTML = "";
    let subtotal = 0;

    cart.forEach(item => {
        let variationHTML = Object.entries(item.variation)
            .map(([key, value]) => `<span class="variation-item">${key}: ${value}</span>`)
            .join(" / ") || "Default";

        let cartItem = document.createElement("div");
        cartItem.classList.add("offcanvas__cart-product");
        cartItem.innerHTML = `
            <div class="offcanvas__cart-product__content__wrapper">
                <div class="offcanvas__cart-product__image">
                    <img src="${item.image}" alt="${item.name}">
                </div>
                <div class="offcanvas__cart-product__content">
                    <h3 class="offcanvas__cart-product__title">
                        <a href="javascript:void(0);">${item.name}</a>
                    </h3>
                    <div class="offcanvas__cart-product__variation">${variationHTML}</div>
                </div>
            </div>
            <div class="offcanvas__cart-product__remove">
                <a href="javascript:void(0);" class="offcanvas__cart-product__remove remove-item" data-id="${item.id}">
                    <i class="fas fa-times"></i>
                </a>
                <span class="offcanvas__cart-product__quantity">${item.quantity} x $${parseFloat(item.price).toFixed(2)}</span>
            </div>
        `;
        cartItemsContainer.appendChild(cartItem);
        subtotal += item.quantity * parseFloat(item.price);
    });

    subtotalContainer.textContent = `$${subtotal.toFixed(2)}`;

    document.querySelectorAll(".remove-item").forEach(button => {
        button.addEventListener("click", function (e) {
            e.preventDefault();
            removeCartItem(this.dataset.id);
        });
    });
}

// Load cart on page load
displayCartItems();
