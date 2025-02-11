const map = L.map('map').setView([16.2334, 80.5509], 15); // Set the initial zoom level to 15

const titleUrl = "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png";
const tiles = L.tileLayer(titleUrl, {});
tiles.addTo(map);

const icon = L.icon({
    iconUrl: '/images/parking.png',
    iconSize: [50, 60],
});

function generateList() {
    const ul = document.querySelector(".list");
    placeList.forEach((place) => {
        const li = document.createElement("li");
        const div = document.createElement("div");
        const a = document.createElement("a");
        const p = document.createElement("p");
        a.addEventListener('click', () => {
            flyToPlace(place);
        });

        div.classList.add("place-style");
        a.innerText = place.properties.name;
        a.href = "#";

        const addressLabel = document.createElement("strong");
        addressLabel.innerText = "Address: ";
        p.appendChild(addressLabel);
        p.innerHTML += place.properties.address;

        div.appendChild(a);
        div.appendChild(p);
        li.appendChild(div);
        ul.appendChild(li);
    });
}
generateList();

function makePopupContent(place) {
    return `
        <div>
            <h4>${place.properties.name}</h4>
            <img src="${place.properties.url}" alt="" style="width:100px;height:100px;">
            <p>${place.properties.info}</p>
            <button class="map-button" onclick="fillFeedbackForm('${place.properties.name}')">📝 Fill Feedback Form </button>
        </div>
    `;
}

function fillFeedbackForm(locationName) {
    console.log("Selected Location:", locationName);

    // Find the selected place from placeList
    const selectedPlace = placeList.find(place => place.properties.name === locationName);

    if (selectedPlace) {
        const formUrl = selectedPlace.properties.formUrl; // Get the correct form URL

        // Store location in localStorage
        localStorage.setItem("selectedLocation", locationName);
        
        // Store feedback date if not already set
        if (!localStorage.getItem("feedbackDate")) {
            localStorage.setItem("feedbackDate", new Date().toISOString().split("T")[0]);
        }

        console.log("✅ Location Stored:", localStorage.getItem("selectedLocation"));
        console.log("✅ Date Stored:", localStorage.getItem("feedbackDate"));

        // Retrieve stakeholder details from localStorage
        const stakeholderType = localStorage.getItem("stakeholderType") || "";
        const academicYear = localStorage.getItem("academicYear") || "";
        const branch = localStorage.getItem("branch") || "";
        const specialization = localStorage.getItem("specialization") || "";
        const date = localStorage.getItem("feedbackDate") || "";

        // Send location to database immediately
        fetch("store_location.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `stakeholderType=${stakeholderType}&academicYear=${academicYear}&branch=${branch}&specialization=${specialization}&date=${date}&location=${locationName}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                console.log("✅ Location saved in DB:", locationName);
                // Redirect to the feedback form
                window.location.href = formUrl;
            } else {
                alert("❌ Error saving location: " + data.message);
            }
        })
        .catch(error => {
            alert("❌ Request failed: " + error);
        });
    } else {
        console.error("❌ Location not found in placeList");
    }
}







function flyToPlace(place) {
    map.flyTo([place.geometry.coordinates[1], place.geometry.coordinates[0]], 20, {
        duration: 3
    });

    setTimeout(() => {
        L.popup({ closeButton: false, offset: L.point(0, -8) })
            .setLatLng([place.geometry.coordinates[1], place.geometry.coordinates[0]])
            .setContent(makePopupContent(place))
            .openOn(map);
    }, 3000);
}

L.geoJSON(placeList, {
    onEachFeature: (feature, layer) => {
        layer.bindPopup(makePopupContent(feature));
    },
    pointToLayer: (feature, latlng) => {
        return L.marker(latlng);
    }
}).addTo(map);
