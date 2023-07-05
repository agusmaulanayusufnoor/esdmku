<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Status_pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class Status_pegawaiController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:statuspegawai list', ['only' => ['index', 'show']]);
        $this->middleware('can:statuspegawai create', ['only' => ['create', 'store']]);
        $this->middleware('can:statuspegawai edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:statuspegawai delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $statuspegawais = (new Status_pegawai)->newQuery();

        if (request()->has('search')) {
            $statuspegawais->where('statuspegawai', 'Like', '%'.request()->input('search').'%');
        }

        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $statuspegawais->orderBy($attribute, $sort_order);
        } else {
            $statuspegawais->latest();
        }

        $statuspegawais = $statuspegawais->paginate(5)->onEachSide(2)->appends(request()->query());

        // dd($statuspegawais);
        return Inertia::render('Master/Statuspegawai/Index', [
            'statuspegawais' => $statuspegawais,
            'filters' => request()->all('search'),
            'can' => [
                'create' => Auth::user()->can('statuspegawai create'),
                'edit' => Auth::user()->can('statuspegawai edit'),
                'delete' => Auth::user()->can('statuspegawai delete'),
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Master/Statuspegawai/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Status_pegawai::create([
            'statuspegawai' => $request->statuspegawai,
        ]);

        return redirect()->route('statuspegawai.index')
                        ->with('message', 'Data status pegawai sudah disampan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Status_pegawai $statuspegawai)
    {
        return Inertia::render('Master/Statuspegawai/Show', [
            'statuspegawai' => $statuspegawai,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Status_pegawai $statuspegawai)
    {
        return Inertia::render('Master/Statuspegawai/Edit', [
            'statuspegawai' => $statuspegawai,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Status_pegawai $statuspegawai)
    {
        $statuspegawai->update($request->all());

        return redirect()->route('statuspegawai.index')
                        ->with('message', 'Data status pegawai sudah diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Status_pegawai $statuspegawai)
    {
        $statuspegawai->delete();

        return redirect()->route('statuspegawai.index')
                        ->with('message', __('Data status pegawai sudah dihapus'));
    }
}
