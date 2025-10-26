<?php

namespace App\Models;

use App\Database\DataSource;

class ContentModel
{
    private DataSource $db;

    public function __construct()
    {
        $this->db = DataSource::getInstance();
    }

    // --- MÓDULOS ---

    public function createModule(int $courseId, string $title, int $order): bool
    {
        $sql = "INSERT INTO course_modules (course_id, title, `order`) VALUES (:course_id, :title, :order)";
        return $this->db->execute($sql, [
            'course_id' => $courseId,
            'title' => $title,
            'order' => $order
        ]);
    }
    
    public function getNextModuleOrder(int $courseId): int
    {
        $sql = "SELECT MAX(`order`) as max_order FROM course_modules WHERE course_id = :course_id";
        $result = $this->db->selectOne($sql, ['course_id' => $courseId]);
        return ($result['max_order'] ?? 0) + 1;
    }

    // --- LIÇÕES ---

    public function createLesson(array $data): bool
    {
        $sql = "INSERT INTO course_lessons (module_id, title, content_type, content_path, content_text, `order`) 
                VALUES (:module_id, :title, :content_type, :content_path, :content_text, :order)";
        return $this->db->execute($sql, $data);
    }
    
    public function getNextLessonOrder(int $moduleId): int
    {
        $sql = "SELECT MAX(`order`) as max_order FROM course_lessons WHERE module_id = :module_id";
        $result = $this->db->selectOne($sql, ['module_id' => $moduleId]);
        return ($result['max_order'] ?? 0) + 1;
    }
    
    public function findModuleById(int $moduleId): ?array
    {
        $sql = "SELECT * FROM course_modules WHERE id = :id";
        return $this->db->selectOne($sql, ['id' => $moduleId]);
    }
}