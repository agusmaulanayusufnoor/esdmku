<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kantor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;


class KantorController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:kantor list', ['only' => ['index', 'show']]);
        $this->middleware('can:kantor create', ['only' => ['create', 'store']]);
        $this->middleware('can:kantor edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:kantor delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $kantors = (new Kantor)->newQuery();

        if (request()->has('search')) {
            $kantors->where('nama_kantor', 'Like', '%'.request()->input('search').'%');
        }

        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $kantors->orderBy($attribute, $sort_order);
        } else {
            $kantors->latest();
        }

        $kantors = $kantors->paginate(5)->onEachSide(2)->appends(request()->query());

        // dd($kantors);
        return Inertia::render('Master/Kantor/Index', [
            'kantors' => $kantors,
            'filters' => request()->all('search'),
            'can' => [
                'create' => Auth::user()->can('kantor create'),
                'edit' => Auth::user()->can('kantor edit'),
                'delete' => Auth::user()->can('kantor delete'),
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Master/Kantor/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Kantor::create([
            'kode_kantor' => $request->kode_kantor,
            'nama_kantor' => $request->nama_kantor,
        ]);

        return redirect()->route('kantor.index')
                        ->with('message', 'Data kantor sudah disampan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kantor $kantor)
    {
        // $roles = Kantor::all()->pluck("name","id");

        return Inertia::render('Master/Kantor/Show', [
            'kantor' => $kantor,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kantor $kantor)
    {
        return Inertia::render('Master/Kantor/Edit', [
            'kantor' => $kantor,
        ]);
    }


     /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kantor $kantor)
    {
        $kantor->update($request->all());

        return redirect()->route('kantor.index')
                        ->with('message', 'Data kantor telah diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kantor $kantor)
    {
        $kantor->delete();

        return redirect()->route('kantor.index')
                        ->with('message', __('Data kantor telah dihapus'));
    }

}
