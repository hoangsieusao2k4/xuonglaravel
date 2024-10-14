<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    const PATH_VIEW = 'students.';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $classrooms = Classroom::all();
        $students=Student::with('passport','classroom','subjects')->latest('id')->paginate(3);
        return view(self::PATH_VIEW.__FUNCTION__,compact('students','classrooms'));
        // $studentSearch = $request->input('student_name');
        // $classroomSearch = $request->input('classroom_id');

        // Tìm kiếm và phân trang
        // $students = Student::with('classroom', 'passport', 'subjects')
        //     ->when($studentSearch, function ($query) use ($studentSearch) {
        //         return $query->where('name', 'like', '%' . $studentSearch . '%'); // Tìm kiếm theo tên học sinh
        //     })
        //     ->when($classroomSearch, function ($query) use ($classroomSearch) {
        //         return $query->where('classroom_id', $classroomSearch); // Tìm kiếm theo lớp học
        //     })
        //     ->paginate(10); // 10 sinh viên mỗi trang

        // Lấy danh sách lớp học để hiển thị trong select
        // $classrooms = Classroom::all();
        // return view('students.index', compact('students', 'classrooms'));
        //
    }
    public function search(Request $request)
    {
        $classrooms = Classroom::all();
        $studentSearch = $request->input('student_name');
        $classroomSearch = $request->input('classroom_id');

        // Tìm kiếm và phân trang
        $students = Student::with('classroom', 'passport', 'subjects')
            ->when($studentSearch, function ($query) use ($studentSearch) {
                return $query->where('name', 'like', '%' . $studentSearch . '%');
            })
            ->when($classroomSearch, function ($query) use ($classroomSearch) {
                return $query->where('classroom_id', $classroomSearch);
            })
            ->paginate(10);

        return view('students.index', compact('students','classrooms'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classrooms = Classroom::all();
        $subjects = Subject::all();
        return view(self::PATH_VIEW . __FUNCTION__, compact('classrooms', 'subjects'));

        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('students')
            ],
            'classroom_id' => 'required',
            'passport_number' => 'nullable',
            'issued_date' => 'nullable|date',
            'expiry_date' => 'nullable|date|',
            // 'subject_ids.*' => 'exists:subjects,id', // kiểm tra các subject_id
        ]);
        try {
            //code...
            $student = Student::create($data);

            if ($request->has('passport_number') && $request->has('issued_date') && $request->has('expiry_date')) {
                $student->passport()->create($request->only(['passport_number', 'issued_date', 'expiry_date']));
            }

            if ($request->has('subject_ids')) {
                $student->subjects()->attach($request->subject_ids);
            }

            return redirect()->route('students.index')->with('succes', true);
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('succes', false);
        }
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $students = Student::with('passport', 'classroom', 'subjects')->find($id);
        // dd($students->toArray());
        return view(self::PATH_VIEW . __FUNCTION__, compact('students'));
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $students = Student::with('passport', 'subjects')->find($id);
        $classrooms = Classroom::all();
        $subjects = Subject::all();
        return view(self::PATH_VIEW . __FUNCTION__, compact('students', 'classrooms', 'subjects'));

        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student = Student::find($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('students')->ignore($student->id)
            ],
            'classroom_id' => 'required',
            'passport_number' => 'nullable',
            'issued_date' => 'nullable|date',
            'expiry_date' => 'nullable|date|',
            // 'subject_ids.*' => 'exists:subjects,id', // kiểm tra các subject_id
        ]);
        try {
            //code...
            $student = Student::find($id);
            $student->update($request->only(['name', 'email', 'classroom_id']));

            if ($request->has('passport_number') && $request->has('issued_date') && $request->has('expiry_date')) {
                $student->passport()->update($request->only(['passport_number', 'issued_date', 'expiry_date']));
            }

            $student->subjects()->sync($request->subject_ids);

            return back()->with('succes', true);
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('succes', false);
        }
    }
    //


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        try {

            $student = Student::findOrFail($id);

            // Xóa các mối quan hệ trong bảng trung gian student_subject
            $student->subjects()->detach();

            // Xóa hộ chiếu nếu có
            if ($student->passport) {
                $student->passport->delete();
            }

            // Xóa sinh viên
            $student->delete();

            return redirect()->route('students.index')->with('success', true);
        } catch (\Throwable $th) {
            return redirect()->route('students.index')->with('success', false);
        }



        //
    }
}
