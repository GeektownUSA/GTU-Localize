function GTU_L_Geolocate() {
  //finds the users location, then runs GTU_L_NearestLocation();
  function success(position) {
    // Do something on success
    GTU_L_NearestLocation(position.coords.latitude, position.coords.longitude);
  }
  function error() {
    // Do something on error
  }

  if (!navigator.geolocation) {
    // Do if Geolocation is turned off
  } else {
    // Run geolocation
    navigator.geolocation.getCurrentPosition(success, error);
  }

  //44.2091874,-101.3681903 South Dakota
  //GTU_L_NearestLocation(44.2091874, -101.3681903)
}
function GTU_L_NearestLocation(UserLat, UserLng) {
  //compares user's location to allGTU_L_Locations.js
  // Drop "Corporate" from the list
  var copropateIdx = GTU_L_Locations.findIndex(
    (l) => l.post_name == GTU_L_Settings["GTU_L_Settings_Corporate"]
  );

  if (~copropateIdx) GTU_L_Locations.splice(copropateIdx, 1);

  function vectorDistance(dx, dy) {
    return Math.sqrt(dx * dx + dy * dy);
  }
  for (var x in GTU_L_Locations) {
    if (GTU_L_Locations[x].ACF) {
      GTU_L_Locations[x].distance = vectorDistance(
        UserLat - GTU_L_Locations[x].ACF.latitude,
        UserLng - GTU_L_Locations[x].ACF.longitude
      );
    } else {
      GTU_L_Locations[x].distance = vectorDistance(
        UserLat - GTU_L_Locations[x].Latitude,
        UserLng - GTU_L_Locations[x].Longitude
      );
    }
    GTU_L_Locations[x].distance *= 69;
  }
  // Remove locations with no distance set - probably missing geocoordinates.
  GTU_L_Locations = GTU_L_Locations.filter((l) => l.distance);

  function compare(a, b) {
    if (a.distance < b.distance) {
      return -1;
    }
    if (a.distance > b.distance) {
      return 1;
    }
    return 0;
  }
  GTU_L_Locations.sort(compare);

  // Assign the location to GTU_L.Local
  //	GTU_L.Local = GTU_L.Posts[0];

  // Perform Functions after being Localized
  GTU_L_LocalizedFunctions();
}
function GTU_L_LocalizedFunctions() {
  //draws store list in formatted html
  GTU_L_UpdatePrefixedIDs();
  GTU_L_LocalizeHREFs();

  // Additional Scripts
  if (GTU_L_Settings.GTU_L_Settings_Geolocation_Scripts) {
    var Scripts = GTU_L_Settings.GTU_L_Settings_Geolocation_Scripts.split(",");
    for (var s in Scripts) {
      eval(Scripts[s] + "()");
    }
  }
}
function GTU_L_UpdatePrefixedIDs() {
  // Updates a div with localized content
  var Prefix = GTU_L_Settings.GTU_L_Settings_Geolocation_Prefix;
  if (Prefix) {
    var Post = GTU_L_Locations[0];
    var Fields = GTU_L_Settings.GTU_L_Settings_Geolocation_Fields.split(",");
    for (var f in Fields) {
      GTU_L_UpdatePrefixedIDs_Items(
        Post,
        Prefix,
        Fields[f],
        Post.ACF[Fields[f]]
      );
    }
    if (document.getElementById(Prefix)) {
      document.getElementById(Prefix).style.display = "block";
    }
  }
  //
  document.getElementsByClassName("localized-show")[0].style.display = "block";
  //
}
function GTU_L_UpdatePrefixedIDs_Items(Post, Prefix, Field, Value) {
  //	Update innerHTML
  var TheseDivs = document.getElementsByClassName(Prefix + "-" + Field);
  for (var Div in TheseDivs) {
    if (Field == "title") {
      TheseDivs[Div].innerHTML = Post.post_title;
    } else if (Field == "phone") {
      TheseDivs[Div].innerHTML = GTU_L_FormatPhone(Value);

      if (document.getElementById(Prefix + "-phone-mobile")) {
        var MobileDiv = document.getElementById(Prefix + "-phone-mobile");
        if (MobileDiv.href) {
          MobileDiv.href = "tel:" + Value;
        }
      }
    } else if (Field == "gmb_vanity") {
      /* Do something */
    } else if (Field == "distance") {
      TheseDivs[Div].innerHTML = Math.round(Post.distance * 100) / 100;
    } else {
      TheseDivs[Div].innerHTML = Value;
    }
  }
  //	Update Links
  var TheseDivs = document.getElementsByClassName(
    Prefix + "-" + Field + "-url"
  );
  for (var Div in TheseDivs) {
    var Field_URL = Field + "-url";
    if (Field_URL == "title-url") {
      //			Test(TheseDivs[Div].href);
      TheseDivs[Div].href += Post.post_name;
    } else if (Field_URL == "phone-url") {
      TheseDivs[Div].href = "tel:" + Value;
      //			if(document.getElementsByClassName(Prefix +'-phone-mobile'+'-url')) {
      //				var MobileDiv = document.getElementById(Prefix +'-phone-mobile');
      //				if(MobileDiv.href) { MobileDiv.href = 'tel:' + Value; }
      //			}
    } else if (Field_URL == "gmb_vanity-url") {
      TheseDivs[Div].href = Value;
    } else if (Field_URL == "distance-url") {
    }
    //		else {
    //			if(TheseDivs[Div].href) { TheseDivs[Div].href = Value; }
    //			TheseDivs[Div].innerHTML = Value;
    //		}
  }
}
function GTU_L_LocalizeHREFs() {
  if (GTU_L_Settings.GTU_L_Settings_Geolocation_Localize_HREFs) {
    var DivsToLocalize = document.getElementsByClassName("gtu_localize_href");
    for (var d in DivsToLocalize) {
      if (DivsToLocalize[d].href) {
        DivsToLocalize[d].href =
          window.location.href +
          GTU_L_Locations[0].post_name +
          DivsToLocalize[d].pathname;
      }
    }
  }
}
function GTU_L_Ziplocate() {
  //finds the users location via Zip, then runs GTU_L_NearestLocation();
  var MyZip = document.getElementById("Zip").value;

  var locator = document.getElementById("locator");
  if (Zips[MyZip]) {
    if (locator) {
      locator.innerHTML = "Loading...";
    }
    setTimeout(function () {
      // Slight delay so you can "see the button working"
      GTU_L_NearestLocation(Zips[MyZip][0], Zips[MyZip][1]);
    }, 100);
  } else {
    if (locator) {
      locator.innerHTML =
        '<h3 class="divider-horiz hp-cherry text-center py-4">Zip Code not found.</h3>';
    }
  }
}
