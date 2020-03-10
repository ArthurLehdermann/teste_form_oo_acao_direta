(function() {
    'use strict';
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');

        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });

        // This code empowers all input tags having a placeholder and data-slots attribute
        document.addEventListener('DOMContentLoaded', () => {
            for (const el of document.querySelectorAll("[placeholder][data-slots]")) {
                const pattern = el.getAttribute("placeholder"),
                    slots = new Set(el.dataset.slots || "_"),
                    prev = (j => Array.from(pattern, (c,i) => slots.has(c)? j=i+1: j))(0),
                    first = [...pattern].findIndex(c => slots.has(c)),
                    accept = new RegExp(el.dataset.accept || "\\d", "g"),
                    clean = input => {
                        input = input.match(accept) || [];
                        return Array.from(pattern, c =>
                            input[0] === c || slots.has(c) ? input.shift() || c : c
                        );
                    },
                    format = () => {
                        const [i, j] = [el.selectionStart, el.selectionEnd].map(i => {
                            i = clean(el.value.slice(0, i)).findIndex(c => slots.has(c));
                            return i<0? prev[prev.length-1]: back? prev[i-1] || first: i;
                        });
                        el.value = clean(el.value).join``;
                        el.setSelectionRange(i, j);
                        back = false;
                    };
                let back = false;
                el.addEventListener("keydown", (e) => back = e.key === "Backspace");
                el.addEventListener("input", format);
                el.addEventListener("focus", format);
                el.addEventListener("blur", () => el.value === pattern && (el.value=""));
            }
        });
    }, false);

    /*
     * Retirado de: https://stackoverflow.com/a/55010378/2750750
     * Comentado por Arthur Lehdermann
     * Exemplos:
<label>Date time:
    <input placeholder="dd/mm/yyyy hh:mm" data-slots="dmyh">
</label><br>
<label>Telephone:
    <input placeholder="+1 (___) ___-____" data-slots="_">
</label><br>
<label>MAC Address:
    <input placeholder="XX:XX:XX:XX:XX:XX" data-slots="X" data-accept="[\dA-H]">
</label><br>
<label>Signed number (3 digits):
    <input placeholder="±___" data-slots="±_" data-accept="^[+-]|(?!^)\d" size="4">
</label><br>
<label>Alphanumeric:
    <input placeholder="__-__-__-____" data-slots="_" data-accept="\w" size="13">
</label><br>
     */
    // This code empowers all input tags having a placeholder and data-slots attribute
    document.addEventListener('DOMContentLoaded', () => { // após carregar tudo
        for (const el of document.querySelectorAll("[placeholder][data-slots]")) { // percorre os elementos com atributos: "placeholder" e "data-slots"
            const pattern = el.getAttribute("placeholder"), // no placeholder vai o padrão (pattern)
                slots = new Set(el.dataset.slots || "_"), // define o caractere digitável("slot") como "_" se não informado
                prev = (j => Array.from(pattern, (c,i) => slots.has(c)? j=i+1: j))(0), // monta um array do tamanho do placeholder para guardar o valor do campo posteriormente
                first = [...pattern].findIndex(c => slots.has(c)), // primeira posição para ser digitada
                accept = new RegExp(el.dataset.accept || "\\d", "g"), // regra de expressão regular "\d"(somente números)
                // método que recebe o valor atual do campo e retorna em um array de caracteres, já filtrando dentro do padrão do placeholder
                clean = input => {
                    input = input.match(accept) || [];
                    return Array.from(pattern, c =>
                        input[0] === c || slots.has(c) ? input.shift() || c : c
                    );
                },
                // método para aplicar a máscara, coloca os caracteres digitados dentro do padrão informado no placeholder
                format = () => {
                    const [i, j] = [el.selectionStart, el.selectionEnd].map(i => {
                        i = clean(el.value.slice(0, i)).findIndex(c => slots.has(c));
                        return i<0? prev[prev.length-1]: back? prev[i-1] || first: i; // se for "Backspace" remove o último caractere
                    });
                    el.value = clean(el.value).join``;
                    el.setSelectionRange(i, j);
                    back = false;
                };
            let back = false;
            el.addEventListener("keydown", (e) => back = e.key === "Backspace"); // quando pressionado uma tecla, se for o "Backspace" guarda para o format() o fazer
            el.addEventListener("input", format); // quando carrega, aplica máscara
            el.addEventListener("focus", format); // quando obtém foco, aplica máscara
            el.addEventListener("blur", () => el.value === pattern && (el.value="")); // quando sai do campo valida, e se estiver inválido limpa o campo
        }
    });
})();