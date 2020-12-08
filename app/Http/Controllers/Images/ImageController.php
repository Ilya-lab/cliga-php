<?php

namespace App\Http\Controllers\Images;

use App\Classif\ImageTypes;
use App\Classif\Thumbs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log;
use Storage;
use Auth;
use Image;


class ImageController extends Controller
{

    public function load()
    {
        return view('home.imageloader');
    }

    public function upload(Request $request, $name = "my_file")
    {
        Log::info("Пришла новая фотка");

        // удаляю
        $files = Storage::allFiles("/storage/temp/".Auth::user()->id);
        Log::info('Очищаю папку temp пользователя ');
        foreach ($files as $file) {
            if (substr($file, -4) == ".php") continue;
            Log::info('Удаляю временный файл - '.$file);
            Storage::delete($file);
            //echo 'ОШИБКА: Недопустимый тип файла.';
            //return;
        }

        Log::info("Проверка на наличие файла ".$request);
        if ($request->file($name) && $request->file($name)->isValid()) {
            $file = $request->file($name);
            Log::info($name." - есть");
            if ($file->isValid())
            {
                // файл загрузился

                Log::info('Файл загружен');
                $dir = "/storage/temp/".Auth::user()->id;
                if (!Storage::makeDirectory($dir)) {
                    // если создать каталог не удалось
                    echo 'ОШИБКА: Не удалось создать каталог на сервере.';
                    return;
                }
                Storage::put($dir."/"."index.php", "<?php");

                $fullPath = $dir."/".md5(date("m.d.y H:i:s")).".".$file->getClientOriginalExtension();
                Log::info("Сохраняю изображение по пути ".$fullPath);
                $path = $request->my_file->storeAs($dir, md5(date("m.d.y H:i:s")).".".$file->getClientOriginalExtension());
                echo json_encode($path);
                return;
            }
        }

        echo "OK";
    }

