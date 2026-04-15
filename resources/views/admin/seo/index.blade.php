@extends('layouts.admin')
@section('title', 'SEO')
@section('content')
<div class="px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Мета-теги</h4>
        <a href="{{ route('admin.seo.create') }}" class="btn btn-primary"><i class="bx bx-plus me-1"></i> Добавить</a>
    </div>
    <div class="card">
        <div class="card-body">
            <table id="seo-table" class="table table-hover" style="width:100%">
                <thead>
                    <tr><th>ID</th><th>URL</th><th>Title</th><th>Description</th><th>Действия</th></tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    $('#seo-table').DataTable({
        serverSide: true,
        processing: true,
        ajax: '{{ route("admin.seo.table") }}',
        columns: [
            { data: 'id', width: '50px' },
            { data: 'url' },
            { data: 'title', defaultContent: '—' },
            { data: 'meta_description', defaultContent: '—', render: (d) => d ? d.substring(0, 60) + '...' : '—' },
            { data: 'actions', orderable: false, searchable: false },
        ],
        language: { url: '/assets/admin/js/datatable-ru.json' }
    });
});
</script>
@endpush
