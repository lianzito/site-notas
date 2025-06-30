<?php
class UserController extends Controller {
    private $userModel;

    public function __construct(){
        if(!isLoggedIn()){
            redirect('auth/login');
        }
        $this->userModel = $this->model('User');
    }

    public function profile(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);
            $data = [
                'id' => $_SESSION['user_id'],
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'name_error' => '', 'email_error' => '', 'password_error' => ''
            ];

            $currentUser = $this->userModel->findUserById($_SESSION['user_id']);

            if(empty($data['name'])){ $data['name_error'] = 'O nome não pode ficar em branco.'; }
            if(empty($data['email'])){ $data['email_error'] = 'O email não pode ficar em branco.'; }
            elseif($data['email'] != $currentUser->email && $this->userModel->findUserByEmail($data['email'])){
                $data['email_error'] = 'Este e-mail já está em uso.';
            }

            if(!empty($data['password'])){
                if(strlen($data['password']) < 6){
                    $data['password_error'] = 'A nova senha deve ter no mínimo 6 caracteres.';
                }
                if($data['password'] != $data['confirm_password']){
                    $data['password_error'] = 'As senhas não coincidem.';
                }
            } else {
                $data['password'] = null;
            }

            if(empty($data['name_error']) && empty($data['email_error']) && empty($data['password_error'])){
                if($this->userModel->updateUser($data)){
                    $_SESSION['user_name'] = $data['name'];
                    flash('profile_message', 'Dados atualizados com sucesso!');
                    redirect('user/profile');
                } else {
                    flash('profile_message', 'Algo deu errado ao atualizar os dados.', 'alert-danger');
                    redirect('user/profile');
                }
            } else {
                $this->view('user/profile', $data);
            }
        } else {
            $user = $this->userModel->findUserById($_SESSION['user_id']);
            $data = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'password' => '', 'confirm_password' => '',
                'name_error' => '', 'email_error' => '', 'password_error' => ''
            ];
            $this->view('user/profile', $data);
        }
    }
}