    /**
     * Сохраняю изображение в каталог в зависимости от типа
     * id - идентификатор бъекта
     * type - тип объекта
     * return возвращает идентификатор записи в БД изображений
     */
    static public function saveImage($id, $type, $url, Request $request) {
        $imagePath = '/storage/images/';

        if ($request->has('file')) {
            // если есть файл
            $file = $request->input('file');
            if(!Storage::disk('public')->exists($file)) return false;

            $it = ImageTypes::find($type);
            $dir = $imagePath.$it->dir;

            Log::info('Проверка каталога '.$dir);
            $secChar = substr($url,0,2);
           // if(!Storage::disk('public')->exists($dir.'/original/'.$secChar)) {
            Log::info('Создание каталогов '.$dir);

            Storage::makeDirectory($dir.'/original/'.$secChar);
            // !!!!сохраняю оригинал, переношу из temp в original
            $pi = pathinfo($file);
            $new_name = ImageController::generateName($dir.'/original/'.$secChar.'/'.$url.'.'.$pi['extension']);
            Log::info('Перемещаю оригинальный файл из '.$file.' в '.$new_name);
            Storage::move($file, $new_name);

            $imgOriginal = Image::make($_SERVER['DOCUMENT_ROOT'] . '/' . $new_name);
            $originalImageModel = new \App\Images\Images();
            $originalImageModel->type_id = $type;
            $originalImageModel->filename = $new_name;
            $originalImageModel->filesize = $imgOriginal->fileSize();
            $originalImageModel->object_id = $id;
            if (!$originalImageModel->save()) {
                return false;
            }
            $imgOriginal->destroy();

            $typeImages = Thumbs::typeImage($type)->get();
            foreach ($typeImages as $typeImage) {
                Storage::makeDirectory($dir.'/'.$typeImage->dir.'/'.$secChar);
                // сохраняю миниатюру 1
                $imgOriginal = Image::make($_SERVER['DOCUMENT_ROOT'] . '/' . $new_name);

                if ((int)$request->input('ww') > 0 && (int)$request->input('hh') > 0) {
                    // если есть выделение
                    $x1 = (int)$request->input('x1');
                    $y1 = (int)$request->input('y1');
                    $width = (int)$request->input('x2');
                    $height = (int)$request->input('y2');
                    $ww = (int)$request->input('ww');
                    $hh = (int)$request->input('hh');
                    $xK = $imgOriginal->width() / $ww;
                    $yK = $imgOriginal->height() / $hh;
                    Log::info('Записываю координаты - X1='.round($x1*$xK).' Y1='.round($y1*$yK).' X2='.round($width*$xK).' Y2='.round($height*$yK));
                    $imgOriginal->crop(round($width*$xK), round($height*$yK), round($x1*$xK), round($y1*$yK));
                    if($typeImage->width<= $typeImage->height)
                        $imgOriginal->resize($typeImage->width, $typeImage->height, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    else $imgOriginal->resize($typeImage->width, $typeImage->width, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $imgOriginal->fit($typeImage->width, $typeImage->height, function ($constraint) {
                        $constraint->upsize();
                    }, 'top');
                } else {
                    if ($imgOriginal->width() < $typeImage->width || $imgOriginal->height() < $typeImage->height ) {
                        $imgOriginal->resize($typeImage->width, $typeImage->height, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        $imgOriginal->fit($typeImage->width, $typeImage->height, function ($constraint) {
                            $constraint->upsize();
                        }, 'top');
                    }
                }

                $pi = pathinfo($new_name);
                $fullDir = $dir.'/'.$typeImage->dir.'/'.$secChar.'/';
                $new_t = ImageController::generateName($fullDir.$url.".".$pi['extension']);
                Log::info('Записываю в файл '.$fullDir.$url.".".$pi['extension']);
                $imgOriginal->save($_SERVER['DOCUMENT_ROOT'] . '/' . $new_t);
                $imgOriginal->destroy();

                $thumbsImageModel = new \App\Images\Thumbs();
                $thumbsImageModel->image_id = $originalImageModel->id;
                $thumbsImageModel->thumb_id = $typeImage->id;
                $thumbsImageModel->filename = $new_t;
                if(!$thumbsImageModel->save()) {
                    return false;
                }
            }

            return $originalImageModel->id;
        }

        return false;
    }

    /* сгенерировать уникальное имя */
    public static function generateName($name) {
        $pi = pathinfo($name);
        while (Storage::exists($name)) {
            $name = $pi['dirname'].'/'.$pi['filename'].'_'.date("dmy_His").'.'.$pi['extension'];
        }

        return $name;
    }

    /* сгенерировать уникальное имя */
    private static function generateError($error) {
        return json_encode(array(
            'status'=>'ERROR',
            'error' => $error,
        ));
    }

    public function uploadDesc(Request $request)
    {
        Log::info("Пришла новая фотка ".$request->input('type'));

        if ($request->file('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            Log::info("file - есть");
            if ($file->isValid())
            {
                // файл загрузился
                Log::info('Файл загружен');
                $photoValidFormat = array('jpg', 'png', 'gif', 'jpeg', 'bmp');
                $fileFormat = $request->file('file')->getClientOriginalExtension();
                if (!in_array(strtolower($fileFormat), $photoValidFormat)) {
                    // файл загружен не того формата
                    return ImageController::generateError('Файл изображения неправильного формата');
                }

                $imagePath = '/storage/images/'.$request->input('type').'/description';
                $dir = $imagePath.'/unknown';
                if(strlen($request->input('url')) > 3) {
                    $secChar = substr($request->input('url'), 0, 2);
                    $dir = $imagePath.'/'.$secChar.'/'.$request->input('url');
                }

                if (!Storage::makeDirectory($dir)) {
                    // если создать каталог не удалось
                    return ImageController::generateError('Невозможно создать каталог для изображения');
                }
                Storage::put($dir."/"."index.php", "<?php");

                $fullPath = $dir."/".md5(date("m.d.y H:i:s")).".".$file->getClientOriginalExtension();
                Log::info("Сохраняю изображение по пути ".$fullPath);
                $nname = md5(date("m.d.y H:i:s"));
                $path = $request->file->storeAs($dir, $nname.'_original.'.$file->getClientOriginalExtension());
                $imgOriginal = Image::make($_SERVER['DOCUMENT_ROOT'] . '/'.$path);

                // подрезаю изображение, для лучшего качество надо изменить
                $imgOriginal->resize(1920, 1080, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $path = $dir.'/'.$nname.'.'.$file->getClientOriginalExtension();
                $imgOriginal->save($_SERVER['DOCUMENT_ROOT'] . '/' . $path);
                $imgOriginal->destroy();
                return json_encode(array(
                    'status'=>'OK',
                    'text' => 'Изображение загружено',
                    'location'=> env('APP_URL').'/'.$path,
                ));
            }
        }

        return ImageController::generateError('Ошибка при загрузке файла. Обратитесь к Администратору системы!');
    }
}
