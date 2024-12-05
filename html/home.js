// Função para carregar conteúdo dinâmico com base na página solicitada
function loadPage(page) {
    // Verifica se é uma página interna ou externa
    const internalPages = ['dashboard', 'cliente', 'contasPagar', 'contasReceber', 'relatorios', 'perfil', 'graficoUsers'];

    if (internalPages.includes(page)) {
        const pageElement = document.getElementById(page);
        
        // Verifica se o elemento existe antes de tentar acessar seu innerHTML
        if (pageElement) {
            document.getElementById('content').innerHTML = pageElement.innerHTML;
        } else {
            console.error('Elemento não encontrado:', page);
        }
    } else {
        fetch(page)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Erro ao carregar a página: ${response.status} ${response.statusText}`);
                }
                return response.text();
            })
            .then(html => {
                document.getElementById('content').innerHTML = html;
            })
            .catch(error => console.error('Erro ao carregar a página:', error));
    }
}

// Função para carregar o conteúdo externo (sem verificar se é interno)
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
