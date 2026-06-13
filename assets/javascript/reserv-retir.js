function changerLeStatut(reserv) {
        const btn = document.getElementById('btn-statut-' + reserv);

        if (btn.innerText === "Non retiré") {
            btn.innerText = "Retiré";
            btn.style.backgroundColor = "#25bd11";
        } else {
            btn.innerText = "Non retiré";
            btn.style.backgroundColor = "#ff9800";
        }

    }