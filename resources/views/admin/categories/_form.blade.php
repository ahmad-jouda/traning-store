<!-- جميع الأخطاء في جميع الحقول -->
@if ($errors->any())
<div class="alert alert-danger">
    Error!
    <ul>
        @foreach($errors->all() as $message)
        <li>{{$message}}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- <input type="hidden" name="_method" value="put"> -->
<div class="form-group mb-3">
    <label for="">Name:</label>
    <input type="text" name="name" value="{{ old('name', $category->name) }}" class="form-control @error('name') is-invalid @enderror">
    @error('name')
    <p class="invalid-feedback">{{ $message }}</p>
    @enderror
    <!-- @if($errors->has('name'))
    <p>{{ $errors->get('name')[0]}}</p>
    @endif -->
</div>
<div class="form-group mb-3">
    <label for="">Parent:</label>
    <select name="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
        <option value="">No Parent</option>
        @foreach($parents as $parent)
        <option value="{{ $parent-> id }}" @if($parent->id == old('parent_id', $category->parent_id)) selected @endif >{{ $parent->name }}</option>
        @endforeach
    </select>
    @error('parent_id')
    <p class="invalid-feedback">{{ $message }}</p>
    @enderror
</div>
<div class="form-group mb-3">
    <label for="">Description:</label>
    <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{old('description', $category->description)}}</textarea>
    @error('description')
    <p class="invalid-feedback">{{ $message }}</p>
    @enderror
</div>
<div class="form-group mb-3">
    <label for="">Image:</label>
    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
    @error('image')
    <p class="invalid-feedback">{{ $message }}</p>
    @enderror
</div>
<div class="form-group mb-3">
    <label for="">Status:</label>
    <div>
        <div class="row mb-3">
            <div class=" col-lg-3 col-sm-6">
                <label><input type="radio" name="status" value="active" @if(old('status', $category->status) == 'active') checked @endif >Active</label>
            </div>
            <div class=" col-lg-3 col-sm-6">
                <label><input type="radio" name="status" value="inactive" @if(old('status', $category->status) == 'inactive') checked @endif>Inactive</label>
            </div>
            @error('status')
            <p class="invalid-feedback">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-primary mb-3">{{ $button_label ?? 'Save' }}</button>
</div>