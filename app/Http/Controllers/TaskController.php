<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $title = trans('main.task_list');
        $tasks = Task::latest()->paginate(10);
        return view('welcome', compact('title', 'tasks'));
    }

    public function store(TaskRequest $request)
    {
        $task = new Task;
        $task->title = $request->title;
        $task->date = $request->date;
        $task->description = $request->description;

        $task->save();

        toast(__('main.data_added_successfully'), 'success');
        return redirect()->back();
    }

    public function show($id)
    {
        $title = trans('main.task_list');
        $task = Task::findOrFail($id);
        return view('show', compact('title', 'task'));
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        toast(__('main.data_deleted_successfully'), 'error');
        return redirect()->back();
    }

    public function finish($id)
    {
        $task = Task::findOrFail($id);
        $task->update(['finished' => 1]);
        toast(__('main.data_finished_successfully'), 'warning');
        return redirect()->back();
    }
}
