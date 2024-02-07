function createRecord(event){
    event.preventDefault()
    if(!formCreateRecord.elements["newEmprunteTitre"].value) return
    if(!formCreateRecord.elements["newEmprunteNomAmi"].value) return
    if(!formCreateRecord.elements["newEmpruntePrenomAmi"].value) return

    let inputs = {
        titre: formCreateRecord.elements["newEmprunteTitre"].value,
        auteurNom: formCreateRecord.elements["newEmprunteAuteurNom"].value,
        auteurPrenom: formCreateRecord.elements["newEmprunteAuteurPrenom"].value,
        nomAmi: formCreateRecord.elements["newEmprunteNomAmi"].value,
        prenomAmi: formCreateRecord.elements["newEmpruntePrenomAmi"].value,
    }

    fetch('api/themeEmprunteLivreAPI.php',{
        method: 'POST',
        body: JSON.stringify(inputs),
    }) .then((response) =>{
        return response.json();
    })
    .then((data) => {
        console.log(data) //TODO : ça n'a aucun intérêt pour l'utilisateur, il vaudrait mieux afficher ici la liste des emprunts
        
    })

}

let formCreateRecord = document.getElementById("createRecord") //TODO :éviter les variables globales (qui en plus ne sont utilisés qu'une seule fois dans une fonction)





function updateRecord(){
    //TODO : attention à l'indentation
    if(!formUpdateRecord.elements["IDduTitre"].value) return
    if(!formUpdateRecord.elements["updateTitre"].value) return
if(!formUpdateRecord.elements["updateNomAmi"].value) return
if(!formUpdateRecord.elements["updatePrenomAmi"].value) return


    let inputs = {
        titreID: formUpdateRecord.elements["IDduTitre"].value,
        titre: formUpdateRecord.elements["updateTitre"].value,
        auteurNom: formUpdateRecord.elements["updateAuteurNom"].value,
        auteurPrenom: formUpdateRecord.elements["updateAuteurPrenom"].value,
        nomAmi: formUpdateRecord.elements["updateNomAmi"].value,
        prenomAmi: formUpdateRecord.elements["updatePrenomAmi"].value,

    }

    fetch('api/themeEmprunteLivreAPI.php',{
        method: 'PUT',
        body: JSON.stringify(inputs),
    }) .then((response) =>{
        return response.json();
    })
    .then((data) => {
        console.log(data) //TODO : voir mes remarques précédentes
        
    })

}

let formUpdateRecord = document.getElementById("updateRecord") //TODO :éviter les variables globales






function deleteRecord(){
    if(!formDeleteRecord.elements["IDtoDelete"].value) return
    
    let inputs = {
        titreID: formDeleteRecord.elements["IDtoDelete"].value,
    }

    fetch('api/themeEmprunteLivreAPI.php',{
        method: 'DELETE',
        body: JSON.stringify(inputs),
    }) .then((response) =>{
        return response.json();
    })
    .then((data) => {
        console.log(data) //TODO : ça n'a aucun intérêt pour l'utilisateur, il vaudrait mieux afficher ici la liste des emprunts
        
    })

}

let formDeleteRecord = document.getElementById("deleteRecord") //TODO :éviter les variables globales


