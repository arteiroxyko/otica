function populaResponsavel(idCliente,nome,cpf) {
    
    ocultaPesquisaDinamica();
    mostraFormDependente(idCliente,nome,cpf);
            
}

function mostraFormDependente(idCliente,nome,cpf) {
    
    var elem = document.getElementById("formDependente");
    var inputIdCliente = document.getElementById("inputIdCliente");
    var inputNome = document.getElementById("inputNomeCliente");
    var inputcpf = document.getElementById("inputCpfCliente");
    var nomeDependente = document.getElementById("inputNomeDependente");
    elem.style.display = "block";
    
    inputIdCliente.value=idCliente;
    inputNome.value=nome;
    inputcpf.value=cpf;
    nomeDependente.focus();
  
}

function ocultaPesquisaDinamica() {
    var elem = document.getElementById("pesquisaDinamica");
    elem.style.display = "none";
}

function ocultaFormDependente() {
    var elem = document.getElementById("formDependente");
    elem.style.display = "none";
}