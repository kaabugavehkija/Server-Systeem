document.getElementById("logout").addEventListener("click", 
	function(){
		var lahku = confirm("Oled kindel, et tahad lahkuda?");
		if(lahku==true){
			return true;
		}else{
			event.preventDefault();
			return;
		}
	});