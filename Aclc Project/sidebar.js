




const tbody = document.querySelector('tbody');
let currentIndex = 0;

function slideRows() {
    const rows = tbody.querySelectorAll('tr');
    const rowHeight = rows[0].offsetHeight;

    currentIndex = (currentIndex + 1) % rows.length;
    tbody.style.transform = `translateY(-${currentIndex * rowHeight}px)`;
}

setInterval(slideRows, 2000); // Adjust the delay as needed