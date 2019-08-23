<?php

namespace Laravolt\Indonesia\Http\Controllers;

use Illuminate\Routing\Controller;
use Laravolt\Indonesia\Http\Requests\Kabupaten\Store;
use Laravolt\Indonesia\Http\Requests\Kabupaten\Update;
use Laravolt\Indonesia\Models\Kabupaten;
use Laravolt\Indonesia\Tables\KabupatenTable;
use Laravolt\Suitable\Builder;
use Laravolt\Suitable\Toolbars\Action;

class KabupatenController extends Controller
{
    public function index()
    {
        $data = Kabupaten::autoSort()->autoFilter()->search(request('search'))->paginate();

        return (new KabupatenTable($data))
            ->decorate(function(Builder $table){
                $table->getDefaultSegment()
                    ->addLeft(
                        Action::make('plus', 'Tambah', route('indonesia::kabupaten.create'))
                            ->addClass('primary')
                    );
            })
            ->title(__('Kabupaten'))
            ->view('indonesia::kabupaten.index');
    }

    public function create()
    {
        return view('indonesia::kabupaten.create');
    }

    public function store(Store $request)
    {
        Kabupaten::create($request->validated());

        return redirect()->route('indonesia::kabupaten.index')->withSuccess('Kabupaten saved');
    }

    public function edit(Kabupaten $kabupaten)
    {
        return view('indonesia::kabupaten.edit', compact('kabupaten'));
    }

    public function update(Update $request, Kabupaten $kabupaten)
    {
        $kabupaten->update($request->validated());

        return redirect()->back()->withSuccess('Kabupaten saved');
    }

    public function destroy(Kabupaten $kabupaten)
    {
        $kabupaten->delete();

        return redirect()->route('indonesia::kabupaten.index')->withSuccess('Kabupaten deleted');
    }
}