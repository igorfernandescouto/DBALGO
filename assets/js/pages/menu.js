document.querySelector('form').addEventListener('submit', function(e) {
    e.preventDefault();  // Prevenir comportamento padrão
    window.location.href = 'index.html';  // Redireciona após o cadastro
});
