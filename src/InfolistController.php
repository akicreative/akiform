<?php

namespace AkiCreative\AkiForms;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use AkiCreative\AkiForms\Models\Akicategory;
use AkiCreative\AkiForms\Models\Akiinfolist;



class InfolistController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private function types()
    {

        $types = [
             'textlink' => 'Link',
            'textfile' => 'File',
            'htmltext' => 'HTML Text',
            'plaintext' => 'Plain Text',
            'header' => 'Header'
           
            

        ];

        return $types;

    }

    private function categories()
    {

        $cats = Akicategory::where('cattype', 'list')->orderBy('name')->get();

        $return = [];

        foreach($cats as $cat){

            $key = $cat->id;

            $return[$key] = $cat->name;
        }

        return $return;

    }

    public function position($category)
    {


        $return = [
            'bottom' => 'Bottom',
            'top' => 'Top'
        ];

        $items = Akiinfolist::where('category', $category)->orderBy('orderby')->get();

        $number = 1;

        foreach($items as $item){

            $key = $item['id'];

            $return[$key] = 'After Item ' . $number;

            $number++;

        }

        


        return $return;

    }

    public function __construct()
    {

        view()->share('types', $this->types());
        view()->share('categories', $this->categories());

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    private function filters(){


        $filters = [

            'category' => ''
             
        ];

        
        $sessionfilters = session('infolistfilters', []);

        foreach($filters as $key => $value){

            if(array_key_exists($key, $sessionfilters)){

                $filters[$key] = $sessionfilters[$key];

            }

        }


        if(request()->input('go') == 'filter'){

            foreach($filters as $key => $value){

                if(request()->has($key)){

                    $filters[$key] = request()->input($key);

                }

            }


        }

        session(['infolistfilters' => $filters]);

        return $filters;

    }

    public function index(Request $request)
    {

        $filters = $this->filters();
    
        $rows = Akiinfolist::where('category', '=', $filters['category'])->orderBy('orderby')->get();

        $data['rows'] = $rows;

        $data['filters'] = $filters;

        $data['position'] = $this->position($filters['category']);
    
        return view('akiforms::infolists.home', $data);

    }

    public function store(Request $r)
    {

        $item = new Infolist;
        $item->category = $r->input('category');
        $item->infotype = $r->input('type');
        $item->save();

        $counter = 1;

        if($r->input('position') == 'top'){

            $item->orderby = 1;
            $item->save();

            $rows = Akiinfolist::where('category', '=', $r->input('category'))->where('id', '!=', $item->id)->orderBy('orderby')->get();
        
            foreach($rows as $row){

                $counter++;

                $row->orderby = $counter;
                $row->save();

            }

        }elseif($r->input('position') == 'bottom'){

            $last = Akiinfolist::where('category', '=', $r->input('category'))->where('id', '!=', $item->id)->orderBy('orderby', 'DESC')->first();

            if(empty($last)){

                $item->orderby = 1;
                $item->save();
            }else{

                $item->orderby = $last->orderby + 1;
                $item->save();
            }

        }else{

            $rows = Akiinfolist::where('category', '=', $r->input('category'))->where('id', '!=', $item->id)->orderBy('orderby')->get();

            foreach($rows as $row){

                $row->orderby = $counter;
                $row->save();

                $counter++;

                if($r->input('position') == $row->id){

                    $finalto = $counter;

                    $counter++;
                }
            }

            $item->orderby = $finalto;

            $item->save();
        }

        return redirect()->route('aki.lists.edit', [$item->id]);
    }

    public function edit($id)
    {

        $item = Akiinfolist::find($id);

        if(empty($item)){

            return redirect()->route('aki.lists.home');

        }

        $data['item'] = $item;

        $filters = $this->filters();

        $data['filters'] = $filters;

        $data['position'] = $this->position($filters['category']);

        return view('akiforms::infolists.update', $data);

    }

    public function save($id, Request $r)
    {


        $item = Akiinfolist::find($id);

        if(empty($item)){

            return redirect()->route('aki.lists.home');

        }

        $item->active = $r->input('active');
        $item->title = $r->input('title');

        $item->category = $r->input('category');

        if(in_array($item->infotype, ['textlink', 'htmltext', 'plaintext'])){

            $item->url = $r->input('url');
            $item->newwindow = $r->input('newwindow', 0);

        }

        if($r->input('filedelete', 0)){

            akiassetdelete($item->file_id);

            $item->file_id = 0;
        }

        if(in_array($item->infotype, ['textfile']) && $r->has('file')){

            $asset = akiassetadd('assetpublic', $r->file('file'), $item->file_id);

            $item->file_id = $asset->id;

        }

        if(in_array($item->infotype, ['textfile', 'htmltext', 'plaintext'])){

            $item->description = $r->input('description');

        }

        if($r->input('imageabovedelete', 0)){

            akiassetdelete($item->imageabove_id);

            $item->imageabove_id = 0;
        }

        if($r->has('imageabove')){

            $asset = akiassetadd('assetpublic', $r->file('imageabove'), $item->imageabove_id);

            $item->imageabove_id = $asset->id;
        }

        if($r->input('imagebelowdelete', 0)){

            akiassetdelete($item->imagebelow_id);

            $item->imagebelow_id = 0;
        }

        if($r->has('imagebelow')){

            $asset = akiassetadd('assetpublic', $r->file('imagebelow'), $item->imagebelow_id);

            $item->imagebelow_id = $asset->id;
        }

        $item->dividerafter = $r->input('dividerafter', 0);
        $item->spaceafter = $r->input('spaceafter', 0);

        $item->save();

        return redirect()->route('aki.lists.home');


    }

    public function orderby(Request $r){

        $moveto = $r->input('position');

        $itemid = $r->input('moveitem');

        $item = Akiinfolist::find($itemid);

        //$rows = Akiinfolist::where('category', '=', $r->input('category'))->where('id', '!=', $itemid)->orderBy('orderby')->get();

        $counter = 1;

        if($moveto == 'top'){

            $item->orderby = 1;
            $item->save();

            $rows = Akiinfolist::where('category', '=', $r->input('category'))->where('id', '!=', $item->id)->orderBy('orderby')->get();
        
            foreach($rows as $row){

                $counter++;

                $row->orderby = $counter;
                $row->save();

            }

        }elseif($moveto == 'bottom'){

            $last = Akiinfolist::where('category', '=', $r->input('category'))->where('id', '!=', $item->id)->orderBy('orderby', 'DESC')->first();

            if(empty($last)){

                $item->orderby = 1;
                $item->save();
            }else{

                $item->orderby = $last->orderby + 1;
                $item->save();
            }


        }else{

            $rows = Akiinfolist::where('category', '=', $r->input('category'))->where('id', '!=', $item->id)->orderBy('orderby')->get();

            foreach($rows as $row){

                $row->orderby = $counter;
                $row->save();

                $counter++;

                if($moveto == $row->id){

                    $finalto = $counter;

                    $counter++;
                }
            }

            $item->orderby = $finalto;

            $item->save();

        }


        return redirect()->route('aki.lists.home');


    }

    public function destroy($id, Request $r)
    {

        if($r->input('confirm') == 'Y'){

            $item = Akiinfolist::find($id);

            akiassetdelete($item->file_id);
            akiassetdelete($item->imageabove_id);
            akiassetdelete($item->imagebelow_id);

            $item->delete();

            return redirect()->route('aki.lists.home');

        }

        return redirect()->route('aki.lists.edit', $id);

    }


}
