<?php

namespace SaadeMotion\Photofolio\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PhotofolioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \Photofolio::view('home')->with([
            'portifolio_item_count' => \Photofolio::model('PortifolioItem')->count()
        ]);
    }

    public function assets(Request $request)
    {
        $path = str_replace('/', DIRECTORY_SEPARATOR, Str::start(urldecode($request->path), '/'));
        $path = realpath(dirname(__DIR__, 3).'/publishable/assets').$path;
        if (realpath($path) != $path) {
            abort(404);
        }
        if (File::exists($path)) {
            $mime = '';
            if (Str::endsWith($path, '.js')) {
                $mime = 'text/javascript';
            } elseif (Str::endsWith($path, '.css')) {
                $mime = 'text/css';
            } elseif (Str::endsWith($path, '.svg')) {
                $mime = 'image/svg+xml';
            } else {
                $mime = File::mimeType($path);
            }
            $response = response(File::get($path), 200, ['Content-Type' => $mime]);
            $response->setSharedMaxAge(31536000);
            $response->setMaxAge(31536000);
            $response->setExpires(new \DateTime('+1 year'));
            return $response;
        }
        return response('', 404);
    }
}
