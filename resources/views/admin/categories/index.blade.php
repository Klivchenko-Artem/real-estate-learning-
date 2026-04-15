@extends('layouts.admin')

@section('title', 'Категории')

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb"><li class="breadcrumb-item active">Категории</li></ol>
    </nav>
@endsection

@section('content')
<div class="px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Категории</h4>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-1"></i> Добавить
        </a>
    </div>
    <div class="card">
        <div class="card-body">
            <table id="categories-table" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Slug</th>
                        <th>Объектов</th>
                        <th>Позиция</th>
                        <th>Действия</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    $('#categories-table').DataTable({
        serverSide: true,
        processing: true,
        ajax: '{{ route("admin.categories.table") }}',
        columns: [
            { data: 'id', width: '50px' },
            { data: 'name' },
            { data: 'slug' },
            { data: 'properties_count', defaultContent: '0' },
            { data: 'position', defaultContent: '0' },
            { data: 'actions', orderable: false, searchable: false },
        ],
        language: { url: '/assets/admin/js/datatable-ru.json' }
    });
});
</script>
@endpush
