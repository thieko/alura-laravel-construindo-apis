<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\SeriesFormRequest;
use App\Jobs\DeleteSeriesCover;
use App\Models\Serie;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;

class SerieController extends Controller
{
    public function index(Request $request)
    {
        $query = Serie::query();
        if(!$request->has('nome')){
            $query->where('nome', $request->nome);
        }
        return $query->paginate(1);
    }
    public function store(Request $request)
    {
        return response()
            ->json(Serie::create($request->all()), 201);
    }
    public function show(int $series)
    {
        $seriesModel = Serie::find($series);
        
        if($seriesModel=== null){
            return response()
            ->json(['message'=>'Series not found'],404);
        }

        return $seriesModel;
    }
    public function update(Serie $series, Request $request)
    {
        $series->fill($request->all());
        $series->save();

        return $series;
    }
    public function destroy(int $series,Authenticatable $user)
    {
        if (!$user->tokenCan('is_admin')) {
            Serie::destroy($series);
        }
        return response()->noContent();
    }
}
