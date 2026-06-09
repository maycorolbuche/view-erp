import IMask from "imask";

window.IMask = IMask;

const masks = {
    cpf: {
        mask: "000.000.000-00",
    },
    cnpj: {
        mask: "AA.AAA.AAA/AAAA-00",
        definitions: {
            A: /[A-Za-z0-9]/,
        },
        prepare: (value) => value.toUpperCase(),
    },
    cpfcnpj: {
        mask: [
            { mask: "000.000.000-00" },
            {
                mask: "AA.AAA.AAA/AAAA-00",
                definitions: {
                    A: /[A-Za-z0-9]/,
                },
            },
        ],
        prepare: (value) => value.toUpperCase(),
    },
    state: {
        mask: "AA",
        definitions: {
            A: /[A-Za-z]/,
        },
        prepare: (value) => value.toUpperCase(),
    },
    zipcode: {
        mask: "00000-000",
    },
    money: {
        mask: Number,
        scale: 2,
        thousandsSeparator: ".",
        radix: ",",
        mapToRadix: ["."],
        normalizeZeros: true,
        padFractionalZeros: true,
    },
    number: {
        mask: Number,
        scale: 0,
        thousandsSeparator: ".",
        radix: ",",
        mapToRadix: ["."],
    },
    decimal: {
        mask: Number,
        scale: 1,
        thousandsSeparator: ".",
        radix: ",",
        mapToRadix: ["."],
        normalizeZeros: true,
        padFractionalZeros: true,
    },

    pis: {
        mask: "000.00000.00-0",
    },

    phone: {
        mask: [{ mask: "(00) 0000-0000" }, { mask: "(00) 00000-0000" }],
    },
};

(() => {
    "use strict";

    document.querySelectorAll("[data-mask]").forEach((el) => {
        /*
        |--------------------------------------------------------------------------
        | Evita dupla inicialização
        |--------------------------------------------------------------------------
        */
        if (el.maskRef) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Tipo
        |--------------------------------------------------------------------------
        */
        const type = el.dataset.mask;

        /*
        |--------------------------------------------------------------------------
        | Configuração
        |--------------------------------------------------------------------------
        */
        let maskOptions = masks[type] ? { ...masks[type] } : { mask: type };

        /*
        |--------------------------------------------------------------------------
        | Casas decimais
        |--------------------------------------------------------------------------
        */
        const decimals = el.dataset.decimals;
        if (decimals) {
            maskOptions.scale = Number(decimals);
        }

        /*
        |--------------------------------------------------------------------------
        | Numérica?
        |--------------------------------------------------------------------------
        */
        const isNumericMask = maskOptions.mask === Number;

        /*
        |--------------------------------------------------------------------------
        | Máscaras comuns
        |--------------------------------------------------------------------------
        */
        if (!isNumericMask) {
            el.maskRef = IMask(el, maskOptions);
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Valor original (backend)
        |--------------------------------------------------------------------------
        */
        const originalValue = el.value;

        /*
        |--------------------------------------------------------------------------
        | Name / ID
        |--------------------------------------------------------------------------
        */
        const originalName = el.getAttribute("name");
        const originalId = el.getAttribute("id");

        /*
        |--------------------------------------------------------------------------
        | Remove do visual
        |--------------------------------------------------------------------------
        */
        el.removeAttribute("name");
        if (originalId) {
            el.removeAttribute("id");
        }

        /*
        |--------------------------------------------------------------------------
        | Hidden input
        |--------------------------------------------------------------------------
        */
        const hidden = document.createElement("input");
        hidden.type = "hidden";
        hidden.name = originalName;
        hidden.value = originalValue;

        if (originalId) {
            hidden.id = originalId;
        }

        const parent = el.parentElement;
        if (parent?.classList.contains("input-group")) {
            parent.insertAdjacentElement("afterend", hidden);
        } else {
            el.insertAdjacentElement("afterend", hidden);
        }

        /*
        |--------------------------------------------------------------------------
        | Máscara
        |--------------------------------------------------------------------------
        */
        const imask = IMask(el, maskOptions);

        /*
        |--------------------------------------------------------------------------
        | Inicializa visual formatado
        |--------------------------------------------------------------------------
        */
        if (originalValue) {
            imask.typedValue = Number(originalValue);
        }

        /*
        |--------------------------------------------------------------------------
        | Sync backend
        |--------------------------------------------------------------------------
        */
        const syncHidden = () => {
            hidden.value = imask.unmaskedValue ? imask.typedValue : "";
        };
        imask.on("accept", syncHidden);
        imask.on("complete", syncHidden);
        syncHidden();

        /*
        |--------------------------------------------------------------------------
        | Refs
        |--------------------------------------------------------------------------
        */
        el.maskRef = imask;
        el.hiddenInputRef = hidden;
    });
})();

//DATA/HORA
//O TIMER É PARA DAR TEMPO DE FLATPICK SER ATIVADO
setTimeout(function () {
    document
        .querySelectorAll(
            "input[data-type='date'],input[data-type='datetime'],input[data-type='time']",
        )
        .forEach((sibling) => {
            const type = sibling.dataset.type;
            const el = sibling.parentElement.querySelector(".input");

            if (!el) {
                return;
            }

            IMask(el, {
                mask:
                    type === "datetime"
                        ? "d{/}m{/}Y 00:00"
                        : type === "time"
                          ? "00:00"
                          : "d{/}m{/}Y",
                blocks: {
                    d: {
                        mask: IMask.MaskedRange,
                        from: 1,
                        to: 31,
                        maxLength: 2,
                    },

                    m: {
                        mask: IMask.MaskedRange,
                        from: 1,
                        to: 12,
                        maxLength: 2,
                    },

                    Y: {
                        mask: IMask.MaskedRange,
                        from: 1900,
                        to: 2999,
                    },
                },
            });
        });
}, 1000);
