var Stores = GTU_L.Posts;

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
function GTU_L_Geolocate() {  //finds the users location, then runs GTU_L_NearestStore();
	var locator = document.getElementById('locator');
	
	setTimeout(function() { // Slight delay so you can "see the button working"
		function success(position) { GTU_L_NearestStore(position.coords.latitude, position.coords.longitude); }
		function error() {
			// if(locator) { locator.innerHTML = 'Unable to retrieve your location'; }
		}

		if (!navigator.geolocation) { if(locator) { locator.innerHTML = 'Geolocation is not supported by your browser'; } }
		else {
//			if(locator) { locator.innerHTML = 'Loading...'; }
			navigator.geolocation.getCurrentPosition(success, error);
		}
	}, 100);
}
function GTU_L_NearestStore(UserLat, UserLng) {  //compares user's location to allstores.js
	function vectorDistance(dx, dy) { return Math.sqrt(dx * dx + dy * dy); }
	for(var x in Stores) {
		if(Stores[0].ACF) {
			Stores[x].distance = vectorDistance(UserLat-Stores[x].ACF.latitude,UserLng-Stores[x].ACF.longitude);
		}
		else {
			Stores[x].distance = vectorDistance(UserLat-Stores[x].Latitude,UserLng-Stores[x].Longitude)
		}
		Stores[x].distance *= 69;
	}	
	function compare( a, b ) {
		if ( a.distance < b.distance ){ return -1; }
		if ( a.distance > b.distance ){ return 1; }
		return 0;
	}
	Stores.sort(compare);
	
	// Assign the location to GTU_L.Local
	GTU_L.Local = GTU_L.Posts[0];
	// Drop "Corporate" from the list
	for(var x in Stores) {
		if(Stores[x].post_title.toLowerCase() == 'corporate') {
			Stores.splice(x,1);
		}
	}
	
	// Draw Results
	GTU_L_DrawStoreList();
}
function GTU_L_DrawStoreList() {  //draws store list in formatted html
	var ThisText = '';
	var Rule = GTU_L_GetURLVariable('ve');
	if(Rule!=false) {Rule = '?ve=' + Rule;}
	else {Rule = '';}
	
	var locator = document.getElementById("locator");
	var NearestStore = document.getElementById("NearestStore");

// This was removed in 0.2.1. I believe this is the cause of the non-location bug.
// Looks like this was added to all access to BranchID after geolocation was used. Creating an alternative method instead.
// GTU_VE.BranchID = Stores[0].branchid;

	if(locator) {
		var StoreLimit = 100;
		
		for(var x in Stores) { // Assign HTML to ThisText... 
			var Store = Stores[x].ACF;
			if(Store.gmb != null) {Store.gmblink = ['<a href="' +Store.gmb+ '">','</a>'];} else {Store.gmblink = ['',''];}
			if(Store.savvy_sliders) { var SavvySliders = '<a href="https://'+window.location.hostname+'/'+Stores[x].post_name+'"><img class="w-25 pl-2 pr-4 pb-1" src="https://'+window.location.hostname+'/wp-content/themes/happys-theme/images/savvy2.png"></a>' }
			else { var SavvySliders = ''; }

			if(x<StoreLimit) {
				ThisText += '<div class="row py-3 divider-horiz justify-content-center no-gutters">';
					// Left Part
					ThisText += '<div class="d-none d-lg-block col-lg-3 pr-3 pr-lg-0">';
						ThisText += '<a href="https://'+window.location.hostname+'/' +Stores[x].post_name+ '">';
							if(Stores[x].FeaturedImage != '') { ThisText += '<img class="w-100" src="' +Stores[x].FeaturedImage+ '"></a>' }
							else { ThisText += '<img class="w-75 p-4" src="/wp-content/themes/happys-theme/images/hp_mascot_thumbsup.png"></a>' }
						ThisText += '<a class="w-100 btn btn-sm bg-gradient" href="' +Store.gmb+ '"><i class=" fas fa-map-marked-alt" aria-hidden="true"></i> Get Directions' +Store.gmblink[1]+ '</a>';
					ThisText += '</div>';

					// Middle Part
					ThisText += '<div class="col-12 col-lg-4 row text-left pl-lg-5 pt-2 pt-lg-0 no-gutters">';
						ThisText += '<h3 class="mb-0 text-center text-lg-left w-100 pb-2 pb-lg-0">'+Store.name+SavvySliders+'</h3>';
						// Address Block
						ThisText += '<div class="col-7 col-lg-12">';
							ThisText += Store.street+'<br>';
							ThisText += Store.city+ ', ' +Store.state+ ' ' +Store.zip;
							ThisText += GTU_L_Phone(Store.phone, ['<i class="fas fa-phone" aria-hidden="true"></i> ',''],'clearfix my-2 d-lg-none', 'fas fa-phone');
						ThisText += '</div>';
						// "X Miles Away", View Store Page, View Hours
						ThisText += '<div class="col-5 my-lg-3">';
							if(Stores[x].distance) { ThisText += (Math.round(Stores[x].distance * 10, 5))/10+ ' Miles away!<br>'; }
							else { ThisText+= '<br>'; }
							
							ThisText += '<a href="https://'+window.location.hostname+'/' +Stores[x].post_name+Rule+ '"><i class="fas fa-building"></i> View Store Page</a><br>';
							ThisText += '<a href="https://'+window.location.hostname+'/' +Stores[x].post_name+ '"><i class="fas fa-clock"></i> View hours</a>';
						ThisText += '</div>';
					ThisText += '</div>';

					// Right Part
					ThisText += '<div class="col-lg-4">';
						ThisText += '<div class="">';
							ThisText += '';
						ThisText += '</div>';
						ThisText += '<div class="row justify-content-between no-gutters">';
							// "Open Till..." logic
							var d = new Date();
							var Today = d.getDay();

							var Hours = [];
							Hours[0] = Store.sun_close;
							Hours[1] = Store.mon_close;
							Hours[2] = Store.tue_close;
							Hours[3] = Store.wed_close;
							Hours[4] = Store.thu_close;
							Hours[5] = Store.fri_close;
							Hours[6] = Store.sat_close;

							if(Hours[Today]) { // If it's open, tell people
								if(Hours[Today].split(':')[0] == 0) { Hours[Today] = 12 + ':' +Hours[Today].split(':')[1]+ 'am'; }
								else if(Hours[Today].split(':')[0] > 12) { Hours[Today] = (Hours[Today].split(':')[0] - 12)+ ':' +Hours[Today].split(':')[1]+ 'pm'; }
								else { Hours[Today] = Hours[Today]+ 'am'; }

								ThisText += '<h3 class="col-12 text-center mb-3 d-none d-lg-block">Open today until '+Hours[Today]+'!</h3>';
							}
							else { // If it's close, tell them something else
								ThisText += '<h3 class="col-12 text-center mb-3 d-none d-lg-block">&nbsp;</h3>';
							}
							ThisText += '<a class="col-5 my-2 btn btn-md bg-gradient" href="javascript:GTU_VE_Link_Force(\'pickup\',\''+Store.branchid+'\');">Pickup</a>';
							ThisText += '<a class="col-5 my-2 btn btn-md bg-gradient" href="javascript:GTU_VE_Link_Force(\'delivery\',\''+Store.branchid+'\');">Delivery</a>';
							ThisText += GTU_L_Phone(Store.phone, ['<h3><i class="fas fa-phone" aria-hidden="true"></i> ','</h3>'],'col-12 my-2 d-none d-lg-block', 'fas fa-phone');
						ThisText += '</div>';
					ThisText += '</div>';
				ThisText += '</div>';
			}
		}
		locator.innerHTML = ThisText;
	}
	if(NearestStore) {
		var Store = Stores[0].ACF;
		if(Store.gmb != null) {Store.gmblink = ['<a href="' +Store.gmb+ '">','</a>'];} else {Store.gmblink = ['',''];}
		if(Store.savvy_sliders) { var SavvySliders = '<a href="https://'+window.location.hostname+'/'+Stores[1].post_name+'"><img class="w-25 pl-2 pr-4 pb-1" src="https://'+window.location.hostname+'/wp-content/themes/happys-theme/images/savvy2.png"></a>' }
		else { var SavvySliders = ''; }
		
		{ // Draw everything
			ThisText += '<div class="row">';
				// Left Side
				ThisText += '<div class="col-4 justify-content-center">';
					ThisText += '<a href="https://'+window.location.hostname+'/' +Stores[0].post_name+ '">';
						if(Stores[0].FeaturedImage != '') { ThisText += '<img class="w-100" src="' +Stores[0].FeaturedImage+ '"></a>' }
						else { ThisText += '<img class="w-75 p-2" src="/wp-content/themes/happys-theme/images/hp_mascot_thumbsup.png"></a>' }
					ThisText += '<h6 class="small"><a class="w-100 btn btn-sm hp-bgblack" href="' +Store.gmb+ '" target="_blank"><i class=" fas fa-map-marked-alt" aria-hidden="true"></i> Map It</a></h6>';
					ThisText += '<div class="hp-distanceaway hp-cherry">NOT YOUR STORE?</div>';
					ThisText += '<div><a href="/locations/">Select another</a></div>';
				ThisText += '</div>';
			
				// Right Side
				ThisText += '<div class="col-8">';
					ThisText += '<h3 class="mb-0 all-caps text-center hp-mdheadline">' +Stores[0].post_title+ ' <span class="hp-distanceaway hp-cherry">' +(Math.round(Stores[0].distance * 10, 5) / 10)+ 'm away</span></h3>';
					ThisText += '<div class="row mt-0 pt-0">';
						ThisText += '<div class="col"><a class="my-2 btn btn-sm bg-gradient w-100" href="javascript:GTU_VE_Link_Force(\'pickup\',\''+Store.branchid+'\');">Pickup</a></div>';
						ThisText += '<div class="col"><a class="my-2 btn btn-sm bg-gradient w-100" href="javascript:GTU_VE_Link_Force(\'delivery\',\''+Store.branchid+'\');">Delivery</a></div>';
					ThisText += '</div>';
					ThisText += '<div class="row font-weight-bold mt-2">';
						ThisText += '<div class="col-lg-auto text-center"><a href="tel:' +Store.phone+ '"><i class="fas fa-phone"></i> ' +GTU_L_FormatPhone(Store.phone)+ '</a></div>';
						ThisText += '<div class="col-lg-auto text-center"><a href="' +Stores[0].post_name+ '"><i class="fas fa-building" aria-hidden="true"></i> Store Page</a></div>';
						ThisText += '<div class="col-lg-auto text-center"><a href="https://'+window.location.hostname+'/' +Stores[0].post_name+ '#hours"><i class="fas fa-clock" aria-hidden="true"></i> Hours</a></div>';
					ThisText += '</div>';
					ThisText += '<hr class="divider-horiz-thintan my-2"></hr>';
					ThisText += '<p class="hp-lgtext text-center">' +Store.street+ '<br>' +Store.city+ ', ' +Store.state+ ' ' +Store.zip+ '</p>';
				ThisText += '</div>';
			ThisText += '</div>';
		}
		NearestStore.innerHTML = ThisText;
	}
}
function GTU_L_FormatPhone(InputPhone) { return ( '(' +InputPhone.substr(0,3)+ ') ' +InputPhone.substr(3,3)+ '-' +InputPhone.substr(6,4)); }
function GTU_L_Phone(Phone,DisplayText=['',''],Classes='') { // Prints Phone Buttons button using Location's "Address Phone" link.
	return ('<a href="tel:' +Phone+ '" class="' +Classes+ '">' +DisplayText[0]+ ' ' +GTU_L_FormatPhone(Phone)+ ' ' +DisplayText[1]+ '</a>');
}
function GTU_L_Ziplocate() {  //finds the users location via Zip, then runs GTU_L_NearestStore();
	var MyZip = document.getElementById('Zip').value;
	
	var locator = document.getElementById('locator');
	if(Zips[MyZip]) {
		if(locator) { locator.innerHTML = 'Loading...'; }
		setTimeout(function() { // Slight delay so you can "see the button working"
			GTU_L_NearestStore(Zips[MyZip][0], Zips[MyZip][1]);
		}, 100);
	}
	else {
		if(locator) { locator.innerHTML = '<h3 class="divider-horiz hp-cherry text-center py-4">Zip Code not found.</h3>'; }
	}
}