const body = document.body;
const sidebar = document.getElementById("sidebar");
const overlay = document.getElementById("overlay");
const mobileToggle = document.getElementById("mobileToggle");
const collapseBtn = document.getElementById("collapseBtn");

// RESTORE SIDEBAR STATE
if (localStorage.getItem("sidebar") === "collapsed") {
    body.classList.add("sidebar-collapsed");
    sidebar.classList.add("collapsed");
}

// Mobile open/close
mobileToggle.addEventListener("click", () => {
    sidebar.classList.add("open");
    sidebar.classList.remove("collapsed");
    overlay.classList.add("show");
    body.classList.remove("sidebar-collapsed");
});
overlay.addEventListener("click", () => {
    sidebar.classList.remove("open");
    overlay.classList.remove("show");
});

// Desktop collapse (icons only)
collapseBtn.addEventListener("click", () => {
    body.classList.toggle("sidebar-collapsed");
    sidebar.classList.toggle("collapsed");
    localStorage.removeItem("sidebar");

    // close all submenus when collapsing
    if (sidebar.classList.contains("collapsed")) {
        document
            .querySelectorAll(".submenu.open")
            .forEach((s) => s.classList.remove("open"));
        document
            .querySelectorAll('[aria-expanded="true"]')
            .forEach((b) => b.setAttribute("aria-expanded", "false"));

        localStorage.setItem("sidebar", "collapsed");
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
