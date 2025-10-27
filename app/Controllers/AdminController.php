<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Models\CourseModel;
use App\Models\ContentModel; // Certifique-se de que este modelo existe
use App\Controllers\BaseController;

class AdminController extends BaseController
{
    private ContentModel $contentModel;
    private CourseModel $courseModel;

    public function __construct()
    {
        if (!Auth::isAdmin()) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
        $this->contentModel = new ContentModel();
        $this->courseModel = new CourseModel();
    }

    private function validateCourseData(array $postData): ?string
    {
        $requiredFields = [
            'title' => 'Título',
            'description' => 'Descrição',
            'instructor' => 'Instrutor',
            'workload' => 'Carga Horária',
            'target_audience' => 'Público-alvo',
            'format' => 'Formato',
            'level' => 'Nível',
            'modality' => 'Modalidade',
            'category' => 'Categoria',
            'status' => 'Status'
        ];

        foreach ($requiredFields as $field => $fieldName) {
            if (empty(trim($postData[$field]))) {
                return "O campo '{$fieldName}' é obrigatório.";
            }
        }
        return null;
    }

    private function handleImageUpload(): array
    {
        if (!isset($_FILES['image']) || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
            return ['path' => null, 'error' => null];
        }

        if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            return ['path' => null, 'error' => 'Erro no upload. Código: ' . $_FILES['image']['error']];
        }

        $uploadSubDir = 'assets' . DIRECTORY_SEPARATOR . 'img-courses';
        $uploadDir = ROOT_PATH . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . $uploadSubDir;

        if (!is_dir($uploadDir)) {
            if (!@mkdir($uploadDir, 0777, true)) {
                 $error = error_get_last();
                 return ['path' => null, 'error' => "Falha ao criar diretório: " . ($error['message'] ?? 'erro desconhecido')];
            }
        }

