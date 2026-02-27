/**
 * Script Robson Reinoso - Massoterapia
 * Gerencia menu sidebar, overlay e carrossel Glide.js
 */

document.addEventListener('DOMContentLoaded', () => {

    // ===== SIDEBAR E MENU =====
    const menuBtn = document.getElementById('menu-toggle');
    const sidebar = document.getElementById('sidebar');
    const closeSidebar = document.getElementById('close-sidebar');
    const overlay = document.getElementById('overlay');
    const navLinks = document.querySelectorAll('.nav-links a');

    if (menuBtn && sidebar && closeSidebar && overlay) {

        // Abrir sidebar
        menuBtn.addEventListener('click', () => {
            sidebar.classList.add('active');
            overlay.classList.add('active');
            menuBtn.classList.add('active');
        });

        // Fechar sidebar
        closeSidebar.addEventListener('click', () => {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
            menuBtn.classList.remove('active');
        });

        // Fechar sidebar ao clicar no overlay
        overlay.addEventListener('click', () => {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
            menuBtn.classList.remove('active');
        });

        // Fechar sidebar ao clicar em um link
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
                menuBtn.classList.remove('active');
            });
        });
    }

    // ===== GLIDE CAROUSEL =====
    /**
     * Configuração do Carrossel Glide.js
     * 
     * type: 'slider' - Carrossel para na última imagem (sem loop infinito)
     * perView: 3 - Mostra 3 slides por vez (desktop)
     * focusAt: 'center' - Foca no slide central
     * gap: 40 - Espaço entre slides
     * rewind: false - Desabilita loop infinito
     * autoplay: false - Sem autoplay
     * breakpoints: Responsividade para tablet e mobile
     */
    if (typeof Glide !== "undefined") {
        const glide = new Glide('.glide', {
            type: 'slider',
            perView: 3,
            focusAt: 'center',
            gap: 40,
            rewind: false,
            autoplay: false,
            breakpoints: {
                900: { perView: 2, gap: 24 },
                600: { perView: 1, gap: 16 }
            }
        });

        glide.mount();

        // Evento opcional: Log quando o carrossel muda
        glide.on('run', () => {
            console.log('Carrossel moveu para slide:', glide.index);
        });

        // Atualizar bullets ao mover
        glide.on('move', () => {
            updateBulletStates(glide);
        });

        // Inicializar estado dos bullets
        updateBulletStates(glide);
    }

    /**
     * Função para atualizar o estado dos bullets
     * @param {Glide} glide - Instância do Glide
     */
    function updateBulletStates(glide) {
        const bullets = document.querySelectorAll('.glide__bullet');
        bullets.forEach((bullet, index) => {
            if (index === glide.index) {
                bullet.classList.add('glide__bullet--active');
            } else {
                bullet.classList.remove('glide__bullet--active');
            }
        });
    }

});

/**
 * MELHORIAS IMPLEMENTADAS:
 * 
 * 1. Loop Infinito Corrigido
 *    - rewind: false impede que o carrossel volte ao início
 *    - Carrossel para na última imagem
 * 
 * 2. Layout Profissional
 *    - Espaçamento adequado entre slides
 *    - Cards com sombra e gradiente
 *    - Animações suaves
 * 
 * 3. Responsividade
 *    - Desktop: 3 slides
 *    - Tablet: 2 slides
 *    - Mobile: 1 slide
 * 
 * 4. Integração com Estilo Robson Reinoso
 *    - Cores verdes (#5aa12f, #1a7f1a)
 *    - Font Poppins
 *    - Botões com gradiente
 *    - Sombras suaves
 * 
 * 5. Controles Intuitivos
 *    - Setas de navegação
 *    - Bullets de paginação
 *    - Sem autoplay (controle do usuário)
 */
