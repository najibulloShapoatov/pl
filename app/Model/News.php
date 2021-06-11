<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class News extends Model
{
    protected $fillable = [
        'title', 'image', 'text_detail','annonce_text', 'viewed', 'is_active'
    ];

    public function getHomeNews(){
        return $this->where('is_active', 1)->orderBy('created_at', 'desc')->take(3)->get();
    }

    public function getByID($id){
        return $this->where(['id' => $id])->get()->first();
    }

    public function getList(){

        $currentYear = date('Y');

        $news = $this->where('is_active', 1)
                        ->whereBetween('created_at', [$currentYear . '-01-01', $currentYear . '-12-31'])
                        ->orderBy('created_at', 'desc')
                        ->take(10)
                        ->get();

        return $news;
    }

    public function getDetail($id){
        $news = $this->where('id', $id)->get()->first();
        $news->viewed = $news->viewed + 1;
        $news->save();
        return $news;

    }

    public function loadMoreNews($input)
    {
        $year = (int)htmlspecialchars($input['year']);

        $page = 0;
        if(isset($input['page'])){
            $page = (int)htmlspecialchars($input['page']);
        }

        $news= $this->orderBy('created_at', 'desc')
            ->whereBetween('created_at', [$year . '-01-01', $year . '-12-31'])
            ->skip(($page*10))
            ->take(10)
            ->get();

        $data['news'] = $news;

        $data['news_qnt'] = count($data['news']);

        return $data;

    }

    public function loadByYear($input)
    {
        $year = (int)htmlspecialchars($input['year']);

        $page = 0;

        $news = $this->orderBy('created_at', 'desc')
            ->whereBetween('created_at', [$year . '-01-01', $year . '-12-31'])
            ->skip(($page*10))
            ->take(10)
            ->get();

        $data['news'] = $news;

        $data['news_qnt'] = count($data['news']);

        return $data;
    }


    //search
    public function searchGlobal($search)
    {

        $data = News::where('title', 'like','%'.$search.'%')
            ->orWhere('text_detail', 'like', '%'.$search.'%')
            ->orWhere('annonce_text', 'like', '%'.$search.'%')
            ->orderBy('created_at', 'desc')
            ->get();


        return $data;
    }





    /*=====================Admin======================================================*/
    public function getListAdm()
    {
        return $this->orderBy('updated_at', 'desc')->paginate(20);
    }

    //change active news
    public function changeActive($input)
    {
        $newsID = htmlspecialchars($input['news_id']);

        $news = $this->where('id', $newsID)->get()->first();

        if($news->is_active == 1){
            $news->is_active = 0;
        }else{
            $news->is_active = 1;
        }
        $news->save();

        return $news->is_active;

    }

    //delete News
    public function deleteNews($input)
    {
        $newsID = htmlspecialchars($input['news_id']);

        $news = $this->where('id', $newsID)->get()->first();
        /*
         * Create
         * delete Comments News
         * */
        return $news->delete();
    }

    //update news
    public function updateNews(Request $request)
    {
        $input = $request->all();
        $newsID = htmlspecialchars($input['news_id']);
        $title = htmlspecialchars($input['title']);
        $anonce = htmlspecialchars($input['anonce']);
        $descr = htmlspecialchars($input['descr']);

        $news = $this->where('id', $newsID)->get()->first();

        $news->title = $title;
        $news->text_detail = $descr;
        $news->annonce_text = $anonce;
        $news->save();

        $path = public_path('uploads/news/' . $newsID);
        if($file = $request->file('image')) {
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }
            $image = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $imageName = time() . '_' . uniqid() . '.' . $extension;
            $img = Image::make($image);

            $img->save($path . '/' . $imageName);

            $img->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $news->image = $imageName;
            $has_image = $news->save();

        }

        return true;

    }


    //create news
    public function createNews(Request $request)
    {

        $input = $request->all();
        $title = htmlspecialchars($input['title']);
        $anonce = htmlspecialchars($input['anonce']);
        $descr = $input['descr'];

        $news = new News();

        $news->title = $title;
        $news->text_detail = $descr;
        $news->annonce_text = $anonce;
        $news->save();

        $path = public_path('uploads/news/' . $news->id);
        if($file = $request->file('image')) {
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }
            $image = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $imageName = time() . '_' . uniqid() . '.' . $extension;
            $img = Image::make($image);

            $img->save($path . '/' . $imageName);

            $img->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $news->image = $imageName;
            $has_image = $news->save();

        }

        return true;
    }

}
