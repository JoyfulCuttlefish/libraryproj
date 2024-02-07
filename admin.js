function createBook(){
    if(!formCreate.elements["newBookTitre"].value) return

    let inputs = {
        titre: formCreate.elements["newBookTitre"].value,
        sorti: formCreate.elements["newSorti"].value,
        synopsis: formCreate.elements["newSynopsis"].value,
        pages: formCreate.elements["newPages"].value,

    }

    fetch('api/themeLivresAPI.php',{
        method: 'POST',
        body: JSON.stringify(inputs),
    }) .then((response) =>{
        return response.json();
    })
    .then((data) => {
        console.log(data) //TODO : inutile, fais qqc d'intéressant pour l'utilisateur
        
    })

}

let formCreate = document.getElementById("createBook")




function readSingle(){ //TODO : cette fonction ne semble utilisée
    if(!formReadSingle.elements["IDtoRead"].value) return
    
    let inputs = {
        id: formReadSingle.elements["IDtoRead"].value,
    }

    fetch('api/themeLivresAPI.php',{
        method: 'GET',
        inputs,
    }) .then((response) =>{
        return response.json();
    })
    .then((data) => {
        console.log(data)
        
    })

}

let formReadSingle = document.getElementById("readSingle")



//fetch(URL)  .then((response) => response.json())  .then((data) => console.log(data));




function updateBook(){
    if(!formUpdate.elements["IDtoModify"].value) return
    if(!formUpdate.elements["updateTitre"].value) return
    if(!formUpdate.elements["updateSorti"].value) return
   

    let inputs = {
        id: formUpdate.elements["IDtoModify"].value,
        titre: formUpdate.elements["updateTitre"].value,
        sorti: formUpdate.elements["updateSorti"].value,
        synopsis: formUpdate.elements["updateSynopsis"].value,
        pages: formUpdate.elements["updatePages"].value,

    }

    fetch('api/themeLivresAPI.php',{
        method: 'PUT',
        body: JSON.stringify(inputs),
    }) .then((response) =>{
        return response.json();
    })
    .then((data) => {
        console.log(data) //TODO : inutile, fais qqc d'intéressant pour l'utilisateur
        
    })

}

let formUpdate = document.getElementById("updateBook")





function deleteBook(){
    if(!formDelete.elements["IDtoDelete"].value) return
    
    let inputs = {
        id: formDelete.elements["IDtoDelete"].value,
    }

    fetch('api/themeLivresAPI.php',{
        method: 'DELETE',
        body: JSON.stringify(inputs),
    }) .then((response) =>{
        return response.json();
    })
    .then((data) => {
        console.log(data) //TODO : inutile, fais qqc d'intéressant pour l'utilisateur
        
    })

}

let formDelete = document.getElementById("deleteBook")

