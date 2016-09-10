<?php

namespace App\Http\Controllers;

use App\Media;
use Illuminate\Http\Request;

use App\Http\Requests;

class MediaController extends Controller
{
    public function index() {
        $media = Media::all();
        return view('media.index', compact('media'));
    }
    public function destroy($id) {
        $media = Media::findOrFail($id);
        $media->delete();
        return redirect("/admin/media")->withMessage('deleted');
    }
}
