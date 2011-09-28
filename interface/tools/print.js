//PRINT_R FUNCTION FO JS

function print_r(obj) 
{
  		win_print_r = window.open('about:blank', 'win_print_r');
		win_print_r.document.write('<html><body>');
		r_print_r(obj, win_print_r);
		win_print_r.document.write('</body></html>');
}
	
function r_print_r(theObj, win_print_r)
{
	  if(theObj.constructor == Array ||
	   theObj.constructor == Object){
	   if (win_print_r == null)
	    win_print_r = window.open('about:blank', 'win_print_r');
	   }
	   for(var p in theObj){
	    if(theObj[p].constructor == Array||
	     theObj[p].constructor == Object){
	     win_print_r.document.write("<li>["+p+"] =>"+typeof(theObj)+"</li>");
	     win_print_r.document.write("<ul>")
	     r_print_r(theObj[p], win_print_r);
	     win_print_r.document.write("</ul>")
	    } else {
	     win_print_r.document.write("<li>["+p+"] =>"+theObj[p]+"</li>");
	    }
	   }
	  win_print_r.document.write("</ul>")
}
