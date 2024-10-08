<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    const PATH_VIEW = 'employees.';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Employee::query()->latest('id')->paginate(3);
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));

        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()

    {
        $manager = Manager::all();
        $department = Department::all();
        //
        return view(self::PATH_VIEW . __FUNCTION__, compact('manager','department'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|string|email|max:150|unique:employees',
            'phone' => 'required|string|max:100',
            'date_of_birth' => 'required|date',
            'hire_date' => 'required|date',
            'salary' => 'required|numeric',
            'is_active' => [

                Rule::in(0, 1)
            ],
            'address' => 'required|max:255',
            'profile_picture' => 'image|nullable', // Chấp nhận file ảnh
        ]);
        try {
            $data = $request->except('profile_picture');
            if ($request->hasFile('profile_picture')) {
                $data['profile_picture'] = $request->file('profile_picture')->store('empolyees', 'public');
            }
            Employee::query()->create($data);
            return redirect()->route('employees.index')->with('success', true);
            //code...
        } catch (\Throwable $th) {
            //  throw $th;
            // Log::error('Error creating product: ' . $th->getMessage(), [
            //     'file' => $th->getFile(),
            //     'line' => $th->getLine(),
            //     'trace' => $th->getTraceAsString(),
            // ]);
            // return back()->with('error', 'Có lỗi xảy ra: ' . $th->getMessage());
            return back()->with('success', false);

            //throw $th;
        }
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return view(self::PATH_VIEW . __FUNCTION__);

        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $manager = Manager::all();
        $department = Department::all();
        //
        return view(self::PATH_VIEW . __FUNCTION__, compact('manager','department','employee'));

        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                Rule::unique('employees')->ignore($employee->id)
            ],
            'phone' => 'required|string|max:100',
            'date_of_birth' => 'required|date',
            'hire_date' => 'required|date',
            'salary' => 'required|numeric',
            'is_active' => [

                Rule::in(0, 1)
            ],
            'address' => 'required|max:255',
            'profile_picture' => 'image|nullable', // Chấp nhận file ảnh
        ]);
        try {
            $data = $request->except('profile_picture');
            $currentImage=$employee->profile_picture;
            $data['is_active']??=0;
            if ($request->hasFile('profile_picture')) {
                $data['profile_picture'] = $request->file('profile_picture')->store('empolyees', 'public');
            }
            $employee->update($data);
            if($request->hasFile('profile_picture')&& Storage::exists($currentImage)){
                Storage::delete($currentImage);

            }
            return back()->with('success', true);
            //code...
        } catch (\Throwable $th) {
             throw $th;
            Log::error('Error creating product: ' . $th->getMessage(), [
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);
            return back()->with('error', 'Có lỗi xảy ra: ' . $th->getMessage());
            // return back()->with('success', false);

            //throw $th;
        }
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
