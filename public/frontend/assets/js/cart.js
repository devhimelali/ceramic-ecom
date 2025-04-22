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

function formatVariationString(variants) {
    return Object.keys(variants)
        .sort()
        .map((key) => `${key}: ${variants[key]}`)
        .join(" / ");
}
function normalizeVariation(variationString) {
    return variationString
        .split(" / ")
        .map((pair) => pair.trim())
        .sort()
        .join(" / ");
}

// Add item to cart
function addItem(id, name, price, quantity = 1, image = "", variation) {
    const normalizedVariation = normalizeVariation(variation);
    console.log(normalizedVariation);
    let existingItem = cart.find(
        (item) =>
            item.id === id &&
            normalizeVariation(item.variation) === normalizedVariation
    );

    if (existingItem) {
        existingItem.quantity += Number(quantity);
    } else {
        cart.push({
            id: id,
            name: name,
            price: parseFloat(price),
            quantity: Number(quantity),
            image: image,
            variation: normalizedVariation,
        });
    }

    saveCart();
}

// Remove item from cart
function removeCartItem(id, variation) {
    cart = cart.filter(
        (item) => !(item.id === id && item.variation === variation)
    );
    saveCart();
    displayCartItems();
}

// Update item quantity
function updateQuantity(id, quantity) {
    let existingItem = cart.find((item) => item.id === id);
    if (existingItem) {
        let newQuantity = existingItem.quantity + Number(quantity);
        if (newQuantity < 1) {
            removeCartItem(id, variation);
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

function displayCartItems() {
    let cartItemsContainer = document.querySelector(
        ".offcanvas__cart-products"
    );
    let subtotalContainer = document.querySelector(".offcanvas__total-price");
    let cartEmptyContainer = document.querySelector(
        ".offcanvas__cart-empty-container"
    );
    let cartBottomContainer = document.querySelector(".offcanvas__bottom");

    if (
        !cartItemsContainer ||
        !subtotalContainer ||
        !cartEmptyContainer ||
        !cartBottomContainer
    )
        return;

    cartItemsContainer.innerHTML = "";
    let subtotal = 0;

    if (cart.length === 0) {
        // Show empty cart UI
        cartEmptyContainer.style.display = "block";
        cartItemsContainer.style.display = "none";
        subtotalContainer.style.display = "none";
        cartBottomContainer.style.display = "none";
        return;
    } else {
        // Show cart items UI
        cartEmptyContainer.style.display = "none";
        cartItemsContainer.style.display = "block";
        subtotalContainer.style.display = "block";
        cartBottomContainer.style.display = "block";
    }

    cart.forEach((item) => {
        let cartItem = document.createElement("div");
        cartItem.classList.add("offcanvas__cart-product");
        cartItem.innerHTML = `
            <div class="offcanvas__cart-product__content__wrapper">
                <div class="offcanvas__cart-product__image">
                    <img src="${item.image}" alt="${item.name}">
                </div>
                <div class="offcanvas__cart-product__content">
                    <h3 class="offcanvas__cart-product__title">
                        <a href="javascript:void(0);" title="${item.name}">
                            ${
                                item.name.length > 20
                                    ? item.name.substring(0, 20) + "..."
                                    : item.name
                            }
                        </a>
                    </h3>
                    <div class="offcanvas__cart-product__variation"><span class="variation-item">${
                        item.variation
                    }</span></div>
                </div>
            </div>
            <div class="offcanvas__cart-product__remove">
                <a href="javascript:void(0);" class="offcanvas__cart-product__remove remove-item"
                data-variation="${item.variation}" data-id="${item.id}">
                    <i class="fas fa-times"></i>
                </a>
                <span class="offcanvas__cart-product__quantity">${
                    item.quantity
                } x $${parseFloat(item.price).toFixed(2)}</span>
            </div>
        `;
        cartItemsContainer.appendChild(cartItem);
        subtotal += item.quantity * parseFloat(item.price);
    });

    subtotalContainer.textContent = `$${subtotal.toFixed(2)}`;

    document.querySelectorAll(".remove-item").forEach((button) => {
        button.addEventListener("click", function (e) {
            e.preventDefault();
            removeCartItem(this.dataset.id, this.dataset.variation);
        });
    });
}

// Load cart on page load
displayCartItems();
