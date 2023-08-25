<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;
use App\Models\Attendance;

use function PHPUnit\Framework\isEmpty;

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
        $attendance = Attendance::where('date', $date)->where('status', 1)->get();

        if($attendance->isEmpty()) {        
            return response()->json(["error" => "Date not registered or deleted. Please, try another one."]);
        }

        return response()->json($attendance);
    }

    public function create(Request $request) {
        $attendance = new Attendance();
        $attendance->date = $request->date;
        $attendance->report = $request->report;
        $attendance->student_id = $attendance->student_id;
        $attendance->status = $attendance->status;

        $attendance->save();
        return $attendance;
    }
}
