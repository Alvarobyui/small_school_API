<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;

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
        $teacher = new Teacher();
        $teacher->name = $request->name;
        $teacher->role = 2;
        $teacher->status = 1;
        $teacher->email = $request->email;
        $teacher->password = $request->password;
        $teacher->save();
        
        return $teacher;
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
