<?php

namespace App\Http\Controllers\Backend\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        return \view('backend.blog.posts.index');
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(): View
    {
        return \view('backend.blog.posts.edit');
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function create(): View
    {
        return \view('backend.blog.posts.create');
    }
}
