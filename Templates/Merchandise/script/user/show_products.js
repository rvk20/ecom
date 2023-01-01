const productList = document.querySelector('.products');
const commentModal = document.querySelector('.comments');
const formModal = document.querySelector('.form-comments');
let outputProduct = '';
let outputModal = '';
let outputForm = '';
let params = new URLSearchParams(location.search);
let element = 0;
let userId;
fetch('../user/data')
    .then(resUser => resUser.json())
    .then(resUser => userId = resUser.id)
    .catch(error => console.log('ERROR'))

const fetchProducts = (dataProducts) => {
    dataProducts.forEach(product => {
        outputProduct += `
         <div class="card" >
                <img id="card_img" src="/images/${product.image}" width="200" height="200"></td>
                <form method="POST" action="/shop/addtocart" id="add_to_cart">
                <label><h2>${product.name}</h2></label>
                <label>${product.cost} zł</label><br>
                <label>Stan magazynu: ${product.quantity}</label><br><br>
                <input type="hidden" name="name" value="${product.name}">
                <input type="hidden" name="id" value="${product.id}">
                <input type="hidden" name="img" value="${product.image}">
                <input type="hidden" name="param" value="${params.get('c')}">
                <input type="hidden" name="cost" value="${product.cost}">
                <input class="quantity" name="quantity" value="1" type="text"><br>
                <input type="submit" value="Dodaj do koszyka"><br><br>
                <div id="${product.id}"><a style="color: blue" id="komentarze">komentarze</a></div>
                </form>
         </div>
         <div class="space"></div>
    `;
        element++;
        if(5 === element) {
            outputProduct += `<br>`
        }
    });
    productList.innerHTML = outputProduct;
};

const fetchComments = (dataComments, pid) => {
    outputForm = `
    <form id="send-form">
    <textarea rows="3" cols="80" name="com" id="com"></textarea><br><br>
    <button id="send-comment" name="send-comment" type="submit">Dodaj komentarz</button>
    </form>
    `;
    formModal.innerHTML = outputForm;
    function foreachComments() {
        outputModal = ``;
        dataComments.forEach(comment => {
            outputModal += `
        <div style="
        border: 0;
        box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1);
        padding-top: 2%;
        padding-bottom: 2%;
        padding-left: 2%;
        padding-right: 2%;
        ">
        <p><b>${comment.author}</b></p>
        <p style="font-size: 14px;">${comment.text}</p>
        </div><br>
    `;
        });
        commentModal.innerHTML = outputModal;
    }
    foreachComments();


    let sendComment = document.getElementById("send-comment");
    document.getElementById('send-form').addEventListener('submit', (ev) => {
        ev.preventDefault();
        ajaxSendComment();
        ajaxGetComments();
    })

    function ajaxGetComments() {
        const xhr = new XMLHttpRequest();
        xhr.onload = function () {
            dataComments = JSON.parse(this.response);
            foreachComments();
        }
        xhr.open('GET','../product/comment?p=' + pid, true);
        xhr.send();
    }

    function ajaxSendComment() {
        const xhr = new XMLHttpRequest();
        const com = document.getElementById('com');
        xhr.open('POST','../product/comment/add', true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send('author='+userId+ '&text='+com.value+ '&product=' + pid);
    }
}

fetch('../products/fetch_all?c=' + params.get('c'))
    .then(resProducts => resProducts.json())
    .then(dataProducts => fetchProducts(dataProducts))
    .catch(error => console.log('ERROR'))

productList.innerHTML = outputProduct;

productList.addEventListener('click', (e) => {
    let commentPressed = e.target.id === 'komentarze';
    let pid = e.target.parentElement.id;
    if(commentPressed) {
        fetch('../product/comment?p=' + pid)
            .then(resComments => resComments.json())
            .then(dataComments => fetchComments(dataComments, pid))
            .catch(error => console.log('ERROR'))

        modal.style.display = "block";
    }
})