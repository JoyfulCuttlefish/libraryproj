function showList() {
var genres = document.getElementById("genreID");
if (genres.style.display == "block") {
genres.style.display = "none";
} else {
genres.style.display = "block";
}
}
window.onclick = function (event) {
if (!event.target.matches('.dropdownButton')) {
document.getElementById('genreID')
.style.display = "none";
}
} 

