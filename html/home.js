// Função para carregar conteúdo dinâmico com base na página solicitada
function loadPage(page) {
    // Define as páginas internas onde o conteúdo já está no HTML
    const internalPages = ['dashboard', 'cliente', 'contasPagar', 'contasReceber', 'relatorios', 'perfil', 'graficoUsers'];

    // Verifica se a página solicitada é interna
    if (internalPages.includes(page)) {
        loadInternalPage(page); // Carrega página interna
    } else {
        loadExternalPage(page); // Carrega página externa
    }
}

// Função para carregar o conteúdo de páginas internas
function loadInternalPage(page) {
    const pageElement = document.getElementById(page);

    // Verifica se o elemento existe antes de tentar acessar seu innerHTML
    if (pageElement) {
        document.getElementById('content').innerHTML = pageElement.innerHTML;
    } else {
        console.error('Elemento não encontrado:', page);
    }
}

// Função para carregar o conteúdo de páginas externas (com fetch)
function loadExternalPage(page) {
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
        .catch(error => {
            console.error('Erro ao carregar a página:', error);
            document.getElementById('content').innerHTML = "<p>Erro ao carregar o conteúdo externo.</p>";
        });
}

// Função para carregar conteúdo dinâmico com base na página solicitada
function loadPagee(page) {
    // Referência para o conteúdo da página
    const contentDiv = document.getElementById("content");

    // Antes de iniciar o carregamento, mostra uma mensagem de "Carregando..."
    contentDiv.innerHTML = "<p>Carregando...</p>";

    // Realiza o fetch para buscar o conteúdo da página
    fetch(page)
        .then(response => {
            // Verifica se a resposta é bem-sucedida (status 2xx)
            if (!response.ok) {
                throw new Error(`Erro ao carregar a página: ${response.status} ${response.statusText}`);
            }
            return response.text(); // Retorna o conteúdo HTML da página
        })
        .then(data => {
            // Exibe o conteúdo carregado no console para depuração
            console.log("Conteúdo carregado:", data);

            if (!data) {
                throw new Error("Conteúdo vazio retornado da página.");
            }

            // Atualiza o conteúdo da div #content com o HTML retornado
            contentDiv.innerHTML = data;
        })
        .catch(error => {
            // Se ocorrer algum erro, exibe uma mensagem apropriada
            console.error('Erro ao carregar o conteúdo:', error);
            contentDiv.innerHTML = "<p>Erro ao carregar o conteúdo. Tente novamente mais tarde.</p>";
        });
}
