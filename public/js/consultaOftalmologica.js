var http = false;

if(navigator.appName == "Microsoft Internet Explorer") {
  http = new ActiveXObject("Microsoft.XMLHTTP");
} else {
  http = new XMLHttpRequest();
}


function MarcarFalta(idCliente,controler){

    if(document.getElementById(idCliente).checked){
     
     http.abort();
  http.open("GET", controler+"/"+idCliente+"/Faltou", true);
  http.onreadystatechange=function() {
    if(http.readyState == 4) {
      //document.getElementById('foo').innerHTML = http.responseText;
      alert("Falta marcada com sucesso!");
    }
  };
  http.send(null);
        
    }else{
        
             http.abort();
  http.open("GET", controler+"/"+idCliente+"/Pendente", true);
  http.onreadystatechange=function() {
    if(http.readyState == 4) {
      //document.getElementById('foo').innerHTML = http.responseText;
      alert("Falta desmarcada com sucesso!");
    }
  };
  http.send(null);
  


    }
    }


