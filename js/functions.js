function newCustomer() {
	//Eerst hidden input klantId leeg maken
	document.getElementById("klantId").value = "";
	
	//Inputfield klantnaam leegmaken, backgroundcolor aanpassen en focus geven
	var id 				= "klantnaam";
	var e 				= document.getElementById(id);
	e.value 			= "";
    e.disabled 			= false;
    e.editable 			= true;
    e.style.background 	= "rgba(0, 255, 0, 0.3)";
    e.focus();
    
    //inputfield email leegmaken
	var id 				= "email";
	var e 				= document.getElementById(id);
	e.value 			= "";
    e.disabled 			= false;
    e.editable 			= true;
    
    //inputfield telefoon leegmaken
	var id 				= "telefoon";
	var e 				= document.getElementById(id);
	e.value 			= "";
    e.disabled 			= false;
    e.editable 			= true;
}