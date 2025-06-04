<?php

namespace App\Controllers;

use App\Models\StudentModel;

class StudentController extends BaseController
{
    public function index()
    {
        // Protect Routes (Middleware)
        // if (!session()->get('isLoggedIn')) {
        //     return redirect()->to('/login');
        // }

        //search logic
        $model = new StudentModel();
        $keyword = $this->request->getGet('search');

        if ($keyword) {
            $data['students'] = $model->like('name', $keyword)
                ->orLike('email', $keyword)
                ->orLike('course', $keyword)
                ->paginate(5); //5 student per page 
        } else {
            $data['students'] = $model->paginate(5);
        }
        $data['pager'] = $model->pager;
        $data['search'] = $keyword;
        return view('students/index', $data);
    }
    public function create()
    {
        // Protect Routes (Middleware)
        // if (!session()->get('isLoggedIn')) {
        //     return redirect()->to('/login');
        // }
        return view('students/create');
    }
    public function store()
    {
        $validation = \Config\Services::validation();
        $rules = [
            'name' => 'required|min_length[3]',
            'email' => 'required',
            'course' => 'required',
            'photo' => 'uploaded[photo]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png]'
        ];

        if (!$this->validate($rules)) {
            return view('students/create', [
                'validation' => $this->validator
            ]);
        }
        $photoFile = $this->request->getFile('photo');
        $newName = $photoFile->getRandomName();
        $photoFile->move('uploads/', $newName); // upload to public/uploads/
        $model = new StudentModel();
        $model->save([
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'course' => $this->request->getPost('course'),
            'photo'  => $newName

        ]);
        //set flash message
        session()->setFlashdata('success', 'student added successfuly!');
        return redirect()->to('/students');
    }
    public function edit($id)
    {
        $rules = [
            'name' => 'required|min_length[3]',
            'email' => 'required',
            'course' => 'required'
        ];
        $model = new StudentModel();
        $data['student'] = $model->find($id);
        return view('students/edit', $data);
    }
    public function update($id)
    {
        if (!$this->validate([
            'name'   => 'required|min_length[3]',
            'email'  => 'required|valid_email',
            'course' => 'required'
        ])) {
            $model = new StudentModel();
            return view('students/edit', [
                'student' => $model->find($id),
                'validation' => $this->validator
            ]);
        }

        $model = new StudentModel();
        $model->update($id, $this->request->getPost());
        session()->setFlashdata('update', 'student Update successfuly!');
        return redirect()->to('/students');
    }
    public function delete($id)
    {
        // Protect Routes (Middleware)  
        // if (!session()->get('isLoggedIn')) {
        //     return redirect()->to('/login');
        // }
        $model = new StudentModel();
        $model->delete($id);
        session()->setFlashdata('delete', 'student delete successfuly!');
        return redirect()->to('/students');
    }

    // ***Feature: Export Students to CSV
    public function exportCSV()
    {
        $model = new StudentModel();
        $students = $model->findAll();
        $filename = "students_" . date('Ymd_His') . ".csv"; //Generates a dynamic filename like students_20250602_143015.csv

        //These are HTTP headers sent to the browser
        header("Content-Description: File Transfer"); //This is a file download (File Transfer) tell the browser
        header("Content-Disposition: attachment; filename=$filename"); //The file should be treated as an attachment
        header("Content-Type: application/csv;"); //The file type is CSV

        //Opens a write stream to the browser using php://output
        $file = fopen('php://output', 'w'); //This means whatever you write will be sent directly to the browser

        //defince the column header of the csv file 
        $header = ['ID', 'Name', 'Email', 'Course'];
        fputcsv($file, $header); //fputcsv() writes an array as a line in the CSV file.

        //Writes each student’s data as a row in the CSV using fputcsv().
        foreach ($students as $row) {
            fputcsv($file, [$row['id'], $row['name'], $row['email'], $row['course']]);
        }
        fclose($file); //close the file stream
        exit;
    }

    //
    public function view($id)
    {
        $model = new StudentModel();
        $student = $model->find($id);
        if (!$student) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Student not found');
        }
        return view('students/view', ['student' => $student]); //It passes the student data to the view as an array with the key 'student'
    }





    //practice helper
    public function helper()
    {
        echo "this is helper method";
        echo '<br/>';
        //predifine helper
        helper('url');
        echo base_url();
        echo '<br/>';

        //array helper
        // helper('array');
        // $data = ['name' => 'John', 'age' => 30, 'city' => 'Paris'];

        // $result = elements(['name', 'city'], $data);
        // echo $result;
        // echo '<br/>';


        //this is custom helper
        function greet($name)
        {
            return "Hello, $name!";
        }
        helper('my');
        echo greet('jhon');
        echo '<br/>';

        //session 
        $session = session();
        //set value
        $session->set('username', 'sandip');
        //get value
        echo $session->get('username');
        //remove data
        $session->remove('username');

        // Flash data (one-time message)
        $session->setFlashdata('msg', 'Welcome!'); //this is flash data msg
    }
}
