const categoryList = document.querySelector('.categories');
let outputCategory = '';

const fetchCategories = (data) => {
    data.forEach(post => {
        outputCategory += `
        <a class="category" id="id${post.id}" href="?c=${post.id}">${post.name}</a><br><br>  
    `;
    });
    categoryList.innerHTML = outputCategory;
};
fetch('/categories/fetch_all')
    .then(res => res.json())
    .then(data => fetchCategories(data))
    .catch(error => console.log('ERROR'))

categoryList.innerHTML = outputCategory;

executeAsync(function() {
    document.getElementById('id'+params.get('c')).style.backgroundColor = "red";
});