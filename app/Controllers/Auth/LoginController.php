<?php

namespace App\Controllers\Auth;

use CodeIgniter\Shield\Controllers\LoginController as ShieldLoginController;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Shield\Exceptions\ValidationException;

class LoginController extends ShieldLoginController
{
    public function loginAction(): RedirectResponse
    {
        $rules = [
            'username' => [
                'label' => 'Username',
                'rules' => [
                    'required',
                    'max_length[30]',
                    'min_length[3]',
                    'regex_match[/\A[a-zA-Z0-9\.]+\z/]',
                ],
                'errors' => [
                    'required' => 'Username tidak boleh kosong',
                    'min_length' => 'Username tidak ditemukan',
                    'max_length' => 'Username tidak ditemukan',
                    'regex_match' => 'Username tidak ditemukan',
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => [
                    'required',
                    'min_length[8]'
                ],
                'errors' => [
                    'required' => 'Password tidak boleh kosong',
                    'min_length' => 'Password memiliki panjang minimal 8 karakter'
                ]
            ],
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        try {
            if (auth()->getAuthenticator()->attempt(["username" => $username, "password" => $password])) {
                return redirect()->to('/user/dashboard');
            }
        } catch (ValidationException $e) {
            return redirect()->back()->withInput()->with("error", $e->getMessage());
        }
        return redirect()->back()->withInput()->with("error", 'Username atau password salah.');
    }
}
