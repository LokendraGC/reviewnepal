<div>
    <hr>
    <div class="table-attrs">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <select class="form-select form-select-md" wire:model.live="perPage">
                    <option selected="" value="20">Show</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="500">500</option>
                </select>
            </div>
            <div>
                <input wire:model.live.debounce.300ms="search" type="text" class="form-control" placeholder="Search">
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table id="basic-datatabl" class="table table-striped dt-responsive nowrap w-100">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Date</th>
                    <th>Count</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    {!! $status === 'trash'
                        ? view('backend.categories.trash-category', compact('category'))
                        : $this->displaySubCategoriesTable([$category], 0) !!}
                @endforeach
            </tbody>
        </table>
        {{ $categories->links() }}
    </div>
</div>
