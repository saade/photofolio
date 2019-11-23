<?php

namespace SaadeMotion\Photofolio\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class PortifolioItemController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $portifolio_id)
    {
        $validator = \Validator::make($request->only(['file']), [
            'file' => 'required|max:10000|mimes:jpg,jpeg,png'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $portifolio = \Photofolio::model('Portifolio')->findOrFail($portifolio_id);

        $file = $request->file('file');
        $filenamewithextension = $file->getClientOriginalName();
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $filenametostore = $filename.'_'.uniqid().'.'.$extension;

        if (!is_dir(storage_path('app/public/'.$portifolio->slug.'/'))) {
            mkdir(storage_path('app/public/'.$portifolio->slug.'/'), 0775, true);
        }

        $image = Image::make($file->getRealPath())->resize(2560, 1440, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $image->save(storage_path('app/public/'.$portifolio->slug.'/'. $filenametostore));

        $portifolioItem = \Photofolio::model('PortifolioItem')->create([
            'portifolio_id' => $portifolio_id,
            'thumb_url' => null,
            'full_url' => '/storage/' . $portifolio->slug . '/' . $filenametostore,
            'original_name' => $filenamewithextension,
            'grid_layout' => $this->getGridLayout($image->width(), $image->height()),
            'is_hidden' => false,
            'is_cover' => false
        ]);

        return response()->json($portifolioItem, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $portifolio_id, $id)
    {
        $validator = \Validator::make($request->only(['grid_layout', 'is_hidden', 'is_cover']), [
            'grid_layout' => 'in:portrait,landscape,square,big-square,random',
            'is_hidden' => 'boolean',
            'is_cover' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        /* Remove old cover if needs to */
        if (isset($request->is_cover)) {
            \Photofolio::model('PortifolioItem')->where(['is_cover' => true, 'portifolio_id' => $portifolio_id])->update(['is_cover' => false]);
        }

        /* Update item */
        $portifolioItem = \Photofolio::model('PortifolioItem')->where(['id' => $id, 'portifolio_id' => $portifolio_id])->firstOrFail();
        $portifolioItem->fill($request->only(['grid_layout', 'is_hidden', 'is_cover']));
        $portifolioItem->save();
        
        return response()->json($portifolioItem, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($portifolio_id, $id)
    {
        $portifolioItem = \Photofolio::model('PortifolioItem')->findOrFail($id);

        /* Delete full_url file from storage */
        $full_url = storage_path('app/public/'.str_replace('/storage/', '', $portifolioItem->full_url));
        if (is_file($full_url)) {
            unlink($full_url);
        }

        $portifolioItem->delete();

        return response()->json(null, 204);
    }

    /**
     * Returns grid layout for the current image.
     *
     * @param  int  $width
     * @param  int  $height
     * @return string 'portrait','landscape','square','big-square'
     */
    public function getGridLayout($width, $height)
    {
        if (abs($width-$height) < 50) {
            return ['square', 'big-square'][mt_rand(0,1)];
        } elseif ($width > $height) {
            return 'landscape';
        } elseif ($width < $height) {
            return 'portrait';
        }
    }
}
