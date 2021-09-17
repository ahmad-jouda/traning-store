<x-dashboard-layout title="Categories List">

    <!-- @include('components.alert') -->
    <!-- 
    :url="URL::current()" === url="{{URL::current()}}"
 -->
    <!-- 
<x-alert title="Title" type="success" :url="URL::current()">
    <x-slot name="actions">
        <a href="#" class="btn btn-danger">Action Button</a>
    </x-slot>
    My message body
</x-alert> 
-->
    <x-alert /> <!-- Components هكذا تستدعيها -->

    <div class="table-toolbar">
        <a href="{{ route('admin.categories.create') }}" class="btn btn-info" style="float: right;margin-left: 39px; color: white;">Create<img src="{{asset('img/plus.svg')}}" alt="Create" /></a>
    </div>

    <form action="{{ route('admin.categories.index') }}" method="get" class="d-flex mb-4">
        <input type="text" name="name" class="form-control me-2" placeholder="Search by name">
        <select name="parent_id" class="form-control me-2">
            <option value="">All Categories</option>
            @foreach($parents as $parent)
            <option value="{{ $parent-> id }}">{{ $parent->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-secondary">Search</button>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Parent Name</th>
                <th>Created At</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->parent->name }}</td>
                <td>{{ $category->created_at }}</td>
                <td>{{ $category->status }}</td>
                <td>
                    <div class="row">
                        <div class=" col-lg-3 col-sm-6">
                            <a class="btn btn-sm btn-dark" href="{{ route('admin.categories.edit', [$category->id]) }}">Edit</a>
                        </div>
                        <div class=" col-lg-3 col-sm-6">
                            <form action="{{route('admin.categories.destroy', [$category->id] )}}" method="post">
                                @CSRF
                                @method('delete')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</x-dashboard-layout>