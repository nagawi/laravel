<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Task;
use Illuminate\Http\Request;
Route::get('hello','HelloController@index');
//Route::get('hello','HelloController@index');
// Route::get('hello','HelloController@index');
// Route::get('hello/other','HelloController@other');
// Route::get('hello/{msg?}/{msg2?}',function ($msg='nothing',$msg2='メッセージは有りません') {
//   $html = <<<EOF
//   <html>
//   <head>
//   <title>Hello</title>
//   <style>
//   body {font-size:16pt; color:#999;}
//   h1 { font-size:100pt; text-align:right; color:#eee; margin:-40px 0px -50px 0px; }
//   </style>
//   </head>
//   <body>
//     <h1>Hello</h1>
//     <p>{$msg}{$msg2}</p>
//     <p>これは、サンプルで作ったページです。</p>
//   </body>
//   </html>
// EOF;
//   return $html;
// });

Route::get('/', function () {
    $tasks = Task::orderBy('created_at','asc')->get();
    return view('tasks',[
	'tasks' => $tasks
    ]);
});

Route::post('/task',function(Request $request) {
    $validator = Validator::make($request->all(),[
	'name' => 'required|max:255',
    ]);

    if($validator->fails()){
	return redirect('/')
	    ->withInput()
	    ->withErrors($validator);
    }

    $task = new Task;
    $task->name = $request->name;
    $task->save();

    return redirect('/');

});

Route::delete('/task/{task}',function(Task $task) {
    $task->delete();
    return redirect('/');
});
