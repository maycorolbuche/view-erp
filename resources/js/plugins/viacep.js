(() => {
    "use strict";

    async function loadCep(cep) {
        cep = cep.replace(/\D/g, "");
        if (cep.length !== 8) {
            throw new Error("CEP inválido");
        }

        const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);

        const data = await response.json();

        if (data.erro) {
            throw new Error("CEP não encontrado");
        }

        return data;
    }

    async function addValue(key, value) {
        if (key && document.getElementById(key)) {
            document.getElementById(key).value = value;
        }
    }

    document.addEventListener("DOMContentLoaded", () => {
        document
            .querySelectorAll("input[data-type='zipcode']")
            .forEach((el) => {
                const type = el.dataset.type;

                if (el._cep) {
                    return;
                }

                el.addEventListener("focus", function () {
                    this.dataset.oldValue = this.value;
                });

                el.addEventListener("blur", async function () {
                    if (this.value === this.dataset.oldValue) {
                        return;
                    }

                    try {
                        const cep_data = await loadCep(this.value);

                        addValue(el.dataset?.address, cep_data?.logradouro);
                        addValue(el.dataset?.district, cep_data?.bairro);
                        addValue(el.dataset?.city, cep_data?.localidade);
                        addValue(el.dataset?.state, cep_data?.uf);
                    } catch (error) {
                        toast.error(error.message);
                        addValue(el.dataset?.address, "");
                        addValue(el.dataset?.district, "");
                        addValue(el.dataset?.city, "");
                        addValue(el.dataset?.state, "");
                    }
                });

                el._cep = true;
            });
    });
})();
