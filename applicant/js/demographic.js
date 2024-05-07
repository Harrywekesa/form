document.getElementById("county").addEventListener("change", (event) => {
            var selectedCounty = document.getElementById("county");
            var url = "./get_sub_counties.php?county_id=" + encodeURIComponent(selectedCounty.value);
            fetch(url).then((response) => {
                if (!response.ok) {
                    console.log("response not okay");
                }
                return response.json();
            }).then((data) => {
                // get the select field
                var subCounty = document.getElementById("sub_county");
                subCounty.innerHTML = "";
                data.forEach((element) => {
                    var option = document.createElement("option");
                    // console.log(element.id, element.county_id, element.sub_county_id, element.sub_county);
                    option.value = element['id'];
                    option.textContent = element['sub_county']
                    subCounty.append(option)
                });
                var otherOption = document.createElement("option");
                otherOption.value = "other";
                otherOption.textContent = "Other";
                subCounty.append(otherOption);
            }).catch((error) => {
                console.error("There was a problem with the fetch operation", error);
            })
        });

        // check if other is selected
        document.getElementById("sub_county").addEventListener("change", (event) => {
            var subCounty = document.getElementById("sub_county");

            if (subCounty.value == "other") { // check if other is selected
                document.getElementById("otherSubCounty").style.display = "block";
            } else {
                document.getElementById("otherSubCounty").style.display = "none";
            }
        });