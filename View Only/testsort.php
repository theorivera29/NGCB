<table id="indextable" border="1" cellpadding="10" cellspacing="0" style="border-collapse:collapse;">
<thead>
<tr>
<th><a href="javascript:SortTable(0,'T');">Author</a></th>
<th><a href="javascript:SortTable(1,'T');">Title</a></th>
<th><a href="javascript:SortTable(2,'N');">Rating</a></th>
<th><a href="javascript:SortTable(3,'D','mdy');">Review Date</a></th>
</tr>
</thead>
<tbody>
<tr>
<td>Orson Scott Card</td>
<td>The Memory Of Earth</td>
<td align="center">2</td>
<td>10/14/11</td>
</tr>
<tr>
<td>Sarah-Kate Lynch</td>
<td>Blessed Are The Cheesemakers</td>
<td align="center">9</td>
<td>1-12-2011</td>
</tr>
<tr>
<td>John Irving</td>
<td>The cider house rules</td>
<td align="center">6</td>
<td>January 31, 11</td>
</tr>
<tr>
<td>Kate Atkinson</td>
<td>When will there be good news?</td>
<td align="center">7</td>
<td>Nov. 31, 2001</td>
</tr>
<tr>
<td>Kathy Hogan Trocheck</td>
<td>Every Crooked Nanny</td>
<td align="center">2</td>
<td>10.21.21</td>
</tr>
<tr>
<td>Stieg Larsson</td>
<td>The Girl With The Dragon Tattoo</td>
<td align="center">2</td>
<td>August 3, 2022</td>
</tr>
</tbody>
</table>

<script type="text/javascript">
var TableIDvalue = "indextable";
var TableLastSortedColumn = -1;
function SortTable() {
var sortColumn = parseInt(arguments[0]);
var type = arguments.length > 1 ? arguments[1] : 'T';
var dateformat = arguments.length > 2 ? arguments[2] : '';
var table = document.getElementById(TableIDvalue);
var tbody = table.getElementsByTagName("tbody")[0];
var rows = tbody.getElementsByTagName("tr");
var arrayOfRows = new Array();
type = type.toUpperCase();
dateformat = dateformat.toLowerCase();
for(var i=0, len=rows.length; i<len; i++) {
	arrayOfRows[i] = new Object;
	arrayOfRows[i].oldIndex = i;
	var celltext = rows[i].getElementsByTagName("td")[sortColumn].innerHTML.replace(/<[^>]*>/g,"");
	if( type=='D' ) { arrayOfRows[i].value = GetDateSortingKey(dateformat,celltext); }
	else {
		var re = type=="N" ? /[^\.\-\+\d]/g : /[^a-zA-Z0-9]/g;
		arrayOfRows[i].value = celltext.replace(re,"").substr(0,25).toLowerCase();
		}
	}
if (sortColumn == TableLastSortedColumn) { arrayOfRows.reverse(); }
else {
	TableLastSortedColumn = sortColumn;
	switch(type) {
		case "N" : arrayOfRows.sort(CompareRowOfNumbers); break;
		case "D" : arrayOfRows.sort(CompareRowOfNumbers); break;
		default  : arrayOfRows.sort(CompareRowOfText);
		}
	}
var newTableBody = document.createElement("tbody");
for(var i=0, len=arrayOfRows.length; i<len; i++) {
	newTableBody.appendChild(rows[arrayOfRows[i].oldIndex].cloneNode(true));
	}
table.replaceChild(newTableBody,tbody);
} // function SortTable()

function CompareRowOfText(a,b) {
var aval = a.value;
var bval = b.value;
return( aval == bval ? 0 : (aval > bval ? 1 : -1) );
} // function CompareRowOfText()

function CompareRowOfNumbers(a,b) {
var aval = /\d/.test(a.value) ? parseFloat(a.value) : 0;
var bval = /\d/.test(b.value) ? parseFloat(b.value) : 0;
return( aval == bval ? 0 : (aval > bval ? 1 : -1) );
} // function CompareRowOfNumbers()

function GetDateSortingKey(format,text) {
if( format.length < 1 ) { return ""; }
format = format.toLowerCase();
text = text.toLowerCase();
text = text.replace(/^[^a-z0-9]*/,"");
text = text.replace(/[^a-z0-9]*$/,"");
if( text.length < 1 ) { return ""; }
text = text.replace(/[^a-z0-9]+/g,",");
var date = text.split(",");
if( date.length < 3 ) { return ""; }
var d=0, m=0, y=0;
for( var i=0; i<3; i++ ) {
	var ts = format.substr(i,1);
	if( ts == "d" ) { d = date[i]; }
	else if( ts == "m" ) { m = date[i]; }
	else if( ts == "y" ) { y = date[i]; }
	}
d = d.replace(/^0/,"");
if( d < 10 ) { d = "0" + d; }
m = m.replace(/^0/,"");
if( m < 10 ) { m = "0" + m; }
y = parseInt(y);
if( y < 100 ) { y = parseInt(y) + 2000; }
return "" + String(y) + "" + String(m) + "" + String(d) + "";
} // function GetDateSortingKey()
</script>

