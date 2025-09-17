<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="questionnaire_id" class="form-label">{{ __('Questionnaire Id') }}</label>
            <input type="text" name="questionnaire_id" class="form-control @error('questionnaire_id') is-invalid @enderror" value="{{ old('questionnaire_id', $questionnaireResponse?->questionnaire_id) }}" id="questionnaire_id" placeholder="Questionnaire Id">
            {!! $errors->first('questionnaire_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="student_profile_id" class="form-label">{{ __('Student Profile Id') }}</label>
            <input type="text" name="student_profile_id" class="form-control @error('student_profile_id') is-invalid @enderror" value="{{ old('student_profile_id', $questionnaireResponse?->student_profile_id) }}" id="student_profile_id" placeholder="Student Profile Id">
            {!! $errors->first('student_profile_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="user_id" class="form-label">{{ __('User Id') }}</label>
            <input type="text" name="user_id" class="form-control @error('user_id') is-invalid @enderror" value="{{ old('user_id', $questionnaireResponse?->user_id) }}" id="user_id" placeholder="User Id">
            {!! $errors->first('user_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="submitted_at" class="form-label">{{ __('Submitted At') }}</label>
            <input type="text" name="submitted_at" class="form-control @error('submitted_at') is-invalid @enderror" value="{{ old('submitted_at', $questionnaireResponse?->submitted_at) }}" id="submitted_at" placeholder="Submitted At">
            {!! $errors->first('submitted_at', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="summary_score" class="form-label">{{ __('Summary Score') }}</label>
            <input type="text" name="summary_score" class="form-control @error('summary_score') is-invalid @enderror" value="{{ old('summary_score', $questionnaireResponse?->summary_score) }}" id="summary_score" placeholder="Summary Score">
            {!! $errors->first('summary_score', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="raw" class="form-label">{{ __('Raw') }}</label>
            <input type="text" name="raw" class="form-control @error('raw') is-invalid @enderror" value="{{ old('raw', $questionnaireResponse?->raw) }}" id="raw" placeholder="Raw">
            {!! $errors->first('raw', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>