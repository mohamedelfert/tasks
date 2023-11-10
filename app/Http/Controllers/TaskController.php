<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $title = trans('main.task_list');
        $selectedCategory = $request->has('category') ? $request->get('category') : null;
        $tasks = Task::with(['category']);
        if ($selectedCategory != null) {
            $tasks = $tasks->whereCategoryId($selectedCategory);
        }
        $tasks = $tasks->latest()->paginate(9);
        $categories = Category::all();
        return view('tasks.index', compact('title', 'tasks', 'categories', 'selectedCategory'));
    }

    public function store(TaskRequest $request)
    {
        $task = new Task;
        $task->title = $request->title;
        $task->date = $request->date;
        $task->description = $request->description;
        $task->category_id = $request->category_id;
        $task->save();
        toast(__('main.data_added_successfully'), 'success');
        return redirect()->back();
    }

    public function show($id)
    {
        $title = trans('main.task_list');
        $task = Task::findOrFail($id);
        return view('tasks.show', compact('title', 'task'));
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
