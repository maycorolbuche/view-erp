import TomSelect from "tom-select";
import "tom-select/dist/css/tom-select.bootstrap5.css";

export function initTomSelect() {
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
            onInitialize: function () {
                if (!this.getValue()) {
                    this.clear(true);
                }
            },
        });
    });
}
