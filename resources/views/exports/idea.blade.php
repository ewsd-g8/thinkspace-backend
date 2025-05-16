<table style="border-collapse: collapse; border: 1px solid;">
    <thead>
        <tr>
            <th style="color: white;background:#272F8C; width:215px; border: 1px solid; border-color: black;">
                {{ __('Title') }}</th>
            <th style="color: white;background:#272F8C; width:115px; border: 1px solid; border-color: black;">
                {{ __('Content') }}</th>
            <th style="color: white;background:#272F8C; width:115px; border: 1px solid; border-color: black;">
                {{ __('Categories') }}</th>
            <th style="color: white;background:#272F8C; width:115px; border: 1px solid; border-color: black;">
                {{ __('Views') }}</th>
            <th style="color: white;background:#272F8C; width:115px; border: 1px solid; border-color: black;">
                {{ __('Comments') }}</th>
            <th style="color: white;background:#272F8C; width:115px; border: 1px solid; border-color: black;">
                {{ __('Written By') }}</th>
            <th style="color: white;background:#272F8C; width:115px; border: 1px solid; border-color: black;">
                {{ __('Created At') }}</th>
            <th style="color: white;background:#272F8C; width:115px; border: 1px solid; border-color: black;">
                {{ __('Updated At') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $index => $idea)
            <tr>
                <td style="border: 1px solid;">{{ $idea->title }}</td>
                <td style="border: 1px solid;">{{ $idea->content }}</td>
                <td style="border: 1px solid;">{{ $idea->categories->pluck('name')->join(', ') }}</td>
                <td style="border: 1px solid;">{{ $idea->views()->count() }}</td>
                <td style="border: 1px solid;">{{ $idea->comments()->count() }}</td>
                <td style="border: 1px solid;">{{ $idea->user->name }}</td>
                <td style="border: 1px solid;">
                    {{ $idea->created_at->format(config('constants.DATE_FORMAT.GENERAL_DATE_FORMAT')) }}</td>
                <td style="border: 1px solid;">
                    {{ $idea->updated_at->format(config('constants.DATE_FORMAT.GENERAL_DATE_FORMAT')) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
