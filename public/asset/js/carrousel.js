var tab = [{
    "image": "ehpad_motricite.jpg",
    "texte": "conserver la motricité"
},
{
    "image": "ehpad_illectronisme.jpg",
    "texte": "lutter contre l'illectronisme"
},
{
    "image": "ehpad_memoire.jpg",
    "texte": "travailler la mémoire"
},
{
    "image": "ehpad_sortie.jpg",
    "texte": "sortir en groupe"
},
{
    "image": "ehpad_plateau_repas.jpg",
    "texte": "les plateaux repas"
},
];
var i = 0;
var caroussel = function () {
    i = i % 5;
    tab[i].bouton;
    try {
        document.querySelector("#image>img").setAttribute("src", "../asset/img/" + tab[i].image);
    } catch (error) {
        document.querySelector("#image>img").setAttribute("src", "../../asset/img/" + tab[i].image);
    }

    document.querySelector("#image>img").style["filter"] = "blur(4px)";
    var delai = setTimeout(function () {
        document.querySelector("#image>img").style["filter"] = "blur(0px)";
    }, 100);
    var delai = setTimeout(function () {
        document.querySelector("#image>img").style["filter"] = "blur(4px)";
    }, 4900);
    document.querySelector("#image>span").innerHTML = tab[i].texte;
    for (let j = 0; j < tab.length; j++) {
        if (i == j) {
            document.querySelectorAll("#image>p>i")[j].className = "bi bi-circle-fill";
        } else {
            document.querySelectorAll("#image>p>i")[j].className = "bi bi-circle";
        }

    }
    i++;
}
var interval = setInterval(caroussel, 5000);