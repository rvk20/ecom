const product = document.querySelector('.product');
let output = '';
let params = new URLSearchParams(location.search);

const fetchProduct = (data) => {
        output += `
        <form action="/admin/product/update?p=${params.get('p')}" method="POST" enctype="multipart/form-data">
            <label for="name">Nazwa:</label><br>
            <input type="text" id="name" name="name" value="${data.name}"><br>
            <label for="name">Koszt:</label><br>
            <input type="text" id="cost" name="cost" value="${data.cost}"><br>
            <label for="name">Ilość:</label><br>
            <input type="text" id="quantity" name="quantity" value="${data.quantity}"><br>
            <label for="name">Obraz:</label><br>
            <input type="file" id="img" name="img" accept="image/*" onchange="preview()"><br><br>
            <img id="show" src="/images/${data.image}" width="200" height="200"><br><br>
            <label for="name">Kategoria:</label><br>
            <select name="category" id="category" class="category">
    `;

};

const fetchCategories = (data) => {
    data.forEach(post => {
        output += `
        <option value="${post.id}">${post.name}</option>
    `;
    });
    output += ` 
            </select><br><br>
            <input type="submit" value="Aktualizuj">
        </form>
    `;
    product.innerHTML = output;
}
fetch('../products/product?p=' + params.get('p'))
    .then(res => res.json())
    .then(data => fetchProduct(data))
    .then(data => fetch('../categories/fetch_all')
        .then(res => res.json())
        .then(data => fetchCategories(data))
        .catch(error => console.log('ERROR'))
    )
    .catch(error => console.log('ERROR'))

executeAsync(function() {
    changeSelectElement("category",params.get('c'));
    document['del-product'].action = "/admin/product/delete?p=" + params.get('p');
});

function preview() {
    let frame = document.getElementById('show');
    frame.src=URL.createObjectURL(event.target.files[0]);
}

product.innerHTML = output;
