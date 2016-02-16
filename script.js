	resizing = function(){
        document.querySelector("body").style.width = (window.innerWidth).toString() + "px";
        document.querySelector("body").style.height = (window.innerHeight).toString() + "px";
        
        document.getElementById("lecture").style.width = (window.innerWidth - 410).toString() + "px";
        

        document.getElementById("chat").style.width = 400 + "px";
        
        
    }
	
    window.addEventListener("resize", resizing);
	document.addEventListener("DOMContentLoaded", resizing);
	
    function getFile(){
        document.getElementById("fi1").click();
    }
    
