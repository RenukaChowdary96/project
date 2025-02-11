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
    // Debugging: Check if locationName is correct
    console.log("Selected Location:", locationName);
    
    // Store selected location in localStorage
    localStorage.setItem("location", locationName);

    // Retrieve stored details for debugging
    console.log("Location Stored:", localStorage.getItem("location"));
    console.log("Date Stored:", localStorage.getItem("date"));

    // Redirect to the corresponding form
    window.location.href = "feedback_parking_area.html"; // Change dynamically if needed
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
