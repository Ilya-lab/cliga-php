<?php

namespace App\Http\Controllers\Sport;

use App\Http\Controllers\Images\ImageController;
use App\News;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Sport\Person;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Classif\Country;
use Gate;
use Illuminate\Support\Facades\Validator;
use Log;

class PersonController extends Controller
{
    public function adminIndex() {
        if (Gate::denies('PERSONS')) {
            return abort(403);
        }
        return view('home.person.index', [ 'countries' => Country::all()]);
    }

    public function persons() {
        return view('home.person.index', [ 'countries' => Country::all() ]);
    }

    /**
     * Вернуть параметры участника
     * @param $id - идентификатор
     * @return
     */
    public function adminShow($id) {
        // проверка на права доступа
        if (Gate::denies('PERSONS')) {
            Log::error("Нет доступа для просмотра участника. User - ".Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нет доступа'));
        }

        try {
            $person = Person::with(['country', 'sex', 'photo', 'photos' => function($query) {
                $query->with('thumb')->get();
            } ])->find($id);
        } catch (Exception $exception) {
            Log::error("Участник не найден. PERSON - ".$id);
            return json_encode(array('status' => 'fail', 'text' => 'Участник не найден'));
        }

        return array('status' => 'OK', 'text' => 'Участник загружен!' , 'id' => $id, 'person' => $person);
    }

    /* загрузить игроков для AJAX */
    public function load()
    {
        if (Gate::denies('PERSONS')) {
            return abort(403);
        }

        if (Input::has('person')) {
            $start = Input::get('person');

            if (strlen($start) >= 2) {
                return Person::select('id', 'family', 'name', 'surname', 'fio','birthdate', 'sex_id', 'country_id','email','phone','active')

                    /*->with(['photos' => function($query) {
                        $query->where('p_type', 1)->where('p_deleted',0)->orderBy('id');
                    }])*/->with('country')->startWith($start)->orderBy('fio')->get();
            }
        }

        return Person::select('id', 'family', 'name', 'surname', 'fio','birthdate', 'sex_id', 'country_id','email','phone','active')
                        ->with('country')->orderBy('fio')->get();
    }

    public function bidLoad()
    {
        if (Input::has('person')) {
            $start = Input::get('person');

            if (strlen($start) >= 2) {
                return Person::select('id', 'family', 'name', 'surname', 'fio','birthdate', 'sex_id')
                    ->with(['photos' => function($query) {
                        $query->/*select('id','type_id')->*/with('thumb')->get();
                    }])->startWith($start)->orderBy('fio')->get();
            }
        }
        return collect();
    }

    /* сохранить игрока */
    public function save(Request $request, bool $insert = true) {
        // проверка на права доступа
        if (Gate::denies('PERSONS')) {
            return json_encode(array('status' => 'fail', 'text' => 'Нет доступа'));
        }

        if(!$insert && !$request->has("id")) {
            return json_encode(array('status' => 'fail', 'text' => 'Не найден идентификатор участника'));
        }

        if ($request->has("family") && $request->has("name")) {
            $id = $request->input('id');
            $family = $request->input('family');
            $name = $request->input('name');
            $surname = $request->input('surname');
            $url = $request->input('url');
            $country = $request->input('country');
            $birthdate = $request->input('birthdate');
            $sex = $request->input('sex');
            $comment = $request->input('comment');
            $email = $request->input('email');
            $phone = $request->input('phone');
            $photo = $request->has('photo') ? $request->input('photo') : 0;
            $active = $request->input('active');
            Log::info('Сохраняю в БД участника: id-'.$id.', url-'.$url.', family-'.$family.', name-'.$name.', surname-'.$surname.', birthdate-'.$birthdate.', sex-'.$sex.', comment-'.$comment.', email-'.$email.', phone-'.$phone.', active-'.$active.', country-'.$country.', photo-'.$photo);

            if($insert) $url = $this->uniqURL($url);

            // проверка
            $validators = Validator::make(
                array(
                    'family' => $family,
                    'name' => $name,
                    'url' => $url,
                ),
                array(
                    'family' => 'required',
                    'name' => 'required',
                    'url' => 'unique:pgsql.site.news|max:220',
                ),
                array(
                    'required' => 'Поле :attribute должно быть введено',
                    'unique' => 'URL игрока должен быть уникальным',
                )
            );

            if($insert)
                $person = new Person;
            else {
                Log::info('Ищу участника с идентификатором: '.$id);
                try {
                    $person = Person::findOrFail($id);
                    if($request->has("photo")) $person->photo_id = $photo;
                } catch (Exception $e) {
                    Log::error('Участник с идентификаторм '.$id.' не найден');
                    return json_encode(array('status' => 'fail', 'text' => 'Участник не найден.'));
                }
            }

            $person->family = $family;
            $person->name = $name;
            $person->surname = $surname;
            $person->url = $url;
            $person->country_id = $country;
            if(isset($birthdate)) $person->birthdate = Carbon::createFromFormat('d.m.Y', $birthdate);
            $person->sex_id = $sex == true ? 1 : 2;
            $person->story = $comment;
            $person->email = $email;
            $person->phone = $phone;
            $person->active = $active;

            try {
                $person->save();
            } catch (Exception $e) {
                return json_encode(array('status' => 'fail', 'text' => 'Участник не сохранен.'));
            }

            // Сохраняю фото
            $newPhotoText = '';
            if($request->has('file')) {
                Log::info('Добавлено фото участника');
                $ret = ImageController::saveImage($person->id, 4, $person->url, $request);
                if(!$ret) {
                    Log::error('Ошибка записи изображения');
                    $newPhotoText = '. Фотография не была загружена.';
                } else {
                    $person->photo_id = $ret;
                    $person->save();
                }
            }

            if($insert) return json_encode(array('status' => 'OK', 'text' => 'Участник добавлен'.$newPhotoText, 'id' => $person->id, 'family' => $person->family.' '.$person->name));
            return json_encode(array('status' => 'OK', 'text' => 'Участник обновлен'.$newPhotoText, 'id' => $person->id, 'family' => $person->family.' '.$person->name));
        }
        Log::error('Не корректно введены фамилия и имя');
        return json_encode(array('status' => 'fail', 'text' => 'Участник не добавлен. Неизвестная ошибка.'));
    }

    private function uniqURL($url) {
        $result = Person::where('url', $url)->get();
        foreach ($result as $person) {
            return $url.'-new';
        }
        return $url;
    }

    /**
     * Обновить персону
     * @param Request $request
     * @return mixed
     */
    public function update(Request $request)
    {
        return $this->save($request, false);
    }
}
