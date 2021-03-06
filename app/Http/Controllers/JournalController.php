<?php

namespace App\Http\Controllers;

use App\Journal;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class JournalController extends Controller
{
    /**
     * JournalController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('owner')->except(['index', 'create', 'store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $journals = Journal::journalsForUserID(auth()->id());

        return view('journals.index', compact('journals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('journals.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $journal = Journal::create([
            'user_id' => auth()->id(),
            'name' => request('name'),
            'description' => request('description')
        ]);

        return redirect($journal->path())->with('flash', 'Your journal has been created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function show(Journal $journal)
    {
        $entries = $this->paginate($journal->entries->sortByDesc('created_at'), 20);
        $entries->withPath($journal->path());

        if (request()->expectsJson()) {
            return compact('journal', 'entries');
        }

        return view('journals.show', compact('journal', 'entries'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function edit(Journal $journal)
    {
        return view('journals.edit', compact('journal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Journal $journal)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $journal->update(request(['name', 'description']));

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return redirect($journal->path())->with('flash', 'Journal name was updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Journal $journal)
    {
        $journal->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return redirect('/journals')->with('flash', '"' . $journal->name . '" was deleted.');
    }

    /**
     * Generates pagination of items in an array or collection.
     * https://gist.github.com/vluzrmos/3ce756322702331fdf2bf414fea27bcb
     *
     * @param array|Collection      $items
     * @param int   $perPage
     * @param int  $page
     * @param array $options
     *
     * @return LengthAwarePaginator
     */
    protected function paginate(Collection $items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
