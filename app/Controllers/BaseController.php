<?php

namespace App\Controllers;

/**
 * Classe base para todos os controladores da aplicação.
 * Centraliza a lógica de renderização das views dentro do layout principal.
 */
class BaseController
{
    /**
     * Renderiza uma view dentro do layout principal.
     * * @param string $view O nome do arquivo da view (ex: 'login' para login.php).
     * @param array $options Dados a serem passados para a view (incluindo 'title', 'styles', 'scripts', etc.).
     */
    protected function render(string $view, array $options = [])
    {
        // Valores padrão que podem ser sobrescritos
        $pageTitle = $options['title'] ?? 'Plataforma de Cursos';
        $faviconImg = $options['favicon'] ?? (defined('BASE_URL') ? BASE_URL . '/assets/img/favicon.png' : '/assets/img/favicon.png');

        $pageStyles = $options['styles'] ?? [];
        $pageScriptsHeader = $options['scriptsHeader'] ?? [];
        $pageScriptsFooter = $options['scriptsFooter'] ?? [];
        
        // NOVO: Permite que uma página use a largura total
        $fullWidthLayout = $options['fullWidthLayout'] ?? false;

        // Extrai os dados para serem usados na view
        extract($options);

        // 1. Captura o conteúdo da view específica
        ob_start();
        $viewPath = VIEWS_PATH . "/pages/{$view}.php";
        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            // Se a view não existir, mostra um erro claro
            echo "<p>Erro: View não encontrada em: {$viewPath}</p>";
        }
        $pageContent = ob_get_clean();

        // 2. Renderiza o layout principal, que encapsula $pageContent
        require VIEWS_PATH . '/layout.php'; // ALTERADO: Usa a constante
    }
}
