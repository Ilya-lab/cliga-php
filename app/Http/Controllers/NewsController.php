<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use App\NewsCategory;
use Illuminate\Support\Facades\Auth;
use Log;
use Storage;
use Gate;
use Image;
use DB;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Images\ImageController;
use Carbon\Carbon;


class NewsController extends Controller
{
    const newsPhotoHeight1 = 270;         // для новости с ватермаркой
    const newsPhotoWidth1 = 480;         // для новости с ватермаркой
    const newsPhotoHeight2 = 540;//200;         // для вывода на главной
    const newsPhotoWidth2 = 960;//520;         // для вывода на главной
    const newsPhotoHeight3 = 800;         // для вывода остальных новостей
    const newsPhotoHeight4 = 463;         // для вывода в новости
    const newsPhotoWidth4 = 750;         // для вывода в новости

    const minWidth = 200;               // минимальное для ширины
    const minHeight = 200;              // минимальное для высоты

    /*
     * все новости пользователя для админпанели
     */
    public function newsAll()
    {
        // проверка на права доступа
        /*if (!Auth::user()->isAdmin() && Gate::denies('NEWS')) {
            abort(403);
        }*/

        if (Auth::user()->isAdmin())
            $model = News::select('news.id', 'date', 'title', 'news.url', 'desc', 'name','image2')
                ->join('site.news_cat', 'cat_id','=','news_cat.id')
                ->orderBy('news.id')->get();
        else $model = News::select('news.id', 'date', 'title', 'news.url', 'desc', 'site.news_cat.name as name','image2')
            ->join('site.news_cat', 'cat_id','=','news_cat.id')
            ->join('users', 'user_id','=','users.id')
            ->where('user_id', Auth::user()->id)
            ->orderBy('news.id', 'DESC')->get();
        return $model;
    }

    public function adminIndex()
    {
        // проверка на права доступа
        if (Gate::denies('NEWS')) {
            abort(403);
        }

        //dd(Auth::user()->roles());


        return view('home.news.index', ['news' => $this->newsAll(), 'categories' => NewsCategory::all()]);
    }

    /*
     * Загрузка асинхронной фотографии к новости */
    public function loadPhotos(Request $request) {
        Log::info("Пришли новые фотки к новости");

        // удаляю
        $files = Storage::allFiles("/storage/temp/".Auth::user()->id);
        Log::info('Очищаю папку temp пользователя ');
        foreach ($files as $file) {
            if (substr($file, -4) == ".php") continue;
            Log::info('Удаляю временный файл - '.$file);
            Storage::delete($file);
        }

        Log::info("Проверка на наличие файла ");
        if ($request->hasFile('files') ) {
            $file = $request->file('files');
            $paths = array();
            foreach ($file as $ff) {
                Log::info("files - есть".$ff);
                if ($ff->isValid())
                {
                    // файл загрузился
                    Log::info('Файл загружен');
                    $dir = "/storage/temp/".Auth::user()->id;
                    if (!Storage::makeDirectory($dir)) {
                        // если создать каталог не удалось
                        Log::error("Не удалось создать каталог на сервере ".$dir);
                        echo json_encode(array('status' => 'fail', 'text' => 'Не удалось создать каталог на сервере'));;
                        return;
                    }
                    Storage::put($dir."/"."index.php", "<?php");

                    $fullPath = $dir."/".md5(date("m.d.y H:i:s")).".".$ff->getClientOriginalExtension();
                    Log::info("Сохраняю изображение по пути ".$fullPath);
                    $paths[] = $ff->storeAs($dir, md5(date("m.d.y H:i:s")).".".$ff->getClientOriginalExtension());
                }
            }

            echo json_encode(array('status' => 'OK', 'files' => $paths));
            return;
        } else {
            Log::error("Нет файлов ");
            echo json_encode(array('status' => 'fail', 'text' => 'Нет файлов'));
            return;
        }
        Log::error("Неизвестная ошибка");
        echo json_encode(array('status' => 'fail', 'text' => 'Неизвестная ошибка'));
    }

