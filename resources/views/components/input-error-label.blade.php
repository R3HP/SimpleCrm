<!-- Simplicity is the essence of happiness. - Cedric Bledsoe -->
<div>
    @if ($errors->has($inputName))
        <div class="alert alert-danger">
            <p class="text-red-500 text-xs mt-1">{{ $errors->first($inputName) }}</p>
        </div>
    @endif
    
    {{-- @error(`{{ $inputName }}`)
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror --}}
</div>