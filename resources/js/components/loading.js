(() => {
    "use strict";

    let loader = document.getElementById("page-loader");
    if (!loader) {
        loader = document.createElement("div");
        loader.id = "page-loader";
        loader.className = "loader-overlay show";

        loader.innerHTML = `
            <div class="loader"></div>
        `;

        document.body.prepend(loader);
    }

    document.addEventListener("DOMContentLoaded", () => {
        loader?.classList.remove("show");

        document.addEventListener("click", (event) => {
            /* Ignora KEY + CLIQUE, ou clique com scroll.... */
            if (
                event.ctrlKey ||
                event.metaKey ||
                event.shiftKey ||
                event.altKey
            ) {
                return;
            }

            const link = event.target.closest("a");
            if (link) {
                const href = link.getAttribute("href");

                if (
                    !href ||
                    href === "#" ||
                    href.startsWith("#") ||
                    href.startsWith("javascript:") ||
                    link.target === "_blank" ||
                    link.hasAttribute("download") ||
                    link.dataset.bsToggle
                ) {
                    return;
                }

                loader?.classList.add("show");
                return;
            }

            const button = event.target.closest("button");
            if (button) {
                const onclick = button.getAttribute("onclick") ?? "";

                if (
                    onclick.includes("window.location") ||
                    onclick.includes("location.href") ||
                    onclick.includes("location.assign")
                ) {
                    loader?.classList.add("show");
                }
            }
        });
    });

    /* REMOVE O LOADER CASO O BOTÃO DE VOLTAR SEJA PRESSIONADO */
    window.addEventListener("pageshow", (event) => {
        if (event.persisted) {
            loader?.classList.remove("show");
        }
    });
})();
