
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
    // Esta função pode ser usada para carregar diferentes páginas, como por exemplo, usando AJAX
    // Aqui apenas mostra um alerta como exemplo.
    alert("Carregando página: " + page);
}