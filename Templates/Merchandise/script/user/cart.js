const productList = document.querySelector('.cart');
const formOrder = document.getElementById('add_order');
let sum = 0;
let toForm = '[';
let outputForm = ``;
let outputCategory = `<tr>
            <td>
                
            </td>
            <td>
                Nazwa
            </td>
            <td>
                Cena
            </td>
            <td>
                Ilość
            </td>
            <td>
            
            </td>
        </tr>`;

const fetchProducts = (data) => {
    let first = false;
    data.forEach(product => {
        if(first)
            toForm += ',';
        toForm += JSON.stringify({"id":product.id, "quantity":product.quantity});
        sum += (product.cost * product.quantity);
        first = true;
        outputCategory += `
        <tr id = "${product.id}">
            <td>
                <img id="card_img" src="/images/${product.img}" width="100" height="100">
            </td>
            <td>
                ${product.name}
            </td>
            <td>
                ${product.cost * product.quantity} zł
            </td>
            <td>
                ${product.quantity}
            </td>
            <td class="last-row">
                <button class="de-btn" id="del">Usuń</button>
            </td>
        </tr>
    `;
    });
    outputCategory += `<br><div><h1>Koszt zamówienia: ${sum} zł</h1></div><br>`;
    toForm += ']';
    outputForm += `
    <form id="send-order">
        <button class="ord-btn" type="submit">Zamów</button>
    </form>
    `;
    productList.innerHTML = outputCategory;

    productList.addEventListener('click', (e) => {
        let delPressed = e.target.id === 'del';
        let idToDel = e.target.parentElement.parentElement.id;
        if(delPressed) {
            ajaxDelProduct(idToDel);
        }
    })

    if(sum>0)
    formOrder.innerHTML = outputForm;
    document.getElementById('send-order').addEventListener('submit', (ev) => {
        //ev.preventDefault();
        ajaxSendOrder();
    })

    function ajaxSendOrder() {
        const xhr = new XMLHttpRequest();
        xhr.open('POST','../cart/addorder', false);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send('product=' + toForm +'&cost=' + sum);
    }

    function ajaxDelProduct(id) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST','../cart/remove', false);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send('id=' + id);
        window.location.reload();
    }
};

fetch('../shop/getcart')
    .then(resProducts => resProducts.json())
    .then(dataProducts => fetchProducts(dataProducts))
    .catch(error => console.log('ERROR'))
