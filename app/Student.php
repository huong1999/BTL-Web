<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

    protected $student;

    public function __construct(Student $student) {
        $this->middleware('auth');
        $this->student = $student;
    }


}
