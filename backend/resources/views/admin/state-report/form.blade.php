<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="student_profile_id" class="form-label">{{ __('Student Profile Id') }}</label>
            <input type="text" name="student_profile_id" class="form-control @error('student_profile_id') is-invalid @enderror" value="{{ old('student_profile_id', $stateReport?->student_profile_id) }}" id="student_profile_id" placeholder="Student Profile Id">
            {!! $errors->first('student_profile_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="report_date" class="form-label">{{ __('Report Date') }}</label>
            <input type="text" name="report_date" class="form-control @error('report_date') is-invalid @enderror" value="{{ old('report_date', $stateReport?->report_date) }}" id="report_date" placeholder="Report Date">
            {!! $errors->first('report_date', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="mood" class="form-label">{{ __('Mood') }}</label>
            <input type="text" name="mood" class="form-control @error('mood') is-invalid @enderror" value="{{ old('mood', $stateReport?->mood) }}" id="mood" placeholder="Mood">
            {!! $errors->first('mood', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="energy_level" class="form-label">{{ __('Energy Level') }}</label>
            <input type="text" name="energy_level" class="form-control @error('energy_level') is-invalid @enderror" value="{{ old('energy_level', $stateReport?->energy_level) }}" id="energy_level" placeholder="Energy Level">
            {!! $errors->first('energy_level', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="sleep_hours" class="form-label">{{ __('Sleep Hours') }}</label>
            <input type="text" name="sleep_hours" class="form-control @error('sleep_hours') is-invalid @enderror" value="{{ old('sleep_hours', $stateReport?->sleep_hours) }}" id="sleep_hours" placeholder="Sleep Hours">
            {!! $errors->first('sleep_hours', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="stress_score" class="form-label">{{ __('Stress Score') }}</label>
            <input type="text" name="stress_score" class="form-control @error('stress_score') is-invalid @enderror" value="{{ old('stress_score', $stateReport?->stress_score) }}" id="stress_score" placeholder="Stress Score">
            {!! $errors->first('stress_score', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="symptoms" class="form-label">{{ __('Symptoms') }}</label>
            <input type="text" name="symptoms" class="form-control @error('symptoms') is-invalid @enderror" value="{{ old('symptoms', $stateReport?->symptoms) }}" id="symptoms" placeholder="Symptoms">
            {!! $errors->first('symptoms', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="location" class="form-label">{{ __('Location') }}</label>
            <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location', $stateReport?->location) }}" id="location" placeholder="Location">
            {!! $errors->first('location', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>