<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class JabatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:jabatan list', ['only' => ['index', 'show']]);
        $this->middleware('can:jabatan create', ['only' => ['create', 'store']]);
        $this->middleware('can:jabatan edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:jabatan delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $jabatans = (new Jabatan)->newQuery();

        if (request()->has('search')) {
            $jabatans->where('nama_jabatan', 'Like', '%'.request()->input('search').'%');
        }

        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $jabatans->orderBy($attribute, $sort_order);
        } else {
            $jabatans->latest();
        }

        $jabatans = $jabatans->paginate(5)->onEachSide(2)->appends(request()->query());

        // dd($jabatans);
        return Inertia::render('Master/Jabatan/Index', [
            'jabatans' => $jabatans,
            'filters' => request()->all('search'),
            'can' => [
                'create' => Auth::user()->can('jabatan create'),
                'edit' => Auth::user()->can('jabatan edit'),
                'delete' => Auth::user()->can('jabatan delete'),
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Master/Jabatan/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Jabatan::create([
            'nama_jabatan' => $request->nama_jabatan,
        ]);

        return redirect()->route('jabatan.index')
                        ->with('message', 'Data jabatan sudah disampan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Jabatan $jabatan)
    {
        return Inertia::render('Master/Jabatan/Show', [
            'jabatan' => $jabatan,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jabatan $jabatan)
    {
        return Inertia::render('Master/Jabatan/Edit', [
            'jabatan' => $jabatan,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jabatan $jabatan)
    {
        $jabatan->update($request->all());

        return redirect()->route('jabatan.index')
                        ->with('message', 'Data jabatan sudah diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jabatan $jabatan)
    {
        $jabatan->delete();

        return redirect()->route('jabatan.index')
                        ->with('message', __('Data jabatan sudah dihapus'));
    }
}
