<?php use App\Core\Auth; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Plataforma de Cursos' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- CSS global -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <link rel="icon" type="image/png" href="<?= $faviconImg ?? (BASE_URL . '/assets/img/favicon.png') ?>">

    <!-- Estilos para as categorias -->
    <style>
        .category-tag {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            line-height: 1.25;
            text-transform: capitalize;
        }
        .category-platinum {
            background-color: #e5e7eb; /* gray-200 */
            color: #4b5563; /* gray-600 */
            border: 1px solid #d1d5db; /* gray-300 */
        }
        .category-premium {
            background-color: #fffbeb; /* amber-50 */
            color: #b45309; /* amber-700 */
            border: 1px solid #fde68a; /* amber-200 */
        }
        .category-essential {
            background-color: #fee2e2; /* red-100 */
            color: #b91c1c; /* red-700 */
            border: 1px solid #fecaca; /* red-200 */
        }
    </style>

    <!-- CSS dinâmico -->
    <?php if (!empty($pageStyles)): ?>
        <?php foreach ($pageStyles as $style): ?>
            <link rel="stylesheet" href="<?= htmlspecialchars($style) ?>">
        <?php endforeach; ?>
    <?php endif; ?>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <?php 
    // Define se a barra lateral deve ser mostrada
    $showSidebar = Auth::isLogged() && !in_array(trim($_GET['url'] ?? '', '/'), ['planos', 'login', 'esqueci-a-senha']);
    ?>

    <div class="flex min-h-screen">
        <?php if ($showSidebar): ?>
            <!-- Barra Lateral Fixa -->
            <?php require_once __DIR__ . '/partials/course_sidebar.php'; ?>
        <?php endif; ?>

        <!-- Conteúdo Principal -->
        <div class="flex-1 flex flex-col">
            <?php require_once __DIR__ . '/partials/header.php'; ?>
            
            <main class="flex-grow p-6 <?= $showSidebar ? 'lg:ml-64' : '' ?>">
                <?php if (!empty($pageContent)) echo $pageContent; ?>
            </main>

            <?php require_once __DIR__ . '/partials/footer.php'; ?>
        </div>
    </div>

    <!-- JS dinâmico no rodapé -->
    <?php if (!empty($pageScriptsFooter)): ?>
        <?php foreach ($pageScriptsFooter as $script): ?>
            <script src="<?= htmlspecialchars($script) ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>

</body>
</html>

