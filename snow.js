/*FAIRE DES FLOCONS QUI BOUGENT
      Source :  http://www.editeurjavascript.com
      Adaptation : http://www.outils-web.com
      Sur-adaptation++ : Eliott ☺
*/

const snow_src = "icones/flocons.png";
const snow_nb = 10;
let dx, x, y;
let angle, rot, x_speed, y_speed;
const width = window.innerWidth;
const height = window.innerHeight;

x = [];
y = [];
dx = []; // Écart entre axe x et position avec angle
angle = []; // Mouvement angulaire / angular momentum
rot = []; // Rotation
x_speed = []; // Vitesse gauche-droite
y_speed = []; // Vitesse chute

// Initialisation
window.onload = () => {
    for (let i = 0; i < snow_nb; ++i) {
        dx[i] = 0;
        x[i] = Math.random() * (width - 50);
        y[i] = Math.random() * height;
        angle[i] = Math.random() * 20;
        rot[i] = Math.floor(Math.random() * 90);
        x_speed[i] = random_x_speed();
        y_speed[i] = random_y_speed();

        let div = document.createElement("div");
        div.id = "snow" + i;
        div.style.position = "absolute";
        div.style.zIndex = -1;
        div.innerHTML = "<img src='" + snow_src + "' style='transform: rotate(" + rot[i] + "deg)' alt='flocon'>";

        document.body.appendChild(div);
    }

    setInterval(function () { // Boucle principale
        for (let i = 0; i < snow_nb; ++i) {
            y[i] += y_speed[i];
            if (y[i] > height - 50) {
                x[i] = Math.random() * (width - angle[i] - 30);
                y[i] = 0;
                x_speed[i] = random_x_speed();
                y_speed[i] = random_y_speed();
            }
            dx[i] += x_speed[i];
            document.getElementById("snow" + i).style.top = y[i];
            document.getElementById("snow" + i).style.left = x[i] + angle[i] * Math.sin(dx[i]);
        }
    }, 20)
}

function random_x_speed() {
    return 0.02 + Math.random() / 10;
}

function random_y_speed() {
    return 0.7 + Math.random();
}
