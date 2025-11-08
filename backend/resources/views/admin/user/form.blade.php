<div class="row padding-1 p-1">
    <div class="col-md-12">

        <!-- Correo Electrónico -->
        <div class="form-group mb-2 mb20">
            <label for="email" class="form-label">{{ __('Correo Electrónico') }}</label>
            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user?->email) }}" id="email" placeholder="Correo Electrónico">
            {!! $errors->first('email', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <!-- Nombre -->
        <div class="form-group mb-2 mb20">
            <label for="name" class="form-label">{{ __('Nombre') }}</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user?->name) }}" id="name" placeholder="Nombre">
            {!! $errors->first('name', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <!-- Apellidos -->
        <div class="form-group mb-2 mb20">
            <label for="paternal_surname" class="form-label">{{ __('Apellido Paterno') }}</label>
            <input type="text" name="paternal_surname" class="form-control @error('paternal_surname') is-invalid @enderror" value="{{ old('paternal_surname', $user?->paternal_surname) }}" id="paternal_surname" placeholder="Apellido Paterno">
            {!! $errors->first('paternal_surname', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="maternal_surname" class="form-label">{{ __('Apellido Materno') }}</label>
            <input type="text" name="maternal_surname" class="form-control @error('maternal_surname') is-invalid @enderror" value="{{ old('maternal_surname', $user?->maternal_surname) }}" id="maternal_surname" placeholder="Apellido Materno">
            {!! $errors->first('maternal_surname', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <!-- Contraseña -->
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <!-- Teléfono -->
        <div class="form-group mb-2 mb20">
            <label for="phone" class="form-label">{{ __('Teléfono') }}</label>
            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user?->phone) }}" id="phone" placeholder="Teléfono">
            {!! $errors->first('phone', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <!-- Dirección -->
        <div class="form-group mb-2 mb20">
            <label for="address" class="form-label">{{ __('Dirección') }}</label>
            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', $user?->address) }}" id="address" placeholder="Dirección">
            {!! $errors->first('address', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <!-- Activo: selector Sí / No -->
        <div class="form-group mb-2 mb20">
            <label for="is_active" class="form-label">{{ __('Activo') }}</label>
            <select name="is_active" id="is_active" class="form-control @error('is_active') is-invalid @enderror">
                <option value="1" {{ old('is_active', $user?->is_active) == 1 ? 'selected' : '' }}>Sí</option>
                <option value="0" {{ old('is_active', $user?->is_active) == 0 ? 'selected' : '' }}>No</option>
            </select>
            {!! $errors->first('is_active', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <!-- Último Inicio de Sesión: texto -->
        <div class="form-group mb-2 mb20">
            <label for="last_login_at" class="form-label">{{ __('Último Inicio de Sesión') }}</label>
            <input type="text" name="last_login_at" class="form-control @error('last_login_at') is-invalid @enderror" value="{{ old('last_login_at', $user?->last_login_at?->format('d-m-Y H:i:s')) }}" id="last_login_at" placeholder="Último Inicio de Sesión" readonly>
            {!! $errors->first('last_login_at', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Enviar') }}</button>
    </div>
</div>
