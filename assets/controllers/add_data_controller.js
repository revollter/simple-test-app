import { Controller } from '@hotwired/stimulus';
import { Modal } from "bootstrap";

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ["modalBody", "table"];

    connect() {
        this.modalInstance = new Modal(this.modal, {
            backdrop: 'static',
            keyboard: false
        });
    }

    open(event) {
        event.preventDefault();

        fetch(this.data.get("formUrl"))
            .then(r => r.text())
            .then(html => {
                this.modalBodyTarget.innerHTML = html;
                this.modalInstance.show();
                this.bindSubmit();
                this.initProductColor();
            });
    }

    bindSubmit() {
        const submitBtn = this.modalBodyTarget.querySelector("#submit-data");
        const form = this.modalBodyTarget.querySelector("#data-form");

        if (!submitBtn || !form) return;

        submitBtn.addEventListener("click", (e) => {
            e.preventDefault();
            const formData = new FormData(form);

            fetch(form.action, {
                method: "POST",
                body: formData
            })
                .then(r => r.json())
                .then(resp => {
                    if (resp.status === "ok") {
                        this.modalInstance.hide();
                        this.reloadTable();
                    } else {
                        this.modalBodyTarget.innerHTML = resp.form;
                        this.bindSubmit();
                    }
                });
        });
    }

    reloadTable() {
        fetch(this.data.get("tableUrl"))
            .then(r => r.text())
            .then(html => {
                this.tableTarget.innerHTML = html;
            });
    }

    initProductColor() {
        const form = this.modalBodyTarget.querySelector("form");
        if (!form) return;

        const productSelect = form.querySelector("#data_product");
        const colorSelect = form.querySelector("#data_color");

        if (!productSelect || !colorSelect) return;
        
        toggleColor(productSelect, colorSelect);
        
        productSelect.addEventListener("change", () => toggleColor(productSelect, colorSelect));

        function toggleColor(product, color) {
            if (product.value.toUpperCase() === "PEN") {
                color.disabled = false;
            } else {
                color.value = "";
                color.disabled = true;
            }
        }
    }


    get modal() {
        return document.getElementById("dataModal");
    }
}
