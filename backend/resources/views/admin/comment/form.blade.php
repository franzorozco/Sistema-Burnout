<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="post_id" class="form-label">{{ __('Post Id') }}</label>
            <input type="text" name="post_id" class="form-control @error('post_id') is-invalid @enderror" value="{{ old('post_id', $comment?->post_id) }}" id="post_id" placeholder="Post Id">
            {!! $errors->first('post_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="user_id" class="form-label">{{ __('User Id') }}</label>
            <input type="text" name="user_id" class="form-control @error('user_id') is-invalid @enderror" value="{{ old('user_id', $comment?->user_id) }}" id="user_id" placeholder="User Id">
            {!! $errors->first('user_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="parent_comment_id" class="form-label">{{ __('Parent Comment Id') }}</label>
            <input type="text" name="parent_comment_id" class="form-control @error('parent_comment_id') is-invalid @enderror" value="{{ old('parent_comment_id', $comment?->parent_comment_id) }}" id="parent_comment_id" placeholder="Parent Comment Id">
            {!! $errors->first('parent_comment_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="body" class="form-label">{{ __('Body') }}</label>
            <input type="text" name="body" class="form-control @error('body') is-invalid @enderror" value="{{ old('body', $comment?->body) }}" id="body" placeholder="Body">
            {!! $errors->first('body', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="score" class="form-label">{{ __('Score') }}</label>
            <input type="text" name="score" class="form-control @error('score') is-invalid @enderror" value="{{ old('score', $comment?->score) }}" id="score" placeholder="Score">
            {!! $errors->first('score', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>