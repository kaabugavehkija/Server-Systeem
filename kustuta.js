document.getElementById("kustuta").addEventListener("click", 
	function(){
		var lahku = confirm("Oled kindel, et tahad broneeringu kustutada?");
		if(lahku==true){
			return true;
		}else{
			event.preventDefault();
			return;
		}
	});