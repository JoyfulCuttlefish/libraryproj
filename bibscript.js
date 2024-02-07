console.log("hi"); //TODO : à supprimer




function showLivres(id) {
    //let urlLivres = `http://localhost/tests/joy_penard_filrougelivres/api/themeLivresAPI.php`; //TODO : ne pas mettre de liens absolus
    let urlLivres = `api/themeLivresAPI.php`; //TODO : correction
    fetch(urlLivres)
    .then((Response => Response.json()))
    .then((data) => {
      let dataApi = data;
      const livresDiv = document.getElementsByClassName('livres'+ id);
      const casseLivreDiv = document.querySelectorAll('.livreJs');
      casseLivreDiv.forEach((livre) => livre.remove(casseLivreDiv ));
      dataApi.forEach(livre => {

         if(livre.auteur == id){
            let livreDiv =  document.createElement("div");
            livreDiv.className = "livreJs";
            livreDiv.innerHTML = livre.titre + "<br>";
            livresDiv[0].appendChild(livreDiv);
         }
         else if (livre.auteur == undefined) {
            console.log('Pas de livre'); //TODO : aucun intérêt pour un utilisateur
         }

         }

      )});
    };


 
 



