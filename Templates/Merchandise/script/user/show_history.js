const orderList = document.querySelector('.orders');
const modalContent = document.querySelector('.products');
let outputOrder = '<tr><td><b>Numer</b></td><td><b>Cena</b></td><td><b>Status</b></td><td><b>Data</b></td><td></td>';

const fetchOrders = (data) => {
    data.forEach(post => {
        outputOrder += `
        <tr id ="${post.id}">
        <td>${post.name}</td><td>${post.cost} zł</td><td>${post.status}</td><td>${post.date}</td><td><a href="#" id="show">szczegóły</a></td></td>
        </tr>  
    `;
    });
        orderList.innerHTML = outputOrder;

      /*  document.getElementById('show').addEventListener('submit', (ev) => {
            //ev.preventDefault();


        })*/
};

fetch('/history/get/all')
    .then(res => res.json())
    .then(data => fetchOrders(data))
    .catch(error => console.log('ERROR'))

orderList.addEventListener('click', (e) => {
    let pressed = e.target.id === 'show';
    let id = e.target.parentElement.parentElement.id;
    if(pressed) {
        modal.style.display = "block";
        ajaxSendComment();
    }
    function ajaxSendComment() {
        let outputItems = '<table><tr><td><b>Produkt</b></td><td><b>Ilość</b></td></tr>';
        const xhr = new XMLHttpRequest();
        xhr.onload = function () {
            let items = JSON.parse(this.response);
            items.forEach(post => {
                outputItems += `
                <tr><td>${post.product}</td><td>${post.quantity}</td></tr>
            `;
            });
            outputItems += `</table>`;
            modalContent.innerHTML = outputItems;
        }
        xhr.open('GET','../admin/orders/get/items?o=' + id, true);
        xhr.send();
    }
})