        $fileName = uniqid() . '-' . basename($_FILES['image']['name']);
        $targetPath = $uploadDir . DIRECTORY_SEPARATOR . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            return ['path' => '/' . str_replace(DIRECTORY_SEPARATOR, '/', $uploadSubDir . '/' . $fileName), 'error' => null];
        } else {
            return ['path' => null, 'error' => 'Falha ao mover o ficheiro. Verifique as permissões do servidor.'];
        }
    }

    public function createCourse()
    {
        $validationError = $this->validateCourseData($_POST);
        if ($validationError) {
            $_SESSION['error_message'] = $validationError;
            $_SESSION['form_data'] = $_POST;
            header('Location: ' . BASE_URL . '/admin/courses/create');
            exit;
        }

        $uploadResult = $this->handleImageUpload();
        if ($uploadResult['error']) {
            $_SESSION['error_message'] = $uploadResult['error'];
            $_SESSION['form_data'] = $_POST;
            header('Location: ' . BASE_URL . '/admin/courses/create');
            exit;
        }

        $data = [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'instructor' => $_POST['instructor'],
            'price' => empty($_POST['price']) ? 0.00 : $_POST['price'],
            'image_url' => $uploadResult['path'],
            'status' => $_POST['status'],
            'workload' => $_POST['workload'],
            'target_audience' => $_POST['target_audience'],
            'format' => $_POST['format'],
            'level' => $_POST['level'],
            'modality' => $_POST['modality'],
            'category' => $_POST['category'],
        ];

        if ($this->courseModel->create($data)) {
            $_SESSION['success_message'] = 'Curso criado com sucesso!';
            unset($_SESSION['form_data']);
        } else {
            $_SESSION['error_message'] = 'Erro ao salvar o curso no banco de dados.';
            $_SESSION['form_data'] = $_POST;
        }

        header('Location: ' . BASE_URL . '/admin/courses');
        exit;
    }

    public function updateCourse($id)
    {
        $validationError = $this->validateCourseData($_POST);
        if ($validationError) {
            $_SESSION['error_message'] = $validationError;
            header('Location: ' . BASE_URL . '/admin/courses/edit/' . $id);
            exit;
        }

        $uploadResult = $this->handleImageUpload();
        if ($uploadResult['error']) {
            $_SESSION['error_message'] = $uploadResult['error'];
            header('Location: ' . BASE_URL . '/admin/courses/edit/' . $id);
            exit;
        }

        $imageUrl = $uploadResult['path'] ?? $_POST['current_image_url'] ?? null;

        $data = [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'instructor' => $_POST['instructor'],
            'price' => empty($_POST['price']) ? 0.00 : $_POST['price'],
            'image_url' => $imageUrl,
            'status' => $_POST['status'],
            'workload' => $_POST['workload'],
            'target_audience' => $_POST['target_audience'],
            'format' => $_POST['format'],
            'level' => $_POST['level'],
            'modality' => $_POST['modality'],
            'category' => $_POST['category'],
        ];

        if ($this->courseModel->update((int)$id, $data)) {
            $_SESSION['success_message'] = 'Curso atualizado com sucesso!';
        } else {
            $_SESSION['error_message'] = 'Erro ao atualizar o curso no banco de dados.';
        }

        header('Location: ' . BASE_URL . '/admin/courses');
        exit;
    }

    public function listCourses()
    {
        $courses = $this->courseModel->findAll();
        $this->render('admin/courses', ['title' => 'Gerenciar Cursos', 'courses' => $courses]);
    }

    public function createCourseForm()
    {
        $courseData = $_SESSION['form_data'] ?? null;
        unset($_SESSION['form_data']);
        
        $this->render('admin/course_form', [
            'title' => 'Adicionar Novo Curso',
            'action' => BASE_URL . '/admin/courses/create',
            'course' => $courseData
        ]);
    }

    public function editCourseForm($id)
    {
        $course = $this->courseModel->findById((int)$id);
        if (!$course) {
            header("Location: " . BASE_URL . "/admin/courses");
            exit;
        }
        $this->render('admin/course_form', [
            'title' => 'Editar Curso',
            'action' => BASE_URL . '/admin/courses/edit/' . $id,
            'course' => $course
        ]);
    }

    public function deleteCourse($id)
    {
        $course = $this->courseModel->findById((int)$id);
        if ($course && !empty($course['image_url'])) {
            $filePath = ROOT_PATH . DIRECTORY_SEPARATOR . 'public' . $course['image_url'];
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
        }

        $this->courseModel->delete((int)$id);
        $_SESSION['success_message'] = 'Curso apagado com sucesso!';
        header('Location: ' . BASE_URL . '/admin/courses');
        exit;
    }

    // --- MÉTODOS PARA GERENCIAR CONTEÚDO (CORRIGIDOS) ---

    public function manageCourseContent($courseId)
    {
        $course = $this->courseModel->findCourseWithContent((int)$courseId);
        if (!$course) {
            $_SESSION['error_message'] = 'Curso não encontrado.';
            header('Location: '. BASE_URL . '/admin/courses');
            exit;
        }

        // Os módulos e lições já vêm de findCourseWithContent
        $modules = $course['modules'] ?? [];

        $this->render('admin/manage_content', [
            'title' => 'Gerenciar Conteúdo: ' . $course['title'],
            'course' => $course,
            'modules' => $modules
        ]);
    }

    public function createModule($courseId)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty(trim($_POST['title']))) {
            $_SESSION['error_message'] = 'Nome do módulo é obrigatório.';
            header('Location: ' . BASE_URL . '/admin/courses/' . $courseId . '/content');
            exit;
        }

        $title = trim($_POST['title']);
        // CORREÇÃO: Obter a próxima ordem
        $order = $this->contentModel->getNextModuleOrder((int)$courseId);

        if ($this->contentModel->createModule((int)$courseId, $title, $order)) {
            $_SESSION['success_message'] = 'Módulo criado com sucesso!';
        } else {
            $_SESSION['error_message'] = 'Erro ao criar o módulo.';
        }
        header('Location: ' . BASE_URL . '/admin/courses/' . $courseId . '/content');
        exit;
    }

    public function deleteModule($courseId, $moduleId)
    {
        // (A lógica de exclusão de lições associadas deve ser tratada no modelo se houver chaves estrangeiras com CASCADE)
        if ($this->contentModel->deleteModule((int)$moduleId)) {
            $_SESSION['success_message'] = 'Módulo excluído com sucesso.';
        } else {
            $_SESSION['error_message'] = 'Erro ao excluir o módulo.';
        }
        header('Location: ' . BASE_URL . '/admin/courses/' . $courseId . '/content');
        exit;
    }

    public function createLessonForm($courseId, $moduleId)
    {
        $course = $this->courseModel->findById((int)$courseId);
        $module = $this->contentModel->findModuleById((int)$moduleId);

        if (!$course || !$module || $module['course_id'] != $courseId) {
            $_SESSION['error_message'] = 'Módulo ou curso inválido.';
            header('Location: ' . BASE_URL . '/admin/courses');
            exit;
        }

        $this->render('admin/lesson_form', [
            'title' => 'Adicionar Nova Lição',
            'course' => $course,
            'module' => $module,
            'lesson' => $_SESSION['form_data'] ?? null,
            // CORREÇÃO: Passa a action correta para o formulário
            'action' => BASE_URL . '/admin/courses/' . $courseId . '/modules/' . $moduleId . '/lessons/create'
        ]);
        unset($_SESSION['form_data']);
    }

    public function createLesson($courseId, $moduleId)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/courses/' . $courseId . '/content');
            exit;
        }

        // CORREÇÃO: Lógica para tratar os diferentes tipos de conteúdo do formulário
        $title = $_POST['title'] ?? '';
        $contentType = $_POST['content_type'] ?? 'video';
        $contentText = null;
        $contentPath = null;

        if (empty($title)) {
            $_SESSION['error_message'] = 'O título da lição é obrigatório.';
            $_SESSION['form_data'] = $_POST;
            header('Location: ' . BASE_URL . '/admin/courses/' . $courseId . '/modules/' . $moduleId . '/lessons/create');
            exit;
        }

        if ($contentType === 'video') {
            $contentPath = $_POST['content_path_video'] ?? null;
        } elseif ($contentType === 'text') {
            $contentText = $_POST['content_text'] ?? null;
        } elseif ($contentType === 'pdf') {
            // A lógica de upload de PDF precisaria ser implementada de forma semelhante ao handleImageUpload
            // Por enquanto, vamos salvar o nome do ficheiro se for enviado, mas o upload real não está aqui.
            $contentPath = $_POST['content_path_pdf'] ?? null; // Simplificado
        }

        $order = $this->contentModel->getNextLessonOrder((int)$moduleId);

        $data = [
            'module_id' => (int)$moduleId,
            'title' => $title,
            'content_type' => $contentType,
            'content_path' => $contentPath,
            'content_text' => $contentText,
            'order' => $order
        ];

        if ($this->contentModel->createLesson($data)) {
            $_SESSION['success_message'] = 'Lição adicionada com sucesso!';
        } else {
            $_SESSION['error_message'] = 'Erro ao adicionar a lição.';
        }
        header('Location: ' . BASE_URL . '/admin/courses/' . $courseId . '/content');
        exit;
    }

    public function editLessonForm($courseId, $lessonId)
    {
        $lesson = $this->contentModel->findLessonById((int)$lessonId);
        if (!$lesson) {
            $_SESSION['error_message'] = 'Lição não encontrada.';
            header('Location: ' . BASE_URL . '/admin/courses/' . $courseId . '/content');
            exit;
        }
        
        $course = $this->courseModel->findById((int)$courseId);
        $module = $this->contentModel->findModuleById((int)$lesson['module_id']);

        $this->render('admin/lesson_form', [
            'title' => 'Editar Lição',
            'course' => $course,
            'module' => $module,
            'lesson' => $lesson,
            'action' => BASE_URL . '/admin/courses/' . $courseId . '/lessons/update/' . $lessonId
        ]);
    }

    public function updateLesson($courseId, $lessonId)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/courses/' . $courseId . '/content');
            exit;
        }

        // CORREÇÃO: Lógica para tratar os diferentes tipos de conteúdo do formulário
        $title = $_POST['title'] ?? '';
        $contentType = $_POST['content_type'] ?? 'video';
        $contentText = null;
        $contentPath = null;

        if (empty($title)) {
            $_SESSION['error_message'] = 'O título da lição é obrigatório.';
            header('Location: ' . BASE_URL . '/admin/courses/' . $courseId . '/lessons/edit/' . $lessonId);
            exit;
        }

        if ($contentType === 'video') {
            $contentPath = $_POST['content_path_video'] ?? null;
        } elseif ($contentType === 'text') {
            $contentText = $_POST['content_text'] ?? null;
        } elseif ($contentType === 'pdf') {
            $contentPath = $_POST['content_path_pdf'] ?? null;
             // Lógica de upload de PDF (se houver novo ficheiro)
        }

        $data = [
            'title' => $title,
            'content_type' => $contentType,
            'content_path' => $contentPath,
            'content_text' => $contentText,
        ];


        if ($this->contentModel->updateLesson((int)$lessonId, $data)) {
            $_SESSION['success_message'] = 'Lição atualizada com sucesso!';
        } else {
            $_SESSION['error_message'] = 'Erro ao atualizar a lição.';
        }
        header('Location: ' . BASE_URL . '/admin/courses/' . $courseId . '/content');
        exit;
    }

    public function deleteLesson($courseId, $lessonId)
    {
        if ($this->contentModel->deleteLesson((int)$lessonId)) {
            $_SESSION['success_message'] = 'Lição excluída com sucesso.';
        } else {
            $_SESSION['error_message'] = 'Erro ao excluir a lição.';
        }
        header('Location: ' . BASE_URL . '/admin/courses/' . $courseId . '/content');
        exit;
    }
}
