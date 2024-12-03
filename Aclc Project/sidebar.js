const burger = document.getElementById('burger');
const sidebar = document.getElementById('sidebar');
const mainContent = document.querySelector('.main-content');

burger.addEventListener('click', () => {
    sidebar.classList.toggle('active');
    mainContent.classList.toggle('active');
});