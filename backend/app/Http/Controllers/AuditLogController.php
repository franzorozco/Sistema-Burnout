<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\AuditLogRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AuditLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $auditLogs = AuditLog::paginate();

        return view('audit-log.index', compact('auditLogs'))
            ->with('i', ($request->input('page', 1) - 1) * $auditLogs->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $auditLog = new AuditLog();

        return view('audit-log.create', compact('auditLog'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AuditLogRequest $request): RedirectResponse
    {
        AuditLog::create($request->validated());

        return Redirect::route('audit-logs.index')
            ->with('success', 'AuditLog created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $auditLog = AuditLog::find($id);

        return view('audit-log.show', compact('auditLog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $auditLog = AuditLog::find($id);

        return view('audit-log.edit', compact('auditLog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AuditLogRequest $request, AuditLog $auditLog): RedirectResponse
    {
        $auditLog->update($request->validated());

        return Redirect::route('audit-logs.index')
            ->with('success', 'AuditLog updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        AuditLog::find($id)->delete();

        return Redirect::route('audit-logs.index')
            ->with('success', 'AuditLog deleted successfully');
    }
}
