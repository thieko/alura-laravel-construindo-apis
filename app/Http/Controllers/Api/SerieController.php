<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\SeriesFormRequest;
use App\Jobs\DeleteSeriesCover;
use App\Models\Serie;
use Illuminate\Http\Request;

class SerieController extends Controller
{
    public function index()
    {
        return Serie::all(); 
    }
    public function store(Request $request)
    {
        return response()
            ->json(Serie::create($request->all()), 201);
    }
    public function show(Serie $series)
    {
        return $series;
    }
    public function update(Serie $series, Request $request)
    {
        $series->fill($request->all());
        $series->save();

        return $series;
    }
    public function destroy(int $series)
    {
        Serie::destroy($series);
        return response()->noContent();
    }
}
