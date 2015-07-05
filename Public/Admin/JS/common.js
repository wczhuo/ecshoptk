var addrowdirect = 0;
var addrowkey = 0;
function addrow(obj, type, depth) {
	switch(depth){
		case 3:
			var table = obj.parentNode.parentNode.parentNode.parentNode.parentNode;
			if(!addrowdirect) {
				var row = table.insertRow(obj.parentNode.parentNode.parentNode.rowIndex);
			} else {
				var row = table.insertRow(obj.parentNode.parentNode.parentNode.rowIndex + 1);
			}
			var typedata = rowtypedata[type];
			for(var i = 0; i <= typedata.length - 1; i++) {
				var cell = row.insertCell(i);
				cell.colSpan = typedata[i][0];
				var tmp = typedata[i][1];
				if(typedata[i][2]) {
					cell.className = typedata[i][2];
				}
				tmp = tmp.replace(/\{(n)\}/g, function($1) {return addrowkey;});
				tmp = tmp.replace(/\{(\d+)\}/g, function($1, $2) {return addrow.arguments[parseInt($2) + 1];});
				cell.innerHTML = tmp;
			}
			addrowkey ++;
			addrowdirect = 0;
		break;
		default:			
			var table = obj.parentNode.parentNode.parentNode.parentNode.parentNode;
			if(!addrowdirect) {
				var row = table.insertRow(obj.parentNode.parentNode.parentNode.rowIndex);
			} else {
				var row = table.insertRow(obj.parentNode.parentNode.parentNode.rowIndex + 1);
			}
			var typedata = rowtypedata[type];
			for(var i = 0; i <= typedata.length - 1; i++) {
				var cell = row.insertCell(i);
				cell.colSpan = typedata[i][0];
				var tmp = typedata[i][1];
				if(typedata[i][2]) {
					cell.className = typedata[i][2];
				}
				tmp = tmp.replace(/\{(n)\}/g, function($1) {return addrowkey;});
				tmp = tmp.replace(/\{(\d+)\}/g, function($1, $2) {return addrow.arguments[parseInt($2) + 1];});
				cell.innerHTML = tmp;
			}
			addrowkey ++;
			addrowdirect = 0;
		break;
	}
}
function deleterow(obj) {
	$(obj).remove();
	/*var table = obj.parentNode.parentNode.parentNode.parentNode.parentNode;
	var tr = obj.parentNode.parentNode.parentNode;
	table.deleteRow(tr.rowIndex);*/
}