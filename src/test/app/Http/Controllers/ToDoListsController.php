<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\ToDoList;
use App\Models\Tag;
use App\Models\Group;
use App\User;

class ToDoListsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //ユーザーがログインしているかを確認する。
        if (Auth::check()) {
            $user = Auth::user();
            $todos = $user->todolists;
            $group_id = $user->group_id;
            $group = Group::find($group_id)->name;
            return view('index', compact('todos'), compact('group'));//indexにリダイレクト
        } 
        else {
            return redirect()->route('login');//ログイン画面にリダイレクト
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all(); // データベースからグループリストを取得

        return view('create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //作成したtodolistを追加。
        $todolist = ToDoList::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'content' => $request->content,
        ]);

        //ユーザーの確認。
        $user = Auth::user();
        $todos = $user->todolists;
        $group_id = $user->group_id;
        $group = Group::find($group_id)->name;

        //タグが付いているかどうかの確認。
        $validator = Validator::make($request->all(), [
            'tag_ids' => ['required'],
        ]);

        //タグが付いているかついていないかで場合分けを行う。
        if ($validator->fails()) {
            return view('index',compact('todos'),compact('group'));
        }

        // タグがある場合、関連付ける。
        $tags = Tag::find($request->tag_ids);
        $tags->each(function ($tag) use ($todolist) {
            $todolist->tags()->attach($tag);
        });

        return view('index',compact('todos'),compact('group'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tags = Todolist::find($id)->tags;
        $todo = ToDoList::findOrFail($id);
        return view('show', compact('todo'), compact('tags'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tags = Tag::all(); // データベースからグループリストを取得
        $todo = ToDoList::findOrFail($id);
        return view('edit', compact('todo'), compact('tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $todo = ToDoList::findOrFail($id);
        $todo->tags()->sync($request->tag_ids); // タグを同期
        $todo->title = $request->title;
        $todo->content = $request->content;
        $todo->save();
        $user = Auth::user();
        $todos = $user->todolists;
        $group_id = $user->group_id;
        $group = Group::find($group_id)->name;
        return view('index',compact('todos'),compact('group'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $todo = ToDoList::findOrFail($id);
        $todo->delete();
        $user = Auth::user();
        $todos = $user->todolists;
        $group_id = $user->group_id;
        $group = Group::find($group_id)->name;
        return view('index',compact('todos'),compact('group'));
    }
}
