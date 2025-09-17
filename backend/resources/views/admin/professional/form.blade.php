<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="user_id" class="form-label">{{ __('User Id') }}</label>
            <input type="text" name="user_id" class="form-control @error('user_id') is-invalid @enderror" value="{{ old('user_id', $professional?->user_id) }}" id="user_id" placeholder="User Id">
            {!! $errors->first('user_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="profession" class="form-label">{{ __('Profession') }}</label>
            <input type="text" name="profession" class="form-control @error('profession') is-invalid @enderror" value="{{ old('profession', $professional?->profession) }}" id="profession" placeholder="Profession">
            {!! $errors->first('profession', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="license_number" class="form-label">{{ __('License Number') }}</label>
            <input type="text" name="license_number" class="form-control @error('license_number') is-invalid @enderror" value="{{ old('license_number', $professional?->license_number) }}" id="license_number" placeholder="License Number">
            {!! $errors->first('license_number', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="bio" class="form-label">{{ __('Bio') }}</label>
            <input type="text" name="bio" class="form-control @error('bio') is-invalid @enderror" value="{{ old('bio', $professional?->bio) }}" id="bio" placeholder="Bio">
            {!! $errors->first('bio', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="is_available" class="form-label">{{ __('Is Available') }}</label>
            <input type="text" name="is_available" class="form-control @error('is_available') is-invalid @enderror" value="{{ old('is_available', $professional?->is_available) }}" id="is_available" placeholder="Is Available">
            {!! $errors->first('is_available', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>