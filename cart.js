// cart.js

// Utility to fetch and save cart in localStorage
function getCart() {
    try {
        return JSON.parse(localStorage.getItem("cart")) || [];
    } catch {
        return [];
    }
}


function setCart(cart) {
    localStorage.setItem("cart", JSON.stringify(cart));
}

// Update Cart Badge
function updateBadge() {
    const badge = document.getElementById('cart-badge');
    const cart = getCart();
    const qty = cart.reduce((sum, item) => sum + (item.quantity || 1), 0);
    if (badge) {
        badge.innerText = qty;
        badge.style.display = qty ? 'flex' : 'none';
    }
}

// Render Cart Sidebar
function updateCart() {
    const cart = getCart();
    const cartItems = document.querySelector(".cart-items");
    const totalPrice = document.getElementById("cart-total-price");
    if (!cartItems || !totalPrice) return;

    cartItems.innerHTML = "";
    let total = 0;

    cart.forEach((item, index) => {
        total += item.price * (item.quantity || 1);
        const li = document.createElement("li");
        li.style.display = "flex";
        li.style.alignItems = "center";
        li.style.justifyContent = "space-between";
        li.style.marginBottom = "8px";
        li.style.borderBottom = "1px solid #eee";
        li.style.paddingBottom = "6px";
        li.innerHTML = `
            <span style="flex:1; font-weight:bold;">${item.name}</span>
            <span style="flex:0 0 40px; text-align:center;">(x${item.quantity || 1})</span>
            <span style="flex:0 0 60px; text-align:right;">Rs.${(item.price * (item.quantity || 1)).toFixed(2)}</span>
            <button data-index="${index}" class="remove-btn" style="background:none; border:none; color:#d84646; font-size:1.2em; cursor:pointer; margin-left:10px;" aria-label="Remove item">❌</button>
        `;
        cartItems.appendChild(li);
    });

    totalPrice.textContent = `Rs.${total.toFixed(2)}`;
    setCart(cart);
    updateBadge();
}

// Setup cracker fire animation container and styles
(function setupFirecracker(){
    const style = document.createElement('style');
    style.textContent = `
    #cracker-fire {
        position: fixed;
        top: 50%;
        left: 50%;
        width: 250px;
        height: 250px;
        pointer-events: none;
        transform: translate(-50%, -50%);
        z-index: 10000;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .cracker-circle {
        position: absolute;
        border-radius: 50%;
        background-color: #ffcc00;
        box-shadow: 0 0 10px 5px #ffcc00;
        opacity: 0.8;
        animation: explode 1s ease-out forwards;
    }
    @keyframes explode {
        0% { transform: scale(0); opacity: 0.8; }
        100% { transform: scale(1.5); opacity: 0; }
    }
    `;
    document.head.appendChild(style);

    const fireContainer = document.createElement('div');
    fireContainer.id = 'cracker-fire';
    document.body.appendChild(fireContainer);

    window.showCrackerFire = function() {
        fireContainer.innerHTML = '';
        fireContainer.style.opacity = '1';
        for(let i=0; i<8; i++) {
            const circle = document.createElement('div');
            circle.className = 'cracker-circle';
            circle.style.top = '50%';
            circle.style.left = '50%';
            const x = (Math.random() - 0.5) * 200;
            const y = (Math.random() - 0.5) * 200;
            circle.style.transformOrigin = 'center';
            circle.style.animationName = 'explode';
            circle.style.animationDuration = '1s';
            circle.style.animationTimingFunction = 'ease-out';
            circle.style.transform = `translate(${x}px, ${y}px) scale(0)`;
            fireContainer.appendChild(circle);
        }
        setTimeout(() => {
            fireContainer.style.opacity = '0';
            fireContainer.innerHTML = '';
        }, 1200);
    };
})();

// Event listeners for add/remove items and Checkout button
document.addEventListener('click', function(e) {
    let cart = getCart();

    if(e.target.classList.contains('add-to-cart')) {
        const btn = e.target;
        const name = btn.getAttribute('data-item') || btn.getAttribute('data-name');
        const price = parseFloat(btn.getAttribute('data-price'));
        const card = btn.closest('.card, .burger-box, .menu-item');
        const img = card?.querySelector('img')?.src || '';

        const existing = cart.find(i => i.name === name);
        if(existing) {
            existing.quantity = (existing.quantity || 1) + 1;
        } else {
            cart.push({name, price, img, quantity: 1});
        }
        setCart(cart);
        updateCart();
        updateBadge();
    }

    if(e.target.classList.contains('remove-btn')) {
        const index = parseInt(e.target.getAttribute('data-index'));
        if(!isNaN(index)) {
            cart.splice(index, 1);
            setCart(cart);
            updateCart();
            updateBadge();
        }
    }

    if(e.target.classList.contains('checkout-btn')) {
        if(cart.length === 0) {
            alert('Your cart is empty!');
            return;
        }
        alert('Order placed successfully!');
        setTimeout(() => {
          window.showCrackerFire();
        }, 100); // Delay to allow alert to close first
        cart = [];
        setCart(cart);
        updateCart();
        updateBadge();
        const sidebar = document.getElementById('cart-sidebar');
        if(sidebar) sidebar.classList.remove('open');
    }
});

// Sidebar toggle and other UI handlers
document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.getElementById('cart-sidebar');
    const toggleBtn = document.getElementById('cart-toggle');
    const closeBtn = document.getElementById('close-cart');

    updateCart();
    updateBadge();

    if(toggleBtn) {
        toggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            sidebar.classList.toggle('open');
        });
    }

    if(closeBtn) {
        closeBtn.addEventListener('click', function() {
            sidebar.classList.remove('open');
        });
    }

    window.addEventListener('click', function(e) {
        if(sidebar.classList.contains('open') &&
           !sidebar.contains(e.target) &&
           e.target !== toggleBtn &&
           !toggleBtn.contains(e.target)) {
            sidebar.classList.remove('open');
        }
    });

    window.addEventListener('storage', function() {
        updateCart();
        updateBadge();
    });
    // MOBILE MENU TOGGLE
document.addEventListener("DOMContentLoaded", function () {
  const menuBtn = document.getElementById("menu-toggle");
  const navMenu = document.getElementById("nav-menu");

  if (menuBtn) {
    menuBtn.addEventListener("click", function () {
      navMenu.classList.toggle("show");
    });
  }
});
});
