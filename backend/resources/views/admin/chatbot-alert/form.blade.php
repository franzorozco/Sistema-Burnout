<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="chatbot_interaction_id" class="form-label">{{ __('Chatbot Interaction Id') }}</label>
            <input type="text" name="chatbot_interaction_id" class="form-control @error('chatbot_interaction_id') is-invalid @enderror" value="{{ old('chatbot_interaction_id', $chatbotAlert?->chatbot_interaction_id) }}" id="chatbot_interaction_id" placeholder="Chatbot Interaction Id">
            {!! $errors->first('chatbot_interaction_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="student_profile_id" class="form-label">{{ __('Student Profile Id') }}</label>
            <input type="text" name="student_profile_id" class="form-control @error('student_profile_id') is-invalid @enderror" value="{{ old('student_profile_id', $chatbotAlert?->student_profile_id) }}" id="student_profile_id" placeholder="Student Profile Id">
            {!! $errors->first('student_profile_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="alert_type" class="form-label">{{ __('Alert Type') }}</label>
            <input type="text" name="alert_type" class="form-control @error('alert_type') is-invalid @enderror" value="{{ old('alert_type', $chatbotAlert?->alert_type) }}" id="alert_type" placeholder="Alert Type">
            {!! $errors->first('alert_type', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="severity" class="form-label">{{ __('Severity') }}</label>
            <input type="text" name="severity" class="form-control @error('severity') is-invalid @enderror" value="{{ old('severity', $chatbotAlert?->severity) }}" id="severity" placeholder="Severity">
            {!! $errors->first('severity', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="resolved_at" class="form-label">{{ __('Resolved At') }}</label>
            <input type="text" name="resolved_at" class="form-control @error('resolved_at') is-invalid @enderror" value="{{ old('resolved_at', $chatbotAlert?->resolved_at) }}" id="resolved_at" placeholder="Resolved At">
            {!! $errors->first('resolved_at', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="resolved_by" class="form-label">{{ __('Resolved By') }}</label>
            <input type="text" name="resolved_by" class="form-control @error('resolved_by') is-invalid @enderror" value="{{ old('resolved_by', $chatbotAlert?->resolved_by) }}" id="resolved_by" placeholder="Resolved By">
            {!! $errors->first('resolved_by', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="notes" class="form-label">{{ __('Notes') }}</label>
            <input type="text" name="notes" class="form-control @error('notes') is-invalid @enderror" value="{{ old('notes', $chatbotAlert?->notes) }}" id="notes" placeholder="Notes">
            {!! $errors->first('notes', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>