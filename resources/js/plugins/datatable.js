import DataTable from "datatables.net-bs5";
import "datatables.net-responsive-bs5";

import "datatables.net-bs5/css/dataTables.bootstrap5.min.css";
import "datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css";

(() => {
    "use strict";

    function createDataTable(el) {
        let currentRequest = null;

        const config = JSON.parse(el.dataset.config);
        console.log("config", config);

        const table = new DataTable(el, {
            serverSide: true,
            processing: true,

            ...(config.searchable === false && {
                dom: "lrtip",
            }),

            ajax: {
                url: config.ajax.url,

                data: function (d) {
                    document
                        .querySelectorAll(
                            `[data-table-filter="${config.id}"] input:not(.--filter-ignore):not([type="hidden"]),
                             [data-table-filter="${config.id}"] select:not(.--filter-ignore)`,
                        )
                        .forEach((element) => {
                            if (element.name) {
                                d[element.name] = element.value;
                            }
                        });
                },

                beforeSend: function (jqXHR) {
                    currentRequest = jqXHR;
                },

                error: function (jqXHR, textStatus, errorThrown) {
                    if (textStatus === "abort") return;

                    console.error("Erro DataTable:", errorThrown);

                    if (window.PNotify) {
                        new PNotify({
                            text: "Ocorreu um erro ao carregar dados da grid.",
                            type: "danger",
                            delay: 1400,
                        });
                    }
                },
            },

            columns: config.columns,

            order: config.order || [],

            language: {
                url: "/assets/datatables/i18n/pt-BR.json",
            },

            createdRow: function (row, data, index) {
                if (config.createdRow) {
                    config.createdRow(row, data, index);
                }
            },

            drawCallback: function (settings) {
                if (window.init_modals) {
                    init_modals();
                }

                if (config.drawCallback) {
                    config.drawCallback(settings);
                }
            },
        });

        document
            .querySelectorAll(
                `[data-table-filter="${config.id}"] input:not(.--filter-ignore):not([type="hidden"]),
                 [data-table-filter="${config.id}"] select:not(.--filter-ignore)`,
            )
            .forEach((element) => {
                element.addEventListener("change", () => {
                    table.draw();
                });
            });

        return table;
    }

    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll("[data-datatable]").forEach((table) => {
            createDataTable(table);
        });
    });
})();
