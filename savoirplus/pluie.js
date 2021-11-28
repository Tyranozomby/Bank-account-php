function rainFall(matrix = false) {
    const waterDrop = document.createElement('i');

    waterDrop.classList.add('fas');
    waterDrop.classList.add('fall');
    if (matrix === false) {
        waterDrop.classList.add('fa-tint');
    } else {
        waterDrop.classList.add('matrix');
        waterDrop.innerText = ["0", "1"][Math.round(Math.random())];
    }

    waterDrop.style.left = Math.random() * window.innerWidth + 'px';
    waterDrop.style.animationDuration = Math.random() * 2 + 's';
    waterDrop.style.opacity = Math.random() + 0.4;
    waterDrop.style.fontSize = Math.random() * 7 + 'px';

    waterDrop.addEventListener("animationend", () => {
        waterDrop.remove();
    });

    document.body.appendChild(waterDrop);

}