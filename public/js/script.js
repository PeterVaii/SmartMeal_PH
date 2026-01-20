document.addEventListener("DOMContentLoaded", () => {
    const list = document.getElementById("ingredients-list");
    const tpl = document.getElementById("ingredient-row-template");
    const addBtn = document.getElementById("add-ingredient");

    if (!list || !tpl || !addBtn) return;

    function addRow(prefill = { name: "", amount: "", unit: "" }) {
        const fragment = tpl.content.cloneNode(true);
        const row = fragment.querySelector(".ingredient-row");

        row.querySelector('input[name="ing_name[]"]').value = prefill.name ?? "";
        row.querySelector('input[name="ing_amount[]"]').value = prefill.amount ?? "";
        row.querySelector('input[name="ing_unit[]"]').value = prefill.unit ?? "";

        row.querySelector(".remove-ingredient").addEventListener("click", () => row.remove());
        list.appendChild(fragment);
    }

    addBtn.addEventListener("click", () => addRow());

    const prefillEl = document.getElementById("ingredients-prefill");
    if (prefillEl) {
        try {
            const data = JSON.parse(prefillEl.textContent || "[]");
            if (Array.isArray(data) && data.length > 0) {
                data.forEach(item => addRow(item));
                return;
            }
        } catch (e) {}
    }

    addRow(); addRow(); addRow();
});