<?php
session_start();
require 'connection.php';

// Fetch products
$stmt = $pdo->query("SELECT * FROM produk WHERE stok > 0");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Count items in cart
$cart_count = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cart_count += $item['quantity'];
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HappyPaws - Toko Keperluan Hewan</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Fredoka:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        /* Hero Section Styles */
        .hero {
            position: relative;
            height: 500px;
            background: linear-gradient(135deg, rgba(255,140,66,0.9) 0%, rgba(255,107,107,0.85) 100%),
                        url('https://images.unsplash.com/photo-1587300003388-59208cc962cb?w=1200') center/cover;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            margin-bottom: 50px;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.3);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            padding: 20px;
        }

        .hero h1 {
            font-family: 'Fredoka', sans-serif;
            font-size: 4rem;
            margin-bottom: 15px;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.3);
            animation: fadeInUp 1s ease;
        }

        .hero p {
            font-size: 1.5rem;
            margin-bottom: 30px;
            text-shadow: 1px 1px 5px rgba(0,0,0,0.3);
            animation: fadeInUp 1s ease 0.2s both;
        }

        .hero-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            animation: fadeInUp 1s ease 0.4s both;
        }

        .btn-hero {
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-hero-primary {
            background: white;
            color: var(--primary);
        }

        .btn-hero-primary:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .btn-hero-secondary {
            background: transparent;
            color: white;
            border: 3px solid white;
        }

        .btn-hero-secondary:hover {
            background: white;
            color: var(--primary);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Floating Pets Animation */
        .floating-pets {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .pet {
            position: absolute;
            font-size: 3rem;
            animation: float 6s ease-in-out infinite;
            opacity: 0.8;
        }

        .pet:nth-child(1) { top: 10%; left: 10%; animation-delay: 0s; }
        .pet:nth-child(2) { top: 20%; right: 15%; animation-delay: 1s; }
        .pet:nth-child(3) { bottom: 20%; left: 15%; animation-delay: 2s; }
        .pet:nth-child(4) { bottom: 15%; right: 10%; animation-delay: 3s; }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        /* Features Section */
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-bottom: 60px;
        }

        .feature-card {
            background: white;
            padding: 30px;
            border-radius: var(--radius);
            text-align: center;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        .feature-card:hover {
            transform: translateY(-10px);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .feature-icon i {
            font-size: 2rem;
            color: white;
        }

        .feature-card h3 {
            margin-bottom: 10px;
            color: var(--dark);
        }

        .feature-card p {
            color: var(--gray);
            font-size: 0.95rem;
        }

        /* Testimonials */
        .testimonials {
            background: white;
            padding: 60px 20px;
            margin: 60px 0;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
        }

        .testimonials h2 {
            text-align: center;
            margin-bottom: 40px;
        }

        .testimonial-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .testimonial-card {
            background: var(--light);
            padding: 25px;
            border-radius: var(--radius);
            text-align: center;
        }

        .testimonial-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: linear-gradient(135deg, #FFE4D1 0%, #FFD4C4 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 2rem;
        }

        .testimonial-card p {
            font-style: italic;
            color: var(--gray);
            margin-bottom: 15px;
        }

        .testimonial-card strong {
            color: var(--dark);
        }

        @media (max-width: 768px) {
            .hero {
                height: 400px;
            }
            .hero h1 {
                font-size: 2.5rem;
            }
            .hero p {
                font-size: 1.1rem;
            }
            .hero-buttons {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <div class="logo">
                <i class="fas fa-paw logo-icon"></i>
                <h1>HappyPaws</h1>
            </div>
            <div class="cart-icon" onclick="toggleCart()">
                <i class="fas fa-shopping-cart"></i>
                <span id="cart-badge"><?= $cart_count ?></span>
            </div>
        </div>
    </header>

    <!-- Navigation -->
    <nav>
        <div class="container">
            <a href="#home"><i class="fas fa-home"></i> Beranda</a>
            <a href="#produk"><i class="fas fa-box"></i> Produk</a>
            <a href="#tentang"><i class="fas fa-heart"></i> Tentang Kami</a>
            <a href="produk.php"><i class="fas fa-cog"></i> Kelola Produk</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="floating-pets">
            <span class="pet">🐕</span>
            <span class="pet">🐈</span>
            <span class="pet">🐾</span>
            <span class="pet">🦴</span>
        </div>
        <div class="hero-content">
            <h1>Selamat Datang di HappyPaws! 🐾</h1>
            <p>Temukan kebahagiaan untuk hewan kesayangan Anda</p>
            <div class="hero-buttons">
                <a href="#produk" class="btn-hero btn-hero-primary">
                    <i class="fas fa-shopping-bag"></i> Belanja Sekarang
                </a>
                <a href="#tentang" class="btn-hero btn-hero-secondary">
                    <i class="fas fa-info-circle"></i> Pelajari Lebih Lanjut
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <div class="container">
        <div class="features">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shipping-fast"></i>
                </div>
                <h3>Pengiriman Cepat</h3>
                <p>Kirim ke seluruh Indonesia dengan cepat dan aman</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-medal"></i>
                </div>
                <h3>Produk Berkualitas</h3>
                <p>Barang asli dan berkualitas tinggi untuk pets Anda</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h3>Layanan 24/7</h3>
                <p>Tim kami siap membantu kapan saja Anda membutuhkan</p>
            </div>
        </div>
    </div>

    <!-- Main Content - Products -->
    <main id="produk" class="container">
        <div class="page-title">
            <h2>🐾 Produk Kami</h2>
            <p>Temukan kebutuhan terbaik untuk hewan kesayangan Anda</p>
        </div>
        
        <?php if (count($products) === 0): ?>
            <div class="empty-state">
                <i class="fas fa-box-open"></i>
                <h3>Belum Ada Produk</h3>
                <p>Saat ini belum ada produk yang tersedia.</p>
                <a href="tambah.php" class="btn btn-primary" style="margin-top: 20px;">
                    <i class="fas fa-plus"></i> Tambah Produk
                </a>
            </div>
        <?php else: ?>
            <div class="product-grid">
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <div class="product-image">
                            <i class="fas fa-paw" style="color: var(--primary);"></i>
                        </div>
                        <div class="product-info">
                            <h3><?= htmlspecialchars($product['nama_produk']) ?></h3>
                            <p class="price"><?= number_format($product['harga'], 0, ',', '.') ?></p>
                            <p class="stock">
                                <i class="fas fa-box"></i> Stok: <span id="stock-<?= $product['id'] ?>"><?= $product['stok'] ?></span>
                            </p>
                            <button class="btn-add" onclick="addToCart(<?= $product['id'] ?>)">
                                <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>

    <!-- Testimonials Section -->
    <section id="tentang" class="testimonials">
        <div class="container">
            <h2>💬 Apa Kata Pelanggan Kami</h2>
            <div class="testimonial-grid">
                <div class="testimonial-card">
                    <div class="testimonial-avatar">🐕</div>
                    <p>"Anjing saya sangat senang dengan makanan dari HappyPaws. Kualitasnya terjamin!"</p>
                    <strong>- Budi, Jakarta</strong>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-avatar">🐈</div>
                    <p>"Kucing saya suka mainan dari sini. Pengiriman juga cepat sekali!"</p>
                    <strong>- Siti, Bandung</strong>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-avatar">🦜</div>
                    <p>"Toko terpercaya untuk kebutuhan hewan kesayangan. Sangat direkomendasikan!"</p>
                    <strong>- Ahmad, Surabaya</strong>
                </div>
            </div>
        </div>
    </section>

    <!-- Cart Modal -->
    <div id="cart-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="toggleCart()">&times;</span>
            <h2><i class="fas fa-shopping-cart"></i> Keranjang Belanja</h2>
            <div id="cart-items">
                <!-- Cart data will be loaded here via JS -->
            </div>
            <div class="cart-total">
                <strong>Total: </strong><span id="cart-total-price">Rp 0</span>
            </div>
            <button class="btn-checkout">
                <i class="fas fa-credit-card"></i> Checkout
            </button>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>© 2024 HappyPaws - Toko Keperluan Hewan Terpercaya 🐾</p>
        </div>
    </footer>

    <script>
        function addToCart(productId) {
            fetch('cart_action.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=add&id=' + productId
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('cart-badge').innerText = data.cart_count;
                    document.getElementById('stock-' + productId).innerText = data.new_stock;
                    showAlert(data.message, 'success');
                } else {
                    showAlert(data.message, 'error');
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function toggleCart() {
            var modal = document.getElementById('cart-modal');
            if (modal.style.display === 'block') {
                modal.style.display = 'none';
            } else {
                loadCart();
                modal.style.display = 'block';
            }
        }

        function loadCart() {
            fetch('cart_action.php?action=get_cart')
            .then(response => response.json())
            .then(data => {
                var container = document.getElementById('cart-items');
                var html = '';
                var total = 0;
                
                if (data.items.length === 0) {
                    html = '<div class="empty-state"><i class="fas fa-shopping-basket"></i><p>Keranjang kosong</p></div>';
                } else {
                    data.items.forEach(function(item) {
                        html += '<div class="cart-item"><span>' + item.nama_produk + ' (x' + item.quantity + ')</span><span>Rp ' + (item.harga * item.quantity).toLocaleString('id-ID') + '</span></div>';
                        total += item.harga * item.quantity;
                    });
                }
                
                container.innerHTML = html;
                document.getElementById('cart-total-price').innerText = 'Rp ' + total.toLocaleString('id-ID');
            });
        }

        function showAlert(message, type) {
            var alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-' + type;
            var icon = type === 'success' ? 'check-circle' : 'exclamation-circle';
            alertDiv.innerHTML = '<i class="fas fa-' + icon + '"></i> ' + message;
            document.body.insertBefore(alertDiv, document.body.firstChild);
            setTimeout(function() { alertDiv.remove(); }, 3000);
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            var modal = document.getElementById('cart-modal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }

        // Smooth scroll for navigation
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                var target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>
</html>
