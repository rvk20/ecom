const productList = document.querySelector('.products');
let outputProduct = '<option value="">Produkty …</option>';
let params = new URLSearchParams(location.search);

const fetchProducts = (dataProducts) => {
    dataProducts.forEach(product => {
        outputProduct += `
        <option value="${product.id}">${product.name}</option>
    `;
    });
    productList.innerHTML = outputProduct;
};
fetch('../products/fetch_all?c=' + params.get('c'))
    .then(resProducts => resProducts.json())
    .then(dataProducts => fetchProducts(dataProducts))
    .catch(error => console.log('ERROR'))

productList.innerHTML = outputProduct;