<!-- <input type="hidden" name="_method" value="put"> -->
<div class="form-group mb-3">
    <label for="">Name:</label>
    <input type="text" name="name" value="{{$category->name}}" class="form-control">
</div>
<div class="form-group mb-3">
    <label for="">Parent:</label>
    <select name="parent_id" class="form-control">
        <option value="">No Parent</option>
        @foreach($parents as $parent)
        <option value="{{ $parent-> id }}" @if($parent->id == $category->parent_id) selected @endif >{{ $parent->name }}</option>
        @endforeach
    </select>
</div>
<div class="form-group mb-3">
    <label for="">Description:</label>
    <textarea name="description" class="form-control">{{$category->description}}</textarea>
</div>
<div class="form-group mb-3">
    <label for="">Image:</label>
    <input type="file" name="image" class="form-control">
</div>
<div class="form-group mb-3">
    <label for="">Status:</label>
    <div>
        <div class="row mb-3">
            <div class=" col-lg-3 col-sm-6">
                <label><input type="radio" name="status" value="active" @if($category->status == 'active') checked @endif >Active</label>
            </div>
            <div class=" col-lg-3 col-sm-6">
                <label><input type="radio" name="status" value="inactive" @if($category->status == 'inactive') checked @endif>Inactive</label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary mb-3">{{ $button_label ?? 'Save' }}</button>
    </div>