console.log('hi'); //TODO : à supprimer
//this just ensures the .js file is being accessed

let countEl = document.getElementById("count-el");

/*initialize the count as 0;
listen for clicks on the increment button (click for likes);
increment the count variable when the button is clicked;
change the count-el in the html to reflect the new count */


//create function increment references id = links w auteur, changes innertext to add 1, parseInt = treat as int
function increment(id) {
    let likes = document.getElementById(id)

    likes.innerText = parseInt(likes.innerText) + 1
}
