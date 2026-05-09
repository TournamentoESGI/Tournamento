function toggleMenu() {
    document.getElementById('nav').classList.toggle('open');
}

document.getElementById('burger').addEventListener('click', toggleMenu);