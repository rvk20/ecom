const itemList = document.querySelector('.products');
let outputItem = '<tr><td>Nazwa</td><td>Ilość</td></tr>';
let params = new URLSearchParams(location.search);

const fetchItems = (data) => {
    data.forEach(post => {
        outputItem += `
        <tr">
        <td>${post.product}</td><td>${post.quantity}</td>
        </tr>  
    `;
    });
    itemList.innerHTML = outputItem;
};

fetch('/admin/orders/get/items?o=' + params.get('o'))
    .then(res => res.json())
    .then(data => fetchItems(data))
    .catch(error => console.log('ERROR'))