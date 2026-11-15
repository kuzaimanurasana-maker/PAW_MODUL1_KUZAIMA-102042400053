<?php
echo $page = $_GET["page"] ?? "home";

$products = [
    [
        "id" => 1,
        "name" => "Apple Watch",
        "category" => "Smartwatch",
        "price" => 1000000,
        "stock" => 3,
        "discount" => 15,
        "icon" => "⌚"
    ],
    [
        "id" => 2,
        "name" => "Sony PlayStation 5",
        "category" => "Gaming Console",
        "price" => 1200000,
        "stock" => 9,
        "discount" => 15,
        "icon" => "🎮"
    ],
    [
        "id" => 3,
        "name" => "Anker PowerCore",
        "category" => "Power Bank",
        "price" => 1300000,
        "stock" => 3,
        "discount" => 15,
        "icon" => "🔋"
    ],
    [
        "id" => 4,
        "name" => "Razer DeathAdder",
        "category" => "Gaming Mouse",
        "price" => 1450000,
        "stock" => 5,
        "discount" => 10,
        "icon" => "🖱️"
    ],
    [
        "id" => 5,
        "name" => "Lenovo ThinkPad",
        "category" => "Laptop",
        "price" => 3800000,
        "stock" => 4,
        "discount" => 10,
        "icon" => "💻"
    ],
    [
        "id" => 6,
        "name" => "Google Pixel",
        "category" => "Smartphone",
        "price" => 1100000,
        "stock" => 2,
        "discount" => 10,
        "icon" => "📱"
    ],
    [
        "id" => 7,
        "name" => "Samsung Galaxy S",
        "category" => "Smartphone",
        "price" => 2500000,
        "stock" => 1,
        "discount" => 10,
        "icon" => "📲"
    ]
];

$minimumPurchase = 1500000;

function rupiah($number)
{
    return "Rp " . number_format($number, 0, ',', '.');
}

