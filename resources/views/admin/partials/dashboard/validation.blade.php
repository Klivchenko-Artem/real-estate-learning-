@if($errors->any())
    <div class="alert alert-danger mx-4 mb-3">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success mx-4 mb-3">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger mx-4 mb-3">{{ session('error') }}</div>
@endif
