function mostra(opcao) {
    if (opcao == 1) {
        mostraArmacao();
    } else {
        ocultaArmacao();
    }
}

function mostraArmacao() {
    var elem = document.getElementById("armacao");
    elem.style.display = "block";
    ocultaLente();
}

function ocultaArmacao() {
    var elem = document.getElementById("armacao");
    elem.style.display = "none";
}

//KEY_M  = 77; 
//KEY_A  = 65; 
//KEY_N  = 78; 
//KEY_U  = 85; 
//
//var m;
//var a;
//var n;
//var u;
//
//var f;
//  
//function checkEventObj ( _event_ ){ 
// // --- IE explorer 
// if ( window.event ) 
//  return window.event; 
// // --- Netscape and other explorers 
// else 
//  return _event_; 
//} 
//  
//function applyKey (_event_){
//    // --- Retrieve event object from current web explorer
//    var winObj = checkEventObj(_event_);
//
//    var intKeyCode = winObj.keyCode;
//    var intAltKey = winObj.altKey;
//    var intCtrlKey = winObj.ctrlKey;
//    
//
//if (m == 1 && a == 2 && n == 1 && u == 2 && f == 0) {
//    alert("Este easter egg é em homenagem a:\nLisa 22/02/2010\nNika 22/04/2013\nminha maninha do coração\ne minha bobona");
//    m = 0;
//    a = 0;
//    n = 0;
//    u = 0;
//    f = 1;
//    exibeDiv();
//}
//
//    // --- Access with [ALT+Key]
//    if (intAltKey) {
//        if (intKeyCode == KEY_M) {
//            m = 1;
//        }
//        if (intKeyCode == KEY_N) {
//            if (a == 2) {
//                n = 1;
//            }
//        }
//    // --- Access with [Key]
//    } else {
//        if (intKeyCode == KEY_A) {
//            if (m == 1) {
//                a = 2;
//            }
//        }
//        if (intKeyCode == KEY_U) {
//            if (n == 1) {
//                u = 2;
//            }
//        }
//    }
//    
//    if (intCtrlKey) {
//        f = 0;
//    }
//}
//
//function exibeDiv() {
//    var elem = document.getElementById("div_dog");
//    elem.style.display = "block";
//    ocultaLente();
//}
//
//function ocultaDiv() {
//    var elem = document.getElementById("div_dog");
//    elem.style.display = "none";
//}