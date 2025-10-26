<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Models\UserModel;
use App\Controllers\BaseController;

class AuthController extends BaseController
{
    public function loginForm()
    {
        if (Auth::isLogged()) {
            header('Location: ' . BASE_URL . '/dashboard');
            exit;
        }
        $this->render('login', ['title' => 'Acesse sua conta']);
    }

    public function login()
    {
        header('Content-Type: application/json');
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            echo json_encode(['success' => false, 'message' => 'Por favor, preencha todos os campos.']);
            return;
        }

        $userModel = new UserModel();
        $user = $userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['password_hash'])) {
            echo json_encode(['success' => false, 'message' => 'Credenciais inválidas.']);
            return;
        }

        // ATUALIZADO: Passa nome, perfil e plano para a função de login
        $userName = $user['name'] ?? 'Usuário';
        $userRole = $user['role'] ?? 'user';
        $userPlan = $user['subscription_plan'] ?? 'none';
        Auth::login((int) $user['id'], $userName, $userRole, $userPlan);
        
        echo json_encode([
            'success' => true,
            'message' => 'Login realizado com sucesso!',
            'redirect' => BASE_URL . '/dashboard'
        ]);
    }

    public function registerForm()
    {
        if (Auth::isLogged()) {
            header('Location: ' . BASE_URL . '/dashboard');
            exit;
        }
        $this->render('register', ['title' => 'Crie sua conta']);
    }

    public function register()
    {
        header('Content-Type: application/json');

        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($name) || empty($email) || empty($password)) {
            echo json_encode(['success' => false, 'message' => 'Todos os campos são obrigatórios.']);
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'message' => 'Por favor, insira um e-mail válido.']);
            return;
        }
        
        if (strlen($password) < 6) {
             echo json_encode(['success' => false, 'message' => 'A senha deve ter pelo menos 6 caracteres.']);
            return;
        }

        $userModel = new UserModel();
        if ($userModel->findByEmail($email)) {
            echo json_encode(['success' => false, 'message' => 'Este e-mail já está em uso.']);
            return;
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $newUserId = $userModel->create([
            'name' => $name,
            'email' => $email,
            'password_hash' => $passwordHash
        ]);

        if ($newUserId) {
            // Faz o login automático do usuário após o cadastro
            Auth::login((int)$newUserId, $name, 'user', 'none');
            echo json_encode([
                'success' => true,
                'message' => 'Cadastro realizado com sucesso!',
                'redirect' => BASE_URL . '/dashboard'
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Ocorreu um erro ao criar a sua conta. Tente novamente.']);
        }
    }

    public function logout()
    {
        Auth::logout();
        header('Location: ' . BASE_URL . '/');
        exit;
    }
}
