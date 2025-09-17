<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="student_profile_id" class="form-label">{{ __('Student Profile Id') }}</label>
            <input type="text" name="student_profile_id" class="form-control @error('student_profile_id') is-invalid @enderror" value="{{ old('student_profile_id', $studentRotation?->student_profile_id) }}" id="student_profile_id" placeholder="Student Profile Id">
            {!! $errors->first('student_profile_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="rotation_id" class="form-label">{{ __('Rotation Id') }}</label>
            <input type="text" name="rotation_id" class="form-control @error('rotation_id') is-invalid @enderror" value="{{ old('rotation_id', $studentRotation?->rotation_id) }}" id="rotation_id" placeholder="Rotation Id">
            {!! $errors->first('rotation_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="assigned_at" class="form-label">{{ __('Assigned At') }}</label>
            <input type="text" name="assigned_at" class="form-control @error('assigned_at') is-invalid @enderror" value="{{ old('assigned_at', $studentRotation?->assigned_at) }}" id="assigned_at" placeholder="Assigned At">
            {!! $errors->first('assigned_at', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="shift_type" class="form-label">{{ __('Shift Type') }}</label>
            <input type="text" name="shift_type" class="form-control @error('shift_type') is-invalid @enderror" value="{{ old('shift_type', $studentRotation?->shift_type) }}" id="shift_type" placeholder="Shift Type">
            {!! $errors->first('shift_type', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="notes" class="form-label">{{ __('Notes') }}</label>
            <input type="text" name="notes" class="form-control @error('notes') is-invalid @enderror" value="{{ old('notes', $studentRotation?->notes) }}" id="notes" placeholder="Notes">
            {!! $errors->first('notes', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>