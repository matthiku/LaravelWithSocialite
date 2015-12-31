<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Controllers\Controller;

use App\Category;


class CategoryController extends Controller
{



    /**
     * Authentication
     */
    public function __construct() {
        $this->middleware('admin');
        $this->middleware('auth');
        $this->middleware('auth', ['except' => ['index', 'show']]);
        $this->middleware('admin', ['except' => ['index', 'show']]);
    }




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categories = Category::get();

        $heading = 'Categories';
        return view( 'admin.categories', array('categories' => $categories, 'heading' => $heading) );
    }





    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.category');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        //
        Category::create($request->all());
        $status = 'New category added.';
        return \Redirect::route('categories.index')
                        ->with(['status' => $status]);
    }







    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $output = Category::find($id);
        if ($output) {
            return view( 'admin.category', array('category' => $output ) );
        }
        //
        $message = 'Error! Category with id "' . $id . '" not found';
        return \Redirect::route('categories.index')
                        ->with(['status' => $message]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCategoryRequest $request, $id)
    {
        //
        // get this category
        $task = Category::where('id', $id)
                ->update($request->except(['_method','_token']));

        $message = 'Category with id "' . $id . '" updated';
        return \Redirect::route('categories.index')
                        ->with(['status' => $message]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        // find a single resource by ID
        $output = Category::find($id);
        if ($output) {
            $output->delete();
            $message = 'Category with id "' . $id . '" deleted.';
            return \Redirect::route('categories.index')
                            ->with(['status' => $message]);
        }
        //
        $message = 'Error! Category with ID "' . $id . '" not found';
        return \Redirect::route('categories.index')
                        ->with(['status' => $message]);
    }
}
