<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelUsers;

class AuthenticationController extends BaseController
{
    public $ModelUser;
    public function __construct()
    {
        $this->ModelUser = new ModelUsers();
    }
    public function login()
    {
        if (Session()->get('logged_in')) {
            return redirect()->to(base_url('hrd/dashboard'));
        } else {
            $data = [
                'title' => 'Login',
            ];

            return view('auth/login', $data);
        }
    }

    public function register()
    {
        $data = [
            'title' => 'Register',
        ];

        return view('auth/register', $data);
    }

    public function attemptRegister()
    {
        try {

            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');
            $name = $this->request->getVar('name');
            $fullName = $this->request->getVar('name');
            $birthLocationDate = $this->request->getVar('birth_location_date');
            $gender = $this->request->getVar('gender');
            $address = $this->request->getVar('address');
            $telephone = $this->request->getVar('telephone');
            $email = $this->request->getVar('email');

            if ($this->ModelUser->where('username', $username)->first()) {
                session()->setFlashdata('error', 'Username already exists.');
                return redirect()->to(base_url('auth/register'));
            }

            $lastCode = $this->ModelUser->orderBy('user_id', 'DESC')->first()['code'];

            if ($lastCode == null) {
                $code = "A1";
            } else {
                $lastCodeNumber = substr($lastCode, 1);
                $nextCodeNumber = $lastCodeNumber + 1;
                $code = "A" . $nextCodeNumber;
            }

            $data = [
                'code' => $code,
                'username' => $username,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'name' => $name,
                'role' => "CANDIDATE",
                'full_name' => $fullName,
                'birth_location_date' => $birthLocationDate,
                'gender' => $gender,
                'address' => $address,
                'telephone' => $telephone,
                'email' => $email,
            ];

            if ($this->ModelUser->insert($data)) {
                session()->setFlashdata('success', 'Register Berhasil');
                return redirect()->to(base_url('auth/login'));
            } else {
                session()->setFlashdata('error', 'Register Gagal');
                return redirect()->to(base_url('auth/register'));
            }
        } catch (\Exception $th) {
            session()->setFlashdata('error', $th->getMessage());
            return redirect()->to(base_url('auth/register'));
        }
    }

    public function attemptLogin()
    {
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $user = $this->ModelUser->where('username', $username)->first();
        if ($user) {
            if (password_verify($password, $user['password'])) {
                $data = [
                    'user_id' => $user['user_id'],
                    'username' => $user['username'],
                    'name' => $user['name'],
                    'role' => $user['role'],
                    'logged_in' => TRUE,
                ];
                session()->set($data);
                if ($user['role'] == 'HRD') {
                    return redirect()->to(route_to('hrd.dashboard'));
                } else {
                    return redirect()->to(route_to('candidate.dashboard'));
                }
            } else {
                session()->setFlashdata('error', 'Password Salah');
                return redirect()->to(base_url('auth/login'));
            }
        } else {
            session()->setFlashdata('error', 'Username Salah');
            return redirect()->to(base_url('auth/login'));
        }
    }

    public function logout()
    {
        try {
            session()->destroy();
            return redirect()->to(base_url('auth/login'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
