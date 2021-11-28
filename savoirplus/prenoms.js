const shuffle = str => [...str].sort(_ => Math.random() - .5).join('');
const capitalize = str => str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
const factorial = n => n < 0 || Boolean(n % 1) ? undefined : n === 0 ? 1 : factorial(n - 1) * n;

let popped_out; // Pour le petit pop-up

// erogeaux
let matrix = false;
let raining = setInterval(() => rainFall(matrix), 10);

// slay
const combi_total = factorial(8) * factorial(3); // Stéphane Lay
let combi_done = [];

function belbaz() {
    const notif = document.getElementById('notification');
    notif.firstChild.nodeValue = String.fromCodePoint(127881) + " Project Finished ! " + String.fromCodePoint(127881);
    notif.classList.add("show");
    clearTimeout(popped_out);
    popped_out = setTimeout(() => {
        notif.classList.remove("show");
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

    const notif = document.getElementById("notification");

    if (combi_done.length === combi_total) {
        notif.firstChild.nodeValue = String.fromCodePoint(0x1F451) + " Ça c'est de la motivation. Bravo ! " + String.fromCodePoint(0x1F451);
    } else if (combi_done.includes(text)) {
        notif.firstChild.nodeValue = String.fromCodePoint(0x1F340) + " Permutation déjà trouvée ! Quelle chance " + String.fromCodePoint(0x1F340);
    } else {
        combi_done.push(text);
        notif.firstChild.nodeValue = String.fromCodePoint(0x3A9) + " Nouvelle combinaison ! " + combi_done.length + "/" + combi_total + " " + String.fromCodePoint(0x3A9);
    }

    notif.classList.add("show");
    clearTimeout(popped_out);
    popped_out = setTimeout(() => {
        notif.classList.remove("show");
    }, 2000);
}


function erogeaux() {
    clearInterval(raining);
    matrix = !matrix;
    raining = setInterval(() => rainFall(matrix), 10);
}