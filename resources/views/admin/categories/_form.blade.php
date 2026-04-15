<div class="mb-3">
    <label class="form-label fw-semibold">Название *</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $category->name ?? '') }}" required/>
</div>
<div class="mb-3">
    <label class="form-label fw-semibold">Slug (URL)</label>
    <input type="text" name="slug" class="form-control" value="{{ old('slug', $category->slug ?? '') }}" placeholder="auto"/>
</div>
<div class="mb-3">
    <label class="form-label fw-semibold">Позиция</label>
    <input type="number" name="position" class="form-control" value="{{ old('position', $category->position ?? 0) }}"/>
</div>
