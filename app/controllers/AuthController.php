<?php
class AuthController extends Controller {
    private $userModel;

    public function __construct(){
        $this->userModel = $this->model('User');
    }

    public function index(){
        $this->login();
    }

    public function register(){
        if(isLoggedIn()){
            redirect('notes');
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'name_error' => '', 'email_error' => '', 'password_error' => '', 'confirm_password_error' => ''
            ];

            if(empty($data['name'])){ $data['name_error'] = 'Por favor, insira seu nome.'; }
            if(empty($data['email'])){ $data['email_error'] = 'Por favor, insira seu email.'; }
            elseif($this->userModel->findUserByEmail($data['email'])){ $data['email_error'] = 'Email já cadastrado.'; }
            if(empty($data['password'])){ $data['password_error'] = 'Por favor, insira uma senha.'; }
            elseif(strlen($data['password']) < 6){ $data['password_error'] = 'A senha deve ter no mínimo 6 caracteres.';}
            if(empty($data['confirm_password'])){ $data['confirm_password_error'] = 'Por favor, confirme a senha.'; }
            else { if($data['password'] != $data['confirm_password']){ $data['confirm_password_error'] = 'As senhas não coincidem.'; }}

            if(empty($data['name_error']) && empty($data['email_error']) && empty($data['password_error']) && empty($data['confirm_password_error'])){
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                if($this->userModel->register($data)){
                    flash('register_success', 'Você foi registrado com sucesso! Faça o login.');
                    redirect('auth/login');
                } else {
                    flash('register_error', 'Ocorreu um erro inesperado. Tente novamente.', 'alert-danger');
                    $this->view('auth/register', $data);
                }
            } else {
                $this->view('auth/register', $data);
            }
        } else {
            $data = [
                'name' => '', 'email' => '', 'password' => '', 'confirm_password' => '',
                'name_error' => '', 'email_error' => '', 'password_error' => '', 'confirm_password_error' => ''
            ];
            $this->view('auth/register', $data);
        }
    }

    public function login(){
        if(isLoggedIn()){
            redirect('notes');
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_error' => '', 'password_error' => ''
            ];

            if(empty($data['email'])){ $data['email_error'] = 'Por favor, insira o email.'; }
            if(empty($data['password'])){ $data['password_error'] = 'Por favor, insira a senha.'; }

            if(empty($data['email_error']) && empty($data['password_error'])){
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);
                if($loggedInUser){
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['password_error'] = 'Email ou senha inválidos.';
                    $this->view('auth/login', $data);
                }
            } else {
                $this->view('auth/login', $data);
            }
        } else {
            $data = [
                'email' => '', 'password' => '', 'email_error' => '', 'password_error' => ''
            ];
            $this->view('auth/login', $data);
        }
    }

    public function createUserSession($user){
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_name'] = $user->name;
        redirect('notes');
    }

    public function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        session_destroy();
        redirect('auth/login');
    }
}