const shuffle = str => [...str].sort(_ => Math.random() - .5).join('');
const capitalize = str => str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
const factorial = n => n < 0 || Boolean(n % 1) ? undefined : n === 0 ? 1 : factorial(n - 1) * n;

let popped_out; // Pour le petit pop-up

// bmedimeg
let matrix = false;
let raining = setInterval(() => rainFall(matrix), 10);

// slay
const combi_total = factorial(8) * factorial(3); // Stéphane Lay
let combi_done = [];

// erogeaux
let left_cat = false;
let right_cat = false;
const cat_height = 585; //px
const cat_width = 366; //px


function belbaz() {
    const popup = document.getElementById('notification');
    popup.firstChild.nodeValue = String.fromCodePoint(127881) + " Project Finished ! " + String.fromCodePoint(127881);
    popup.classList.add("show");
    clearTimeout(popped_out);
    popped_out = setTimeout(() => {
        popup.classList.remove("show");
    }, 2000);
    fiesta();
}


function rgruet() {
    let turn = document.getElementById("turn");
    if (turn.style.transform === "rotate(180deg)")
        turn.style.transform = "";
    else
        turn.style.transform = "rotate(180deg)";
}


function slay(a) {
    let text = a.firstChild.nodeValue;
    let split = text.split(" ");
    text = capitalize(shuffle(split[0])) + " " + capitalize(shuffle(split[1]));
    a.firstChild.nodeValue = text;

    const popup = document.getElementById("notification");

    if (combi_done.length === combi_total) {
        popup.firstChild.nodeValue = String.fromCodePoint(0x1F451) + " Ça c'est de la motivation. Bravo ! " + String.fromCodePoint(0x1F451);
    } else if (combi_done.includes(text)) {
        popup.firstChild.nodeValue = String.fromCodePoint(0x1F340) + " Permutation déjà trouvée ! Quelle chance " + String.fromCodePoint(0x1F340);
    } else {
        combi_done.push(text);
        popup.firstChild.nodeValue = String.fromCodePoint(0x3A9) + " Nouvelle association ! " + combi_done.length + "/" + combi_total + " " + String.fromCodePoint(0x3A9);
    }

    popup.classList.add("show");
    clearTimeout(popped_out);
    popped_out = setTimeout(() => {
        popup.classList.remove("show");
    }, 2000);
}


function erogeaux() {

    let img = document.createElement("img");
    img.setAttribute("src", "chat.png");
    img.setAttribute("class", "chat");
    img.style.blur = 0;

    let scale = Math.random() / 2.5 + 0.6; // Valeur entre 0.6 et 1
    img.style.width = scale * cat_width + "px";
    img.style.height = scale * cat_height + "px";


    if (!right_cat) {

        img.style.marginRight = img.style.right = "-" + cat_width + "px";

        document.body.appendChild(img);
        right_cat = true;

        setTimeout(() => {
            img.style.right = img.style.marginRight = "0";
            setTimeout(() => {
                img.style.marginRight = img.style.right = "-" + cat_width + "px";
                setTimeout(() => {
                    img.remove();
                    right_cat = false;
                }, 600)
            }, 3500)
        }, 0)
    } else if (!left_cat) {

        img.style.marginLeft = img.style.left = "-" + cat_width + "px";
        img.style.transform = "scaleX(-1)"

        document.body.appendChild(img);
        left_cat = true;

        setTimeout(() => {
            img.style.left = img.style.marginLeft = "0";
            setTimeout(() => {
                img.style.marginLeft = img.style.left = "-" + cat_width + "px";
                setTimeout(() => {
                    img.remove();
                    left_cat = false;
                }, 600)
            }, 3500)
        }, 0)
    }


}

function bmedimeg() {
    clearInterval(raining);
    matrix = !matrix;
    raining = setInterval(() => rainFall(matrix), 10);
}