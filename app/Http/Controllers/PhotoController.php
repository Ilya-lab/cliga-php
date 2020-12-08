<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhotoController extends Controller
{
    // игроки
    const newsPhotoDir = "/images/news";
    const newsPhotoHeight1 = 450;         // для новости с ватермаркой
    const newsPhotoWidth1 = 800;         // для новости с ватермаркой
    const newsPhotoHeight2 = 450;         // для вывода на главной
    const newsPhotoWidth2 = 800;         // для вывода на главной
    const newsPhotoHeight3 = 800;         // для вывода остальных новостей

    const minWidth = 200;               // минимальное для ширины
    const minHeight = 200;              // минимальное для высоты

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = Curl::to('https://api.vk.com/method/photos.getAlbums')
            ->withData( array( 'owner_id' => '-22004651',
                'need_covers' => '1',/*'count' => '10',*/
                'access_token' => config("app.vktoken"),
                'v' => '5.65' ) )
            ->asJson()
            ->get();
//dd($response);
        $photos = array();
        if (isset($response->response->items)) {
            $i = 0;
            foreach ($response->response->items as $photo) {
                /*if ($i == 0) {
                    $i++;
                    continue;
                }*/

                $photos[] = array(
                    'url' => '/photo/album/'.$photo->id,
                    'title' => $photo->title,
                    'desc' => $photo->description,
                    'image' => $photo->thumb_src,
                    'dt' => $photo->created
                );
                $i++;
            }
        }

        return view('photos', ['photos' => $photos, 'videos' => array(),
            'championats' => ChampionatController::sideChampionats() ]);
    }

    /**
     * Функция сохраняет фото и кладёт в базу ссылку
     * @param Request $request - запрос
     */
    public static function saveNewsPhoto(Request $request) {
        if (!$request->hasFile('photo_file')) {
            $arr = array('original'=> NULL,
                't1'=>NULL,
                't2'=>NULL,
                't3'=>NULL);

            return $arr;
        }

        if ($request->file('photo_file') && $request->file('photo_file')->isValid()) {
            $file = $request->file('photo_file');
            if ($file->isValid())
            {
                // файл загрузился
                $str = substr($file->getClientOriginalName(), 0, 2);    // беру первые два символа
                $str = preg_replace('%[^A-Za-zА-Яа-я0-9]%', '', $str);
                $dir = PhotoController::newsPhotoDir."/".$str;
                if (!Storage::exists($dir))
                {
                    // если каталог не существует, создаём
                    if (!Storage::makeDirectory($dir)) {
                        // если создать каталог не удалось
                        return array('error'=>'Не удалось создать каталог на сервере. '.$dir);
                    }
                    Storage::put($dir."/"."index.php", "<?php");
                }

                //$fileName = PhotoController::getFileName($file->getClientOriginalName())."_original.".$file->getClientOriginalExtension();
                $fileName = PhotoController::getFileName($file->getClientOriginalName()).".".$file->getClientOriginalExtension();

                $ph = true;
                while ($ph) {
                    if (Storage::exists($dir."/".$fileName)) {
                        $fileName = PhotoController::getFileName($file->getClientOriginalName())."_new.".$file->getClientOriginalExtension();
                        continue;
                    }
                    $ph = false;
                }

                $fullPath = $_SERVER['DOCUMENT_ROOT'].$dir."/".$fileName;
                $file->move($_SERVER['DOCUMENT_ROOT'].$dir."/", $fileName);

                // сохраняю миниатюру 1
                $img1 = Image::make($fullPath);
                if ($img1->width() < PhotoController::minWidth || $img1->height() < PhotoController::minHeight ) {
                    Storage::delete($fullPath);
                    return array('error'=>'Изображение несоответствует минимальной '.PhotoController::minWidth.' ширине или '.PhotoController::minHeight.' высоте!');
                }

                if ($img1->width() < PhotoController::newsPhotoWidth1 || $img1->height() < PhotoController::newsPhotoHeight1 ) {
                    $img1->resize(PhotoController::newsPhotoWidth1, PhotoController::newsPhotoHeight1, function ($constraint) {
                        $constraint->aspectRatio();
                        //$constraint->upsize();
                    });
                }
                /*$img1->resize(PhotoController::newsPhotoWidth1, PhotoController::newsPhotoHeight1, function ($constraint) {
                    $constraint->aspectRatio();
                });*/
                $img1->fit(PhotoController::newsPhotoWidth1, PhotoController::newsPhotoHeight1, function ($constraint) {
                    $constraint->upsize();
                });
                // накладываю ватермарку
                $watermark = Image::make($_SERVER['DOCUMENT_ROOT'].PhotoController::newsPhotoDir."/lllf_watermark.png");
                $img1->insert($watermark, 'top-right', 20, 20);

                $fileName1 = PhotoController::getFileName($fileName)."_t1.".$file->getClientOriginalExtension();
                $img1->save($_SERVER['DOCUMENT_ROOT'].$dir."/".$fileName1);
                // от сохранения миниатюры 1

                // сохраняю миниатюру 2
                $img2 = Image::make($fullPath);
                if ($img2->width() < PhotoController::newsPhotoWidth1 || $img2->height() < PhotoController::newsPhotoHeight1 ) {
                    $img2->resize(PhotoController::newsPhotoWidth2, PhotoController::newsPhotoHeight2, function ($constraint) {
                        $constraint->aspectRatio();
                        //$constraint->upsize();
                    });
                }
                // add callback functionality to retain maximal original image size
                $img2->fit(PhotoController::newsPhotoWidth2, PhotoController::newsPhotoHeight2, function ($constraint) {
                    $constraint->upsize();
                });
                $fileName2 = PhotoController::getFileName($fileName)."_t2.".$file->getClientOriginalExtension();
                $img2->save($_SERVER['DOCUMENT_ROOT'].$dir."/".$fileName2);
                // от сохранения миниатюры 2

                // сохраняю миниатюру 3
                $img3 = Image::make($fullPath);
                // add callback functionality to retain maximal original image size
                $img3->fit(PhotoController::newsPhotoHeight3, PhotoController::newsPhotoHeight3, function ($constraint) {
                    $constraint->upsize();
                });
                $fileName3 = PhotoController::getFileName($fileName)."_t3.".$file->getClientOriginalExtension();
                $img3->save($_SERVER['DOCUMENT_ROOT'].$dir."/".$fileName3);
                // от сохранения миниатюры 3

                $arr = array('original'=>$str."/".$fileName,
                    't1'=>$str."/".$fileName1,
                    't2'=>$str."/".$fileName2,
                    't3'=>$str."/".$fileName3);

                return $arr;
            }
        }
        return array('error'=>'Файл не загружен');
    }

    public static function deleteNewsPhoto($im, $im1, $im2, $im3) {
        $pos = strpos($im, '/');
        if ($pos && file_exists($_SERVER['DOCUMENT_ROOT'].PhotoController::newsPhotoDir.'/'.$im)) {
            $newpath0 = "deleted/".substr($im, $pos+1);
            Storage::move(PhotoController::newsPhotoDir.'/'.$im, PhotoController::newsPhotoDir.'/'.$newpath0);

            $newpath1 = "deleted/".substr($im1, $pos+1);
            Storage::move(PhotoController::newsPhotoDir.'/'.$im1,PhotoController::newsPhotoDir.'/'.$newpath1);

            $newpath2 = "deleted/".substr($im2, $pos+1);
            Storage::move(PhotoController::newsPhotoDir.'/'.$im2, PhotoController::newsPhotoDir.'/'.$newpath2);

            $newpath3 = "deleted/".substr($im3, $pos+1);
            Storage::move(PhotoController::newsPhotoDir.'/'.$im3, PhotoController::newsPhotoDir.'/'.$newpath3);
        }
    }

    static private  function getFileName($filename) {
        return strstr($filename, '.', true);
        // return $filename;
    }



    /**
     * Удалить фотографию
     * @param $type - тип фотографии
     * @param $photo - код фотографии
     */
    public static function deletePhoto($photo) {
        $photo = Photo::findOrFail($photo);

        // перемещаю файл в удалённые
        $pos = strpos($photo->p_filename, '/');
        if ($pos) {
            $newpath0 = "deleted/".substr($photo->p_filename, $pos+1);
            //return playerPhotoDir.'/'.$photo->p_filename;
            Storage::move(PhotoController::playerPhotoDir.'/'.$photo->p_filename, PhotoController::playerPhotoDir.'/'.$newpath0);

            $newpath1 = "deleted/".substr($photo->p_filename_t1, $pos+1);
            Storage::move(PhotoController::playerPhotoDir.'/'.$photo->p_filename_t1, PhotoController::playerPhotoDir.'/'.$newpath1);

            $newpath2 = "deleted/".substr($photo->p_filename_t2, $pos+1);
            Storage::move(PhotoController::playerPhotoDir.'/'.$photo->p_filename_t2, PhotoController::playerPhotoDir.'/'.$newpath2);

            $newpath3 = "deleted/".substr($photo->p_filename_t3, $pos+1);
            Storage::move(PhotoController::playerPhotoDir.'/'.$photo->p_filename_t3, PhotoController::playerPhotoDir.'/'.$newpath3);

            $photo->p_filename = $newpath0;
            $photo->p_filename_t1 = $newpath1;
            $photo->p_filename_t2 = $newpath2;
            $photo->p_filename_t3 = $newpath3;
            $photo->p_deleted = 1;
            if (!$photo->save()) {
                return "Ошибка удаления фотографии";
            }
            return;
        }
        return "Ошибка удаления фотографии";
    }

    public function album($id, $number = 1) {
        $response = Curl::to('https://api.vk.com/method/photos.getAlbums')
            ->withData( array( 'owner_id' => '-22004651',
                'album_ids' => $id,/*'count' => '10',*/
                'access_token' => config("app.vktoken"),
                'v' => '5.65' ) )
            ->asJson()
            ->get();

        //dd($response);
        $title = "Альбом не распознан";
        $desc = "Нет описания";
        $dt = "";
        $image = "";
        $vk_image="";
        $text = "Нет описания";
        if (isset($response->response->items)) {
            foreach ($response->response->items as $photo) {
                $title = $photo->title;
                $desc = $photo->description;
                $dt = $photo->created;

            }
        }


        $response = Curl::to('https://api.vk.com/method/photos.get')
            ->withData( array( 'owner_id' => '-22004651',
                'album_id' => $id,
                'access_token' => config("app.vktoken"),
                'v' => '5.65' ) )
            ->asJson()
            ->get();

        // dd($response);
        $photos = array();
        $allPhotos = array();
        $i=0;
        if (isset($response->response->items)) {
            foreach ($response->response->items as $photo) {
                $i++;
                if ($i == $number) {
                    $image = $photo->photo_807;//src_xbig;
                    $vk_image = $photo->photo_130;//src_xbig;
                    $text = $photo->text;
                }
                if ($i <=8) {
                    $photos[] = array(
                        'number' => $i,
                        'image' => $photo->photo_130,//src_big,
                    );
                }
                $allPhotos[] = array(
                    'number' => $i,
                    'image' => $photo->photo_130,//src_big,
                );

            }
        }

        if (empty($text)) $text = "Нет описания";

        return view('photo', ['title' => $title, 'desc' => $desc, 'dt' => $dt, 'id' => $id,
            'photo' => $image, 'text' => $text, 'number' => $number, 'all' => $i,
            'photos' => $photos, 'allPhotos' => $allPhotos, 'vk' => $vk_image
        ]);
    }
    
    
    public function photogallery() {
        return view('photogallery');
    }
}
