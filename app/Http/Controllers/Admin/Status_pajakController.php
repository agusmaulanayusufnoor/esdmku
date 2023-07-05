<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Status_pajak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class Status_pajakController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:statuspajak list', ['only' => ['index', 'show']]);
        $this->middleware('can:statuspajak create', ['only' => ['create', 'store']]);
        $this->middleware('can:statuspajak edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:statuspajak delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $statuspajaks = (new Status_pajak)->newQuery();

        if (request()->has('search')) {
            $statuspajaks->where('statuspajak', 'Like', '%'.request()->input('search').'%');
        }

        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $statuspajaks->orderBy($attribute, $sort_order);
        } else {
            $statuspajaks->latest();
        }

        $statuspajaks = $statuspajaks->paginate(5)->onEachSide(2)->appends(request()->query());

        // dd($statuspajaks);
        return Inertia::render('Master/Statuspajak/Index', [
            'statuspajaks' => $statuspajaks,
            'filters' => request()->all('search'),
            'can' => [
                'create' => Auth::user()->can('statuspajak create'),
                'edit' => Auth::user()->can('statuspajak edit'),
                'delete' => Auth::user()->can('statuspajak delete'),
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Master/Statuspajak/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Status_pajak::create([
            'statuspajak' => $request->statuspajak,
        ]);

        return redirect()->route('statuspajak.index')
                        ->with('message', 'Data status pajak sudah disampan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Status_pajak $statuspajak)
    {
        return Inertia::render('Master/Statuspajak/Show', [
            'statuspajak' => $statuspajak,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Status_pajak $statuspajak)
    {
        return Inertia::render('Master/Statuspajak/Edit', [
            'statuspajak' => $statuspajak,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Status_pajak $statuspajak)
    {
        $statuspajak->update($request->all());

        return redirect()->route('statuspajak.index')
                        ->with('message', 'Data status pajak sudah diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Status_pajak $statuspajak)
    {
        $statuspajak->delete();

        return redirect()->route('statuspajak.index')
                        ->with('message', __('Data status pajak sudah dihapus'));
    }
}
