// Show the dropdown menu when the user clicks on their profile
function menuToggle() {
    const toggleMenu = document.querySelector('.MenuItems');
    toggleMenu.classList.toggle('active');

    // Close the dropdown menu if the user clicks outside of it
    window.onclick = function (e) {
        if (!e.target.matches("#Profile")) {
            toggleMenu.classList.remove("active");
        }
    };
}
