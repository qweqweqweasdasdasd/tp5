<?php

//常规 路由 tp5.1 不需要use think\route 5.0 需要
//Route::get('test','api/test/index');
//Route::put('test/:id','api/test/update'); //update
//Route::delete('test/:id','api/test/delete'); //delete


//资源路由
Route::resource('test','api/test');		//post方式 save方法
