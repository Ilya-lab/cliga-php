
function is_array( mixed_var ) {	// Finds whether a variable is an array
	//
	// +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	// +   improved by: Legaev Andrey
	// +   bugfixed by: Cord

	return ( mixed_var instanceof Array );
}

function empty( mixed_var ) {	// Determine whether a variable is empty
	//
	// +   original by: Philippe Baumann

	return ( mixed_var === "" || mixed_var === 0   || mixed_var === "0" || mixed_var === null  || mixed_var === false  ||  ( is_array(mixed_var) && mixed_var.length === 0 ) );
}

function declOfNum(number, titles) {
    cases = [2, 0, 1, 1, 1, 2];
    return number+" "+titles[ (number%100>4 && number%100<20)? 2 : cases[(number%10<5)?number%10:5] ];
}
function birthDateToAge(b, n) {
    var x = new Date(n), z = new Date(b), b = new Date(b), n = new Date(n);
    x.setFullYear(n.getFullYear() - b.getFullYear(), n.getMonth() - b.getMonth(), n.getDate() - b.getDate());
    z.setFullYear(b.getFullYear() + x.getFullYear(), b.getMonth() + x.getMonth() + 1);
    if (z.getTime() == n.getTime()) {
        if (x.getMonth() == 11) {
            return [x.getFullYear() + 1, 0, 0];
        } else {
            return [x.getFullYear(), x.getMonth() + 1, 0];
        }
    } else {
        return [x.getFullYear(), x.getMonth(), x.getDate()];
    }
}
