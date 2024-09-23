@if ($getRecord()->file)
    <a href="{{ asset('storage/' . $getRecord()->file) }}" download>
        Download File
    </a>
@else
    No file uploaded.
@endif
