function GTU_L_FormAutofillLocation(FieldID) { // On all forms specified, autofill the "Location" field with GTU_L.Local
	var FormID = GTU_L_Find_GFID();
	var DropdownID = 'input_'+FormID+'_' +FieldID;
	var Dropdown = document.getElementById(DropdownID);
	
	if(FormID) {
		for(var x in Dropdown.options) {
			if(Dropdown.options[x].value == GTU_L.Local.post_name) {
//				Test_VE(Dropdown.options[x].selected);
				Dropdown.options[x].selected = true;
				break;
			}
		}
	}
}
function GTU_L_Find_GFID() { // Returns the FormID of a Broadcasted Gravity Form, blind-rubik's-style
	var FormID = ''; 
	for (var x=0; x<99; x++) {
		if(FormID == '') {
			for (var y=0; y<99; y++) {
				if(document.getElementById('field_' +x+ '_' +y)) {
					FormID = x;
					return FormID;
					break;
				}
			}
		}
	}
}
function GTU_L_GetURLVariable(variable) { // Returns URL Variable
       var query = window.location.search.substring(1);
       var vars = query.split("&");
       for (var i=0;i<vars.length;i++) {
               var pair = vars[i].split("=");
               if(pair[0] == variable){return pair[1];}
       }
       return(false);
}
function GTU_L_FormatPhone(InputPhone) { return ( '(' +InputPhone.substr(0,3)+ ') ' +InputPhone.substr(3,3)+ '-' +InputPhone.substr(6,4)); }
function GTU_L_Phone(Phone,DisplayText=['',''],Classes='') { // Prints Phone Buttons button using Location's "Address Phone" link.
	return ('<a href="tel:' +Phone+ '" class="' +Classes+ '">' +DisplayText[0]+ ' ' +GTU_L_FormatPhone(Phone)+ ' ' +DisplayText[1]+ '</a>');
}