var grid = [];

var inagrid = [];
var coord = [];

var lin = 15;
var col = 30;

var palavras = ['GREEN','BICYCLE','MOUNTAIN','SMARTY','ESTONIA','LATVIA','RIGA','TALLINN','ZEPPELIN','COW','DOG','CHEESE','HELLO','GOOGLE','LINUX'];

function isEmpty(obj) {
    for(var prop in obj) {
        if(obj.hasOwnProperty(prop))
            return false;
    }
    return true;
}

function criaMatriz(){
    for (var i = 0; i < lin; i++) {
        grid[i] = [];
        for (var j = 0; j < col; j++) {
            grid[i][j] = 0;
        }
    }
}

function display() {
	for (var i = 0; i < lin; i++) {
		for (var j = 0; j < col; j++) {
			document.write(grid[i][j] +",");
		}
		document.write("<br />");
	}
}

function first(word, l, c) {

	place(l, c, word, true);

}

function validate() {

}

function generate(firstword) {
	var mode = false
	currentword = firstword;
	for (var i = 1; i <= palavras.length; i++) {
		matches = letterMatch(currentword, palavras[i]);
		if (!isEmpty(matches)){
			
			var current = coord[i-1];
			var j = 0;

			place(current[0]+matches[j][0],current[1]-matches[j][1], palavras[i], mode);

			/*while (!place(current[0]+matches[j][0],current[1]-matches[j][1], palavras[i], mode)){
				if (j == matches.length){ break;}
				j++;
			}*/
			break;

			/*document.write(currentword + " | " + palavras[i] + "<br />");

			for (var c = 0; c < matches.length; c++) {
				document.write("[" + matches[c] + "]" + " - ");
			}
			document.write("<br />"); */

			if (mode){
				mode = false;
			}else{
				mode = true;
			}

			currentword = palavras[i];

		}
	}
}

function place(lin, col, word, vertical){
	var l =lin;
	var c = col;

	document.write(lin + " : " +col + "<br/>");

	for (var i = 0; i < word.length; i++) {
		grid[lin][col] = word[i];
		if (vertical) { lin++; }
		else { col++; }
	}

	inagrid.push(word);
	coord.push([l, c, lin, col]);
}

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

	firstword = palavras[0];

	first(firstword, 2, 15);
	
	generate(firstword);
	display();
}