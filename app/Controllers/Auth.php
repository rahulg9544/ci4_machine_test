<?php
namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function register()
    {
        return view('register');
    }

    public function store()
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'profile_pic' => 'uploaded[profile_pic]|max_size[profile_pic,1024]|is_image[profile_pic]',
            'gender' => 'required|in_list[male,female,other]',
            'password' => 'required|min_length[8]',
            'password_confirm' => 'matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();

        $file = $this->request->getFile('profile_pic');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads', $newName);
        }

        $userModel->save([
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'profile_pic' => $newName,
            'gender' => $this->request->getPost('gender'),
            'password' => $this->request->getPost('password'),
        ]);

        return redirect()->to('/login')->with('message', 'Registration successful');
    }

    public function login()
    {
        return view('login');
    }

    public function authenticate()
    {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[8]',
        ];

       

        if (!$this->validate($rules)) {
            
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        $user = $userModel->where('email', $this->request->getPost('email'))->first();

     

        if (!$user || !password_verify($this->request->getPost('password'), $user['password'])) {


            return redirect()->back()->with('error', 'Invalid credentials');
        }

        // echo "<pre>";
        // print_r($user);

        // exit;

        session()->set('user', $user);
        return redirect()->to('/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
