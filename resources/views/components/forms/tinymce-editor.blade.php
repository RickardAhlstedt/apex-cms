<label class="form-label" for="{{ $id ?? 'myeditorinstance' }}">{{ $label ?? '' }}</label>
<textarea class="{{ $class }}" id="{{ $id ?? 'myeditorinstance' }}" name="{{ $id ?? 'textarea' }}" {{ $required ?? '' }}>{{ $content ?? 'Start something amazing!' }}</textarea>
