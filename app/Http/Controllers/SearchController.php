<?php

namespace App\Http\Controllers;

use App\Entry;
use App\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    /**
     * SearchController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $search = request('q');

        $journalsAndEntries = DB::table('journals')->select(
            'id as journal_id',
            'name as journal_name',
            'description as journal_description',
            'created_at as journal_created_at',
            'updated_at as journal_updated_at',
            'user_id')
            ->addSelect(DB::raw("'' as entry_id"))
            ->addSelect(DB::raw("'' as entry_body"))
            ->addSelect(DB::raw("'' as entry_created_at"))
            ->addSelect(DB::raw("'' as entry_updated_at"))
            ->from('journals')
            ->where('user_id', '=', auth()->id())
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            })
            ->union(DB::table('entries')->select(
                'journals.id as journal_id',
                'journals.name as journal_name',
                'journals.description as journal_description',
                'journals.created_at as journal_created_at',
                'journals.updated_at as journal_updated_at',
                'journals.user_id',
                'entries.id as entry_id',
                'entries.body as entry_body',
                'entries.created_at as entry_created_at',
                'entries.updated_at as entry_updated_at'
            )->from('entries')->join('journals', function($join) {
                $join->on('entries.journal_id', '=', 'journals.id');
            })->where('body', 'LIKE', "%{$search}%")
                ->where('journals.user_id', '=', auth()->id())
                )->get();

        $results = paginate($journalsAndEntries, 25);

        if (request()->expectsJson()) {
            return $results;
        }

        return view('search-results', compact('results'));
    }
}
