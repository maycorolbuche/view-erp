import TomSelect from "tom-select";
import "tom-select/dist/css/tom-select.bootstrap5.css";

document.querySelectorAll(".tom-select").forEach((el) => {
    // evita inicializar duas vezes
    if (el.tomselect) return;

    new TomSelect(el, {
        create: false,
        allowEmptyOption: true,

        plugins: {
            remove_button: {
                title: "Remover",
            },
        },
        placeholder: "Selecione",
        render: {
            no_results: function () {
                return '<div class="no-results">Nenhum resultado encontrado</div>';
            },
        },
        onInitialize: function () {
            if (!this.getValue()) {
                this.clear(true);
            }
        },
    });
});
