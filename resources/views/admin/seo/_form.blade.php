<div class="mb-3">
    <label class="form-label fw-semibold">URL *</label>
    <input type="text" name="url" class="form-control" value="{{ old('url', $seo->url ?? '') }}" placeholder="/" required/>
</div>
<div class="mb-3">
    <label class="form-label fw-semibold">Title</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $seo->title ?? '') }}" maxlength="255"/>
</div>
<div class="mb-3">
    <label class="form-label fw-semibold">Meta Description</label>
    <textarea name="meta_description" class="form-control" rows="3" maxlength="500">{{ old('meta_description', $seo->meta_description ?? '') }}</textarea>
</div>
<div class="mb-3">
    <label class="form-label fw-semibold">Meta Keywords</label>
    <input type="text" name="meta_keywords" class="form-control" value="{{ old('meta_keywords', $seo->meta_keywords ?? '') }}"/>
</div>
<div class="mb-3">
    <label class="form-label fw-semibold">OG Title</label>
    <input type="text" name="og_title" class="form-control" value="{{ old('og_title', $seo->og_title ?? '') }}"/>
</div>
<div class="mb-3">
    <label class="form-label fw-semibold">OG Description</label>
    <textarea name="og_description" class="form-control" rows="2">{{ old('og_description', $seo->og_description ?? '') }}</textarea>
</div>
