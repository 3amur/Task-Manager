<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Tasks = Task::all();
        return $this->sendResponse(TaskResource::collection($Tasks), 'All Tasks Retrieved Successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
            'status' => 'in:pending,in-progress,completed',
            'user_id' => 'required|exists:users,id',
        ]);
        
        if($validator->fails()){
            return $this->sendError('Validaton Error', $validator->errors());
        }
        $Task = Task::create($data);
        return $this->sendResponse(new TaskResource($Task), 'Task Created Successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
            'status' => 'required|in:pending,in-progress,completed',
            'user_id' => 'required|exists:users,id',
        ]);
        
        if($validator->fails()){
            return $this->sendError('Validaton Error', $validator->errors());
        }
        $task->title = $data['title'];
        $task->status = $data['status'];
        $task->user_id = $data['user_id'];
        $task->save();
        return $this->sendResponse(new TaskResource($task), 'Task Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return $this->sendError('Task not found', 404);
        }
        $task->delete();
        return $this->sendResponse([], 'Task Deleted Successfully');
    }
}
