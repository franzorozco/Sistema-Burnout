<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="user_id" class="form-label">{{ __('User Id') }}</label>
            <input type="text" name="user_id" class="form-control @error('user_id') is-invalid @enderror" value="{{ old('user_id', $auditLog?->user_id) }}" id="user_id" placeholder="User Id">
            {!! $errors->first('user_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="action" class="form-label">{{ __('Action') }}</label>
            <input type="text" name="action" class="form-control @error('action') is-invalid @enderror" value="{{ old('action', $auditLog?->action) }}" id="action" placeholder="Action">
            {!! $errors->first('action', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="table_name" class="form-label">{{ __('Table Name') }}</label>
            <input type="text" name="table_name" class="form-control @error('table_name') is-invalid @enderror" value="{{ old('table_name', $auditLog?->table_name) }}" id="table_name" placeholder="Table Name">
            {!! $errors->first('table_name', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="record_id" class="form-label">{{ __('Record Id') }}</label>
            <input type="text" name="record_id" class="form-control @error('record_id') is-invalid @enderror" value="{{ old('record_id', $auditLog?->record_id) }}" id="record_id" placeholder="Record Id">
            {!! $errors->first('record_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="old_data" class="form-label">{{ __('Old Data') }}</label>
            <input type="text" name="old_data" class="form-control @error('old_data') is-invalid @enderror" value="{{ old('old_data', $auditLog?->old_data) }}" id="old_data" placeholder="Old Data">
            {!! $errors->first('old_data', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="new_data" class="form-label">{{ __('New Data') }}</label>
            <input type="text" name="new_data" class="form-control @error('new_data') is-invalid @enderror" value="{{ old('new_data', $auditLog?->new_data) }}" id="new_data" placeholder="New Data">
            {!! $errors->first('new_data', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="ip_address" class="form-label">{{ __('Ip Address') }}</label>
            <input type="text" name="ip_address" class="form-control @error('ip_address') is-invalid @enderror" value="{{ old('ip_address', $auditLog?->ip_address) }}" id="ip_address" placeholder="Ip Address">
            {!! $errors->first('ip_address', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="user_agent" class="form-label">{{ __('User Agent') }}</label>
            <input type="text" name="user_agent" class="form-control @error('user_agent') is-invalid @enderror" value="{{ old('user_agent', $auditLog?->user_agent) }}" id="user_agent" placeholder="User Agent">
            {!! $errors->first('user_agent', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>