<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="item_id" class="form-label">{{ __('Item Id') }}</label>
            <input type="text" name="item_id" class="form-control @error('item_id') is-invalid @enderror" value="{{ old('item_id', $questionnaireChoice?->item_id) }}" id="item_id" placeholder="Item Id">
            {!! $errors->first('item_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="choice_order" class="form-label">{{ __('Choice Order') }}</label>
            <input type="text" name="choice_order" class="form-control @error('choice_order') is-invalid @enderror" value="{{ old('choice_order', $questionnaireChoice?->choice_order) }}" id="choice_order" placeholder="Choice Order">
            {!! $errors->first('choice_order', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="value" class="form-label">{{ __('Value') }}</label>
            <input type="text" name="value" class="form-control @error('value') is-invalid @enderror" value="{{ old('value', $questionnaireChoice?->value) }}" id="value" placeholder="Value">
            {!! $errors->first('value', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="label" class="form-label">{{ __('Label') }}</label>
            <input type="text" name="label" class="form-control @error('label') is-invalid @enderror" value="{{ old('label', $questionnaireChoice?->label) }}" id="label" placeholder="Label">
            {!! $errors->first('label', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>