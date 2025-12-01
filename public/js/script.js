document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.querySelector(".sidebar");
    const toggleBtn = document.querySelector("#toggleSidebar");

    toggleBtn.addEventListener("click", function () {
        if (window.innerWidth <= 768) {
            sidebar.classList.toggle("show"); // mobile
        } else {
            sidebar.classList.toggle("collapsed"); // desktop collapse
        }
    });
});
