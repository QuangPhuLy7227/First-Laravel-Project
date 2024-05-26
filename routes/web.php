<?php

use App\Models\Job;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('home');
});

//Job Index
Route::get('/jobs', function () {
    $job = Job::with('employer')->latest()->simplePaginate(3);
    return view('jobs.index', [
        'jobs' => $job
    ]);
});

//Job Create
Route::get('/jobs/create', function () {
    return view('jobs.create');
});

//Job Show
Route::get('/jobs/{id}', function ($id) {

    $job = Job::find( $id );
    return view('jobs.show', ['job' => $job]);
});

//Job Store
Route::post('/jobs', function () {
    //validation
    request()->validate([
        'title' => ['required', 'min:3'],
        'salary'=> ['required'],
    ]);

    Job::create( [
        'title'=> request('title'),
        'salary'=> request('salary'),
        'employer_id'=> 1
    ]);

    return redirect('/jobs');
});

//Job Edit
Route::get('/jobs/{id}/edit', function ($id) {
    return view('jobs.edit', [
        'job'=> Job::find($id),
    ]);
});

//Job Update
Route::patch('/jobs/{id}', function ($id) {
    //validate
    request()->validate([
        'title' => ['required', 'min:3'],
        'salary'=> ['required'],
    ]);
    //authorize
    //update the job
    $job = Job::findOrFail( $id );
    // $job->title = request('title');
    // $job->salary = request('salary');
    // $job->save();

    $job->update([
        'title'=> request('title'),
        'salary'=> request('salary'),
    ]);
    //redirect to the job page
    return redirect('/jobs/' . $job->id);
});

//Job Destroy
Route::delete('/jobs/{id}', function ($id) {
    //authorize
    //delete the job
    Job::findOrFail( $id )->delete();
    //redirect
    return redirect('/jobs');
});

Route::get('/contact', function () {
    return view('contact');
});
