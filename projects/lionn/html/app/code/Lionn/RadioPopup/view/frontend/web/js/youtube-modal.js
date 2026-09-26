// Verifica e cria política Trusted Types se necessário
function createTrustedTypesPolicy() {
    if (window.trustedTypes && window.trustedTypes.createPolicy) {
        return trustedTypes.createPolicy('htmlPolicy', {
            createHTML: (html) => html,
        });
    }
    return null;
}

// Versão segura de insertAdjacentHTML
function safeInsertAdjacentHTML(element, position, html) {
    const policy = createTrustedTypesPolicy();
    if (policy) {
        element.insertAdjacentHTML(position, policy.createHTML(html));
    } else {
        element.insertAdjacentHTML(position, html);
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const modalHTML = `
        <div class="dynamic-youtube-modal" style="display: none;">
            <div class="modal-content">
                <button class="close-modal"></button>
                <iframe 
                    id="youtube-iframe" 
                    width="100%" 
                    height="315" 
                    src="" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen>
                </iframe>
            </div>
        </div>
    `;

    // Adiciona o modal ao body de forma segura
    safeInsertAdjacentHTML(document.body, 'beforeend', modalHTML);

   // Traduções
    const translations = {
    'pt': 'Fechar (X)',
    'en': 'Close (X)',
    'es': 'Cerrar (X)',
    'ja': '閉じる (X)',
    'zh': '关闭 (X)',
     };


    const currentLanguage = document.documentElement.lang || 'pt';
    const closeModalText = translations[currentLanguage] || translations['pt'];

    window.addEventListener('load', function () {
        const modal = document.querySelector('.dynamic-youtube-modal');
        const iframe = document.getElementById('youtube-iframe');
        const closeButton = modal.querySelector('.close-modal');

        // Configura botão de fechar
        closeButton.textContent = closeModalText;

        // Funções de controle do modal
        function closeModal() {
            modal.style.display = 'none';
            iframe.src = '';
        }

        function openModal(youtubeUrl) {
            const modifiedUrl = youtubeUrl.includes('?') 
                ? `${youtubeUrl}&autoplay=1&disablepictureinpicture=1` 
                : `${youtubeUrl}?autoplay=1&disablepictureinpicture=1`;
            
            iframe.src = modifiedUrl;
            modal.style.display = 'flex';
        }

        // Event listeners
        closeButton.addEventListener('click', closeModal);

        document.addEventListener('keydown', (e) => {
            if (e.key === "Escape") {
                closeModal();
            }
        });

        document.querySelectorAll('.open-youtube-modal').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const youtubeUrl = link.dataset.youtubeUrl;
                if (youtubeUrl) {
                    openModal(youtubeUrl);
                } else {
                    console.error("URL do YouTube não encontrada.");
                }
            });
        });
    });
});