<div class="table-responsive">
    <table id="datatable" class="table table-bordered">
        <thead>
            <tr>
                <th>Software Name</th>
                <th>Status</th>
                <th>Platform</th>
                <th>Department</th>
                <th>Number of User</th>
                <th>Implementation Date</th>
                <th>Contact Person</th>
                <th>Developer</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @forelse($projects as $item)
            <tr>
                <td>{{ $item->SoftwareName }}</td>
                <td>
                    @switch($item->StatusID)
                        @case(4)
                        <span  class="badge badge-pill badge-success">Complete</span>
                        @break
                        @case(3)
                        <span  class="badge badge-pill badge-warning">Pipeline</span>
                        @break
                        @case(2)
                        <span  class="badge badge-pill badge-primary">In Progress</span>
                        @break
                        @default
                        <span  class="badge badge-pill badge-secondary">New</span>
                    @endswitch
                </td>
                <td>{{ implode(',',$item->platforms->pluck('platform_name.PlatformName')->toArray()) }}</td>
                <td>{{ implode(',',$item->departments->pluck('department_name.DepartmentName')->toArray()) }}</td>
                <td>{{ $item->NumberOfUser }}</td>
                <td>{{ \Carbon\Carbon::parse($item->ImplementationDate)->toFormattedDateString() }}</td>
                <td>{{ $item->ContactPerson }}</td>
                <td>{{ implode(',',$item->developers->pluck('developer_name.DeveloperName')->toArray()) }}</td>
                <td>{{ $item->Description }}</td>
            @empty
                <p>No data found!</p>
            @endforelse
            </tr>
        </tbody>
    </table>
</div>