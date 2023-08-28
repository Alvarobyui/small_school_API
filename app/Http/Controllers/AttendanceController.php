<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Attendance;
use Attribute;
use Nette\Schema\ValidationException;

use function PHPUnit\Framework\isEmpty;

class AttendanceController extends Controller
{
    public function index() {
        $attendance = Attendance::where('status', 1)->get();
        return $attendance;

    }

    public function getByDate($date) {
        $dateTime = \DateTime::createFromFormat('Y-m-d', $date);
        if (!$dateTime || $dateTime->format('Y-m-d') !== $date) {
            return response()->json(["error" => "Invalid date format. Please provide a date in 'YYYY-MM-DD' format."]);
        }
        
        $attendance = Attendance::where('date', $date)->where('status', 1)->get();
    
        if($attendance->isEmpty()) {        
            return response()->json(["error" => "Date not registered or deleted. Please, try another one."]);
        }
    
        $fullInfo = $attendance->map(function ($record) {
            return [
                'date'          => $record->date,
                'student_id'    => $record->student_id,
                'student_name'  => $record->student->name,
                'report'        => $record->report  // Obtener el nombre del estudiante relacionado
            ];
        });
    
        return response()->json($fullInfo);
    }

    public function create(Request $request) {
        if (!Student::where('id', $request->student_id)->exists()) {
            return response()->json(["error" => "Student not found. Please, choose another one."]);
        }

        $validatedData = $request->validate([
            'date' => 'required|date',
            'report' => 'required|in:Absent,absent,Excused absence,excused absence,Present,present,Tardy,tardy,Unexcused absence,unexcused absence',
            'student_id' => 'required',
        ]);
    
        if (!$validatedData) {
            throw new ValidationException('Validation Error');
        }

        $attendance = new Attendance();
        $attendance->date = $request->date;
        $attendance->report = $request->report;
        $attendance->student_id = $request->student_id;
        $attendance->status = 1;
    
        $attendance->save();
        return $attendance;
    }
    
    public function update(Request $request, Attendance $attendance) {
        if (!Student::where('id', $request->student_id)->exists()) {
            return response()->json(["error" => "Student not found. Please, choose another one."]);
        }
        
        if($attendance->status == 0) {
            return response()->json(['error'=>'Register not found or deleted. Please, choose another one.']);
        }

        $validatedData = $request->validate([
            'date' => 'required|date',
            'report' => 'required|in:Absent,absent,Excused absence,excused absence,Present,present,Tardy,tardy,Unexcused absence,unexcused absence',
            'student_id' => 'required',
        ]);

        $attendance->date = $request->date;
        $attendance->report = $request->report;
        $attendance->student_id = $request->student_id;
        $attendance->save();

        return $attendance;
    }

    public function delete(Attendance $attendance) {
        $attendance->status = 0;
        $attendance->save();
        return $attendance;
    }

}
