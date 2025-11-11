export function handleNavLinkClick() {
    const pageContent = document.getElementById('pageContent');
    const navLinks = document.querySelectorAll('.navLink');

    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            if (mainLoader.style.top === '-10rem') {
                mainLoader.style.top = '33%';
            } else {
                mainLoader.style.top = '-10rem';
            }
            pageContent.classList.add('fade-out');
        });
    });
}
