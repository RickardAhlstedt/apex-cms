<label class="form-label" for="{{ $id ?? 'myeditorinstance' }}">{{ $label ?? '' }}</label>
<textarea class="{{ $class }}" id="{{ $id ?? 'myeditorinstance' }}" name="{{ $id ?? 'textarea' }}" {{ $required ?? '' }} data-type="{{ $type ?? '' }}" data-count="{{ $count ?? 0 }}">{{ $content ?? 'Start something amazing!' }}</textarea>
