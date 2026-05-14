const sidebar = document.getElementById("sidebar");
const overlay = document.getElementById("overlay");
const mobileToggle = document.getElementById("mobileToggle");
const collapseBtn = document.getElementById("collapseBtn");

// Mobile open/close
mobileToggle.addEventListener("click", () => {
    sidebar.classList.add("open");
    overlay.classList.add("show");
});
overlay.addEventListener("click", () => {
    sidebar.classList.remove("open");
    overlay.classList.remove("show");
});

// Desktop collapse (icons only)
collapseBtn.addEventListener("click", () => {
    document.body.classList.toggle("sidebar-collapsed");
    sidebar.classList.toggle("collapsed");
    // close all submenus when collapsing
    if (sidebar.classList.contains("collapsed")) {
        document
            .querySelectorAll(".submenu.open")
            .forEach((s) => s.classList.remove("open"));
        document
            .querySelectorAll('[aria-expanded="true"]')
            .forEach((b) => b.setAttribute("aria-expanded", "false"));
    }
});

// Close mobile sidebar on link click
document.querySelectorAll(".submenu a").forEach((a) => {
    a.addEventListener("click", () => {
        if (window.innerWidth < 992) {
            sidebar.classList.remove("open");
            overlay.classList.remove("show");
        }
    });
});
