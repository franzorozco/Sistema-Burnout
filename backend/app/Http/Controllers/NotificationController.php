<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\NotificationRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $notifications = Notification::paginate();

        return view('notification.index', compact('notifications'))
            ->with('i', ($request->input('page', 1) - 1) * $notifications->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $notification = new Notification();

        return view('notification.create', compact('notification'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NotificationRequest $request): RedirectResponse
    {
        Notification::create($request->validated());

        return Redirect::route('notifications.index')
            ->with('success', 'Notification created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $notification = Notification::find($id);

        return view('notification.show', compact('notification'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $notification = Notification::find($id);

        return view('notification.edit', compact('notification'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NotificationRequest $request, Notification $notification): RedirectResponse
    {
        $notification->update($request->validated());

        return Redirect::route('notifications.index')
            ->with('success', 'Notification updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Notification::find($id)->delete();

        return Redirect::route('notifications.index')
            ->with('success', 'Notification deleted successfully');
    }
}
