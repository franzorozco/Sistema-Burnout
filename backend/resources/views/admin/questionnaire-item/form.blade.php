<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="questionnaire_id" class="form-label">{{ __('Questionnaire Id') }}</label>
            <input type="text" name="questionnaire_id" class="form-control @error('questionnaire_id') is-invalid @enderror" value="{{ old('questionnaire_id', $questionnaireItem?->questionnaire_id) }}" id="questionnaire_id" placeholder="Questionnaire Id">
            {!! $errors->first('questionnaire_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="item_order" class="form-label">{{ __('Item Order') }}</label>
            <input type="text" name="item_order" class="form-control @error('item_order') is-invalid @enderror" value="{{ old('item_order', $questionnaireItem?->item_order) }}" id="item_order" placeholder="Item Order">
            {!! $errors->first('item_order', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="question_text" class="form-label">{{ __('Question Text') }}</label>
            <input type="text" name="question_text" class="form-control @error('question_text') is-invalid @enderror" value="{{ old('question_text', $questionnaireItem?->question_text) }}" id="question_text" placeholder="Question Text">
            {!! $errors->first('question_text', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="response_type" class="form-label">{{ __('Response Type') }}</label>
            <input type="text" name="response_type" class="form-control @error('response_type') is-invalid @enderror" value="{{ old('response_type', $questionnaireItem?->response_type) }}" id="response_type" placeholder="Response Type">
            {!! $errors->first('response_type', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="meta" class="form-label">{{ __('Meta') }}</label>
            <input type="text" name="meta" class="form-control @error('meta') is-invalid @enderror" value="{{ old('meta', $questionnaireItem?->meta) }}" id="meta" placeholder="Meta">
            {!! $errors->first('meta', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>