<?php

namespace Juzaweb\Modules\Notification\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Juzaweb\Modules\Core\Http\Controllers\AdminController;

class NotificationController extends AdminController
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('notification::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('notification::create');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('notification::edit');
    }
}
