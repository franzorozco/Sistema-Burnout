<div class="row padding-1 p-1">
    <div class="col-md-12">

        <!-- Selector de Usuario -->
        <div class="form-group mb-2 mb20">
            <label for="user_id" class="form-label">{{ __('ID de Usuario') }}</label>
            <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror">
                <option value="">{{ __('Selecciona un usuario') }}</option>
                @foreach(\App\Models\User::all() as $user)
                    <option value="{{ $user->id }}" {{ old('user_id', $studentProfile?->user_id) == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} (ID: {{ $user->id }})
                    </option>
                @endforeach
            </select>
            {!! $errors->first('user_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <!-- Código del Estudiante -->
        <div class="form-group mb-2 mb20">
            <label for="student_code" class="form-label">{{ __('Código del Estudiante') }}</label>
            <input type="text" name="student_code" class="form-control @error('student_code') is-invalid @enderror" value="{{ old('student_code', $studentProfile?->student_code) }}" id="student_code" placeholder="Código del Estudiante">
            {!! $errors->first('student_code', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <!-- Fecha de Nacimiento -->
        <div class="form-group mb-2 mb20">
            <label for="birthdate" class="form-label">{{ __('Fecha de Nacimiento') }}</label>
            <input type="date" name="birthdate" class="form-control @error('birthdate') is-invalid @enderror" value="{{ old('birthdate', $studentProfile?->birthdate) }}" id="birthdate" placeholder="Fecha de Nacimiento">
            {!! $errors->first('birthdate', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <!-- Carrera -->
        <div class="form-group mb-2 mb20">
            <label for="career" class="form-label">{{ __('Carrera') }}</label>
            <input type="text" name="career" class="form-control @error('career') is-invalid @enderror" value="{{ old('career', $studentProfile?->career) }}" id="career" placeholder="Carrera">
            {!! $errors->first('career', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <!-- Semestre -->
        <div class="form-group mb-2 mb20">
            <label for="semester" class="form-label">{{ __('Semestre') }}</label>
            <input type="text" name="semester" class="form-control @error('semester') is-invalid @enderror" value="{{ old('semester', $studentProfile?->semester) }}" id="semester" placeholder="Semestre">
            {!! $errors->first('semester', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <!-- Nombre del Grupo -->
        <div class="form-group mb-2 mb20">
            <label for="group_name" class="form-label">{{ __('Nombre del Grupo') }}</label>
            <input type="text" name="group_name" class="form-control @error('group_name') is-invalid @enderror" value="{{ old('group_name', $studentProfile?->group_name) }}" id="group_name" placeholder="Nombre del Grupo">
            {!! $errors->first('group_name', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <!-- Consentimiento Otorgado -->
        <div class="form-group mb-2 mb20">
            <label for="consent_given" class="form-label">{{ __('Consentimiento Otorgado') }}</label>
            <input type="text" name="consent_given" class="form-control @error('consent_given') is-invalid @enderror" value="{{ old('consent_given', $studentProfile?->consent_given) }}" id="consent_given" placeholder="Consentimiento Otorgado">
            {!! $errors->first('consent_given', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <!-- Fecha del Consentimiento -->
        <div class="form-group mb-2 mb20">
            <label for="consent_at" class="form-label">{{ __('Fecha del Consentimiento') }}</label>
            <input type="date" name="consent_at" class="form-control @error('consent_at') is-invalid @enderror" value="{{ old('consent_at', $studentProfile?->consent_at) }}" id="consent_at" placeholder="Fecha del Consentimiento">
            {!! $errors->first('consent_at', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Enviar') }}</button>
    </div>
</div>
