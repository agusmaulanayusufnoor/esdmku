<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendidikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PendidikanController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:pendidikan list', ['only' => ['index', 'show']]);
        $this->middleware('can:pendidikan create', ['only' => ['create', 'store']]);
        $this->middleware('can:pendidikan edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:pendidikan delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $pendidikans = (new Pendidikan)->newQuery();

        if (request()->has('search')) {
            $pendidikans->where('nama_pendidikan', 'Like', '%'.request()->input('search').'%');
        }

        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $pendidikans->orderBy($attribute, $sort_order);
        } else {
            $pendidikans->latest();
        }

        $pendidikans = $pendidikans->paginate(5)->onEachSide(2)->appends(request()->query());

        // dd($pendidikans);
        return Inertia::render('Master/Pendidikan/Index', [
            'pendidikans' => $pendidikans,
            'filters' => request()->all('search'),
            'can' => [
                'create' => Auth::user()->can('pendidikan create'),
                'edit' => Auth::user()->can('pendidikan edit'),
                'delete' => Auth::user()->can('pendidikan delete'),
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Master/Pendidikan/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Pendidikan::create([
            'nama_pendidikan' => $request->nama_pendidikan,
        ]);

        return redirect()->route('pendidikan.index')
                        ->with('message', 'Data pendidikan sudah disampan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pendidikan $pendidikan)
    {
        return Inertia::render('Master/Pendidikan/Show', [
            'pendidikan' => $pendidikan,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pendidikan $pendidikan)
    {
        return Inertia::render('Master/Pendidikan/Edit', [
            'pendidikan' => $pendidikan,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pendidikan $pendidikan)
    {
        $pendidikan->update($request->all());

        return redirect()->route('pendidikan.index')
                        ->with('message', 'Data pendidikan sudah diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pendidikan $pendidikan)
    {
        $pendidikan->delete();

        return redirect()->route('pendidikan.index')
                        ->with('message', __('Data pendidikan sudah dihapus'));
    }
}
