<div class="mb-1">
    <a href="{{ route('backend.weekly-menu.create') }}" class="btn btn-primary float-right">
        Create
    </a>
</div>
<table class="table table-bordered table-striped" id="meals-table">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @isset($page->weeklyMenus)
        @foreach($page->weeklyMenus as $menu)
            <tr>
                <td>{{ $menu->id }}</td>
                <td>{{ $menu->name }}</td>
                <td class="text-center">
                    @if($menu->status)
                        <span class="badge rounded-pill bg-success">Active</span>
                    @endif
                </td>
                <td>
                    <div class="table_actions_btns">
                        <a href="{{ route('backend.weekly-menu.edit', $menu->id) }}"
                           class="btn btn-block btn-primary">
                            Edit
                        </a>
                        <a href="{{ route('backend.weekly-menu.destroy', $menu->id) }}"
                           class="btn btn-block btn-danger" data-action="delete-record">
                            Delete
                        </a>
                    </div>
                </td>
            </tr>
        @endforeach
    @endisset
    </tbody>
</table>
{{ $page->weeklyMenus->links() }}
