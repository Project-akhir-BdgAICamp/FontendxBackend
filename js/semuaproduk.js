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
        productElement.className = 'product';
        productElement.innerHTML = `
            <a href="${product.link}">
                <img src="${product.imgSrc}" alt="${product.title}">
                <h3>${product.title}</h3>
                <p>${product.price}</p>
                <a href="${product.link}">
                    <button>Lihat Detail</button>
                </a>
            </a>
        `;
        productsContainer.appendChild(productElement);
    });
}

loadProducts();
