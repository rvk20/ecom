const orderList = document.querySelector('.orders');
const orderList1 = document.querySelector('.orders1');
const orderList2 = document.querySelector('.orders2');
let outputOrder = '<tr><td>Numer</td><td>Cena</td><td>Użytkownik</td><td>Data</td><td></td><td></td></tr>';


const fetchOrders = (data) => {
    data.forEach(post => {
        outputOrder += `
        <tr id ="${post.id}">
        <td>${post.name}</td><td>${post.cost}</td><td>${post.user}</td><td>${post.date}</td><td><a href="/admin/orders/items?o=${post.id}" id="show">szczegóły</a></td>
        <td><form action="/admin/orders/set/items" method="POST"><input type="hidden" name="status" value="Realizowane"><input type="hidden" name="id" value="${post.id}"><input class="button" type="submit" name="submit" value="Zmień status"></form></td>
        </tr>  
    `;
    });
    orderList.innerHTML = outputOrder;
};

const fetchOrders1 = (data) => {
    outputOrder = '<tr><td>Numer</td><td>Cena</td><td>Użytkownik</td><td>Data</td><td></td><td></td></tr>';
    data.forEach(post => {
        outputOrder += `
        <tr id ="${post.id}">
        <td>${post.name}</td><td>${post.cost}</td><td>${post.user}</td><td>${post.date}</td><td><a href="/admin/orders/items?o=${post.id}" id="show">szczegóły</a></td>
        <td><form action="/admin/orders/set/items" method="POST"><input type="hidden" name="status" value="Wysłane"><input type="hidden" name="id" value="${post.id}"><input class="button" type="submit" name="submit" value="Zmień status"></form></td>
        </tr>  
    `;
    });
    orderList1.innerHTML = outputOrder;
};

const fetchOrders2 = (data) => {
    outputOrder = '<tr><td>Numer</td><td>Cena</td><td>Użytkownik</td><td>Data</td><td></td></tr>';
    data.forEach(post => {
        outputOrder += `
        <tr id ="${post.id}">
        <td>${post.name}</td><td>${post.cost}</td><td>${post.user}</td><td>${post.date}</td><td><a href="/admin/orders/items?o=${post.id}" id="show">szczegóły</a></td>
        </tr>  
    `;
    });
    orderList2.innerHTML = outputOrder;
};


fetch('/admin/orders/get/all?o=Złożone')
    .then(res => res.json())
    .then(data => fetchOrders(data))
    .catch(error => console.log('ERROR'))

fetch('/admin/orders/get/all?o=Realizowane')
    .then(res => res.json())
    .then(data => fetchOrders1(data))
    .catch(error => console.log('ERROR'))

fetch('/admin/orders/get/all?o=Wysłane')
    .then(res => res.json())
    .then(data => fetchOrders2(data))
    .catch(error => console.log('ERROR'))
