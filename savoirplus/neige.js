setInterval(rainFall, 10);

function rainFall() {
    const waterDrop = document.createElement('i');

    waterDrop.classList.add('fas');
    waterDrop.classList.add('fa-tint');
    waterDrop.style.left = Math.random() * window.innerWidth + 'px';
    waterDrop.style.animationDuration = Math.random() * 2 + 's';
    waterDrop.style.opacity = Math.random() + 0.4;
    waterDrop.style.fontSize = Math.random() * 7 + 'px';

    document.body.appendChild(waterDrop);

    setTimeout(() => {

    }, 600)
}