<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

    protected $table = 'students';
    protected $fillable = ['id', 'name', 'mssv', 'dateOfBirth', 'class', 'password'];

    public function __construct(Student $student) {
        $this->middleware('auth');
        $this->student = $student;
    }

    public function showStudent()
    {
        $students = Student::all();

        return $students;
    }

    public function addStudent($input)
    {
        $student = $this->create($input);
        return $student;
    }

    public function updateStudent($input, $id)
    {
        $student = Student::findOrFail($id);      //output the first result of query
        $student->name = $input->name;
        $student->mssv = $input->mssv;
        $student->dateOfBirth = $input->dateOfBirth;
        $student->class = $input->class;
        $student->password = $input->password;
        $student->save();

        return $student;

    }

    public function deleteStudent($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return $student;
    }

    public function searchStudent($key)
    {
        $students = Student::select('*')
            ->where('name', 'like', "%$key%")
            ->orwhere('mssv', 'like', "%$key%")
            ->orwhere('dateOfBirth', 'like', "%$key%")
            ->orwhere('class', 'like', "%$key%")
            ->get();    //take data

        return $students;

    }
}





}
