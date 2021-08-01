<?php

namespace App\Http\Controllers\Admin;

use App\Models\Area;
use App\Models\City;
use App\Models\Place;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Place\CreateRequest;
use App\Http\Requests\Admin\Place\UpdateRequest;


class PlacesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $places=Place::latest()->get();
        return view('Admin.places.index',compact('places'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::all();
        $categories = Category::all();

        return view('Admin.places.create',compact('cities','categories'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->file('images'));
        try{
            $place=new Place;
            $place->name_en=$request->input('name_en');
            $place->name_ar=$request->input('name_ar');
            $place->description_en=$request->input('description_en');
            $place->description_ar=$request->input('description_ar');
            $place->address_en=$request->input('address_en');
            $place->address_ar=$request->input('address_ar');
            $place->latitude=$request->input('latitude');
            $place->longitude=$request->input('longitude');
            $place->city_id=$request->input('city_id');
            $place->area_id=$request->input('area_id');
            $place->category_id=$request->input('category_id');
            $place->main_image = $this->upload($request->file('main_image'));
            $images=array();
            $file_count = count($request->file('images'));
            for ($i=0; $i<$file_count; $i++) {
                $images[$i] = $this->upload($request->file('images')[$i]);
               
       }
            $place->images = implode(',',$images);
            $place->save();
            return redirect(route('admin.places.index'));

        }catch(\Exception $e){
            dd($e);
        }






    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $place=Place::findOrFail($id);

        $cities = City::all();
        $areas = Area::all();
        $categories = Category::all();
        return view('Admin.places.show',compact('cities','categories','place','areas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $place=Place::findOrFail($id);
        $cities = City::all();
        $areas = Area::all();
        $categories = Category::all();
        return view('Admin.places.edit',compact('cities','categories','place','areas'));

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
     
        $place=Place::findOrFail($id);
        $place->name_en=$request->input('name_en');
            $place->name_ar=$request->input('name_ar');
            $place->description_en=$request->input('description_en');
            $place->description_ar=$request->input('description_ar');
            $place->address_en=$request->input('address_en');
            $place->address_ar=$request->input('address_ar');
            $place->latitude=$request->input('latitude');
            $place->longitude=$request->input('longitude');
            $place->city_id=$request->input('city_id');
            $place->area_id=$request->input('area_id');
            $place->category_id=$request->input('category_id');
            if($request->file('main_image')){
                $place->main_image = $this->upload($request->file('main_image'));
            }
          if($request->file('images')){
            $images=array();
            $file_count = count($request->file('images'));
            for ($i=0; $i<$file_count; $i++) {
                $images[$i] = $this->upload($request->file('images')[$i]);
               
       }
       //dd(implode(',',$images));
     
            $place->images = implode(',',$images);

          }
    
            $place->save();
            return redirect(route('admin.places.index'));
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $place=Place::findOrFail($id);
        $place->delete();
        return back();
    }


    public function topRatedPlaces(){
       
        $topRatedPlaces = Place::orderBy('rating', 'desc')->latest()->get();
       // dd($topRatedPlaces);
        return view('Admin.places.topRatedPlaces',compact('topRatedPlaces'));
    }


public function activation(Request $request,$id){
    try{
        $place=Place::findOrFail($id);
        //dd($request->input('active_popular'));
        if($request->input('active_topRating')!=$place->active_topRating){
            $place->active_topRating=$request->input('active_topRating');
            $place->save();
            return redirect(route('admin.places.topRating'));
        }
        if($request->input('active_popular')!=$place->active_popular){
            $place->active_popular=$request->input('active_popular');
            $place->save();
            return redirect(route('admin.places.PopularPlaces'));

        }
       
        }
    catch (\Exception $ex){
        dd($ex);
    }
   


}
    public function PopularPlaces(){
        $popularPlaces=Place::latest()->get();

        return view('Admin.places.PopularPlaces',compact('popularPlaces'));
    }

    public function upload($image)
    {
        $file = $image;
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $file->move('uploads/places', $filename);
        return '/uploads/places/' . $filename;
    }


}
