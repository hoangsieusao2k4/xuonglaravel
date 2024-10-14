<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    public function index()
    {
        $task = Task::query()->latest('id')->paginate(2);
        // dd($task);
        return response()->json($task);
    }

    public function store(Request $request)
    {

        $data = $request->validate([
            'task_name' => 'required|max:255',
            'description' => 'nullable|max:255',
            'status' => 'required',
            'project_id'=>'required',

        ]);
        try {

            $task = Task::query()->create($data);
            return response()->json([
                'data' => $task,
                'status' => true,
                'message' => 'Thêm dữ liệu thành công',
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([

                'status' => false,
                'message' => 'Lỗi hệ thống',
            ]);
        }
    }

    public function show( string $id)
    {
        $data = Task::find($id);
        return response()->json([
            'data' => $data,
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',

        ]);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'task_name' => 'required|max:255',
            'description' => 'nullable|max:255',
            'status' => 'required',
            'project_id'=>'required',
        ]);
        $task=Task::find($id);
        if(!$task){
            return response()->json([
                'status' => false,
                'message' => 'Không có dữ liệu với ID='.$id,

            ], 500);

        }
        try {

            //code...


            $task ->update($data);
            return response()->json([
                'status' => true,
                'message' => 'Sửa liệu thành công!',
                'data' => $task
            ],201);
        } catch (\Throwable $th) {
            // dd($th->getMessage());
            Log::error(
                __CLASS__ . '@' . __FUNCTION__,
                [
                    'error' => [$th->getMessage()]
                ]
            );
            return response()->json([
                'status' => false,
                'message' => 'Lỗi hệ thống',

            ], 500);

            //throw $th;
        }
    }

    public function destroy(string $id)
    {
        $task=Task::find($id);
        try {
            $task->delete();
            return response()->json([
                'status' => true,
                'message' => 'Xóa thành công',
                'data' => $task
            ],201);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => false,
                'message' => 'Lỗi hệ thống',
            ], 500);
        }
    }
}
