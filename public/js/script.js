document.addEventListener("DOMContentLoaded", () => {
    const ingList = document.getElementById("ingredients-list");
    const ingTpl = document.getElementById("ingredient-row-template");
    const ingAddBtn = document.getElementById("add-ingredient");

    if (ingList && ingTpl && ingAddBtn) {
        function addRow(prefill = { name: "", amount: "", unit: "" }) {
            const fragment = ingTpl.content.cloneNode(true);
            const row = fragment.querySelector(".ingredient-row");

            const nameInput = row.querySelector('input[name="ing_name[]"]');
            const amountInput = row.querySelector('input[name="ing_amount[]"]');
            const unitInput = row.querySelector('input[name="ing_unit[]"]');

            nameInput.value = prefill.name ?? "";
            amountInput.value = prefill.amount ?? "";
            unitInput.value = prefill.unit ?? "";

            row.querySelector(".remove-ingredient").addEventListener("click", () => row.remove());
            ingList.appendChild(fragment);
        }

        ingAddBtn.addEventListener("click", () => addRow());

        let didPrefill = false;
        const prefillEl = document.getElementById("ingredients-prefill");
        if (prefillEl) {
            try {
                const data = JSON.parse(prefillEl.textContent || "[]");
                if (Array.isArray(data) && data.length > 0) {
                    data.forEach(item => addRow(item));
                    didPrefill = true;
                }
            } catch (e) {}
        }
        if (!didPrefill) {
            addRow(); addRow(); addRow();
        }
    }

    const toggles = document.querySelectorAll(".shopping-toggle");
    if (toggles.length > 0) {
        toggles.forEach(cb => {
            cb.addEventListener("change", async () => {
                const name = cb.dataset.name || "";
                const unit = cb.dataset.unit || "";
                const checked = cb.checked ? 1 : 0;

                const fd = new FormData();
                fd.append("name", name);
                if (unit !== "") fd.append("unit", unit);
                fd.append("checked", String(checked));

                try {
                    const res = await fetch("?c=shoppinglist&a=toggleAjax", {
                        method: "POST",
                        body: fd
                    });

                    const data = await res.json();
                    if (!data.ok) throw new Error(data.error || "unknown");

                    const row = cb.closest(".shopping-row");
                    if (row) row.classList.toggle("checked", cb.checked);

                } catch (e) {
                    cb.checked = !cb.checked;
                    alert("Nepodarilo sa uložiť stav položky.");
                }
            });
        });
    }

    const search = document.getElementById("recipe-search");
    const recipesList = document.getElementById("recipes-list");
    if (!search || !recipesList) return;

    let timer = null;
    let seq = 0;

    const noResults = document.createElement("div");
    noResults.className = "alert alert-warning mt-3";
    noResults.textContent = "Nenašli sa žiadne recepty.";
    noResults.style.display = "none";
    recipesList.parentElement.appendChild(noResults);

    function escapeHtml(s) {
        return (s || "").replace(/[&<>"']/g, ch => ({
            "&": "&amp;",
            "<": "&lt;",
            ">": "&gt;",
            '"': "&quot;",
            "'": "&#039;"
        }[ch]));
    }

    async function runSearch() {
        const q = search.value.trim();
        const mySeq = ++seq;

        try {
            const res = await fetch(`?c=recipes&a=searchAjax&q=${encodeURIComponent(q)}`, {
                headers: { "Accept": "application/json" }
            });

            const data = await res.json();
            if (!data.ok) throw new Error("bad_response");
            if (mySeq !== seq) return;

            const items = Array.isArray(data.recipes) ? data.recipes : [];

            if (items.length === 0) {
                recipesList.innerHTML = "";
                noResults.style.display = "block";
                return;
            }

            noResults.style.display = "none";

            recipesList.innerHTML = items.map(r => `
                <a class="list-group-item list-group-item-action"
                   href="?c=recipes&a=show&id=${r.id}">
                    <div class="fw-semibold">
                        ${escapeHtml(r.title)}
                        ${r.is_public ? "" : `<span class="badge bg-secondary ms-2">súkromný</span>`}
                    </div>
                    ${r.description ? `<div class="text-muted small">${escapeHtml(r.description)}</div>` : ""}
                </a>
            `).join("");

        } catch (e) {}
    }

    search.addEventListener("input", () => {
        clearTimeout(timer);
        timer = setTimeout(runSearch, 200);
    });
    runSearch();
});