const containerSlot = document.querySelector(".slot");
const belbazconfettis = document.querySelector(".belbaz");
const btnConfettis = document.querySelector(".test");

const emojis = ["	\ud83d\ude00","\uD83C\uDF89", "\ud83c\udf82","	\ud83d\udc4f "];
const emojis1 = ["	\ud83e\udd73","\ud83d\udc4b", "	\ud83d\ude44","\ud83d\ude2f","\ud83d\udc4c"];

belbazconfettis.addEventListener("click", fiesta);
btnConfettis.addEventListener("click", fiesta);

function fiesta() {

    if(isTweening()) return;

    for (let i = 0; i < 50; i++) {
        const confetti = document.createElement("div");
        confetti.innerText = emojis[Math.floor(Math.random() * emojis.length)];
        containerSlot.appendChild(confetti);
    }

    animateConfettis();
}


function animateConfettis() {

    const TLCONF = gsap.timeline();

    TLCONF.to(".slot div", {
        y: "random(-100,100)",
        x: "random(-100,100)",
        z: "random(0,1000)",
        rotation: "random(-90,90)",
        duration: 1,
    })
        .to(".slot div", { autoAlpha: 0, duration: 0.4 }, "-=0.2")
        .add(() => {
            containerSlot.innerHTML = "";
        });
}


function isTweening(){
    return gsap.isTweening('.slot div');
}