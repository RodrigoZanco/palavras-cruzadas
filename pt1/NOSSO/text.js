var palavras = [ 'elefante', 'cachorro', 'formiga', 'arara', 'sapo', 'cao'];




function ini(){
    /* linha inicioPalavra + (0 até tamanhoPalavra)(VARIAVEL)  - coluna sorteio(0-9)(FIXO)                      VERTICAL */
    /* linha linha sorteio(0-9)(FIXO) - coluna inicioPalavra + (0 até tamanhoPalavra)(VARIAVEL)                 HORIZONTAL */
    var i = 1;
    var x = i;
    var y = 0;
    var cont = 0;

    for(x ; x < palavras.length && cont==0; x++) {
        for(y ; y < palavras[x].length && cont==0 ; y++) {
            if (palavras[i-1].indexOf(palavras[x][y]) >= 0){
            var letraIgualReceptor = palavras[i-1].indexOf(palavras[x][y]);
            var letraIgualBusca = y;
            var palavra = x;
            cont = 1;
            }
        }
    }

    document.write(letraIgualReceptor);
    document.write(letraIgualBusca);
    document.write(palavra);




}