@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Accept terms</div>

        <div class="card-body">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. A aperiam commodi culpa cum doloribus, illum in
            iure iusto, numquam odio quam quibusdam quo repellendus sit, velit. Harum minima nobis recusandae?

            <form class="mt-4" action="{{ route('terms.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input {{ $errors->has('terms_accepted') ? 'is-invalid' : '' }}"
                               type="checkbox" id="terms_accepted" name="terms_accepted" value="1">
                        <label class="form-check-label" for="terms_accepted">Accept terms</label>
                    </div>
                    @if($errors->has('terms_accepted'))
                        <div class="invalid-feedback" style="display: block;">
                            {{ $errors->first('terms_accepted') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <button class="btn btn-primary" type="submit">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection