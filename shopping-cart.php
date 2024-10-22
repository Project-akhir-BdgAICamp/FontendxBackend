<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="styleindex.css">
  <title>Keranjang Belanja</title>
</head>
<body>
  <header class="bg-primary text-white text-center py-4">
    <h1>Keranjang Belanja</h1>
  </header>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="index.php">Glamora</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="baju.php">Baju</a></li>
          <li class="nav-item"><a class="nav-link" href="sepatu.php">Sepatu</a></li>
          <li class="nav-item"><a class="nav-link" href="tas.php">Tas</a></li>
          <li class="nav-item"><a class="nav-link" href="semuaproduk.php">Semua Produk</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Daftar belanjaan di keranjang -->
  <section class="container my-4">
    <table class="table table-striped table-bordered">
        <thead class="table-light">
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="cartItems">
        </tbody>
    </table>
  </section>

  <script>
      // Fungsi untuk menambahkan barang ke keranjang
      function addToCart(id, name, price) {
          const cart = getCartData();
          
          // Cek apakah produk sudah ada di keranjang
          const existingItem = cart.find(item => item.id === id);
          if (existingItem) {
              existingItem.quantity += 1; // Jika ada, tambahkan jumlahnya
          } else {
              cart.push({ id, name, price, quantity: 1 }); // Jika tidak ada, tambahkan item baru
          }
          
          // Simpan kembali ke localStorage
          localStorage.setItem('cart', JSON.stringify(cart));
          
          // Tampilkan keranjang setelah menambahkan barang
          displayCartItems();
      }

      // Fungsi untuk mendapatkan data keranjang dari localStorage
      function getCartData() {
          return JSON.parse(localStorage.getItem('cart')) || [];
      }

      // Fungsi untuk menampilkan produk di keranjang
      function displayCartItems() {
        const cartItemsContainer = document.getElementById('cartItems');
        const cart = getCartData();
        let totalItems = 0;
        let totalPrice = 0;

        cartItemsContainer.innerHTML = ''; // Kosongkan kontainer sebelum menampilkan
        if (cart.length === 0) {
            cartItemsContainer.innerHTML = '<tr><td colspan="5">Keranjang masih kosong.</td></tr>';
        } else {
            cart.forEach(item => {
                const total = item.price * item.quantity;
                totalItems += item.quantity; // Tambahkan jumlah item
                totalPrice += total; // Tambahkan total harga
                
                cartItemsContainer.innerHTML += `
                    <tr>
                        <td>${item.name}</td>
                        <td>Rp ${item.price.toLocaleString('id-ID')}</td>
                        <td>${item.quantity}</td>
                        <td>Rp ${total.toLocaleString('id-ID')}</td>
                        <td><button class="btn btn-danger" onclick="removeFromCart('${item.id}')">Hapus</button></td>
                    </tr>
                `;
            });
        }

        // Debugging
        console.log("Total Items: ", totalItems);
        console.log("Total Price: ", totalPrice);

        // Panggil fungsi untuk memperbarui ringkasan keranjang
        updateCartSummary(totalItems, totalPrice);
      }

      // Fungsi untuk memperbarui ringkasan keranjang
      function updateCartSummary(totalItems, totalPrice) {
        document.getElementById('totalItems').textContent = totalItems;
        document.getElementById('totalPrice').textContent = `Rp ${totalPrice.toLocaleString('id-ID')}`;
      }

      // Fungsi untuk menghapus item dari keranjang
      function removeFromCart(id) {
          const cart = getCartData().filter(item => item.id !== id);
          localStorage.setItem('cart', JSON.stringify(cart));
          displayCartItems(); // Tampilkan keranjang setelah penghapusan
      }

      // Panggil fungsi untuk menampilkan keranjang saat halaman dimuat
      displayCartItems();
  </script>

  <section class="container my-4">
    <h2>Ringkasan Keranjang</h2>
    <p>Total Produk: <span id="totalItems">0</span></p>
    <p>Total Harga: <span id="totalPrice">Rp 0</span></p>
    <button class="btn btn-success" onclick="goToCheckout()">Checkout</button>
  </section>

  <footer class="text-center py-4">
    <p>&copy; 2024 Glamora. All rights reserved.</p>
  </footer>

  <script>
    function goToCheckout() {
      window.location.href = 'checkout.php';
    }
  </script>
</body>
</html>
