import {Toast} from "bootstrap";

function createToast(intent, title, message, buttons = []) {
    // Cria o cabeçalho da toast.
    const iconEl = document.createElement("i");
    iconEl.className = `fas fa-square text-${intent} rounded me-2`;
    const titleEl = document.createElement("strong");
    titleEl.className = "me-auto";
    titleEl.textContent = title;
    const closeBtnEl = document.createElement("button");
    closeBtnEl.className = "btn-close";
    closeBtnEl.setAttribute("type", "button");
    closeBtnEl.setAttribute("data-bs-dismiss", "toast");
    const headerEl = document.createElement("div");
    headerEl.className = "toast-header";
    headerEl.appendChild(iconEl);
    headerEl.appendChild(titleEl);
    headerEl.appendChild(closeBtnEl);

    // Cria os botões da toast (se houver).
    let btnContainerEl = null;
    if (buttons.length > 0) {
        btnContainerEl = document.createElement("div");
        btnContainerEl.className = "mt-2 pt-2 border-top";
        buttons.forEach(btn => {
            const btnEl = document.createElement("button");
            btnEl.className = `btn btn-${btn.intent || "primary"} btn-sm me-2`;
            btnEl.textContent = btn.text;
            btnEl.setAttribute("data-bs-dismiss", "toast");
            btnEl.style.width = "60px";
            if (typeof btn.onClick === "function") btnEl.addEventListener("click", btn.onClick);
            btnContainerEl.appendChild(btnEl);
        });
    }

    // Cria o corpo da toast.
    const bodyEl = document.createElement("div");
    bodyEl.className = "toast-body";
    bodyEl.textContent = message;
    if (btnContainerEl) bodyEl.appendChild(btnContainerEl);

    // Cria o elemento da toast.
    const toastEl = document.createElement("div");
    toastEl.className = "toast mb-2 mt-2";
    toastEl.setAttribute("role", "alert");
    toastEl.appendChild(headerEl);
    toastEl.appendChild(bodyEl);

    // Insere a toast to toast-container.
    const toastContainerEl = document.getElementById("toast-container");
    toastContainerEl.appendChild(toastEl);

    // Cria um event listener que apaga a toast quando ela for ocultada.
    toastEl.addEventListener("hidden.bs.toast", () => {
        toastContainerEl.removeChild(toastEl);
    });

    return toastEl;
}

const toaster = {
    displaySuccess(message) {
        const toastEl = createToast("success", "Sucesso", message);
        const toast = new Toast(toastEl);
        toast.show();
    },

    displayWarning(message) {
        const toastEl = createToast("warning", "Atenção", message);
        const toast = new Toast(toastEl);
        toast.show();
    },

    displayError(message) {
        const toastEl = createToast("danger", "Erro", message);
        const toast = new Toast(toastEl);
        toast.show();
    },

    displayConfirm(message, onYes, onNo = null) {
        const toastEl = createToast("primary", "Confirme", message, [
            {
                intent: "primary",
                text: "Sim",
                onClick: onYes,
            },
            {
                intent: "danger",
                text: "Não",
                onClick: onNo,
            },
        ]);
        const toast = new Toast(toastEl);
        toast.show();
    },
};

export default toaster;
