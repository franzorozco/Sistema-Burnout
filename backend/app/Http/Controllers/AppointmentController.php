<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\AppointmentRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $appointments = Appointment::paginate();

        return view('admin.appointment.index', compact('appointments'))
            ->with('i', ($request->input('page', 1) - 1) * $appointments->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $appointment = new Appointment();

        return view('admin.appointment.create', compact('appointment'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AppointmentRequest $request): RedirectResponse
    {
        Appointment::create($request->validated());

        return Redirect::route('admin.appointments.index')
            ->with('success', 'Appointment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $appointment = Appointment::find($id);

        return view('admin.appointment.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $appointment = Appointment::find($id);

        return view('admin.appointment.edit', compact('appointment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AppointmentRequest $request, Appointment $appointment): RedirectResponse
    {
        $appointment->update($request->validated());

        return Redirect::route('admin.appointments.index')
            ->with('success', 'Appointment updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Appointment::find($id)->delete();

        return Redirect::route('admin.appointments.index')
            ->with('success', 'Appointment deleted successfully');
    }
}
