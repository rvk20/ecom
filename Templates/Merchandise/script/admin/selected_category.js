const selectElement = document.querySelector('select[name="categories"]');
const selectElement1 = document.querySelector('select[name="products"]');

executeAsync(function() {
    changeSelectElement("categories",params.get('c'));
});

selectElement.addEventListener('change', (event) => {
    location.href = `?c=${event.target.value}`;
});

selectElement1.addEventListener('change', (event) => {
    location.href = `product?p=${event.target.value}&c=${params.get('c')}`;
});