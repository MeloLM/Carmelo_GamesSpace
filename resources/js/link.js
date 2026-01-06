/---------- CHANGE PAGE ACTIVE LINK ----------/

// Ottieni tutti i link della pagina
let links = document.querySelectorAll('.link_custom');
    
// Cicla su tutti i link
links.forEach(function(link) {
    // Verifica se il link corrisponde all'URL della pagina corrente
    if (link.href === window.location.href) {
        // Aggiungi la classe "selected" al link corrente
        link.classList.add('selected');
    } else {
        // Rimuovi la classe "selected" dal link corrente
        link.classList.remove('selected');
    }
});
