<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="user_id" class="form-label">{{ __('User Id') }}</label>
            <input type="text" name="user_id" class="form-control @error('user_id') is-invalid @enderror" value="{{ old('user_id', $post?->user_id) }}" id="user_id" placeholder="User Id">
            {!! $errors->first('user_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="title" class="form-label">{{ __('Title') }}</label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $post?->title) }}" id="title" placeholder="Title">
            {!! $errors->first('title', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="body" class="form-label">{{ __('Body') }}</label>
            <input type="text" name="body" class="form-control @error('body') is-invalid @enderror" value="{{ old('body', $post?->body) }}" id="body" placeholder="Body">
            {!! $errors->first('body', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="is_anonymous" class="form-label">{{ __('Is Anonymous') }}</label>
            <input type="text" name="is_anonymous" class="form-control @error('is_anonymous') is-invalid @enderror" value="{{ old('is_anonymous', $post?->is_anonymous) }}" id="is_anonymous" placeholder="Is Anonymous">
            {!! $errors->first('is_anonymous', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="score" class="form-label">{{ __('Score') }}</label>
            <input type="text" name="score" class="form-control @error('score') is-invalid @enderror" value="{{ old('score', $post?->score) }}" id="score" placeholder="Score">
            {!! $errors->first('score', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="views" class="form-label">{{ __('Views') }}</label>
            <input type="text" name="views" class="form-control @error('views') is-invalid @enderror" value="{{ old('views', $post?->views) }}" id="views" placeholder="Views">
            {!! $errors->first('views', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>