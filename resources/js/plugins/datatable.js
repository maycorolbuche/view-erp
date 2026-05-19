import $ from "jquery";

window.$ = $;
window.jQuery = $;

import DataTable from "datatables.net-bs5";

import "datatables.net-bs5/css/dataTables.bootstrap5.min.css";

export function createDataTable(config) {
    let currentRequest = null;

    const table = $(`#${config.id}`)
        .on("preXhr.dt", function () {
            if (currentRequest && currentRequest.readyState !== 4) {
                currentRequest.abort();
            }
        })
        .DataTable({
            serverSide: true,
            processing: true,

            ...(config.searchable === false && {
                dom: "lrtip",
            }),

            ajax: {
                url: config.ajax.url,

                data: function (d) {
                    $(`[data-table-filter='${config.id}']`)
                        .find(
                            "input:not(.--filter-ignore):not([type=hidden]), select:not(.--filter-ignore)",
                        )
                        .each(function () {
                            d[$(this).attr("name")] = $(this).val();
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

    $(`[data-table-filter='${config.id}']`)
        .find(
            "input:not(.--filter-ignore):not([type=hidden]), select:not(.--filter-ignore)",
        )
        .on("change", function () {
            table.draw();
        });

    return table;
}

export function initDataTables() {
    $("[data-datatable]").each(function () {
        const config = $(this).data("config");
        createDataTable(config);
    });
}
