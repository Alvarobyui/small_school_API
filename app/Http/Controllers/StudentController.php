<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Database\QueryException;

class StudentController extends Controller
{
    public function index() {
        $students = Student::where('status', 1)->get();
        return $students;
    }
    public function getByID($id) {
        $student = Student::where('id', $id)->where('status', 1)->first();
        if(!$student) {        
            return response()->json(["error"=>"Student not found or deleted. Please, verify the student's id."]);
        }
        return $student;
    }
    public function create(Request $request) {
        $student = new Student();
        $student->name = $request->name;
        $student->role = 2;
        $student->status = 1;
        $student->email = $request->email;
        $student->password = $request->password;
        $student->save();
        
        return $student;
    }
    public function update(Request $request, Student $student) {
        if($student->status != 1) {
            return response()->json(['error'=>'Student not found or deleted. Please, choose another one.']);
        }
        $student->name = $request->name;
        $student->role = $request->role;
        $student->status = $request->status;
        $student->email = $request->email;
        $student->password = $request->password;
        $student->save();

        return $student;
    }

    public function delete(Student $student) {
        $student->status = 0;
        $student->save();
        return $student;
    }
    
}
