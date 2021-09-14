<x-dashboard-layout title="Add Category">
    <form action="{{ route('admin.categories.store')}}" method="post" enctype="multipart/form-data">
        @CSRF
        @include('admin.categories._form', [
        'button_label' => 'Add',
        ])
    </form>
</x-dashboard-layout>