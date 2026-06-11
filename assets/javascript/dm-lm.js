document.addEventListener("DOMContentLoaded", function() {

    const savedutheme = localStorage.getItem('theme');

    if (savedutheme) {
        document.getElementsByTagName('html')[0].setAttribute("data-theme", savedutheme);
    }

});

function modeNuit(){
    document.getElementsByTagName('html')[0].setAttribute("data-theme", "dark");
    localStorage.setItem('theme', 'dark');
    }

function modeJour(){
    document.getElementsByTagName('html')[0].setAttribute("data-theme", "light");
    localStorage.setItem('theme', 'light');
    }

function modeDys()
{document.getElementsByTagName('html')[0].setAttribute(
"dyslexie-text", "dys")}