const numStars = 720;  // Increase the number of stars

function random(min, max) {
    return Math.random() * (max - min) + min;
}

function randomDirection() {
    const directions = ['-100vh', '100vh'];
    return directions[Math.floor(Math.random() * directions.length)];
}

for (let i = 0; i < numStars; i++) {
    const star = document.createElement('div');
    star.classList.add('star');
    const size = random(2, 6) + 'px';
    star.style.width = size;
    star.style.height = size;
    star.style.left = random(0, window.innerWidth) + 'px';
    star.style.top = random(0, window.innerHeight) + 'px';  // Ensure stars are visible immediately
    star.style.animationDuration = random(200, 300) + 's';  // Slow down the falling speed
    star.style.setProperty('--moveX', randomDirection());
    star.style.setProperty('--moveY', randomDirection());
    document.body.appendChild(star);
}
