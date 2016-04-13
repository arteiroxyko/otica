//Funções que pesqusam diretamente na pagina
//Carrega paginas ajax pela URL
function openAjax() {
    var Ajax;
    try {Ajax = new XMLHttpRequest(); // XMLHttpRequest para browsers mais populares, como: Firefox, Safari, dentre outros.
    }catch(ee){
    try {Ajax = new ActiveXObject("Msxml2.XMLHTTP"); // Para o IE da MS
    }catch(e){
    try {Ajax = new ActiveXObject("Microsoft.XMLHTTP"); // Para o IE da MS
    }catch(e){Ajax = false;}
    }
    }
    return Ajax;
} 
function carregaAjax(div, getURL) {

    document.getElementById(div).style.display = "block";
    if(document.getElementById) { // Para os browsers complacentes com o DOM W3C.
        var exibeResultado = document.getElementById(div); // div que exibirá o resultado.
        var Ajax = openAjax(); // Inicia o Ajax.
        Ajax.open("GET", getURL, true); // fazendo a requisição
        Ajax.onreadystatechange = function(){
            if(Ajax.readyState == 1) { // Quando estiver carregando, exibe: carregando...
                exibeResultado.innerHTML = "<div>Carregando</div>";
            }
            if(Ajax.readyState == 4) { // Quando estiver tudo pronto.
                if(Ajax.status == 200) {
                    var resultado = Ajax.responseText; // Coloca o retornado pelo Ajax nessa variável
                    //resultado = resultado.replace(/\+/g,""); // Resolve o problema dos acentos (saiba mais aqui: http://www.plugsites.net/leandro/?p=4)
                    //resultado = resultado.replace(/ã/g,"a");
                    resultado = unescape(resultado); // Resolve o problema dos acentos
                    exibeResultado.innerHTML = resultado;
                } else {
                    exibeResultado.innerHTML = "Por favor, tente novamente!";
                }
            }
        }
    Ajax.send(null); // submete
    }
}
//adiciona mascara de cnpj
function MascaraCNPJ(cnpj){
	if(mascaraInteiro(cnpj)==false){
            event.returnValue = false;
	}	
        return formataCampo(cnpj, '00.000.000/0000-00', event);
}
//adiciona mascara de cep
function MascaraCep(cep){
	if(mascaraInteiro(cep)==false){
            event.returnValue = false;
	}	
	return formataCampo(cep, '00000-000', event);
}
//adiciona mascara de data
function MascaraData(data){
	if(mascaraInteiro(data)==false){
		event.returnValue = false;
	}	
	return formataCampo(data, '00/00/0000', event);
}
//adiciona mascara ao telefone
function MascaraTelefone(tel){
        if(tel.value==''){
            return false;
        }
	if(mascaraInteiro(tel)==false){
		event.returnValue = false;
	}
                
        exp = /\-|\.|\/|\(|\)|\,|\:| /g
	campoSoNumeros = tel.value.toString().replace( exp, "" ); 
               
        
        if(campoSoNumeros.length===11){
        return formataCampo(tel, '(00) 00000-0000', event);
        }else{
	return formataCampo(tel, '(00) 0000-0000', event);
        }
}
//cria mascara para Reais
function FormataReais(fld, milSep, decSep, e) {
var sep = 0;
var key = '';
var i = j = 0;
var len = len2 = 0;
var strCheck = '0123456789';
var aux = aux2 = '';
var whichCode = (window.Event) ? e.which : e.keyCode;
if (whichCode == 13) return true;
key = String.fromCharCode(whichCode);  // Valor para o código da Chave
if (strCheck.indexOf(key) == -1) return false;  // Chave inválida
len = fld.value.length;
for(i = 0; i < len; i++)
if ((fld.value.charAt(i) != '0') && (fld.value.charAt(i) != decSep)) break;
aux = '';
for(; i < len; i++)
if (strCheck.indexOf(fld.value.charAt(i))!=-1) aux += fld.value.charAt(i);
aux += key;
len = aux.length;
if (len == 0) fld.value = '';
if (len == 1) fld.value = '0'+ decSep + '0' + aux;
if (len == 2) fld.value = '0'+ decSep + aux;
if (len > 2) {
aux2 = '';
for (j = 0, i = len - 3; i >= 0; i--) {
if (j == 3) {
aux2 += milSep;
j = 0;
}
aux2 += aux.charAt(i);
j++;
}
fld.value = '';
len2 = aux2.length;
for (i = len2 - 1; i >= 0; i--)
fld.value += aux2.charAt(i);
fld.value += decSep + aux.substr(len - 2, len);
fld.value = fld.value.replace(".","");
}
return false;
}
//adiciona mascara ao preco
function MascaraPreco(preco){	
	if(mascaraInteiro(preco)==false){
		event.returnValue = false;
	}
	return formataCampo(preco, '0000.00', event);
}
//adiciona mascara ao CPF
function MascaraCPF(cpf){
	if(mascaraInteiro(cpf)==false){
		event.returnValue = false;
	}	
	return formataCampo(cpf, '000.000.000-00', event);
}
//Adiciona Mascara Horario
function MascaraHorario(horario){
	if(mascaraInteiro(horario)==false){
		event.returnValue = false;
	}	
	return formataCampo(horario, '00:00', event);
}
//Valida Se Cpf é valido
function ValidarCPF(Objcpf){
	var cpf = Objcpf.value;
	exp = /\.|\-/g
	cpf = cpf.toString().replace( exp, "" ); 
	var digitoDigitado = eval(cpf.charAt(9)+cpf.charAt(10));
	var soma1=0, soma2=0;
	var vlr =11;
	
	for(i=0;i<9;i++){
		soma1+=eval(cpf.charAt(i)*(vlr-1));
		soma2+=eval(cpf.charAt(i)*vlr);
		vlr--;
	}	
	soma1 = (((soma1*10)%11)==10 ? 0:((soma1*10)%11));
	soma2=(((soma2+(2*soma1))*10)%11);
	
	var digitoGerado=(soma1*10)+soma2;
	if(digitoGerado!=digitoDigitado)	
		alert('CPF Invalido!');		
}
//valida numero inteiro com mascara
function mascaraInteiro(){
	if (event.keyCode < 48 || event.keyCode > 57){
		event.returnValue = false;
                return false;
	}
	return true;
}
//formata de forma generica os campos
function formataCampo(campo, Mascara, evento) { 
	var boleanoMascara; 
	
	var Digitato = evento.keyCode;
	exp = /\-|\.|\/|\(|\)|\,|\:| /g
	campoSoNumeros = campo.value.toString().replace( exp, "" ); 
   
	var posicaoCampo = 0;	 
	var NovoValorCampo="";
	var TamanhoMascara = campoSoNumeros.length;
	
	if (Digitato != 8) { // backspace 
		for(i=0; i<= TamanhoMascara; i++) { 
			boleanoMascara  = ((Mascara.charAt(i) == "-") || (Mascara.charAt(i) == ".")
								|| (Mascara.charAt(i) == "/")) 
			boleanoMascara  = boleanoMascara || ((Mascara.charAt(i) == "(") 
								|| (Mascara.charAt(i) == ")") || (Mascara.charAt(i) == " ")) 
			if (boleanoMascara) { 
				NovoValorCampo += Mascara.charAt(i); 
				  TamanhoMascara++;
			}else { 
				NovoValorCampo += campoSoNumeros.charAt(posicaoCampo); 
				posicaoCampo++; 
			  }	   	 
		  }	 
		campo.value = NovoValorCampo;
		  return true; 
	}else { 
		return true; 
	}
}
//Abri um popUp com o tamanho informado
function abrirPopUp(url,width,height) {

    if(height>600){
        var left = (screen.width  - width)/2;
        var top = 0;
    }else{

    var left = (screen.width  - width)/2;
    var top = (screen.height - height)/2;
    }
   window.open(url,'janela', 'left='+left+',width='+width+', height='+height+', top='+top+', scrollbars=yes, status=no, toolbar=no, location=yes, directories=no, menubar=no, resizable=no, fullscreen=no'); 

}
//Função que aceita somente numeros
function SomenteNumeros(e){
    
	var tecla=new Number();
	if(window.event) {
		tecla = e.keyCode;
	}
	else if(e.which) {
                    tecla = e.which;
	}
	else {
		return true;
	}
	if((tecla >= "58") || (tecla <= "47")){
		return false;
	}
}
//função que aceita somente letras
function SomenteLetras(e){
	var tecla=new Number();
	if(window.event) {
		tecla = e.keyCode;
	}
	else if(e.which) {
		tecla = e.which;
	}
	else {
		return true;
	}
	if((tecla >= "00") && (tecla <= "31")||(tecla >= "33") && (tecla <= "64")){
		return false;
	}
}
//Mascara que adiciona , no campo double e aceita valor negativo
function Mascara_double(obj){
  valida_num(obj)
  if (obj.value.match("-")){
    mod = "-";
  }else{
    mod = "";
  }
  valor = obj.value.replace("-","");
  valor = valor.replace(",","");
  if (valor.length >= 3){
    valor = poe_ponto_num(valor.substring(0,valor.length-2))+","+valor.substring(valor.length-2, valor.length);
  }
  obj.value = mod+valor;
}

