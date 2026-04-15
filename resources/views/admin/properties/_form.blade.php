<div class="row g-4">
    <div class="col-md-8">
        <div class="mb-3">
            <label class="form-label fw-semibold">Название *</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $property->name ?? '') }}" required/>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Краткое описание</label>
            <input type="text" name="short_description" class="form-control" value="{{ old('short_description', $property->short_description ?? '') }}" maxlength="500"/>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Описание</label>
            <textarea name="description" class="form-control" rows="6">{{ old('description', $property->description ?? '') }}</textarea>
        </div>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Категория *</label>
                <select name="category_id" class="form-select" required>
                    <option value="">— выберите —</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $property->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Адрес</label>
                <input type="text" name="address" class="form-control" value="{{ old('address', $property->address ?? '') }}"/>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label fw-semibold">Цена (₽) *</label>
            <input type="number" name="price" class="form-control" value="{{ old('price', $property->price ?? '') }}" min="0" required/>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Площадь (м²) *</label>
            <input type="number" step="0.1" name="area" class="form-control" value="{{ old('area', $property->area ?? '') }}" min="0" required/>
        </div>
        <div class="row g-2">
            <div class="col-6">
                <label class="form-label fw-semibold">Комнат</label>
                <input type="number" name="rooms" class="form-control" value="{{ old('rooms', $property->rooms ?? '') }}" min="0"/>
            </div>
            <div class="col-6">
                <label class="form-label fw-semibold">Этаж</label>
                <input type="number" name="floor" class="form-control" value="{{ old('floor', $property->floor ?? '') }}" min="0"/>
            </div>
            <div class="col-6">
                <label class="form-label fw-semibold">Этажей всего</label>
                <input type="number" name="floors_total" class="form-control" value="{{ old('floors_total', $property->floors_total ?? '') }}" min="0"/>
            </div>
            <div class="col-6">
                <label class="form-label fw-semibold">Позиция</label>
                <input type="number" name="position" class="form-control" value="{{ old('position', $property->position ?? 0) }}"/>
            </div>
        </div>
        <div class="mb-3 mt-3">
            <label class="form-label fw-semibold">Изображение</label>
            @isset($property->image)
                <div class="mb-2">
                    <img src="{{ asset('storage/'.$property->image) }}" class="img-thumbnail" style="max-height:120px" alt="">
                </div>
            @endisset
            <input type="file" name="image" class="form-control" accept="image/*"/>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Alias (URL)</label>
            <input type="text" name="alias" class="form-control" value="{{ old('alias', $property->alias ?? '') }}"/>
        </div>
        <div class="mb-2">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="status" id="status" value="1"
                    {{ old('status', $property->status ?? true) ? 'checked' : '' }}/>
                <label class="form-check-label" for="status">Активен</label>
            </div>
        </div>
        <div class="mb-2">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1"
                    {{ old('is_featured', $property->is_featured ?? false) ? 'checked' : '' }}/>
                <label class="form-check-label" for="is_featured">Показать на главной</label>
            </div>
        </div>
    </div>
</div>
