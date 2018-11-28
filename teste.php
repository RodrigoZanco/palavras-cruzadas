<!DOCTYPE html>
<html>
	<head>

		<meta charset="utf-8">
		<title>Palavras Cruzadas</title>

		<link rel="stylesheet" href="style.css">
		<!--<script type="text/javascript" src="jogo.js"></script>-->

        <?php

            try{
                $username = "root";
                $password = "";
                $conn = new PDO('mysql:host=localhost;dbname=banco_palavras', $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                echo 'Conexão Efetuada com sucesso.<br>';
                     
            }
            catch(PDOException $e) {
                echo 'ERROR: ' . $e->getMessage(); //aqui pode se adicionar um script de retorno junto com o tratamento.
            }
            
            $stmt = $conn->query("SELECT palavra FROM palavras ORDER BY rand() LIMIT 15"); //statement para consulta (query)
            
            $a = 0;

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {  //exemplo de retorno da consulta. Deve se fazer por post para implementar na pagina.
                //echo "<tr><td>id_grupo: ".$row["id_grupo"]." | </td>";
                echo "<td>palavra: ".$row["palavra"]."<br></td>"; 
                echo "</tr>";
                $a++;
                $vetor[] = $row["palavra"];
                //$vetor2[] = $row["id_grupo"];
            }
            echo "tamanho: $a<br>";

            /* ------------------INVERTE VETOR E PRINTA NA TELA (USEI PRA VER SE TAVA FUNCIONANDO)

            $a--;
            while($a >= 0){
                
                echo $vetor["$a"]."<br>";
                $a--;
            }

            */

            // echo '<script>var palavras = "'. $vetor .'";</script>'; - consegue passar a quantidade, mas n o dado do vetor

        ?>



        <script>
        
            /*
                Titulo: 	CrossWordsGenerator
                Autor: 		Henrique Campiotti Marques
                GitHub: 	github.com/sr-henry
                Data: 		27/NOV/2018
            */

            //Matriz do jogo (Tabuleiro)
            var grid = [];

            //Dimensões da matriz (Tabuleiro)
            var linhas = 15;
            var colunas = 30;

            //Lista para armazenar as coordenadas das palavras inseridas na matriz
            var coord = [];

            //Lista de palavras para gerar o jogo
            
            var palavras = ['TALLINN','MOUNTAIN','RIGA','SMARTY','CHEESE','COW','BICYCLE','GREEN','LINUX','ZEPPELIN','GOOGLE','ESTONIA','DOG','LATVIA','HELLO'];

            //Função para embaralhar a Lista de palavras
            function shuffle(array) {

            var currentIndex = array.length, temporaryValue, randomIndex;

            while (0 !== currentIndex) {

                randomIndex = Math.floor(Math.random() * currentIndex);
                currentIndex -= 1;

                temporaryValue = array[currentIndex];
                array[currentIndex] = array[randomIndex];
                array[randomIndex] = temporaryValue;
            }

            return array;
            }

            //Função para verificar se existe elementos em uma estrutura
            function isEmpty(obj) {
                for(var prop in obj) {
                    if(obj.hasOwnProperty(prop))
                        return false;
                }
                return true;
            }

            //Inicializa a matriz (Tabuleiro), com '0'
            function criaMatriz(){
                for (var i = 0; i < linhas; i++) {
                    grid[i] = [];
                    for (var j = 0; j < colunas; j++) {
                        grid[i][j] = 0;
                    }
                }
            }

            //Mostra a matriz de maneira usual
            function display() {
                document.write("<h3>##Matriz##</h3>")
                for (var i = 0; i < linhas; i++) {
                    for (var j = 0; j < colunas; j++) {
                        document.write(grid[i][j] +"    ");
                    }
                    document.write("<br />");
                }
            }

            //Gera o jogo, computa as palavras
            function generate(firstword) {

                var mode = false;
                var v;
                var j;
                var current;
                var matches;
                var currentword = firstword;

                for (var i = 1; i < palavras.length; i++) {//Percorre as palavras da lista de palavras

                    matches = letterMatch(currentword, palavras[i]); //Verifica combinação das letras

                    if (!isEmpty(matches)){ //verifica se existe combinações

                        current = coord[i-1]; //Pega as coordenadas da ultima palavra inserida

                        if (!current) { //Verifica se ela existe
                            current = coord[coord.length-1]; //Caso não exista seu indice é ajustado
                        }

                        j = 0;

                        while (j < matches.length){ //Verificar cada uma das combinações
                            if (mode){ //Verifica a posição da proxima palavra, no caso se for Vertical		
                                //Valida posição a ser inserida	
                                v = validate_place(matches[j][1], (current[0]-matches[j][1]), (current[1]+matches[j][0]), palavras[i], mode);
                            }
                            else{//Se não for vertical é Horizontal
                                v = validate_place(matches[j][1] ,(current[0]+matches[j][0]), (current[1]-matches[j][1]), palavras[i], mode);
                            }

                            if (v) { //Se pode ser inserida ele insere

                                if (mode){
                                    //Insere na Vertical
                                    place(current[0]-matches[j][1], current[1]+matches[j][0], palavras[i], mode); 
                                }
                                else{
                                    //Insere na Horizontal
                                    place(current[0]+matches[j][0], current[1]-matches[j][1], palavras[i], mode);
                                }
                                
                                //Atualiza a palavra atual
                                currentword = palavras[i];

                                //Muda o sentido da proxima palavra
                                if (mode){ mode = false; }
                                else{ mode = true; }

                                break;
                            }
                            else{
                                j++;
                            }
                        }
                    }
                }
            }

            //Insere palavra na matriz (Tabuleiro)
            function place(lin, col, word, vertical){
                var l =lin;
                var c = col;

                //document.write("Function Place: " + word + " == [" + lin + " : " +col + "] <br/>");

                for (var i = 0; i < word.length; i++) {
                    grid[lin][col] = word[i];
                    if (vertical) { lin++; }
                    else { col++; }
                }

                coord.push([l, c, lin, col]);
            }

            //Valida a posição a ser inserida
            function validate_place(letterpos, lin, col, word, vertical) {
                //precisa melhorar
                if (lin < 0 || lin > linhas || col < 0 || col > colunas){
                    return false;
                }
                for (var i = 0; i <= word.length; i++) {
                    if (grid[lin][col]!=0 && grid[lin][col]!=word[letterpos]){
                        return false;
                    }
                    if (vertical){ lin++; }
                    else{ col++; }
                }
                return true;
            }

            //Verifica combinações de letras entre as palavras
            function letterMatch(palavra1, palavra2) {
                matches = [];
                for (var i = 0; i < palavra1.length; i++) {
                    for (var j = 0; j < palavra2.length; j++) {
                        if (palavra1[i] == palavra2[j]) {
                            matches.push([palavra1.indexOf(palavra1[i]), palavra2.indexOf(palavra2[j])]);
                        }
                    }
                }
                return matches;
            }

            function main() {

                criaMatriz();

                palavras = shuffle(palavras);

                firstword = palavras[0];

                //document.write("<h3>##Genrate##</h3><br/>");

                //document.write(palavras + "<br />");

                place(3, 10, firstword, true);
                
                generate(firstword);
                
                //display();

            }

            function inicializar(){
                var tabela = document.getElementById("palavras_cruzadas");

                main();

                dadoMatriz = grid;

                    for (var i=0 ; i < dadoMatriz.length ; i++){
                        var linha = tabela.insertRow(-1);
                        var dadoLinha = dadoMatriz[i];

                        for(var j=0 ; j < dadoLinha.length ; j++){
                            var cel = linha.insertCell(-1);

                            if(dadoLinha[j] != 0){
                                var textoID = String('texto' + '_' + i + '_' + j);
                                cel.innerHTML ='<input type="text" class="formulario" style="text-transform: uppercase" maxlength="1" ' + 'id="' + textoID + '">';
                            } else {
                                cel.style.backgroundColor = "black";
                            }
                        }
                    }
                    numeros_Dica();
                }


            function numeros_Dica(){
                document.getElementById("texto_0_5").placeholder = "1";
                document.getElementById("texto_2_6").placeholder = "2";
                document.getElementById("texto_5_4").placeholder = "3";
                document.getElementById("texto_7_0").placeholder = "4";
                document.getElementById("texto_2_4").placeholder = "5";
                document.getElementById("texto_0_7").placeholder = "6";
                document.getElementById("texto_2_1").placeholder = "7";
            }


            function checar() {
                for (var i = 0; i < dadoMatriz.length; i++) {
                    var dadoLinha = dadoMatriz[i];
                    for (var j = 0; j < dadoLinha.length; j++) {
                        if (dadoLinha[j] != 0) {
                            var celula = document.getElementById('texto' + '_' + i + '_' + j);
                            if (celula.value != dadoMatriz[i][j]) {
                                celula.style.backgroundColor = 'red';
                            } else {
                                celula.style.backgroundColor = 'green';
                            }
                        }    
                    }
                }
            }
        
        </script>

	</head>

	<body onload="inicializar()">

	    <div id="fundo_jogo">
	        <table id="palavras_cruzadas">

	        </table>
	    </div>

	</body>
</html> 