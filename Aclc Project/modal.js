
    // Get modal elements
    const modal = document.getElementById("myModal");
    const modalId = document.getElementById("modal-id");
    const modalName = document.getElementById("modal-name");
    const modalImage = document.getElementById("modal-image");
    const modalCourse = document.getElementById("modal-course");
    const modalYear = document.getElementById("modal-year");
    const closeBtn = document.querySelector(".close");

    // Function to open modal and populate data
    function openModal(id, name, image, course, year) {
        setTimeout(() => {
            modalId.textContent = id;
            modalName.textContent = name;
            modalImage.src = image;
            modalCourse.textContent = course;
            modalYear.textContent = year;
            modal.style.display = "block";
        }, 500); // Delay of 500 milliseconds
    }

    // Event listener for "View Profile" buttons
    document.querySelectorAll(".profile-btn").forEach(button => {
        button.addEventListener("click", () => {
            const id = button.dataset.id;
            const name = button.dataset.name;
            const image = button.dataset.image;
            const course = button.dataset.course;
            const year = button.dataset.year;
            openModal(id, name, image, course, year);
        });
    });

    // Close modal when the "X" is clicked
    closeBtn.onclick = () => {
        modal.style.display = "none";
    };

    // Close modal when clicking outside the modal content
    window.onclick = event => {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    };
    function openModal(id, name, image, course, year,) {
        const loading = document.getElementById("loading");
        loading.style.display = "block";

        setTimeout(() => {
            loading.style.display = "none";
            modalId.textContent = id;
            modalName.textContent = name;
            modalImage.src = image;
            modalCourse.textContent = course;
            modalYear.textContent = year;
            modal.style.display = "block";
        }, 500); // Delay of 500 milliseconds
    }