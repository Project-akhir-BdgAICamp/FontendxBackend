async function fetchProducts(url) {
    const response = await fetch(url);
    const text = await response.text();
    const parser = new DOMParser();
    const doc = parser.parseFromString(text, 'text/html');

    return Array.from(doc.querySelectorAll('.product')).map(product => {
        return {
            imgSrc: product.querySelector('img').src,
            title: product.querySelector('h3').innerText,
            price: product.querySelector('p').innerText,
            link: product.querySelector('a').href
        };
    });
}

async function loadProducts() {
    const urls = ['baju.html', 'sepatu.html', 'tas.html'];
    const allProducts = [];

    for (const url of urls) {
        const products = await fetchProducts(url);
        allProducts.push(...products);
    }

    const productsContainer = document.getElementById('products');
    allProducts.forEach(product => {
        const productElement = document.createElement('div');
        productElement.className = 'product';  // Tambahkan class untuk styling dari CSS
        productElement.innerHTML = `
            <a href="${product.link}" class="product-link">
                <img src="${product.imgSrc}" alt="${product.title}" class="product-image">
                <h3 class="product-title">${product.title}</h3>
                <p class="product-price">${product.price}</p>
                <button class="detail-btn">Lihat Detail</button>
            </a>
        `;
        productsContainer.appendChild(productElement);
    });
}

loadProducts();
