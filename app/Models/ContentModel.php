<?php

namespace App\Models;

use App\Database\DataSource;

class ContentModel
{
    private DataSource $db;
    private string $modulesTable = 'course_modules';
    private string $lessonsTable = 'course_lessons';


    public function __construct()
    {
        $this->db = DataSource::getInstance();
    }

    // --- MÓDULOS ---

    public function createModule(int $courseId, string $title, int $order): bool
    {
        $sql = "INSERT INTO {$this->modulesTable} (course_id, title, `order`) VALUES (:course_id, :title, :order)";
        return $this->db->execute($sql, [
            'course_id' => $courseId,
            'title' => $title,
            'order' => $order
        ]);
    }
    
    public function getNextModuleOrder(int $courseId): int
    {
        $sql = "SELECT MAX(`order`) as max_order FROM {$this->modulesTable} WHERE course_id = :course_id";
        $result = $this->db->selectOne($sql, ['course_id' => $courseId]);
        return ($result['max_order'] ?? 0) + 1;
    }
    
    public function findModuleById(int $moduleId): ?array
    {
        $sql = "SELECT * FROM {$this->modulesTable} WHERE id = :id";
        return $this->db->selectOne($sql, ['id' => $moduleId]);
    }

    /**
     * (MÉTODO NOVO) Busca todos os módulos de um curso.
     */
    public function findModulesByCourseId(int $courseId): array
    {
        $sql = "SELECT * FROM {$this->modulesTable} WHERE course_id = :course_id ORDER BY `order` ASC";
        return $this->db->select($sql, ['course_id' => $courseId]);
    }
    
    /**
     * (MÉTODO NOVO) Apaga um módulo.
     */
    public function deleteModule(int $moduleId): bool
    {
        // NOTA: Se o DB tiver 'ON DELETE CASCADE' para lições, isto é suficiente.
        // Caso contrário, teria de apagar as lições primeiro.
        $sql = "DELETE FROM {$this->modulesTable} WHERE id = :id";
        return $this->db->execute($sql, ['id' => $moduleId]);
    }


    // --- LIÇÕES ---

    public function createLesson(array $data): bool
    {
        $sql = "INSERT INTO {$this->lessonsTable} (module_id, title, content_type, content_path, content_text, `order`) 
                VALUES (:module_id, :title, :content_type, :content_path, :content_text, :order)";
        return $this->db->execute($sql, $data);
    }
    
    public function getNextLessonOrder(int $moduleId): int
    {
        $sql = "SELECT MAX(`order`) as max_order FROM {$this->lessonsTable} WHERE module_id = :module_id";
        $result = $this->db->selectOne($sql, ['module_id' => $moduleId]);
        return ($result['max_order'] ?? 0) + 1;
    }

    /**
     * (MÉTODO NOVO) Encontra uma lição pelo ID.
     */
    public function findLessonById(int $lessonId): ?array
    {
        $sql = "SELECT * FROM {$this->lessonsTable} WHERE id = :id";
        return $this->db->selectOne($sql, ['id' => $lessonId]);
    }
    
    /**
     * (MÉTODO NOVO) Atualiza uma lição.
     */
    public function updateLesson(int $lessonId, array $data): bool
    {
        // A ordem (order) não está incluída nesta atualização simples
        $sql = "UPDATE {$this->lessonsTable} SET 
                    title = :title, 
                    content_type = :content_type, 
                    content_path = :content_path, 
                    content_text = :content_text 
                WHERE id = :id";
        
        $data['id'] = $lessonId;
        return $this->db->execute($sql, $data);
    }
    
    /**
     * (MÉTODO NOVO) Apaga uma lição.
     */
    public function deleteLesson(int $lessonId): bool
    {
        $sql = "DELETE FROM {$this->lessonsTable} WHERE id = :id";
        return $this->db->execute($sql, ['id' => $lessonId]);
    }
}
