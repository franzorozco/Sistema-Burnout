<?php

namespace App\Http\Controllers;

use App\Models\StateReport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\StateReportRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class StateReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $stateReports = StateReport::paginate();

        return view('state-report.index', compact('stateReports'))
            ->with('i', ($request->input('page', 1) - 1) * $stateReports->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $stateReport = new StateReport();

        return view('state-report.create', compact('stateReport'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StateReportRequest $request): RedirectResponse
    {
        StateReport::create($request->validated());

        return Redirect::route('state-reports.index')
            ->with('success', 'StateReport created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $stateReport = StateReport::find($id);

        return view('state-report.show', compact('stateReport'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $stateReport = StateReport::find($id);

        return view('state-report.edit', compact('stateReport'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StateReportRequest $request, StateReport $stateReport): RedirectResponse
    {
        $stateReport->update($request->validated());

        return Redirect::route('state-reports.index')
            ->with('success', 'StateReport updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        StateReport::find($id)->delete();

        return Redirect::route('state-reports.index')
            ->with('success', 'StateReport deleted successfully');
    }
}
