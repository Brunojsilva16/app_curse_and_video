<?php
// Extrai os módulos da variável principal do curso para facilitar o uso e evitar erros.
$modules = $course['modules'] ?? [];
?>
<div class="flex flex-col lg:flex-row h-screen bg-gray-100 font-sans">

    <!-- Barra Lateral com a Lista de Aulas (Sidebar) -->
    <aside class="w-full lg:w-80 bg-white shadow-lg flex-shrink-0 overflow-y-auto">
        <div class="p-6 border-b">
            <a href="<?= BASE_URL ?>/dashboard" class="text-sm text-indigo-600 hover:text-indigo-800 font-semibold flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Voltar para Meus Cursos
            </a>
            <h2 class="text-xl font-bold text-gray-800 mt-4"><?= htmlspecialchars($course['title']) ?></h2>
        </div>
        
        <div class="p-4">
            <div class="space-y-4">
                <?php if (!empty($modules)) : ?>
                    <?php foreach ($modules as $module) : ?>
                        <div>
                            <h3 class="font-bold text-gray-700 px-3 mb-2"><?= htmlspecialchars($module['title']) ?></h3>
                            <ul class="space-y-1">
                                <?php foreach ($module['lessons'] as $lesson) : ?>
                                    <li>
                                        <a href="#" class="flex items-center p-3 text-sm rounded-md text-gray-600 hover:bg-indigo-50 hover:text-indigo-700 transition-colors">
                                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <span class="flex-1"><?= htmlspecialchars($lesson['title']) ?></span>
                                            <span class="text-xs text-gray-500">10:45</span>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                     <p class="text-sm text-gray-500 px-3">Nenhum conteúdo adicionado a este curso ainda.</p>
                <?php endif; ?>
            </div>
        </div>
    </aside>

    <!-- Área de Conteúdo Principal -->
    <main class="flex-1 flex flex-col">
        <!-- Cabeçalho do Conteúdo -->
        <header class="bg-white shadow-sm p-4 flex justify-between items-center z-10">
            <div>
                 <h1 class="text-2xl font-bold text-gray-900">Bem-vindo ao curso!</h1>
                 <p class="text-sm text-gray-600">Selecione uma aula para começar.</p>
            </div>
            <div>
                 <span class="text-sm font-semibold text-gray-700">Progresso: 0%</span>
                 <div class="w-40 bg-gray-200 rounded-full h-2.5 mt-1">
                    <div class="bg-indigo-600 h-2.5 rounded-full" style="width: 0%"></div>
                 </div>
            </div>
        </header>

        <!-- Player de Vídeo e Conteúdo -->
        <div class="flex-1 p-6 lg:p-8 overflow-y-auto">
             <!-- Placeholder para quando nenhuma aula foi selecionada -->
            <div id="lesson-content-placeholder" class="flex items-center justify-center h-full bg-gray-200 rounded-lg">
                <div class="text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" /> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhuma aula selecionada</h3>
                    <p class="mt-1 text-sm text-gray-500">Escolha uma aula na barra lateral para começar a assistir.</p>
                </div>
            </div>

             <!-- O conteúdo da aula será carregado aqui por JavaScript -->
            <div id="lesson-content-area" class="hidden">
                <!-- Player de Vídeo -->
                <div class="aspect-w-16 aspect-h-9 bg-black rounded-lg overflow-hidden mb-6">
                     <iframe id="video-player" src="" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                </div>

                <!-- Descrição e Materiais -->
                <div>
                    <h2 id="lesson-title" class="text-3xl font-bold text-gray-900"></h2>
                    <div id="lesson-text-content" class="prose max-w-none mt-4 text-gray-700"></div>
                    <div id="lesson-pdf-content" class="mt-6"></div>
                </div>
            </div>
        </div>
    </main>
</div>