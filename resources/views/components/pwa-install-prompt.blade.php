<!-- PWA Install Prompt Component -->
<div id="pwa-install-prompt" class="fixed bottom-4 right-4 z-50 bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-lg shadow-xl max-w-sm w-full mx-4 transform translate-y-full opacity-0 transition-all duration-500 ease-out hidden">
    <div class="p-4">
        <!-- Header -->
        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center gap-2">
                <div class="bg-white/20 p-2 rounded-lg">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/>
                    </svg>
                </div>
                <span class="font-semibold text-sm">📱 Instalar App</span>
            </div>
            <button id="pwa-close-btn" class="text-white/70 hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Content -->
        <div class="mb-4">
            <p class="text-sm text-white/90 leading-relaxed">
                Adicione a <strong>Boxing House PF</strong> à sua tela inicial para acesso rápido e uma experiência como app nativo!
            </p>
        </div>

        <!-- Actions -->
        <div class="flex gap-2">
            <button id="pwa-install-btn" class="flex-1 bg-white text-blue-600 font-semibold py-2 px-4 rounded-lg text-sm hover:bg-white/90 transition-colors">
                ⬇️ Instalar
            </button>
            <button id="pwa-maybe-later-btn" class="px-3 py-2 text-white/80 hover:text-white text-sm">
                Depois
            </button>
        </div>

        <!-- iOS specific instruction -->
        <div id="ios-instruction" class="mt-3 p-2 bg-white/10 rounded text-xs text-white/80 hidden">
            <p>📱 <strong>Para iPhone/iPad:</strong> toque no botão de <strong>Compartilhar</strong> (quadrado com seta) e depois em <strong>"Adicionar à Tela de Início"</strong></p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Verifica se estamos na dashboard (professor ou aluno)
    const currentPath = window.location.pathname;
    const isDashboard = currentPath.includes('/dashboard') || 
                       currentPath === '/professor' || 
                       currentPath === '/aluno' ||
                       currentPath.endsWith('/dashboard');
    
    if (!isDashboard) return;

    const prompt = document.getElementById('pwa-install-prompt');
    const installBtn = document.getElementById('pwa-install-btn');
    const closeBtn = document.getElementById('pwa-close-btn');
    const maybeLaterBtn = document.getElementById('pwa-maybe-later-btn');
    const iosInstruction = document.getElementById('ios-instruction');
    
    let deferredPrompt;
    const hasDismissed = localStorage.getItem('pwa-dismissed') === 'true';
    const hasDismissedSession = sessionStorage.getItem('pwa-dismissed-session') === 'true';

    // Verifica se já está instalado ou foi dismisseado
    if (window.matchMedia('(display-mode: standalone)').matches || 
        window.navigator.standalone === true ||
        hasDismissed ||
        hasDismissedSession) {
        return;
    }

    // Detecta o tipo de dispositivo/navegador
    const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
    const isAndroid = /Android/.test(navigator.userAgent);
    const canUseBeforeInstallPrompt = !isIOS;

    console.log('PWA Prompt: Detectado dispositivo:', isIOS ? 'iOS' : isAndroid ? 'Android' : 'Desktop');

    // Configuração específica para iOS
    if (isIOS) {
        iosInstruction.classList.remove('hidden');
        installBtn.textContent = '💡 Ver como instalar';
    }

    // Função para mostrar o prompt
    function showPrompt() {
        if (prompt) {
            prompt.classList.remove('hidden');
            // Trigger animation após um micro delay
            requestAnimationFrame(() => {
                prompt.classList.remove('translate-y-full', 'opacity-0');
                prompt.classList.add('translate-y-0', 'opacity-100');
            });
            console.log('PWA Prompt: Exibido');
        }
    }

    // Função para esconder o prompt
    function hidePrompt() {
        if (prompt) {
            prompt.classList.add('translate-y-full', 'opacity-0');
            prompt.classList.remove('translate-y-0', 'opacity-100');
            
            setTimeout(() => {
                prompt.classList.add('hidden');
            }, 500);
            console.log('PWA Prompt: Escondido');
        }
    }

    // Listener para o evento beforeinstallprompt (Android/Desktop)
    window.addEventListener('beforeinstallprompt', (e) => {
        console.log('PWA Prompt: Evento beforeinstallprompt capturado');
        e.preventDefault();
        deferredPrompt = e;
        
        // Mostra o prompt após 2 segundos
        setTimeout(() => showPrompt(), 2000);
    });

    // Para iOS ou se não capturou o evento, mostra apenas com instrução
    if (isIOS || (!deferredPrompt && canUseBeforeInstallPrompt)) {
        setTimeout(() => {
            console.log('PWA Prompt: Mostrando para iOS ou como fallback');
            showPrompt();
        }, 2000);
    }

    // Se não for iOS e não tiver o evento após 3 segundos, mostra mesmo assim
    setTimeout(() => {
        if (!deferredPrompt && !isIOS && !hasDismissed && !hasDismissedSession) {
            console.log('PWA Prompt: Fallback - mostrando sem evento beforeinstallprompt');
            showPrompt();
        }
    }, 3000);

    // Instalar aplicativo
    installBtn.addEventListener('click', async () => {
        if (isIOS) {
            // Para iOS, apenas mostra/destaca a instrução
            iosInstruction.classList.remove('hidden');
            iosInstruction.classList.add('animate-pulse');
            return;
        }
        
        if (deferredPrompt) {
            try {
                deferredPrompt.prompt();
                const { outcome } = await deferredPrompt.userChoice;
                console.log('PWA Install: User choice:', outcome);
                
                if (outcome === 'accepted') {
                    console.log('PWA instalada com sucesso');
                    localStorage.setItem('pwa-dismissed', 'true');
                }
                
                deferredPrompt = null;
                hidePrompt();
            } catch (error) {
                console.error('Erro ao instalar PWA:', error);
            }
        } else {
            // Fallback: mostrar instruções manuais
            alert('Para instalar:\n\n1. Abra o menu do navegador (⋮)\n2. Procure por "Instalar app" ou "Adicionar à tela inicial"\n3. Confirme a instalação');
        }
    });

    // Fechar prompt (definitivo)
    closeBtn.addEventListener('click', () => {
        localStorage.setItem('pwa-dismissed', 'true');
        hidePrompt();
        console.log('PWA Prompt: Dismisseado definitivamente');
    });

    // Talvez depois (apenas nesta sessão)
    maybeLaterBtn.addEventListener('click', () => {
        sessionStorage.setItem('pwa-dismissed-session', 'true');
        hidePrompt();
        console.log('PWA Prompt: Dismisseado nesta sessão');
    });

    // Detecta quando o app foi instalado
    window.addEventListener('appinstalled', () => {
        console.log('PWA foi instalada');
        localStorage.setItem('pwa-dismissed', 'true');
        hidePrompt();
    });
});
</script>