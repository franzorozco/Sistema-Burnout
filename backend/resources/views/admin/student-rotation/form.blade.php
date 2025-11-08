<div class="row padding-1 p-1">
    <div class="col-md-12">

        <!-- Selector de Perfil de Estudiante -->
        <div class="form-group mb-2 mb20">
            <label for="student_profile_id" class="form-label">{{ __('Perfil de Estudiante') }}</label>
            <select name="student_profile_id" id="student_profile_id" class="form-control @error('student_profile_id') is-invalid @enderror">
                <option value="">{{ __('Seleccione un estudiante') }}</option>
                @foreach($students as $student)
                    <option value="{{ $student->id }}" {{ old('student_profile_id', $studentRotation?->student_profile_id) == $student->id ? 'selected' : '' }}>
                        {{ $student->name }} {{ $student->paternal_surname }} {{ $student->maternal_surname }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('student_profile_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <!-- Selector de Rotación -->
        <div class="form-group mb-2 mb20">
            <label for="rotation_id" class="form-label">{{ __('Rotación') }}</label>
            <select name="rotation_id" id="rotation_id" class="form-control @error('rotation_id') is-invalid @enderror">
                <option value="">{{ __('Seleccione una rotación') }}</option>
                @foreach($rotations as $rotation)
                    <option value="{{ $rotation->id }}" {{ old('rotation_id', $studentRotation?->rotation_id) == $rotation->id ? 'selected' : '' }}>
                        {{ $rotation->name }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('rotation_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <!-- Fecha Asignada -->
        <div class="form-group mb-2 mb20">
            <label for="assigned_at" class="form-label">{{ __('Asignado el') }}</label>
            <input type="text" name="assigned_at" class="form-control @error('assigned_at') is-invalid @enderror" value="{{ old('assigned_at', $studentRotation?->assigned_at) }}" id="assigned_at" placeholder="Asignado el">
            {!! $errors->first('assigned_at', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <!-- Tipo de Turno -->
        <div class="form-group mb-2 mb20">
            <label for="shift_type" class="form-label">{{ __('Tipo de Turno') }}</label>
            <input type="text" name="shift_type" class="form-control @error('shift_type') is-invalid @enderror" value="{{ old('shift_type', $studentRotation?->shift_type) }}" id="shift_type" placeholder="Tipo de Turno">
            {!! $errors->first('shift_type', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <!-- Notas -->
        <div class="form-group mb-2 mb20">
            <label for="notes" class="form-label">{{ __('Notas') }}</label>
            <input type="text" name="notes" class="form-control @error('notes') is-invalid @enderror" value="{{ old('notes', $studentRotation?->notes) }}" id="notes" placeholder="Notas">
            {!! $errors->first('notes', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>

    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Enviar') }}</button>
    </div>
</div>