$purchase = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $page = "hasil";

    $productId = (int)($_POST["product_id"] ?? 0);
    $quantity = (int)($_POST["quantity"] ?? 0);

    $selectedProduct = null;

    foreach ($products as $product) {
        if ($product["id"] == $productId) {
            $selectedProduct = $product;
            break;
        }
    }

    if ($selectedProduct != null && $quantity >= 1) {

        if ($quantity <= $selectedProduct["stock"]) {

            $subtotal = $selectedProduct["price"] * $quantity;

            if ($subtotal >= $minimumPurchase) {
                $discount = $selectedProduct["discount"];
                $discountAmount = ($subtotal * $discount) / 100;
            } else {
                $discount = 0;
                $discountAmount = 0;
            }

            $total = $subtotal - $discountAmount;

            $purchase = [
                "name" => $selectedProduct["name"],
                "quantity" => $quantity,
                "price" => $selectedProduct["price"],
                "subtotal" => $subtotal,
                "discount" => $discount,
                "discountAmount" => $discountAmount,
                "total" => $total
            ];
        }
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cia Store - Technology Shop</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f6f8fb;
            color: #17233d;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: auto;
        }

        header {
            background: #101d38;
            padding: 20px 0;
            color: #54b5ff;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 25px;
            font-weight: bold;
        }

        .logo span {
            color: #54b5ff;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-left: 25px;
            font-size: 14px;
            transition: 0.3s;
        }

        nav a:hover {
            color: #54b5ff;
        }

        .hero {
            background: linear-gradient(120deg, #101d38, #1765b5);
            color: white;
            min-height: calc(100vh - 70px);
            display: flex;
            align-items: center;
            padding: 80px 0;
        }

        .hero-content {
            max-width: 700px;
        }

        .hero small {
            color: #8ed0ff;
            font-weight: bold;
            letter-spacing: 2px;
            font-size: 13px;
        }

        .hero h1 {
            font-size: 48px;
            line-height: 1.2;
            margin: 20px 0;
        }

        .hero h1 span {
            color: #54b5ff;
            display: block;
        }

        .hero p {
            color: white;
            line-height: 1.8;
            margin-bottom: 30px;
            max-width: 650px;
            font-size: 16px;
        }

        .hero-button {
            display: inline-block;
            background: #54b5ff;
            color: #10203d;
            padding: 14px 25px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }

        .hero-button:hover {
            background: white;
            transform: translateY(-2px);
        }

        .section {
            padding: 70px 0;
            min-height: calc(100vh - 70px);
        }

        .section-title {
            text-align: center;
            margin-bottom: 40px;
        }

        .section-title h2 {
            font-size: 32px;
            margin-bottom: 10px;
        }

        .section-title p {
            color: #78859b;
        }

        .result-container {
            max-width: 700px;
            margin: auto;
            text-align: center;
        }

        .result-icon {
            font-size: 55px;
            margin-bottom: 15px;
        }

        .receipt {
            background: white;
            padding: 30px;
            border-radius: 15px;
            border: 1px solid #cfe5ff;
            box-shadow: 0 8px 25px #0000000d;
            text-align: left;
        }

        .receipt h3 {
            color: #1765b5;
            margin-bottom: 20px;
            text-align: center;
            font-size: 24px;
        }

        .receipt-row {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            padding: 13px 0;
            border-bottom: 1px solid #edf0f5;
        }

        .receipt-row.total {
            color: #1765b5;
            font-size: 20px;
            font-weight: bold;
            border: none;
            margin-top: 10px;
        }

        .back-button {
            display: inline-block;
            margin-top: 25px;
            background: #1765b5;
            color: white;
            padding: 13px 25px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
        }

        .back-button:hover {
            background: #10477f;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .product-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            border: 1px solid #e9edf5;
            transition: 0.3s;
        }

        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 30px #00000012;
        }

        .product-image {
            height: 175px;
            background: linear-gradient(135deg, #eaf3ff, #d6eaff);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 75px;
            position: relative;
        }

        .discount-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: #ed4c5c;
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: bold;
        }

        .product-content {
            padding: 22px;
        }

        .category {
            color: #438bd2;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .product-content h3 {
            font-size: 19px;
            margin: 8px 0;
        }

        .price-normal {
            color: #1765b5;
            font-size: 21px;
            font-weight: bold;
            margin: 5px 0 12px;
        }

        .stock {
            font-size: 13px;
            margin: 12px 0;
            font-weight: bold;
        }

        .available {
            color: #15965a;
        }

        .empty {
            color: #e14c4c;
        }

        .minimum-note {
            font-size: 12px;
            color: #78859b;
            margin: 8px 0 15px;
        }

        .buy-form label {
            display: block;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 7px;
        }

        .buy-form select {
            width: 100%;
            padding: 11px;
            border: 1px solid #dce3ee;
            border-radius: 7px;
            margin-bottom: 12px;
            background: white;
        }

        .buy-button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 7px;
            font-weight: bold;
            background: #1765b5;
            color: white;
            cursor: pointer;
        }

        .buy-button:hover {
            background: #10477f;
        }

        .about {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 5px 20px #0000000d;
            max-width: 900px;
            margin: auto;
        }

        .about h2 {
            color: #1765b5;
            margin-bottom: 20px;
            font-size: 30px;
        }

        .about p {
            color: #5d6a7e;
            line-height: 1.8;
            margin-bottom: 15px;
        }

        .about-box {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 30px;
        }

        .about-item {
            background: #f4f8ff;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
        }

        .about-item h3 {
            color: #1765b5;
            margin-bottom: 10px;
        }

        .about-item p {
            font-size: 13px;
            margin: 0;
        }

        footer {
            background: #101d38;
            color: white;
            text-align: center;
            padding: 35px 0;
        }

        footer p {
            color: #b8c7dc;
            font-size: 13px;
            margin-top: 8px;
        }

        @media (max-width: 900px) {
            .product-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .about-box {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 600px) {
            .navbar {
                flex-direction: column;
                gap: 15px;
            }

            nav a {
                margin: 0 7px;
            }

            .hero {
                min-height: calc(100vh - 100px);
                padding: 60px 0;
            }

            .hero h1 {
                font-size: 34px;
            }

            .hero p {
                font-size: 14px;
            }

            .product-grid {
                grid-template-columns: 1fr;
            }

            .section {
                padding: 50px 0;
            }

            .about {
                padding: 25px;
            }

            .receipt {
                padding: 20px;
            }

            .receipt-row {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>

<header>
    <div class="container navbar">

        <div class="logo">
            CIA <span>STORE.</span>
        </div>

        <nav>
            <a href="?page=home">Home</a>
            <a href="?page=produk">Produk</a>
            <a href="?page=tentang">Tentang Kami</a>
        </nav>

    </div>
</header>

<?php if ($page == "home"): ?>

<section class="hero">
    <div class="container">
        <div class="hero-content">

            <small>WELCOME TO CIA STORE</small>

            <h1>
                Teknologi Untuk
                <span>Kehidupan Lebih Mudah.</span>
            </h1>

            <p>
                Cia Store hadir untuk menyediakan berbagai
                kebutuhan teknologi dengan pilihan produk
                berkualitas dan harga yang terjangkau.
                Temukan perangkat teknologi yang sesuai
                dengan kebutuhanmu hanya di Cia Store.
            </p>

            <a href="?page=produk" class="hero-button">
                Lihat Produk →
            </a>

        </div>
    </div>
</section>

<?php elseif ($page == "produk"): ?>

<section class="section">
    <div class="container">

        <div class="section-title">
            <h2>Katalog Produk</h2>
            <p>Pilih produk teknologi favoritmu dengan harga terbaik.</p>
        </div>

        <div class="product-grid">

            <?php foreach ($products as $product): ?>

            <div class="product-card">

                <div class="product-image">
                    <?= $product["icon"] ?>

                    <span class="discount-badge">
                        -<?= $product["discount"] ?>%
                    </span>
                </div>

                <div class="product-content">

                    <span class="category">
                        <?= htmlspecialchars($product["category"]) ?>
                    </span>

                    <h3>
                        <?= htmlspecialchars($product["name"]) ?>
                    </h3>

                    <p class="price-normal">
                        <?= rupiah($product["price"]) ?>
                    </p>

                    <?php if ($product["stock"] > 0): ?>

                        <p class="stock available">
                            ● Tersedia (<?= $product["stock"] ?> unit)
                        </p>

                    <?php else: ?>

                        <p class="stock empty">
                            ● Stok Habis
                        </p>

                    <?php endif; ?>

                    <p class="minimum-note">
                        Diskon <?= $product["discount"] ?>%
                        untuk pembelian minimal
                        <?= rupiah($minimumPurchase) ?>
                    </p>

                    <?php if ($product["stock"] > 0): ?>

                    <form method="POST" class="buy-form">

                        <input
                            type="hidden"
                            name="product_id"
                            value="<?= $product["id"] ?>"
                        >

                        <label for="quantity<?= $product["id"] ?>">
                            Jumlah Pembelian
                        </label>

                        <select
                            name="quantity"
                            id="quantity<?= $product["id"] ?>"
                            required
                        >

                            <?php for ($i = 1; $i <= $product["stock"]; $i++): ?>

                                <option value="<?= $i ?>">
                                    <?= $i ?> Unit
                                </option>

                            <?php endfor; ?>

                        </select>

                        <button type="submit" class="buy-button">
                            Beli Sekarang →
                        </button>

                    </form>

                    <?php endif; ?>

                </div>
            </div>

            <?php endforeach; ?>

        </div>
    </div>
</section>

<?php elseif ($page == "hasil"): ?>

<section class="section">
    <div class="container">

        <div class="result-container">

            <?php if ($purchase != null): ?>

                <div class="result-icon">✅</div>

                <div class="section-title">
                    <h2>Pembelian Berhasil</h2>
                    <p>Terima kasih telah berbelanja di Cia Store.</p>
                </div>

                <div class="receipt">

                    <h3>Rincian Pembelian</h3>

                    <div class="receipt-row">
                        <span>Nama Produk</span>
                        <strong>
                            <?= htmlspecialchars($purchase["name"]) ?>
                        </strong>
                    </div>

                    <div class="receipt-row">
                        <span>Jumlah</span>
                        <strong>
                            <?= $purchase["quantity"] ?> unit
                        </strong>
                    </div>

                    <div class="receipt-row">
                        <span>Harga Satuan</span>
                        <strong>
                            <?= rupiah($purchase["price"]) ?>
                        </strong>
                    </div>

                    <div class="receipt-row">
                        <span>Subtotal</span>
                        <strong>
                            <?= rupiah($purchase["subtotal"]) ?>
                        </strong>
                    </div>

                    <div class="receipt-row">
                        <span>Diskon <?= $purchase["discount"] ?>%</span>

                        <strong>
                            <?php if ($purchase["discount"] > 0): ?>
                                -<?= rupiah($purchase["discountAmount"]) ?>
                            <?php else: ?>
                                Rp 0
                            <?php endif; ?>
                        </strong>
                    </div>

                    <div class="receipt-row total">
                        <span>Total Bayar</span>
                        <strong>
                            <?= rupiah($purchase["total"]) ?>
                        </strong>
                    </div>

                </div>

                <a href="?page=produk" class="back-button">
                    ← Kembali ke Produk
                </a>

            <?php else: ?>

                <div class="receipt">
                    <h3>Data pembelian tidak ditemukan.</h3>
                </div>

                <a href="?page=produk" class="back-button">
                    ← Kembali ke Produk
                </a>

            <?php endif; ?>

        </div>
    </div>
</section>

<?php elseif ($page == "tentang"): ?>

<section class="section">
    <div class="container">

        <div class="section-title">
            <h2>Tentang Kami</h2>
            <p>Mengenal lebih dekat Cia Store.</p>
        </div>

        <div class="about">

            <h2>CIA STORE.</h2>

            <p>
                Cia Store adalah toko teknologi yang menyediakan
                berbagai kebutuhan perangkat teknologi dengan
                pilihan produk berkualitas dan harga yang terjangkau.
            </p>

            <p>
                Kami menyediakan berbagai macam produk seperti:
                smartwatch, smartphone, laptop, gaming console,
                power bank, dan perangkat teknologi lainnya.
            </p>

            <p>
                Cia Store hadir untuk membantu pelanggan mendapatkan
                produk teknologi yang sesuai dengan kebutuhan dengan
                proses pembelian yang mudah dan nyaman.
            </p>

            <div class="about-box">

                <div class="about-item">
                    <h3>Produk Berkualitas</h3>
                    <p>
                        Menyediakan berbagai produk teknologi pilihan.
                    </p>
                </div>

                <div class="about-item">
                    <h3>Harga Terjangkau</h3>
                    <p>
                        Harga bersaing dan tersedia berbagai
                        penawaran menarik.
                    </p>
                </div>

                <div class="about-item">
                    <h3>Mudah & Nyaman</h3>
                    <p>
                        Proses melihat produk dan pembelian
                        yang sederhana.
                    </p>
                </div>

            </div>

        </div>
    </div>
</section>

<?php endif; ?>

<footer>
    <div class="container">

        <h3>CIA STORE.</h3>

        <p>For Your Technology</p>

        <p>
            Menyediakan berbagai produk teknologi
            untuk kebutuhan digital kamu.
        </p>

        <p>Pilih Cia Store Sekarang!</p>

        <p>© 2026 Cia Store.</p>

    </div>
</footer>

</body>
</html> 