<div class="d-flex gap-2">
    @isset($editRoute)
        <a href="{{ $editRoute }}" class="btn btn-sm btn-outline-primary">
            <i class="bx bx-edit"></i>
        </a>
    @endisset
    @isset($deleteRoute)
        <form action="{{ $deleteRoute }}" method="POST" onsubmit="return confirm('Удалить?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-outline-danger">
                <i class="bx bx-trash"></i>
            </button>
        </form>
    @endisset
</div>
