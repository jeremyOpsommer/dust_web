const menuToggle = document.querySelector<HTMLElement>('.menu-toggle');
const navMenu = document.querySelector<HTMLElement>('nav ul');

if (menuToggle && navMenu) {
    menuToggle.addEventListener('click', () => {
        navMenu.classList.toggle('show-menu');
    });
}