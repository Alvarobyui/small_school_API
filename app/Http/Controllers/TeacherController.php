<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use Illuminate\Validation\ValidationException;

class TeacherController extends Controller
{
    public function index() {
        $teachers = Teacher::where('status', 1)->get();
        return $teachers;
    }

    public function getByID($id) {
        $teacher = Teacher::where('id', $id)->where('status', 1)->first();
        if(!$teacher) {        
            return response()->json(["error"=>"Teacher not found or deleted. Please, verify the teacher's id."]);
        }
        return $teacher;
    }

    public function create(Request $request) {
        try {
            $validateData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:teachers,email',
                'password' => 'required|string|min:8',
            ]);
        

            $teacher = new Teacher();
            $teacher->name = $validateData['name'];
            $teacher->role = 2;
            $teacher->status = 1;
            $teacher->email = $validateData['email'];
            $teacher->password = bcrypt($validateData['password']);
            $teacher->save();
            
            return $teacher;
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        }
    }

    public function update(Request $request, Teacher $teacher) {
        if($teacher->status != 1) {
            return response()->json(['error'=>'Teacher not found or deleted. Please, choose another one.']);
        }
        $teacher->name = $request->name;
        $teacher->role = $request->role;
        $teacher->status = $request->status;
        $teacher->email = $request->email;
        $teacher->password = $request->password;
        $teacher->save();

        return $teacher;
    }

    public function delete(Teacher $teacher) {
        $teacher->status = 0;
        $teacher->save();
        return $teacher;
    }
}
