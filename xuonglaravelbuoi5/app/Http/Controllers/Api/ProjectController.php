<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Project::query()->latest('id')->paginate(2);
        return response()->json([
            'data' => $data,
            'status' => true,
            'message' => 'lấy dữ liệu thành công',
        ]);
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'project_name' => 'required|max:255',
            'description' => 'nullable|max:255',
            'start_date' => 'required',

        ]);
        try {

            $project = Project::query()->create($data);
            return response()->json([
                'data' => $project,
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

        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Project::find($id);
        return response()->json([
            'data' => $data,
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',

        ]);
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $data = $request->validate([
            'project_name' => 'required|max:255',
            'description' => 'nullable|max:255',
            'start_date' => 'required',

        ]);
        $project=Project::find($id);
        if(!$project){
            return response()->json([
                'status' => false,
                'message' => 'Không có dữ liệu với ID='.$id,

            ], 500);

        }
        try {

            //code...


            $project ->update($data);
            return response()->json([
                'status' => true,
                'message' => 'Sửaliệu thành công!',
                'data' => $project
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project=Project::find($id);
        try {
            $project->delete();
            return response()->json([
                'status' => true,
                'message' => 'Xóa thành công',
                'data' => $project
            ],201);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => false,
                'message' => 'Lỗi hệ thống',

            ], 500);
        }
        //
    }
}
