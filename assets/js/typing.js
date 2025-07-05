const phrases = ["SIMPRAK", "Sistem Informasi Manajemen Praktikum"];
const el = document.getElementById("typed-text");
let phraseIndex = 0;
let charIndex = 0;
let isDeleting = false;

function type() {
    const currentPhrase = phrases[phraseIndex];

    if (isDeleting) {
        el.textContent = currentPhrase.substring(0, charIndex--);
        if (charIndex < 0) {
            isDeleting = false;
            phraseIndex = (phraseIndex + 1) % phrases.length;
            setTimeout(type, 300);
        } else {
            setTimeout(type, 50);
        }
    } else {
        el.textContent = currentPhrase.substring(0, charIndex++);
        if (charIndex > currentPhrase.length) {
            isDeleting = true;
            setTimeout(type, 1000);
        } else {
            setTimeout(type, 100);
        }
    }
}

document.addEventListener("DOMContentLoaded", type);
