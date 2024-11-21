function validarFormulario(event) {
    event.preventDefault(); // Impede o envio do formulário até a validação

    // Seleciona tods os campos do form
    const nome = document.getElementById("nome");
    const datadenascimento = document.getElementById("datadenascimento");
    const profissao = document.getElementById("profissao");
    const cpf = document.getElementById("cpf");
    const email = document.getElementById("email");
    const telefone = document.getElementById("telefone");
    const cidade = document.getElementById("cidade");
    const endereco = document.getElementById("endereco");
    const bairro = document.getElementById("bairro");
    const cep = document.getElementById("cep");
    const numero = document.getElementById("numero");
    const senha = document.getElementById("senha");
    const confirmarsenha = document.getElementById("confirmarsenha");
    //variavel local para verificar o erro
    let mensagemErro = "";

    // esta eh uma validação do CPF
    const regexCPF = /^\d{3}-\d{3}-\d{3}-\d{2}$/;
    if (!regexCPF.test(cpf.value)) {
        mensagemErro += "Por favor, insira um CPF válido (formato: xxx-xxx-xxx-xx).\n";
    }

    if (nome.value.trim() === "") {
        mensagemErro += "Por favor, informe seu nome.\n";
    }

    const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!regexEmail.test(email.value)) {
        mensagemErro += "Por favor, insira um e-mail válido.\n";
    }
    //celular
    const regextelefone = /^\(\d{2}\) \d{5}-\d{4}$/;
    if (!regextelefone.test(celular.value)) {
        mensagemErro += "Por favor, insira um telefone válido (formato: (xx) xxxxx-xxxx).\n";
    }
    if (cidade.value.trim() === "") {
        mensagemErro += "Por favor, informe sua cidade.\n";
    }
    //data de nascimento
    if (datadenascimento.value === "") {
        mensagemErro += "Por favor, informe sua data de nascimento.\n";
    }

    // cidade
    if (sexo.value.trim() === "") {
        mensagemErro += "Por favor, informe seu sexo.\n";
    }
    if (profissao.value.trim() === "") {
        mensagemErro += "Por favor, informe sua profissao.\n";
    }

    // endereço
    if (endereco.value.trim() === "") {
        mensagemErro += "Por favor, informe seu endereço.\n";
    }
    if (bairro.value.trim() === "") {
        mensagemErro += "Por favor, informe seu bairro.\n";
    }
    if (cep.value.trim() === "") {
        mensagemErro += "Por favor, informe o cep.\n";
    }
    //  número da casa
    if (numeroCasa.value.trim() === "") {
        mensagemErro += "Por favor, informe o número da casa.\n";
    }

    // senha (mínimo de 8 caracteres)
    if (senha.value.length < 8) {
        mensagemErro += "A senha deve ter pelo menos 8 caracteres.\n";
    }

    //  confirmação de senha coincide
    if (senha.value !== confirmarsenha.value) {
        mensagemErro += "As senhas não coincidem.\n";
    }

    //  mensagens de erro, se houver
    if (mensagemErro !== "") {
        alert(mensagemErro);
    } else {
        document.querySelector("form").submit(); // ok para o envio do form
    }
}