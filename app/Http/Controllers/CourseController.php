<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    public function index() {
        $courses = Course::where('status', 1)->get();
        return $courses;
    }
    public function getByID($id) {
        $course = Course::where('id', $id)->where('status', 1)->first();
        if(!$course) {        
            return response()->json(["error"=>"Course not existent or deleted. Verify the course's id."]);
        }
        return $course;
    }
    public function create(Request $request) {
        $course = new Course();
        $course->name = $request->name;
        $course->description = $request->description;
        $course->status = 1;
        $course->save();
        
        return $course;
    }
    public function update(Request $request, Course $course) {
        if($request->status == 0) {
            return response()->json(['error'=>'Course not found or deleted. Please, choose another one.']);
        } 
        
        $course->name = $request->name;
        $course->description = $request->description;
        $course->save();
        
        return $course;
    }

    public function delete(Course $course) {
        $course->status = 0;
        $course->save();
        return $course;
    }

}
