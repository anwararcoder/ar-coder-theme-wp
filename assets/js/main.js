/*
::
:: Theme Name: AR-Coder Theme
:: Email: nourramadan144@gmail.com
:: Author URI: http://ar-coder.com/
:: Author: AR-Coder
:: Version: 1.0
:: 
*/

document.addEventListener('DOMContentLoaded', () => {
    const navBar = document.querySelector('.nav-bar');
    const navBarMenu = document.querySelector('.nav-bar-menu');
    const cancelNavBarButtons = document.querySelectorAll('.cancel-nav-bar, .cancel-nav-bar-2');
    const openNavBarButton = document.querySelector('.open-nav-bar');
    let lastScrollPosition = 0;

    // :: => Handle Scroll Event
    const handleScroll = () => {
        const currentScrollPosition = window.scrollY;
        const isScrolled = currentScrollPosition > 100;

        navBar.classList.toggle('active', isScrolled);
        navBar.classList.toggle('hide', currentScrollPosition > lastScrollPosition);

        lastScrollPosition = currentScrollPosition;
    };

    // :: => Handle NavBar Toggle
    const handleNavBarToggle = () => {
        navBarMenu.classList.toggle('active');
    };

    // :: => Handle Dropdown Toggle for Small Screens
    const handleDropdownToggle = (button) => {
        const dropdownContent = button.querySelector('.HasDropdownListContent');
        dropdownContent.style.display = (dropdownContent.style.display === 'block') ? 'none' : 'block';
    };

    window.addEventListener('scroll', handleScroll);

    cancelNavBarButtons.forEach(button => button.addEventListener('click', handleNavBarToggle));
    openNavBarButton.addEventListener('click', handleNavBarToggle);

    const dropdownToggleButtons = document.querySelectorAll('.HasDropdownList');
    dropdownToggleButtons.forEach(button => {
        if (window.innerWidth < 1024) {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                handleDropdownToggle(button);
            });
        }
    });
});
