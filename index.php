<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Coffee Bliss - Shop</title>
  <link rel="icon" href="assets/images/coffee-hero-section.png" type="image/png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Josefin+Sans:wght@700&display=swap" rel="stylesheet" />
  <style>
    :root {
      --primary: #6F4E37;
      --secondary: #fff5ea;
      --accent: #dac2a0;
      --text: #232323;
      --muted: #646464;
      --radius: 15px;
    }
    * {
      box-sizing: border-box;
    }
    body {
      margin: 0;
      font-family: 'Montserrat', sans-serif;
      background: var(--secondary);
      color: var(--text);
      min-height: 100vh;
    }
    header {
      width: 100%;
      background: var(--primary);
      color: #fff;
      box-shadow: 0 2px 12px rgba(0, 0, 0, 0.07);
      position: sticky;
      top: 0;
      left: 0;
      z-index: 30;
    }
    .nav-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 1rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      height: 68px;
    }
    .logo {
      font-family: 'Josefin Sans', serif;
      font-weight: bold;
      font-size: 2.1rem;
      letter-spacing: 2px;
      color: #fff;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    nav ul {
      list-style: none;
      display: flex;
      gap: 1.5rem;
      margin: 0;
      padding: 0;
    }
    nav li a {
      color: #fff;
      text-decoration: none;
      font-size: 1rem;
      opacity: 0.96;
      padding: 2px 5px;
      border-radius: 5px;
      transition: background 0.14s;
    }
    nav li a:hover {
      background: rgba(255, 255, 255, 0.13);
    }
    .nav-right {
      display: flex;
      align-items: center;
      gap: 1.1rem;
    }
    .cart-link {
      color: #fff;
      font-size: 1.5rem;
      position: relative;
      cursor: pointer;
      margin-left: 6px;
      padding: 0 6px;
      border-radius: 6px;
      transition: box-shadow 0.12s;
    }
    .cart-link.active,
    .cart-link:focus {
      box-shadow: 0 2px 8px #dabf8b88;
      background: #fffc;
    }
    .cart-link .cart-badge {
      position: absolute;
      top: -8px;
      right: -5px;
      background: #b84c31;
      color: #fff;
      font-size: 0.77rem;
      border-radius: 50%;
      width: 20px;
      height: 20px;
      display: flex;
      justify-content: center;
      align-items: center;
      font-weight: bold;
      border: 2px solid #fff;
    }
    .signin-link {/* Sign In link */
  color: #fff;
  font-size: 1.25rem;
  display: flex;
  align-items: center;
  gap: 7px;
  padding: 3px 12px;
  border-radius: 7px;
  background: #7a6045;
  text-decoration: none;
  font-weight: 600;
  transition: background 0.18s;
}
.signin-link:hover,
.signin-link:focus {
  background: #a0845a;
  color: #fff;
  text-decoration: none;
}
    .menu-toggle {
      display: none;
      font-size: 2rem;
      cursor: pointer;
      color: #fff;
      background: none;
      border: none;
      margin-left: 20px;
    }
    /* Sidebar Cart */
    .cart-sidebar {
      position: fixed;
      top: 0;
      right: -400px;
      width: 350px;
      max-width: 92vw;
      height: 100%;
      background: #fff;
      box-shadow: -4px 0 16px rgba(40, 19, 0, 0.08);
      z-index: 90;
      transition: right 0.34s cubic-bezier(0.66, 0.05, 0.32, 1.11);
      padding: 30px 21px 22px 21px;
      border-radius: 16px 0 0 16px;
      display: flex;
      flex-direction: column;
      gap: 12px;
    }
    .cart-sidebar.open {
      right: 0;
    }
    .cart-sidebar .close-cart {
      border: none;
      background: none;
      font-size: 2.1rem;
      color: var(--primary);
      position: absolute;
      top: 14px;
      right: 14px;
      cursor: pointer;
    }
    .cart-title {
      font-family: 'Josefin Sans', serif;
      margin: 0 0 10px 0;
      color: var(--primary);
      font-size: 1.33rem;
      font-weight: bold;
    }
    .cart-items {
      flex: 1 1 auto;
      overflow-y: auto;
      padding: 0;
      margin: 12px 0;
      list-style: none;
    }
    .cart-items li {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 14px;
      border-bottom: 1px solid #eee;
      padding-bottom: 9px;
    }
    .cart-items li:last-child {
      border: none;
    }
    .cart-thumb {
      width: 38px;
      height: 38px;
      border-radius: var(--radius);
      object-fit: cover;
      border: 1px solid #f5e9d8;
      background: #f8f2e8;
    }
    .cart-prod-details {
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 1px;
    }
    .cart-prod-name {
      font-weight: bold;
      font-size: 1.04rem;
    }
    .cart-prod-qty {
      color: var(--muted);
      font-size: 0.94rem;
    }
    .cart-remove {
      color: #e95b3a;
      background: transparent;
      border: none;
      font-size: 1.5rem;
      margin-left: 6px;
      cursor: pointer;
    }
    .cart-total {
      display: flex;
      justify-content: space-between;
      font-weight: bold;
      color: var(--primary);
      font-size: 1.08rem;
      padding-top: 7px;
      border-top: 2px solid #f4e6d3;
    }
    .checkout-btn {
      width: 100%;
      background: #27ae60;
      color: #fff;
      border: none;
      border-radius: 7px;
      font-size: 1rem;
      padding: 20px ;
      font-weight: bold;
      margin-top: 12px;
      margin-bottom: 55px;
      cursor: pointer;
      flex-shrink: 0;
    }
    .checkout-btn:hover {
      background: #964e27;
    }
    /* Notification */
    #cart-message-box {
      position: fixed;
      top: 84px;
      right: 24px;
      padding: 14px 26px;
      border-radius: 8px;
      color: #fff;
      background: var(--primary);
      box-shadow: 0 2px 14px #0002;
      font-size: 1rem;
      font-weight: bold;
      z-index: 200;
      display: none;
      animation: fade-popup 2.1s;
    }
    @keyframes fade-popup {
      0% {
        opacity: 0;
        transform: translateY(-12px);
      }
      8% {
        opacity: 1;
        transform: none;
      }
      92% {
        opacity: 1;
      }
      100% {
        opacity: 0;
        transform: translateY(-4px);
      }
    }
    /* Main Layout */
    .hero-section {
      background: linear-gradient(100deg, var(--primary) 50%, #ffeedd 100%);
      min-height: 260px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      text-align: center;
      padding: 25px 0 35px 0;
    }
    .hero-title {
      font-size: 3.2rem;
      font-family: 'Josefin Sans', serif;
      color: #fff;
      letter-spacing: 2px;
      margin: 0;
    }
    .hero-desc {
      color: #ffdabb;
      font-size: 1.1rem;
      margin: 13px 0 0 0;
      font-weight: 500;
    }
    button[name="logout"] {
  color: #fff;                 /* white text */
  border: none;
  padding: 6px 14px;
  border-radius: 6px;
  cursor: pointer;
  font-size: 14px;
  background-color: #5a3d2e;   /* darker brown */
  font-family: 'Segoe UI', Arial, sans-serif;
  transition: background-color 0.3s ease, transform 0.2s ease;
}

button[name="logout"]:hover {
  background-color: #7a6045;   /* lighter brown on hover */
}

button[name="logout"]:active {
  transform: scale(0.95);      /* press effect */
}

    /* Menu section */
    .menu-section {
      max-width: 1200px;
      margin: 0 auto;
      padding: 32px 10px 40px 10px;
    }
    .section-title {
      font-family: 'Josefin Sans', serif;
      color: var(--primary);
      font-size: 2.3rem;
      text-align: center;
      margin-bottom: 29px;
    }
    .menu-list {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 26px;
    }
    .menu-item {
      background: #fff;
      border-radius: var(--radius);
      box-shadow: 0 2px 12px #2c1c0938;
      padding: 22px 20px 16px 20px;
      text-align: center;
      display: flex;
      flex-direction: column;
      align-items: center;
      transition: transform 0.17s;
      cursor: pointer;
      height: 270px;
    }
    .menu-item:hover {
      transform: translateY(-7px) scale(1.02);
      box-shadow: 0 8px 20px #70300018;
    }
    .menu-image {
      width: 110px;
      height: 110px;
      object-fit: cover;
      border-radius: 50%;
      margin-bottom: 15px;
      border: 3px solid #fff8ed;
      box-shadow: 0 1px 5px #9e631855;
      background: #f8f4ee;
    }
    .name {
      font-size: 1.26rem;
      font-weight: bold;
      margin: 2px 0 4px 0;
      color: var(--primary);
    }
    .text {
      color: var(--muted);
      font-size: 1.01rem;
      margin-bottom: 7px;
      min-height: 40px;
    }
    /* Responsive nav */
    @media (max-width: 900px) {
      .nav-container {
        flex-direction: column;
        height: auto;
        padding: 10px 1rem;
      }
      nav ul {
        flex-direction: column;
        margin-top: 11px;
      }
      .nav-right {
        margin-top: 15px;
      }
    }
    @media (max-width: 600px) {
      .section-title {
        font-size: 1.75rem;
      }
      .hero-title {
        font-size: 2.2rem;
      }
      .hero-section {
        padding: 23px 0 24px 0;
      }
      .cart-sidebar {
        width: 98vw;
        max-width: 98vw;
      }
    }
    @media (max-width: 450px) {
      .menu-item {
        padding: 13px 5px 10px 5px;
      }
      .menu-image {
        width: 59px;
        height: 59px;
      }
    }
    /* ===== MOBILE FIX ===== */
@media (max-width: 768px) {

  .menu-toggle {
    display: block;
  }

  nav ul {
    display: none;
    flex-direction: column;
    background: var(--primary);
    width: 100%;
    position: absolute;
    top: 68px;
    left: 0;
    text-align: center;
    padding: 10px 0;
  }

  nav ul.show {
    display: flex;
  }

  .nav-container {
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
  }

  .nav-right {
    gap: 10px;
  }

  /* CART FIX (IMPORTANT) */
  .cart-sidebar {
    right: -100% !important;
  }

  .cart-sidebar.open {
    right: 0 !important;
  }

  .menu-list {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 480px) {
  .menu-list {
    grid-template-columns: 1fr;
  }
}
  </style>
</head>
<body>
  <!-- Notification -->
  <div id="cart-message-box"></div>
  <!-- HEADER -->
  <header>
  <div class="nav-container">

    <!-- MENU BUTTON (MOBILE) -->
    <button class="menu-toggle" id="menu-toggle">
      <i class="fas fa-bars"></i>
    </button>

    <a href="#" class="logo"><span>☕</span> Coffee Bliss</a>

    <nav>
      <ul id="nav-menu">
        <li><a href="#home">Home</a></li>
        <li><a href="#menu">Menu</a></li>
        <li><a href="#about">About</a></li>
      </ul>
    </nav>
      <div class="nav-right">
        <a href="#" class="cart-link" id="cart-toggle" tabindex="0" title="View Cart">
          <i class="fas fa-shopping-cart"></i>
          <span class="cart-badge" id="cart-badge">0</span>
        </a>
      </div>
      <div class="nav-right">
        <?php
        if (isset($_SESSION['username'])) {
          echo $_SESSION['username']."<style>#signin-link{display:none;}</style>";
          echo '<form method="post" action="logout.php" style="display:inline;">
                  <button type="submit" name="logout">Logout</button>
                </form>';
        }
        else {
          echo 'Please login';
        }
        ?>
  <a href="signin.html" class="signin-link" id="signin-link" tabindex="0" title="Sign In">
    <i class="fas fa-user-circle"></i>
  </a>
  <form action="signin.php" method="POST" autocomplete="off">
  <!-- Your form fields -->
</form>

</div>

    </div>
  </header>

  <!-- SIDEBAR CART -->
  <aside id="cart-sidebar" class="cart-sidebar">
    <button class="close-cart" id="close-cart" aria-label="Close Cart">&times;</button>
    <h3 class="cart-title">Your Cart</h3>
    <ul class="cart-items" id="cart-items"></ul>
    <div class="cart-total">
      <span>Total:</span>
      <span id="cart-total-price">Rs.0.00</span>
    </div>
    <button class="checkout-btn">Checkout</button>
  </aside>

  <!-- HERO -->
  <section id="home" class="hero-section">
    <h1 class="hero-title">Discover Your Favorite Coffee</h1>
    <p class="hero-desc">Brewed with love, served with a smile. Taste the difference!</p>
  </section>

  <!-- MENU -->
   
  <section class="menu-section" id="menu">
    <h2 class="section-title">Our Menu</h2>
    
    <ul class="menu-list">
      <li class="menu-item" onclick="location.href='hotbeverages.html'">
        <img src="assets/images/hot-beverages.png" alt="Hot Beverages" class="menu-image" />
        <div class="name">Hot Beverages</div>
        <div class="text">A wide range of steaming hot coffee to refresh your senses.</div>
      </li>
      <li class="menu-item" onclick="location.href='coldbeverages.html'">
        <img src="assets/images/cold-beverages.png" alt="Cold Beverages" class="menu-image" />
        <div class="name">Cold Beverages</div>
        <div class="text">Chilled, creamy and frothy cold coffee for summer days.</div>
      </li>
      <li class="menu-item" onclick="location.href='refreshment.html'">
        <img src="assets/images/refreshment.png" alt="Refreshment" class="menu-image" />
        <div class="name">Refreshment</div>
        <div class="text">Fruit and icy drinks to energize your day.</div>
      </li>
      <li class="menu-item" onclick="location.href='speciialcombo.html'">
        <img src="assets/images/special-combo.png" alt="Special Combos" class="menu-image" />
        <div class="name">Special Combos</div>
        <div class="text">Your favourite eating and drinking combinations.</div>
      </li>
      <li class="menu-item" onclick="location.href='dessert.html'">
        <img src="assets/images/desserts.png" alt="Dessert" class="menu-image" />
        <div class="name">Dessert</div>
        <div class="text">Sweet treats to finish your meal perfectly.</div>

      </li>
      <li class="menu-item" onclick="location.href='burger.html'">
        <img src="assets/images/burger-frenchfries.png" alt="Burger & French Fries" class="menu-image" />
        <div class="name">Burger & French Fries</div>
        <div class="text">Quick bites for your small size hunger.</div>
      </li>
    </ul>
  </section>

  <!-- ABOUT SECTION -->
  <section style="background: #f7ede1; padding:48px 0;" id="about">
    <div style="max-width: 1100px; margin:0 auto; display: flex; flex-wrap:wrap; align-items:center; gap:40px; padding: 0 16px;">
      <div style="flex:1 1 330px; min-width:275px;">
        <img src="assets/images/about-image.jpg" alt="Coffeehouse Interior" style="width:100%; max-width:410px; border-radius:24px; box-shadow:0 4px 28px #6F4E3725;background: #e2c99c;" />
      </div>
      <div style="flex:2 1 350px; min-width:270px;">
        <h2 style="font-family: 'Josefin Sans', serif; color: #6F4E37; font-size:2.1rem; margin-bottom:10px;">About Coffee Bliss</h2>
        <p style="font-size:1.14rem; color:#664c35; line-height:1.6; margin-bottom:18px;">
          <b>Coffee Bliss</b> is your cozy destination for fresh-brewed coffee and delightful bites in the heart of town. <br />
          Our passion for <b>quality beans</b> and warm community shows in every cup we serve. <br />
          Whether meeting friends or recharging solo, enjoy our hand-crafted drinks in a welcoming, sun-lit space.<br /><br />
          We champion sustainable sourcing and friendly smiles—visit and discover why our customers feel right at home.
        </p>
        <ul style="list-style:none; padding:0; display:flex; gap:20px; margin-top:20px;">
          <li>
            <a href="#" style="color:#b5946b; font-size:1.9rem;"><i class="fab fa-facebook-square"></i></a>
          </li>
          <li>
            <a href="#" style="color:#b5946b; font-size:1.9rem;"><i class="fab fa-instagram"></i></a>
          </li>
          <li>
            <a href="#" style="color:#b5946b; font-size:1.9rem;"><i class="fab fa-x-twitter"></i></a>
          </li>
        </ul>
      </div>
    </div>
  </section>

  <!-- CONTACT SECTION -->
  <section id="contact" style="background:#fff5ea; padding:46px 0 54px 0;">
    <div style="max-width:1100px; margin:0 auto; display:flex; flex-wrap:wrap; align-items:center; gap:40px; padding:0 16px;">
      <div style="flex:1 1 320px; min-width:255px;">
        <h2 style="font-family:'Josefin Sans', serif; color:#6F4E37; font-size:2rem;">Contact Us</h2>
        <p style="font-size:1.06rem; color:#856740; line-height:1.7; margin:20px 0 20px 0;">
          <b>We’d love to hear from you!</b> Whether you have a question, feedback, or just want to say hi, drop us a message below or reach us at:
        </p>
        <ul style="list-style:none; padding:0; margin-bottom:17px;">
          <li style="margin-bottom:12px; color:#83562c;">
            <i class="fas fa-map-marker-alt" style="width:18px; text-align:center;"></i> Law College Square, W High Ct Rd,  
opposite Gomti Apartment, Nagpur
          </li>
          <li style="margin-bottom:12px; color:#83562c;">
            <i class="fas fa-envelope" style="width:18px; text-align:center;"></i> info@coffeebliss.com
          </li>
          <li style="margin-bottom:12px; color:#83562c;">
            <i class="fas fa-phone" style="width:18px; text-align:center;"></i> 49123-456789
          </li>
        </ul>
        <div>
          <b style="color:#83562c;">Hours:</b>
          <div style="color:#b5946b;">Mon-Fri: 8:00 AM - 8:00 PM<br/>Sat-Sun: 9:00 AM - 10:00 PM</div>
        </div>
      </div>
      <div style="flex:2 1 350px; min-width:250px;">
        <form id="feedback-form" method="post" action="php/feedback.php" 
        style="background: #fff; border-radius:12px; box-shadow:0 2px 16px #beaa9050; padding:26px 20px; max-width:390px; margin:0 auto;" autocomplete="off">
          <h3 style="font-family:'Josefin Sans', serif; font-size:1.16rem; color:#6F4E37; margin-bottom:16px; font-weight:600;">Feedback</h3>
          <input type="text" placeholder="Your Name" name="name" required style="width:100%; margin-bottom:12px; padding:11px 12px; border:1px solid #e8d8c2; border-radius:7px; font-size:1rem; outline:none;" />
          <input type="email" placeholder="Your Email" name="email" required style="width:100%; margin-bottom:12px; padding:11px 12px; border:1px solid #e8d8c2; border-radius:7px; font-size:1rem; outline:none;" />
          <textarea placeholder="Your Message" name="message" required rows="4" style="width:100%; margin-bottom:16px; padding:11px 12px; border:1px solid #e8d8c2; border-radius:7px; font-size:1rem; resize:vertical; outline:none;"></textarea>
          <button type="submit" style="background:#6F4E37; color:#fff; width:100%; border:none; border-radius:8px; padding:12px 0; font-size:1.14rem; font-weight:bold; cursor:pointer; transition:background .18s;">Send Message</button>
          <div id="feedback-message" style="margin-top:14px; min-height:20px; font-size:0.95rem;"></div>
      
        </form>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer style="text-align:center; padding:20px 0; color:#c8ae85; font-size:.97rem;">
    &copy; 2025 Coffee Bliss. All rights reserved.
  </footer>

  <!-- Cart JS load -->
  <script src="cart.js"></script>
</body>
</html>
