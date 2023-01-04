const validation = document.querySelector(".validation");
let params = new URLSearchParams(location.search);

if(params.get('v')==='f')
    validation.innerHTML = `Nieprawidłowe dane logowania.`;
if(params.get('v')==='e')
    validation.innerHTML = `Użytkownik już istnieje.`;