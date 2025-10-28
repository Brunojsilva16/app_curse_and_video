<?php
use App\Core\Auth;
// O nome do usuário é recuperado da sessão
$userName = Auth::userName() ?? 'Usuário';
?>

<!-- 
  Barra de Navegação Lateral Fixa 
  - `hidden lg:flex`: A barra fica escondida em telas pequenas e vira um flex container (visível) em telas grandes (lg).
-->
<div class="fixed top-0 left-0 w-64 h-full bg-slate-900 text-white shadow-lg z-40 flex-col hidden lg:flex">
    
    <!-- Perfil do Usuário -->
    <div class="p-6 border-b border-slate-700">
        <div class="flex items-center space-x-4">
            <!-- Placeholder para a foto -->
            <div class="w-12 h-12 rounded-full bg-slate-700 flex items-center justify-center">
                <svg class="w-8 h-8 text-slate-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-white"><?= htmlspecialchars($userName) ?></h2>
                <a href="<?= BASE_URL ?>/perfil" class="text-sm text-sky-400 hover:text-sky-300">
                    Ver Perfil
                </a>
            </div>
        </div>
    </div>

    <!-- Links de Navegação Principal -->
    <nav class="flex-grow p-4 space-y-2">
        <!-- <a href="#" class="flex items-center px-4 py-2 text-slate-300 hover:bg-slate-700 hover:text-white rounded-md transition-colors">
            Sobre os cursos
        </a> -->
        <a href="<?= BASE_URL ?>/" class="flex items-center px-4 py-2 text-slate-300 hover:bg-slate-700 hover:text-white rounded-md transition-colors">
            Cursos
        </a>
        <a href="<?= BASE_URL ?>/dashboard" class="flex items-center px-4 py-2 bg-slate-800 text-white font-semibold rounded-md">
            Meus Cursos
        </a>
        <a href="#" class="flex items-center px-4 py-2 text-slate-300 hover:bg-slate-700 hover:text-white rounded-md transition-colors">
            Certificados e histórico
        </a>
    </nav>
    
    <!-- Botão de Sair -->
    <div class="p-4 border-t border-slate-700 mt-auto">
        <a href="<?= BASE_URL ?>/logout" class="flex items-center w-full px-4 py-2 text-slate-300 hover:bg-red-600 hover:text-white rounded-md transition-colors">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            Sair
        </a>
    </div>

</div>

