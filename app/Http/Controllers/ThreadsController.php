<?php

namespace App\Http\Controllers;

use App\Filters\ThreadsFilter;
use App\Http\Requests\ThreadStoreRequest;
use App\Models\Category;
use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThreadsController extends Controller
{

    public function index(Category $category, ThreadsFilter $filters)
    {
        $threads = $this->getThreads($filters, $category);

        return view('threads.index', compact('threads'));
    }

    public function getThreads(ThreadsFilter $filters, Category $category)
    {
        $threads = Thread::latest()->filter($filters);

        if ($category->exists) {
            $threads->where('category_id', $category->id);
        }

        return $threads->simplePaginate(10)->withQueryString();
    }

    public function create()
    {
        return view('threads.create');
    }

    public function store(ThreadStoreRequest $request)
    {
        $thread = Auth::user()->threads()->create(
            $request->validated(),
        );

        return redirect($thread->path())->with('success', 'Thread has been created.');
    }

    public function show($categoryId, Thread $thread)
    {
        return view('threads.show', [
            'thread' => $thread,
            'replies' => $thread->replies()->paginate(5),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    public function destroy(Thread $thread)
    {
        $this->authorize('update', $thread);

        $thread->delete();

        if (request()->wantsJson()) {
            return response(204, []);
        }

        return redirect('/threads');
    }
}
