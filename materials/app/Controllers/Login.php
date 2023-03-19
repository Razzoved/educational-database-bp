<?php declare(strict_types = 1);

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Config\Services;

class Login extends BaseController
{
    protected array $settings = [
        'email' => [
            'rules'  => 'required|valid_email|validUserEmail',
            'errors' => [
                'validUserEmail' => 'Invalid email.'
            ],
        ],
        'password' => [
            'rules'  => 'required|validUserPassword[{email}]',
            'errors' => [
                'validUserPassword' => 'Invalid password.'
            ],
        ],
    ];

    public function index() : string
    {
        return view('user_login', ['validation' => Services::validation()]);
    }

    public function authenticate()
    {
        if (!$this->validate($this->settings)) {
            return view('user_login', ['validation' => $this->validator]);
        }

        $user = model(UserModel::class)->getByEmail(
            $this->request->getPost('email')
        );

        $user->password = null;
        session()->set([
            'user' => $user,
            'isLoggedIn' => true,
        ]);

        return previous_url() === base_url('login')
            ? redirect('admin')
            : redirect()->to(previous_url());
    }
}
