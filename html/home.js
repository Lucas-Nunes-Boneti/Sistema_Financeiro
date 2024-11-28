
function loadPage(page) {
    // Verifica se é uma página interna ou externa (Dashboard, Perfil etc. são seções internas)
    if (page === 'dashboard' || page === 'contasPagar' || page === 'contasReceber' || 
        page === 'relatorios' || page === 'perfil') {
        document.getElementById('content').innerHTML = document.getElementById(page).innerHTML;
    } else {
        // Carrega uma página externa como 'Usuario.html' via AJAX
        fetch(page)
            .then(response => response.text())
            .then(html => {
                document.getElementById('content').innerHTML = html;
            })
            .catch(error => console.error('Erro ao carregar a página:', error));
    }
}

document.addEventListener('DOMContentLoaded', () => {
    loadPage('dashboard');
});

function loadPagee(page) {
    fetch(page)
        .then(response => response.text())
        .then(data => {
            // Acessa o elemento onde o conteúdo será carregado
            document.getElementById("content").innerHTML = data;
        })
        .catch(error => {
            console.error('Erro ao carregar o conteúdo:', error);
            document.getElementById("content").innerHTML = "<p>Erro ao carregar o conteúdo.</p>";
        });
}