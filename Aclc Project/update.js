    const modal = document.getElementById("myModal");
    const closeBtn = document.querySelector(".close");

    const deleteStudentBtn = document.getElementById("deleteStudent");

    // Open modal with populated data
    function openModal(id, name, image, course, year, section) {
        setTimeout(() => {
            document.getElementById("modal-id").value = id;
            document.getElementById("modal-name").value = name;
            document.getElementById("modal-course").value = course;
            document.getElementById("modal-year").value = year;
            document.getElementById("modal-section").value = section;
            document.getElementById("modal-image").src = image;
            modal.style.display = "block";
        }, 500);
    }

    // Handle delete action
    deleteStudentBtn.addEventListener("click", () => {
        const id = document.getElementById("modal-id").value;

        if (confirm("Are you sure you want to delete this student?")) {
            fetch("delete_student.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: `id=${id}`,
            })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                    modal.style.display = "none";
                    location.reload(); // Reload the page to reflect changes
                })
                .catch(error => console.error("Error:", error));
        }
    });

    // Close modal
    closeBtn.onclick = () => {
        modal.style.display = "none";
    };

    // Close modal when clicking outside the modal
    window.onclick = event => {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    };
