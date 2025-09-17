<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="user_id" class="form-label">{{ __('User Id') }}</label>
            <input type="text" name="user_id" class="form-control @error('user_id') is-invalid @enderror" value="{{ old('user_id', $chatbotInteraction?->user_id) }}" id="user_id" placeholder="User Id">
            {!! $errors->first('user_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="session_id" class="form-label">{{ __('Session Id') }}</label>
            <input type="text" name="session_id" class="form-control @error('session_id') is-invalid @enderror" value="{{ old('session_id', $chatbotInteraction?->session_id) }}" id="session_id" placeholder="Session Id">
            {!! $errors->first('session_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="input_text" class="form-label">{{ __('Input Text') }}</label>
            <input type="text" name="input_text" class="form-control @error('input_text') is-invalid @enderror" value="{{ old('input_text', $chatbotInteraction?->input_text) }}" id="input_text" placeholder="Input Text">
            {!! $errors->first('input_text', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="input_metadata" class="form-label">{{ __('Input Metadata') }}</label>
            <input type="text" name="input_metadata" class="form-control @error('input_metadata') is-invalid @enderror" value="{{ old('input_metadata', $chatbotInteraction?->input_metadata) }}" id="input_metadata" placeholder="Input Metadata">
            {!! $errors->first('input_metadata', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="response_text" class="form-label">{{ __('Response Text') }}</label>
            <input type="text" name="response_text" class="form-control @error('response_text') is-invalid @enderror" value="{{ old('response_text', $chatbotInteraction?->response_text) }}" id="response_text" placeholder="Response Text">
            {!! $errors->first('response_text', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="response_metadata" class="form-label">{{ __('Response Metadata') }}</label>
            <input type="text" name="response_metadata" class="form-control @error('response_metadata') is-invalid @enderror" value="{{ old('response_metadata', $chatbotInteraction?->response_metadata) }}" id="response_metadata" placeholder="Response Metadata">
            {!! $errors->first('response_metadata', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="intent" class="form-label">{{ __('Intent') }}</label>
            <input type="text" name="intent" class="form-control @error('intent') is-invalid @enderror" value="{{ old('intent', $chatbotInteraction?->intent) }}" id="intent" placeholder="Intent">
            {!! $errors->first('intent', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="sentiment" class="form-label">{{ __('Sentiment') }}</label>
            <input type="text" name="sentiment" class="form-control @error('sentiment') is-invalid @enderror" value="{{ old('sentiment', $chatbotInteraction?->sentiment) }}" id="sentiment" placeholder="Sentiment">
            {!! $errors->first('sentiment', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="detected_risk" class="form-label">{{ __('Detected Risk') }}</label>
            <input type="text" name="detected_risk" class="form-control @error('detected_risk') is-invalid @enderror" value="{{ old('detected_risk', $chatbotInteraction?->detected_risk) }}" id="detected_risk" placeholder="Detected Risk">
            {!! $errors->first('detected_risk', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="detected_keywords" class="form-label">{{ __('Detected Keywords') }}</label>
            <input type="text" name="detected_keywords" class="form-control @error('detected_keywords') is-invalid @enderror" value="{{ old('detected_keywords', $chatbotInteraction?->detected_keywords) }}" id="detected_keywords" placeholder="Detected Keywords">
            {!! $errors->first('detected_keywords', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>