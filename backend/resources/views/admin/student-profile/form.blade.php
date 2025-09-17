<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="user_id" class="form-label">{{ __('User Id') }}</label>
            <input type="text" name="user_id" class="form-control @error('user_id') is-invalid @enderror" value="{{ old('user_id', $studentProfile?->user_id) }}" id="user_id" placeholder="User Id">
            {!! $errors->first('user_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="student_code" class="form-label">{{ __('Student Code') }}</label>
            <input type="text" name="student_code" class="form-control @error('student_code') is-invalid @enderror" value="{{ old('student_code', $studentProfile?->student_code) }}" id="student_code" placeholder="Student Code">
            {!! $errors->first('student_code', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="birthdate" class="form-label">{{ __('Birthdate') }}</label>
            <input type="text" name="birthdate" class="form-control @error('birthdate') is-invalid @enderror" value="{{ old('birthdate', $studentProfile?->birthdate) }}" id="birthdate" placeholder="Birthdate">
            {!! $errors->first('birthdate', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="career" class="form-label">{{ __('Career') }}</label>
            <input type="text" name="career" class="form-control @error('career') is-invalid @enderror" value="{{ old('career', $studentProfile?->career) }}" id="career" placeholder="Career">
            {!! $errors->first('career', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="semester" class="form-label">{{ __('Semester') }}</label>
            <input type="text" name="semester" class="form-control @error('semester') is-invalid @enderror" value="{{ old('semester', $studentProfile?->semester) }}" id="semester" placeholder="Semester">
            {!! $errors->first('semester', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="group_name" class="form-label">{{ __('Group Name') }}</label>
            <input type="text" name="group_name" class="form-control @error('group_name') is-invalid @enderror" value="{{ old('group_name', $studentProfile?->group_name) }}" id="group_name" placeholder="Group Name">
            {!! $errors->first('group_name', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="consent_given" class="form-label">{{ __('Consent Given') }}</label>
            <input type="text" name="consent_given" class="form-control @error('consent_given') is-invalid @enderror" value="{{ old('consent_given', $studentProfile?->consent_given) }}" id="consent_given" placeholder="Consent Given">
            {!! $errors->first('consent_given', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="consent_at" class="form-label">{{ __('Consent At') }}</label>
            <input type="text" name="consent_at" class="form-control @error('consent_at') is-invalid @enderror" value="{{ old('consent_at', $studentProfile?->consent_at) }}" id="consent_at" placeholder="Consent At">
            {!! $errors->first('consent_at', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>