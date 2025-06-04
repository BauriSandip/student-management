<?php

namespace App\Controllers;

use App\Models\AdminModel;

class AuthController extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }
    public function loginPost()
    {
        $session = session(); //initilize the session service
        $model = new AdminModel();

        //user input post request
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        //find the admin by email
        $admin = $model->where('email', $email)->first(); //first() returns the first matching row
        if ($admin && password_verify($password, $admin['password'])) {
            $session->set('isLoggedIn', true);
            return redirect()->to('/students');
        } else {
            return redirect()->back()->with('error', 'Invalid login');
        }
    }
    public function logout()
    {
        //Calls the session() helper to access the current session.
        //Then calls the destroy() method to completely delete all session data.
        session()->destroy();
        return redirect()->to('/login');
    }
}
