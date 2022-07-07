class City 
{
    constructor()
    {
        this.map = L.map("map").setView([48.84513, 2.34551], 14);
        this.marker = L.marker([48.84513, 2.34551]).addTo(this.map);
        this.marker.bindPopup("<b>Bonjour &#128512;</b><br>Le théâtre se trouve ici.", {minWidth: 100}).openPopup();

        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom:20,
            minZoom:11
        }).addTo(this.map);

        
    }
}

new City();
