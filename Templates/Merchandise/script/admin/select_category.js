const categoryList = document.querySelector('.categories');
let outputCategory = '<option value="">Kategorie …</option>';

const fetchCategories = (data) => {
    data.forEach(post => {
        outputCategory += `
        <option value="${post.id}">${post.name}</option>
    `;
    });
    categoryList.innerHTML = outputCategory;
};
fetch('/categories/fetch_all')
    .then(res => res.json())
    .then(data => fetchCategories(data))
    .catch(error => console.log('ERROR'))

categoryList.innerHTML = outputCategory;