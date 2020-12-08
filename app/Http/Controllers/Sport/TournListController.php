<?php

namespace App\Http\Controllers\Sport;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Sport\Leagues;
use App\Sport\TournList;
use Auth;
use Log;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Images\ImageController;
use Gate;

class TournListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('TOURNLIST')) {
            return abort(403);
        }

        return view('home.tournlist', ['tournlist' => $this->tournList(), 'leagues' => Leagues::all() ]);
    }

    public function tournList() {
        if (Gate::denies('TOURNLIST')) {
            return abort(403);
        }

        return TournList::with(['league','logo' => function($query) {
            $query->with(['thumb' => function($query) {
                $query->select('filename','image_id');
            }]);
        }])->orderBy('name')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function delete($id)
    {
        if (!Auth::user()->isAdmin()) abort(403);

        $tourn = TournList::findOrFail($id);
        $tourn->delete();

        return redirect()->route('tournlist');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::denies('TOURNLIST')) {
            return abort(403);
        }

        Log::info('Сохранение нового турнира от пользователя - '.Auth::user()->name);

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:pgsql.sport.tb_tournlist|max:50',
            'url' => 'required|unique:pgsql.sport.tb_tournlist|max:50',
            'league' => 'required',
        ]);

        if ($validator->fails()) {
            $txt = '';
            foreach ($validator->errors()->all() as $message) {
                $txt .= $message;
            }
            Log::error('Ошибка проверки: '. $request);
            return ['status' => 'fail', 'text' => $txt ];
        }

        // Сохраняю
        $tourn = new TournList;
        $tourn->name = $request->name;
        $tourn->url = $request->url;
        $tourn->league_id = $request->league;
        $tourn->desc = $request->desc;
        $tourn->save();

        // Сохраняю логотип
        if($request->has('file')) {
            Log::info('Добавлен логотип соревнования');
            $ret = ImageController::saveImage($tourn->id, 2, $request->url, $request);
            if(!$ret) {
                Log::error('Ошибка записи изображения');
                return ['status' => 'fail', 'text' => 'Турнир сохранён, но логотип не был загружен.' ];
            } else {
                $tourn->image_id = $ret;
                $tourn->save();
            }
        }

        return ['status' => 'success', 'data' => $tourn ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
