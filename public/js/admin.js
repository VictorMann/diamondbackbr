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

const tipeMimeValid = [
    'image/jpeg',
    'image/jpg',
    'image/png',
    'image/gif',
];

function geraBase64(file) {
    return new Promise((resolve, reject) => {
        
        let reader = new FileReader();
        reader.addEventListener('load', function(event) {
            resolve(this.result);
        }, false);

        reader.readAsDataURL(file);
    });
}

function getHash() {
    return parseInt(Math.random() * new Date().getTime());
}

function getMaxOrder() {
    let order = document.querySelectorAll('.n-order');
    return order && [].reduce.call(order, (max, el) => Math.max(max, el.textContent), Number.MIN_VALUE) || 0;
}

function spinner() {
    
    let vlLoading = document.querySelector('.vl-loading');
    if (vlLoading) return;
    
    vlLoading = document.createElement('div');
    vlLoading.classList.add('vl-loading');
    
    vlContent = document.createElement('div');
    vlContent.classList.add('vl-loading-content');

    vlLoading.append(vlContent);
    document.body.append(vlLoading);
}

// remove alerta
setTimeout(() => $('.alert').hide(300), 3000);