function poe_ponto_num(valor){
  valor = valor.replace(/\./g,"");
  if (valor.length > 3){
    valores = "";
    while (valor.length > 3){
      valores = "."+valor.substring(valor.length-3,valor.length)+""+valores;
      valor = valor.substring(0,valor.length-3);
    }
    return valor+""+valores;
  }else{
    return valor;
  }
}
function valida_num(obj){
  numeros = new RegExp("[0-9]");
  while (!obj.value.charAt(obj.value.length-1).match(numeros)){
    if(obj.value.length == 1 && obj.value == "-"){
      return true;
    }
    if(obj.value.length >= 1){
      obj.value = obj.value.substring(0,obj.value.length-1)
    }else{
      return false;
    }
  }
}

function mostraCampo(id_campo) {
//    var elem = document.getElementById(id_campo);
//    elem.style.display = "block";
var $this = $('#'+id);
$this.attr("required", "true");
$("#"+id_campo).show();
}

function ocultaCampo(id_campo, id) {
//    var elem = document.getElementById(id_campo);
//    elem.style.display = "none";
var $this = $('#'+id);
$this.removeAttr('required');
$("#"+id_campo).hide();
}

function number_format( number, decimals, dec_point, thousands_sep ) {
    // %        nota 1: Para 1000.55 retorna com precisão 1 no FF/Opera é 1,000.5, mas no IE é 1,000.6
    // *     exemplo 1: number_format(1234.56);
    // *     retorno 1: '1,235'
    // *     exemplo 2: number_format(1234.56, 2, ',', ' ');
    // *     retorno 2: '1 234,56'
    // *     exemplo 3: number_format(1234.5678, 2, '.', '');
    // *     retorno 3: '1234.57'
    // *     exemplo 4: number_format(67, 2, ',', '.');
    // *     retorno 4: '67,00'
    // *     exemplo 5: number_format(1000);
    // *     retorno 5: '1,000'
    // *     exemplo 6: number_format(67.311, 2);
    // *     retorno 6: '67.31'
 
    var n = number, prec = decimals;
    n = !isFinite(+n) ? 0 : +n;
    prec = !isFinite(+prec) ? 0 : Math.abs(prec);
    var sep = (typeof thousands_sep == "undefined") ? ',' : thousands_sep;
    var dec = (typeof dec_point == "undefined") ? '.' : dec_point;
 
    var s = (prec > 0) ? n.toFixed(prec) : Math.round(n).toFixed(prec); //fix for IE parseFloat(0.55).toFixed(0) = 0;
 
    var abs = Math.abs(n).toFixed(prec);
    var _, i;
 
    if (abs >= 1000) {
        _ = abs.split(/\D/);
        i = _[0].length % 3 || 3;
 
        _[0] = s.slice(0,i + (n < 0)) +
              _[0].slice(i).replace(/(\d{3})/g, sep+'$1');
 
        s = _.join(dec);
    } else {
        s = s.replace('.', dec);
    }
 
    return s;
}

//function precoMaior(prCusto, prVenda) {
//        prCusto.replace(',', '.');
//        prVenda.replace(',', '.');
//    
//    if (prCusto > prVenda) {
//        if (! confirm('Preço de custo é maior que Preço de venda.\n\nDeseja Cadastrar mesmo assim?')) { 
//            return false;
//        }
//    }
//    return true;
//}
/**
jQuery.noConflict();

function msgAlert(title1,msg1,type1){
    jQuery.msgBox({
    title: title1,
    content: msg1,
	type: type1,
	opacity:0.5
       
});
}
        
function msgConfirm (title1,msg1){

    jQuery.msgBox({
    title: title1,
    content: msg1,
    type: "confirm",
    buttons: [{ value: "Yes" }, { value: "No" }, { value: "Cancel"}],
    success: function (result) {
        if (result == "Yes") {
            return true;
        }else{
            return false;
        }
    }
});
    
    
}




*/


