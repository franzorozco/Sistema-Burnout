<div class="row padding-1 p-1">
    <div class="col-md-12">
        {{-- Nombre del rol --}}
        <div class="form-group mb-2 mb20">
            <label for="name" class="form-label">{{ __('Name') }}</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $role->name ?? '') }}" id="name" placeholder="Name">
            {!! $errors->first('name', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        {{-- Guard Name (oculto) --}}
        <div class="form-group mb-2 mb20">
            <input type="hidden" name="guard_name" class="form-control @error('guard_name') is-invalid @enderror"
                   value="{{ old('guard_name', $role->guard_name ?? 'web') }}" id="guard_name" placeholder="Guard Name">
            {!! $errors->first('guard_name', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        {{-- Descripción --}}
        <div class="form-group mb-2 mb20">
            <label for="description" class="form-label">{{ __('Description') }}</label>
            <input type="text" name="description" class="form-control @error('description') is-invalid @enderror"
                   value="{{ old('description', $role->description ?? '') }}" id="description" placeholder="Description">
            {!! $errors->first('description', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        {{-- Created By --}}
        <div class="form-group mb-2 mb20">
            <label for="created_by" class="form-label">{{ __('Created By') }}</label>
            <select name="created_by" id="created_by" class="form-control @error('created_by') is-invalid @enderror">
                <option value="">{{ __('Select a user') }}</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}"
                        {{ old('created_by', $role->created_by ?? '') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('created_by', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        {{-- Permisos --}}
        <div class="form-group mb-2 mb20">
            <label class="form-label">{{ __('Permissions') }}</label>
            <div class="row">
                @foreach($permissions as $permission)
                    <div class="col-md-3">
                        <div class="form-check">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                   class="form-check-input" id="perm_{{ $permission->id }}"
                                   {{ in_array($permission->name, old('permissions', $rolePermissions)) ? 'checked' : '' }}>
                            <label class="form-check-label" for="perm_{{ $permission->id }}">{{ $permission->name }}</label>
                        </div>
                    </div>
                @endforeach
            </div>
            {!! $errors->first('permissions', '<div class="invalid-feedback d-block" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>

    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>