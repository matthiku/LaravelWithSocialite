<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Task;
use App\Category;


class TaskController extends Controller
{



    /**
     * Authentication
     */
    public function __construct() {
        $this->middleware('auth');
    }




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id = Null)
    {

        $user = Auth::user();

        // If the user is not an Admin, only show his own tasks
        if ($user->is_admin) {
            if ($request->is('*/user/*')) {
                $tasks = Task::where('user_id', $id)->get();
            } elseif ($request->is('*/category/*')) {
                $tasks = Task::where('category_id', $id)->get();
            } else {
                $tasks = Task::get();
            }
            // also retrieve the trashed tasks
            $trashed = Task::onlyTrashed()->get();
        }
        else {
            $tasks = Task::where('user_id', $user->id)->get();
            // also retrieve the trashed tasks
            $trashed = Task::onlyTrashed()->get();
        }

        $heading = 'My Tasks';
        //
        return view( 'tasks', array('tasks' => $tasks, 'heading' => $heading, 'trashed' => $trashed) );
    }






    /**
     * Show the FORM for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // get list of categories
        $cats = $this->getCategories();
        if ($cats) {
            // show the form to add a task
            return view('create', [ 'categories' => $cats ]);
        }
        // 
        $message = 'No categories found, unable to add a task! First add a category...';
        return \Redirect::route('categories.create')
                        ->withErrors(['error' => $message]);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskRequest $request)
    {

        // using the eloquent model relationship
        //
        // create a new task with the data from the form
        $task = new Task($request->all());
        // save it as a 'child' of the user->task relationship, or:
        // get the authenticated user's articles and add a new one to that list!
        $newTask = Auth::user()->tasks()->save($task);

        $message = 'Task added with id ' . $newTask->id;
        //        return redirect()->route('tasks', [ 'message' => $message ]);
        return \Redirect::route('tasks.index')
                        ->with(['status' => $message]);
    }







    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // find a single resource by ID
        $output = Task::find($id);
        if ($output) {
            // If the user is not an Admin, only show his own tasks
            if (!Auth::user()->is_admin && Auth::user()->id<>$output->user_id ) {
                $message = 'Error! Unable to view task with id "'.$id.'"';
                return \Redirect::route('tasks.index')->with(['status' => $message]);
            }
            return view( 'show', array('task' => $output ));
        }
        //
        $message = 'Task with id "' . $id . '" not found';
        return \Redirect::route('tasks.index')
                        ->withErrors(['error' => $message]);
    }




    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // find a single resource by ID
        $output = Task::find($id);
        if ($output) {
            // If the user is not an Admin, only show his own tasks
            if (!Auth::user()->is_admin && Auth::user()->id<>$output->user_id ) {
                $message = 'Error! Unable to edit task with id "'.$id.'"';
                return \Redirect::route('tasks.index')->with(['status' => $message]);
            }
            return view( 'create', array('task' => $output, 'categories' => $this->getCategories() ));
        }
        //
        $message = 'Task with id "' . $id . '" not found';
        return \Redirect::route('tasks.index')
                        ->withErrors(['status' => $message]);
    }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTaskRequest $request, $id)
    {
        $output = Task::find($id);
        // If the user is not an Admin, only show his own tasks
        if (!Auth::user()->is_admin && Auth::user()->id<>$output->user_id ) {
            $message = 'Error! Unable to edit task with id "'.$id.'"';
            return \Redirect::route('tasks.index')->with(['status' => $message]);
        }
        // get this task
        $task = Task::where('id', $id)
                ->update($request->except(['_method','_token']));

        $message = 'Task with id "' . $id . '" updated';
        return \Redirect::route('tasks.index')
                        ->with(['status' => $message]);
    }






    /**
     * Remove the specified resource from storage (Soft Delete!).
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // find a single resource by ID
        $output = Task::find($id);
        if ($output) {
            // model uses soft deletes...
            $task = Task::find( $id );
            $task->delete();
            $message = 'Task with id "' . $id . '" marked as "done".';
            return \Redirect::route('tasks.index')
                            ->with(['status' => $message]);
        }
        //
        $message = 'Task with ID "' . $id . '" not found';
        return \Redirect::route('tasks.index')
                        ->withErrors(['status' => $message]);
    }



    /**
     * Recover a soft-deleted resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        // find a single resource by ID
        $output = Task::withTrashed()->where('id', $id);
        if ($output) {
            // model uses soft deletes...
            Task::withTrashed()
                ->where('id', $id)
                ->restore();
            $status = 'Task with id "' . $id . '" has been restored';
            return \Redirect::route('tasks.index')
                            ->with(['status' => $status]);
        }
        //
        $message = 'Task with ID "' . $id . '" not found';
        return \Redirect::route('tasks.index')
                        ->withErrors(['status' => $message]);
    }


    /**
     * Permanently delete a resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function forceDelete($id)
    {
        // find a single resource by ID
        $output = Task::withTrashed()->where('id', $id);
        if ($output) {
            // model uses soft deletes...
            Task::withTrashed()
                ->where('id', $id)
                ->forceDelete();
            $status = 'Task with id "' . $id . '" has been permanently deleted.';
            return \Redirect::route('tasks.index')
                            ->with(['status' => $status]);
        }
        //
        $message = 'Task with ID "' . $id . '" not found';
        return \Redirect::route('tasks.index')
                        ->withErrors(['status' => $message]);
    }



    private function getCategories() {
        // get list (array) of categories
        $cats = Category::get();
        $categories = [];
        foreach ($cats as $cat) {
            $categories[$cat->id] = $cat->name;
        }
        return $categories;
    }

}
