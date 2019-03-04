let prod_destroy = document.querySelectorAll('.p-destroy');
let spoofing = document.forms.spoofing;
const mensagem_exclusao = (cod, title) => `Você está prestes a EXCLUIR o produto:\n\n${cod} - ${title}`;
prod_destroy.forEach(a => 
    a.addEventListener('click', function(event) {
        
        event.preventDefault();
        
        let tr     = this.parentNode.parentNode,
            cod    = tr.children[0].textContent,
            titulo = tr.children[1].textContent;

        
        if (confirm(mensagem_exclusao(cod, titulo))) {
            spoofing.action = this.href;
            spoofing.submit();
        }
    })
);
