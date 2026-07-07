{{Form::open(array('url'=>'users','method'=>'post'))}}
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('name',__('Name'),['class'=>'form-label']) }}
                {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter User Name'),'required'=>'required'))}}
                @error('name')
                <small class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('email',__('Email'),['class'=>'form-label'])}}
                {{Form::text('email',null,array('class'=>'form-control','placeholder'=>__('Enter User Email'),'required'=>'required'))}}
                @error('email')
                <small class="invalid-email" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
                @enderror
            </div>
        </div>
        @if(\Auth::user()->type != 'super admin')
            <div class="form-group col-md-6">
                {{ Form::label('role', __('User Role'),['class'=>'form-label']) }}
                {!! Form::select('role', $roles, null,array('class' => 'form-control select','required'=>'required')) !!}
                @error('role')
                <small class="invalid-role" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
                @enderror
            </div>
        @elseif(\Auth::user()->type == 'super admin')
            {!! Form::hidden('role', 'company', null,array('class' => 'form-control select','required'=>'required')) !!}
        @endif
    <div class="col-md-6">
    <div class="form-group">
        {{Form::label('password',__('Password'),['class'=>'form-label'])}}
        <div class="input-group">
            <input type="password" name="password" id="password"
                class="form-control"
                placeholder="{{__('Enter User Password')}}"
                required minlength="6">
            <span class="input-group-text" style="cursor:pointer"
                onclick="var p=document.getElementById('password');var e=document.getElementById('eye-icon');if(p.type==='password'){p.type='text';e.classList.replace('ti-eye','ti-eye-off');}else{p.type='password';e.classList.replace('ti-eye-off','ti-eye');}">
                <i class="ti ti-eye" id="eye-icon"></i>
            </span>
        </div>
        @error('password')
        <small class="invalid-password" role="alert">
            <strong class="text-danger">{{ $message }}</strong>
        </small>
        @enderror
    </div>
</div>

{{-- Phone --}}
<div class="col-md-6">
    <div class="form-group">
        {{Form::label('phone',__('Phone No'),['class'=>'form-label'])}}
        {{Form::text('phone',null,array('class'=>'form-control','placeholder'=>__('Enter Phone No')))}}
    </div>
</div>

{{-- Address --}}
<div class="col-md-6">
    <div class="form-group">
        {{Form::label('address',__('Address'),['class'=>'form-label'])}}
        {{Form::text('address',null,array('class'=>'form-control','placeholder'=>__('Enter Address')))}}
    </div>
</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn btn-primary">
</div>


{{Form::close()}}