    /**
     * переместить новость в архив
     * @param Request $request
     */
    public function moveToArchive(Request $request)
    {
        // проверка на права доступа
        if (Gate::denies('NEWS')) {
            Log::error("Нет доступа для помещения в архив. User - ".Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нет доступа'));
        }

        if(!$request->has("id")) {
            Log::error("Нет ключа для удаления. User - ".Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нет ключа для удаления'));
        }

        $id = $request->input("id");
        try {
            DB::select('SELECT site.move_news_to_archive(?)', array($id));
        } catch (Exception $exception) {
            Log::error("Ошибка перемещении новости в архив. News - ".$id);
            return json_encode(array('status' => 'fail', 'text' => 'Ошибка перемещении новости в архив'));
        }

        return json_encode(array('status' => 'OK', 'text' => 'Новость перемещена в архив!' , 'id' => $id));
    }

    /**
     * сохранить новость асинхронно
     * @param Request $request
     * @return Redirect
     */
    public function save(Request $request)
    {
        return $this->saveDB($request, true);
    }

    public function adminShow($id) {
        // проверка на права доступа
        if (Gate::denies('NEWS')) {
            Log::error("Нет доступа для просмотра новости. User - ".Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нет доступа'));
        }

        try {
            $news = News::select('site.news.*','site.news_cat.name as catname')
                ->join('site.news_cat','cat_id','=','site.news_cat.id')
                ->where('site.news.id',$id)->first();
        } catch (Exception $exception) {
            Log::error("Новость не найдена. NEWS - ".$id);
            return json_encode(array('status' => 'fail', 'text' => 'Новость не найдена'));
        }

        return json_encode(array('status' => 'OK', 'text' => 'Новость загружена!' , 'id' => $id, 'news' => $news));
    }

    /**
     * Удалить новость
     * @param $id
     * @return string
     */
    public function remove(Request $request)
    {
        // проверка на права доступа
        if (Gate::denies('NEWS')) {
            Log::error("Нет доступа для удаления новости. User - ".Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нет доступа'));
        }

        if(!$request->has("id")) {
            Log::error("Нет ключа для удаления новости. User - ".Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нет ключа для удаления'));
        }

        $id = $request->input("id");

        try {
            $news = News::findOrFail($id);
        } catch (Exception $exception) {
            Log::error("Новость не найден. User - ".Auth::user()->id.'. ID - '. $id);
            return json_encode(array('status' => 'fail', 'text' => 'Новость не найдена'));
        }

        // проверка на автора
        if (!Auth::user()->isAdmin() && Auth::user()->id != $news->user_id) {
            Log::error("Нет доступа. Только автору новсти возможно её удаление или администратору. User - ".Auth::user()->id);
            return json_encode(array('status' => 'fail', 'text' => 'Нет доступа. Только автору новсти возможно её удаление или администратору.'));
        }

        try {
            $news->delete();
        } catch (Exception $exception) {
            Log::error("Ошибка удаления новости. User - ".Auth::user()->id.'. ID - '. $id);
            return json_encode(array('status' => 'fail', 'text' => 'Ошибка удаления новости'));
        }

        return json_encode(array('status' => 'OK', 'text' => 'Новость удалена!' , 'id' => $id));
    }


    /**
     * Записываю в БД в зависимости от режима
     * @param Request $request
     */
    private function saveDB(Request $request, bool $insert = true) {
        // проверка на права доступа
        if (Gate::denies('NEWS')) {
            //abort(403);
            return json_encode(array('status' => 'fail', 'text' => 'Нет доступа'));
        }

        if(!$insert && !$request->has("id")) {
            return json_encode(array('status' => 'fail', 'text' => 'Не найден идентификатор новости'));
        }

        if ($request->has("name")) {
            $title = $request->input('name');
            if ($request->has("desc")) {
                $desc = $request->input('desc');
                if ($request->has("news")) {
                    $news2 = $request->input('news');
                    // if ($news2 == "<p>&nbsp;</p>") $news2 = "";
                    $url = $request->input('url');
                    $cat = $request->input('category');
                    $date = $request->input('date');
                    $fileName = $request->input('file_name');
                    $im = "";
                    $im1 = "";
                    $im2 = "";
                    $im3 = "";
                    $im4 = "";
                    $top = $request->input('top') == "true" || $request->input('top') == "on" ? 1 : 0;
                    $visible = $request->input('visible') == "true" || $request->input('visible') == "on" ? 1 : 0;
                    $lenta = $request->input('lenta') == "true" || $request->input('lenta') == "on" ? 1 : 0;

                    Log::info('Сохраняю в БД: title-'.$title.', url-'.$url.', desc-'.$desc.', date-'.$date.', filename-'.$fileName);

                    // проверка
                    if($insert) {
                        $validators = Validator::make(
                            array(
                                'title' => $title,
                                'url' => $url,
                                'desc' => $desc,
                                'news' => $news2,
                            ),
                            array(
                                'desc' => 'required',
                                'url' => 'unique:pgsql.site.news|max:220',
                            ),
                            array(
                                'required' => 'Поле :attribute должно быть введено',
                                'unique' => 'Заголовок новости должен быть уникальным',
                            )
                        );
                    } else {
                        $validators = Validator::make(
                            array(
                                'title' => $title,
                                'url' => $url,
                                'desc' => $desc,
                                'news' => $news2,
                            ),
                            array(
                                'desc' => 'required',
                                'url' => 'required|max:220',
                            ),
                            array(
                                'required' => 'Поле :attribute должно быть введено',
                                'unique' => 'Заголовок новости должен быть уникальным',
                            )
                        );
                    }

                    if ($validators->fails()) {
                        $errorMessages = $validators->messages();
                        $errors = "";
                        foreach ($errorMessages->all() as $messages) {
                            $errors .= $messages . ". ";
                        }
                        if (isset($errors)) {
                            return json_encode(array('status' => 'fail', 'text' => $errors));
                        }
                    }

                    $imageChange = true;
                    if(!$insert) {
                        $listDir = explode("/", $fileName);
                        if(count($listDir) > 2) {
                            if($listDir[1] != "temp") {
                                Log::info('Не найден temp каталог в пути. Обнуляю рисунок.');
                                $fileName = '';
                                $imageChange = false;
                            }
                        }
                    }

                    if(!empty($fileName)) {
                        $fullPath = $_SERVER['DOCUMENT_ROOT']."/".$fileName;
                        Log::info('Записываю загруженный файл '.$fullPath);
                        $imagePath = '/storage/images/news/';

                        Log::info('Проверка каталога '.$imagePath);
                        $secChar = substr($url,0,2);

                        Storage::makeDirectory($imagePath.'original/'.$secChar);
                        // !!!!сохраняю оригинал, переношу из temp в original
                        $pi = pathinfo($fileName);
                        $im = $imagePath.'original/'.$secChar."/".$url.'.'.$pi['extension'];
                        $new_name = ImageController::generateName($imagePath.'original/'.$secChar.'/'.$url.'.'.$pi['extension']);
                        Log::info('Перемещаю оригинальный файл из '.$fileName.' в '.$new_name);
                        Storage::move($fileName, $new_name);

                        // сохраняю миниатюру 1
                        $img1 = Image::make($_SERVER['DOCUMENT_ROOT'].$new_name);
                        if ($img1->width() < NewsController::minWidth || $img1->height() < NewsController::minHeight ) {
                            Log::info('Изображение несоответствует минимальной '.NewsController::minWidth.' ширине или '.NewsController::minHeight.' высоте!');
                            Storage::delete($fullPath);
                            return json_encode(array('status' => 'fail', 'text' => 'Изображение несоответствует минимальной '.NewsController::minWidth.' ширине или '.NewsController::minHeight.' высоте!'));
                        }

                        if ($img1->width() < NewsController::newsPhotoWidth1 || $img1->height() < NewsController::newsPhotoHeight1 ) {
                            $img1->resize(NewsController::newsPhotoWidth1, NewsController::newsPhotoHeight1, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                        }

                        $img1->fit(NewsController::newsPhotoWidth1, NewsController::newsPhotoHeight1, function ($constraint) {
                            $constraint->upsize();
                        });
                        // накладываю ватермарку
                        /* $watermark = Image::make($_SERVER['DOCUMENT_ROOT'].PhotoController::newsPhotoDir."/lllf_watermark.png");
                         $img1->insert($watermark, 'top-right', 20, 20);*/

                        Storage::makeDirectory($imagePath.'t1/'.$secChar);
                        $im1 = $imagePath.'t1/'.$secChar."/".$url.'.'.$pi['extension'];
                        $img1->save($_SERVER['DOCUMENT_ROOT'].$imagePath.'t1/'.$secChar."/".$url.'.'.$pi['extension']);
                        // от сохранения миниатюры 1

                        // сохраняю миниатюру 2
                        $img2 = Image::make($_SERVER['DOCUMENT_ROOT'].$new_name);
                        if ($img2->width() < NewsController::newsPhotoWidth2 || $img2->height() < NewsController::newsPhotoHeight2 ) {
                            $img2->resize(NewsController::newsPhotoWidth2, NewsController::newsPhotoHeight2, function ($constraint) {
                                $constraint->aspectRatio();
                                //$constraint->upsize();
                            });
                        }
                        // add callback functionality to retain maximal original image size
                        $img2->fit(NewsController::newsPhotoWidth2, NewsController::newsPhotoHeight2, function ($constraint) {
                            $constraint->upsize();
                        });
                        Storage::makeDirectory($imagePath.'t2/'.$secChar);
                        $im2 = $imagePath.'t2/'.$secChar."/".$url.'.'.$pi['extension'];
                        $img2->save($_SERVER['DOCUMENT_ROOT'].$imagePath.'t2/'.$secChar."/".$url.'.'.$pi['extension']);
                        // от сохранения миниатюры 2

                        // сохраняю миниатюру 3
                        /*$img3 = Image::make($_SERVER['DOCUMENT_ROOT'].$new_name);
                        $img3->fit(NewsController::newsPhotoHeight3, NewsController::newsPhotoHeight3, function ($constraint) {
                            $constraint->upsize();
                        });
                        Storage::makeDirectory($imagePath.'t3/'.$secChar);
                        $im3 = $imagePath.'t3/'.$secChar."/".$url.'.'.$pi['extension'];
                        $img3->save($_SERVER['DOCUMENT_ROOT'].$imagePath.'t3/'.$secChar."/".$url.'.'.$pi['extension']);*/
                        // от сохранения миниатюры 3

                        // сохраняю миниатюру 4
                        $img4 = Image::make($_SERVER['DOCUMENT_ROOT'].$new_name);
                        if ($img4->width() < NewsController::newsPhotoWidth4 || $img2->height() < NewsController::newsPhotoHeight4 ) {
                            $img4->resize(NewsController::newsPhotoWidth4, NewsController::newsPhotoHeight4, function ($constraint) {
                                $constraint->aspectRatio();
                                //$constraint->upsize();
                            });
                        }
                        // add callback functionality to retain maximal original image size
                        $img4->fit(NewsController::newsPhotoWidth4, NewsController::newsPhotoHeight4, function ($constraint) {
                            $constraint->upsize();
                        });
                        Storage::makeDirectory($imagePath.'t3/'.$secChar);
                        $im4 = $imagePath.'t3/'.$secChar."/".$url.'.'.$pi['extension'];
                        $img4->save($_SERVER['DOCUMENT_ROOT'].$imagePath.'t3/'.$secChar."/".$url.'.'.$pi['extension']);
                        // от сохранения миниатюры 4
                    }

                    if($insert)
                        $news = new News;
                    else {
                        Log::info('Ищу новость с идентификатором: '.$request->input('id'));
                        try {
                            $news = News::findOrFail($request->input('id'));
                            if(!empty($news->image) && empty($im) && $imageChange) {
                                Log::info('Было фото: '.$news->image.', а стало: '.$im);
                                $news->image = "";
                                $news->image1 = "";
                                $news->image2 = "";
                                $news->image3 = "";
                            }
                        } catch (Exception $e) {
                            Log::error('Новость с идентификаторм '.$request->input('id').' не найдена');
                            return json_encode(array('status' => 'fail', 'text' => 'Новость не найдена.'));
                        }
                    }

                    $news->title = $title;
                    $news->url = $url;
                    $news->desc = $desc;
                    $news->news = $news2;
                    $news->date = Carbon::createFromFormat('d.m.Y   H:i', $date) ;
                    $news->user_id = Auth::user()->id;
                    if($insert) {
                        // если вставка
                        $news->image = $im;
                        $news->image1 = $im1;
                        $news->image2 = $im2;
                        $news->image3 = $im4;
                    } else {
                        if($imageChange) {
                            $news->image = $im;
                            $news->image1 = $im1;
                            $news->image2 = $im2;
                            $news->image3 = $im4;
                        }
                    }

                    $news->top = $top;
                    $news->visible = $visible;
                    $news->head = $lenta;
                    $news->cat_id = $cat;

                    try {
                        $news->save();
                    } catch (Exception $e) {
                        return json_encode(array('status' => 'fail', 'text' => 'Новость не сохранена.'));
                    }

                    if($insert) return json_encode(array('status' => 'OK', 'text' => 'Новость добавлена', 'id' => $news->id, 'news' => $news));
                    return json_encode(array('status' => 'OK', 'text' => 'Новость обновлена', 'id' => $news->id, 'news' => $news));

                } else return json_encode(array('status' => 'OK', 'text' => 'Не введена новость'));//return Redirect::back()->with('message', 'Не введена новость')->withInput();
            } else return json_encode(array('status' => 'OK', 'text' => 'Не введена краткая новость'));//return Redirect::back()->with('message', 'Не введена краткая новость')->withInput();
        } else return json_encode(array('status' => 'OK', 'text' => 'Не введён заголовок новости'));//return Redirect::back()->with('message', 'Не введён заголовок новости')->withInput();

        return json_encode(array('status' => 'fail', 'text' => 'Новость не добавлена. Неизвестная ошибка.'));
    }

    /**
     * Обновление новости
     * @param Request $request
     * @return Redirect
     */
    public function update(Request $request)
    {
        return $this->saveDB($request, false);
    }


    /**
     * Показать новости за категорию
     * @param $id
     */
    public function cat($id) {
        $name = NewsCategory::where('c_url', $id)->firstOrFail();

        $model = News::select('news.id', 'n_date', 'n_title', 'n_url', 'n_desc', 'c_name', 'c_url')
            ->join('news_cat', 'n_catid','=','news_cat.id')
            ->active()
            ->visible()
            ->where('c_url', $id)
            ->orderBy('news.n_top', 'DESC')
            ->orderBy('news.n_date', 'DESC')->get();
        return view('categorynews', [
            'news'=>$model,
            'categories'=> NewsCategory::where('c_url','<>',$id)->orderBy('id', 'DESC')->get(),
            'title' => $name->c_name,
        ]);
    }

    /**
     * Загрузить новости на главную страницу
     */
    static public function main() {
        return News::select('url','title','desc','date','image1','image2','cat_id')->with('category')
            /*top()->head()*/->active()->visible()->limit(6)->orderBy('top','DESC')->orderBy('date','DESC')->get();
    }

    /**
     * Вывести новость
     * @param $url - идентификатор новости
     */
    public function show($url) {
        $news = News::select('title', 'desc', 'news', 'date', 'image1', 'image2', 'image3', 'cat_id', 'url')->visible()->with('category')->active()->URL($url)->get()->first();
        if($news == null) abort(404);
        return view('news', ['news' => $news]);
    }

    /**
     * Вывести все задачи
     * @return \Illuminate\Support\Collection
     */
    public function showAll($offset = 0,$limit = 30) {
        $news = News::select('title', 'desc', 'date', 'image1', 'image2', 'image3', 'cat_id', 'url')->visible()->with('category')->active()
            ->offset($offset)->limit($limit)
            ->orderByDesc('date')->get();
        return view('newsall', ['news' => $news]);
    }
}
