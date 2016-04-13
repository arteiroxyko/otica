var http = false;

if (navigator.appName == "Microsoft Internet Explorer") {
    http = new ActiveXObject("Microsoft.XMLHTTP");
} else {
    http = new XMLHttpRequest();
}


function Baixa(idCheque, controler) {

    if (document.getElementById(idCheque).checked) {

        http.abort();
        http.open("GET", controler + "/" + idCheque + "/1", true);
        http.onreadystatechange = function() {
            if (http.readyState == 4) {
                //document.getElementById('foo').innerHTML = http.responseText;
                alert("Baixa do cheque marcada com sucesso!");
            }
        };
        http.send(null);

    } else {

        http.abort();
        http.open("GET", controler + "/" + idCheque + "/0", true);
        http.onreadystatechange = function() {
            if (http.readyState == 4) {
                //document.getElementById('foo').innerHTML = http.responseText;
                alert("Cheque não foi recebido!");
            }
        };
        http.send(null);



    }
}