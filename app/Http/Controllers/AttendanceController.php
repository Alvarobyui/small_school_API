<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;
use App\Models\Attendance;
class AttendanceController extends Controller
{
    public function index() {
        $attendance = Attendance::where('status', 1)->get();
        return $attendance;

/*         $table->date('date');
        $table->string('status');
        $table->unsignedBigInteger('student_id')->nullable();
        $table->foreign('student_id')->references('id')->on('students');
 */ }
    public function getByDate($date) {
        $attendance = Attendance::where('date', $date)->where('status', 1)->all();
        if(!$attendance) {        
            return response()->json(["error"=>"Date not registered or deleted. Please, try another one."]);
        }
        return $attendance;
    }

    public function create(Request $request) {
        return $request;
    }
}
