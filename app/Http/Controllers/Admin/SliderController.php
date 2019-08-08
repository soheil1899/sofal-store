<?php

namespace App\Http\Controllers\Admin;

use App\Gallery;
use App\Image;
use App\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class SliderController extends Controller
{
    public function index()
    {
        return view('admin.slider');
    }

    public function getslider()
    {
        return Slider::with('images')->get();
    }

    public function savesliderimage(Request $request)
    {

        $this->validate($request, [
            'title' => 'required',
        ]);

        if ($request->sliderid == 'null'){
            $slider = Slider::create([
                'title' => $request->title,
            ]);
            Storage::disk('media')->makeDirectory('slider/' . $slider['id']);
        }
        else{
            $slider = Slider::where('id', $request->sliderid)->first();
            $slider->title = $request->title;
            $slider->save();
        }



        $imagename = rand(10000,99999);

        $image = new ImageManager();
        $image->make($request->image->getRealPath())->save(public_path() . '/media/slider/'.$slider['id'].'/original_'. $imagename .'.png');
        $image->make($request->image->getRealPath())->resize('120', '120')->save(public_path() .'/media/slider/'.$slider['id'].'/small_'. $imagename .'.png');

        $image = Image::create([
            'image' => $imagename,
            'slider_id' => $slider['id'],
        ]);



        return [$slider['id'], $imagename, $image['id']];
    }


    public function deletesliderimage(Request $request)
    {
        $image = Image::where('id', $request->id)->first();

        Storage::disk('media')->delete('slider/'.$image['slider_id'].'/original_'. $image['image'] . '.png');
        Storage::disk('media')->delete('slider/'.$image['slider_id'].'/small_'. $image['image'] . '.png');

        $image->delete();
    }

    public function deleteslider(Request $request)
    {
        Slider::where('id', $request->id)->delete();

        Storage::disk('media')->deleteDirectory('slider/'. $request->id);
    }

}
