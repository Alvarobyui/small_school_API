<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Database\QueryException;
use App\Models\Course;

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
        $student->email = $request->email;
        $student->password = $request->password;
        $student->course_id = $request->course_id;
        $student->save();

        return $student;
    }
    
    public function enroll(Request $request, Student $student) {
        // Si el course_id está presente, lo usamos directamente
        if ($request->has('course_id')) {
            $course = Course::find($request->course_id);
            if (!$course) {
                return response()->json(['error' => 'Invalid course ID.'], 400);
            }
            $student->course_id = $course->id;
        } 
        // Si el nombre del curso está presente, buscamos el curso por su nombre
        elseif ($request->has('course_name')) {
            $course = Course::where('name', $request->course_name)->first();
            if (!$course) {
                return response()->json(['error' => 'Course not found with the provided name.'], 400);
            }
            $student->course_id = $course->id;
        } 
        // Si ninguno de los dos está presente, retornamos un error
        else {
            return response()->json(['error' => 'You must provide either a course ID or course name.'], 400);
        }
    
        // Guardar el estudiante con el course_id actualizado
        $student->save();
    
        return response()->json(['message' => 'Student enrolled successfully.']);
    }

    public function delete(Student $student) {
        $student->status = 0;
        $student->save();
        return $student;
    }
    
}
