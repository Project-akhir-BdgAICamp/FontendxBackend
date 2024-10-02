// Data produk
const products = [
    // Produk Baju
    { name: "Kemeja Formal Cowok", price: "Rp 250.000 <span class='badge badge-success'>Diskon 20%</span>", image: "baju-cowok1.jpg", link: "detail-produk.html?produk=kemeja-formal-cowok" },
    { name: "Kaos Santai Cowok", price: "Rp 100.000 <span class='badge badge-warning'>Baru!</span>", image: "baju-cowok2.jpg", link: "detail-produk.html?produk=kaos-santai-cowok" },
    { name: "Jaket Kulit Cowok", price: "Rp 400.000", image: "baju-cowok3.jpg", link: "detail-produk.html?produk=jaket-kulit-cowok" },
    { name: "Dress Kasual Cewek", price: "Rp 300.000 <span class='badge badge-danger'>Best Seller!</span>", image: "baju-cewek1.jpg", link: "detail-produk.html?produk=dress-kasual-cewek" },
    { name: "Blouse Cewek", price: "Rp 200.000", image: "baju-cewek2.jpg", link: "detail-produk.html?produk=blouse-cewek" },
    { name: "Cardigan Cewek", price: "Rp 250.000", image: "baju-cewek3.jpg", link: "detail-produk.html?produk=cardigan-cewek" },
  
    // Produk Sepatu
    { name: "Sepatu Sneakers Cowok", price: "Rp 500.000", image: "sepatu-cowok1.jpg", link: "detail-produk.html?produk=sepatu-sneakers-cowok" },
    { name: "Sepatu Formal Cowok", price: "Rp 600.000", image: "sepatu-cowok2.jpg", link: "detail-produk.html?produk=sepatu-formal-cowok" },
    { name: "Sepatu Olahraga Cowok", price: "Rp 700.000", image: "sepatu-cowok3.jpg", link: "detail-produk.html?produk=sepatu-olahraga-cowok" },
    { name: "Sepatu Heels Cewek", price: "Rp 450.000", image: "sepatu-cewek1.jpg", link: "detail-produk.html?produk=sepatu-heels-cewek" },
    { name: "Sepatu Casual Cewek", price: "Rp 350.000", image: "sepatu-cewek2.jpg", link: "detail-produk.html?produk=sepatu-casual-cewek" },
    { name: "Sepatu Sneakers Cewek", price: "Rp 550.000", image: "sepatu-cewek3.jpg", link: "detail-produk.html?produk=sepatu-sneakers-cewek" },
  
    // Produk Tas
    { name: "Tas Ransel Cowok", price: "Rp 350.000", image: "tas-cowok1.jpg", link: "detail-produk.html?produk=tas-ransel-cowok" },
    { name: "Tas Selempang Cowok", price: "Rp 250.000", image: "tas-cowok2.jpg", link: "detail-produk.html?produk=tas-selempang-cowok" },
    { name: "Tas Gym Cowok", price: "Rp 450.000", image: "tas-cowok3.jpg", link: "detail-produk.html?produk=tas-gym-cowok" },
    { name: "Tas Tote Cewek", price: "Rp 300.000", image: "tas-cewek1.jpg", link: "detail-produk.html?produk=tas-tote-cewek" },
    { name: "Tas Punggung Cewek", price: "Rp 400.000", image: "tas-cewek2.jpg", link: "detail-produk.html?produk=tas-punggung-cewek" },
    { name: "Tas Clutch Cewek", price: "Rp 250.000", image: "tas-cewek3.jpg", link: "detail-produk.html?produk=tas-clutch-cewek" },
  ];
  
  // Menampilkan produk
  const productsContainer = document.getElementById('products');
  products.forEach(product => {
    const col = document.createElement('div');
    col.classList.add('col-md-4', 'mb-4');
    col.innerHTML = `
      <div class="card h-100 shadow-sm">
        <img src="${product.image}" class="card-img-top" alt="${product.name}">
        <div class="card-body text-center">
          <h5 class="card-title">${product.name}</h5>
          <p class="card-text">${product.price}</p>
          <a href="${product.link}" class="btn btn-primary">Lihat Detail</a>
        </div>
        <div class="card-footer">
          <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">Stok 60%</div>
          </div>
        </div>
      </div>
    `;
    productsContainer.appendChild(col);
  });
  