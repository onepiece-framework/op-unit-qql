
/** op-unit-qql:/webpack/display.js
 *
 * @created     2024-07-19
 * @version     1.0
 * @package     op-unit-qql
 * @author      Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright   Tomoaki Nagahara All right reserved.
 */

//	...
console.log('QQL.display.js');

//	...
document.addEventListener('DOMContentLoaded', function(){
	//	...
	let divs = document.querySelectorAll('div.qql.records');
	divs.forEach(function( div ){
		let table = Table(div.innerText);
		div.innerText = '';
		div.appendChild(table);
	});

	//	...
	function Table(text){
		//	...
		let json  = JSON.parse(text);
		let table = document.createElement('table');
			table.appendChild( tHead(json) );
			table.appendChild( tBody(json) );

		//	...
		return table;
	}

	//	...
	function tHead( json ){
		//	...
		let thead = document.createElement('thead');
		let tr    = document.createElement('tr');
		thead.appendChild(tr);

		//	...
		Object.keys(json[0]).forEach( function(field){
			let th = document.createElement('th');
				th.innerText = field;
			tr.appendChild(th);
		});

		//	...
		return thead;
	}

	//	...
	function tBody( json ){
		//	...
		let tbody = document.createElement('tbody');
		//	...
		json.forEach( function(record){
			//	...
			let tr = document.createElement('tr');
			tbody.appendChild(tr);
			//	...
			Object.keys(record).forEach( function(field){
				let value = record[field];
				let td = document.createElement('td');
					td.innerHTML = value;
				tr.appendChild(td);
			});
		});
		//	...
		return tbody;
	}
});
