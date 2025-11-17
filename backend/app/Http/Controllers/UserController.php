<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = $this->buildQuery($request);

        $users = $query->paginate(15);

        return view('admin.user.index', compact('users'))
            ->with('i', ($request->input('page', 1) - 1) * $users->perPage());
    }

    public function create(): View
    {
        $user = new User();

        return view('admin.user.create', compact('user'));
    }

    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'Usuario creado correctamente');
    }

    public function show($id): View
    {
        $user = User::find($id);

        return view('admin.user.show', compact('user'));
    }

    public function edit($id): View
    {
        $user = User::find($id);

        return view('admin.user.edit', compact('user'));
    }

    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $user->update($request->validated());

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario actualizado correctamente');
    }

    public function destroy($id): RedirectResponse
    {
        User::find($id)->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario eliminado correctamente');
    }

    /**
     * Export users list to PDF.
     */
    public function exportPdf(Request $request)
    {
        // Build the same query as index so filters are respected
        $query = $this->buildQuery($request);

        $users = $query->get();

        $filters = $request->only(['email', 'name', 'is_active']);

        $pdf = Pdf::loadView('admin.user.pdf', compact('users', 'filters'));

        return $pdf->download('users_report_' . date('Ymd') . '.pdf');
    }

    /**
     * Build users query applying possible filters from request.
     */
    protected function buildQuery(Request $request)
    {
        $query = User::query();

        if ($email = $request->query('email')) {
            $query->where('email', 'like', "%{$email}%");
        }

        if ($name = $request->query('name')) {
            $query->where('name', 'like', "%{$name}%");
        }

        if (!is_null($request->query('is_active')) && $request->query('is_active') !== '') {
            $value = $request->query('is_active');
            if ($value === '1' || $value === '0') {
                $query->where('is_active', (int) $value);
            }
        }

        $query->orderBy('id', 'desc');

        return $query;
    }
}
