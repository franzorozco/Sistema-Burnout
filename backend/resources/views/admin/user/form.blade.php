<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user?->email) }}" id="email" placeholder="Email">
            {!! $errors->first('email', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="name" class="form-label">{{ __('Name') }}</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user?->name) }}" id="name" placeholder="Name">
            {!! $errors->first('name', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="paternal_surname" class="form-label">{{ __('Paternal Surname') }}</label>
            <input type="text" name="paternal_surname" class="form-control @error('paternal_surname') is-invalid @enderror" value="{{ old('paternal_surname', $user?->paternal_surname) }}" id="paternal_surname" placeholder="Paternal Surname">
            {!! $errors->first('paternal_surname', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="maternal_surname" class="form-label">{{ __('Maternal Surname') }}</label>
            <input type="text" name="maternal_surname" class="form-control @error('maternal_surname') is-invalid @enderror" value="{{ old('maternal_surname', $user?->maternal_surname) }}" id="maternal_surname" placeholder="Maternal Surname">
            {!! $errors->first('maternal_surname', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>


        <div class="form-group mb-2 mb20">
            <label for="phone" class="form-label">{{ __('Phone') }}</label>
            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user?->phone) }}" id="phone" placeholder="Phone">
            {!! $errors->first('phone', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="address" class="form-label">{{ __('Address') }}</label>
            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', $user?->address) }}" id="address" placeholder="Address">
            {!! $errors->first('address', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="is_active" class="form-label">{{ __('Is Active') }}</label>
            <input type="text" name="is_active" class="form-control @error('is_active') is-invalid @enderror" value="{{ old('is_active', $user?->is_active) }}" id="is_active" placeholder="Is Active">
            {!! $errors->first('is_active', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="last_login_at" class="form-label">{{ __('Last Login At') }}</label>
            <input type="text" name="last_login_at" class="form-control @error('last_login_at') is-invalid @enderror" value="{{ old('last_login_at', $user?->last_login_at) }}" id="last_login_at" placeholder="Last Login At">
            {!! $errors->first('last_login_at', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>