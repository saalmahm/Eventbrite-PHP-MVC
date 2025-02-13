console.log("fgbngbnf ");

document.querySelectorAll('section button').forEach(button => {
    button.addEventListener('click', () => {
        const content = button.nextElementSibling;
        const icon = button.querySelector('svg');

        content.classList.toggle('hidden');
        icon.classList.toggle('rotate-180');

        document.querySelectorAll('section button').forEach(otherButton => {
            if (otherButton !== button) {
                const otherContent = otherButton.nextElementSibling;
                const otherIcon = otherButton.querySelector('svg');
                otherContent.classList.add('hidden');
                otherIcon.classList.remove('rotate-180');
            }
        });
    });
});

const mobileMenuButton = document.getElementById('mobile-menu-button');
const closeMenuButton = document.getElementById('close-menu');
const mobileMenu = document.getElementById('mobile-menu');

mobileMenuButton.addEventListener('click', () => {
    mobileMenu.classList.add('active');
});

closeMenuButton.addEventListener('click', () => {
    mobileMenu.classList.remove('active');
});