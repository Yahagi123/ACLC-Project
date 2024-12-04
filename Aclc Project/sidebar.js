const burger = document.getElementById('burger');
const sidebar = document.getElementById('sidebar');
const mainContent = document.querySelector('.main-content');

burger.addEventListener('click', () => {
    sidebar.classList.toggle('active');
    mainContent.classList.toggle('active');
});




const tbody = document.querySelector('tbody');
let currentIndex = 0;

function slideRows() {
    const rows = tbody.querySelectorAll('tr');
    const rowHeight = rows[0].offsetHeight;

    currentIndex = (currentIndex + 1) % rows.length;
    tbody.style.transform = `translateY(-${currentIndex * rowHeight}px)`;
}

setInterval(slideRows, 2000); // Adjust the delay as needed