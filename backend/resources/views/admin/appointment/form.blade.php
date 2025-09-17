<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="student_profile_id" class="form-label">{{ __('Student Profile Id') }}</label>
            <input type="text" name="student_profile_id" class="form-control @error('student_profile_id') is-invalid @enderror" value="{{ old('student_profile_id', $appointment?->student_profile_id) }}" id="student_profile_id" placeholder="Student Profile Id">
            {!! $errors->first('student_profile_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="professional_id" class="form-label">{{ __('Professional Id') }}</label>
            <input type="text" name="professional_id" class="form-control @error('professional_id') is-invalid @enderror" value="{{ old('professional_id', $appointment?->professional_id) }}" id="professional_id" placeholder="Professional Id">
            {!! $errors->first('professional_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="scheduled_at" class="form-label">{{ __('Scheduled At') }}</label>
            <input type="text" name="scheduled_at" class="form-control @error('scheduled_at') is-invalid @enderror" value="{{ old('scheduled_at', $appointment?->scheduled_at) }}" id="scheduled_at" placeholder="Scheduled At">
            {!! $errors->first('scheduled_at', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="duration_minutes" class="form-label">{{ __('Duration Minutes') }}</label>
            <input type="text" name="duration_minutes" class="form-control @error('duration_minutes') is-invalid @enderror" value="{{ old('duration_minutes', $appointment?->duration_minutes) }}" id="duration_minutes" placeholder="Duration Minutes">
            {!! $errors->first('duration_minutes', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="status" class="form-label">{{ __('Status') }}</label>
            <input type="text" name="status" class="form-control @error('status') is-invalid @enderror" value="{{ old('status', $appointment?->status) }}" id="status" placeholder="Status">
            {!! $errors->first('status', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="notes" class="form-label">{{ __('Notes') }}</label>
            <input type="text" name="notes" class="form-control @error('notes') is-invalid @enderror" value="{{ old('notes', $appointment?->notes) }}" id="notes" placeholder="Notes">
            {!! $errors->first('notes', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="created_by" class="form-label">{{ __('Created By') }}</label>
            <input type="text" name="created_by" class="form-control @error('created_by') is-invalid @enderror" value="{{ old('created_by', $appointment?->created_by) }}" id="created_by" placeholder="Created By">
            {!! $errors->first('created_by', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>