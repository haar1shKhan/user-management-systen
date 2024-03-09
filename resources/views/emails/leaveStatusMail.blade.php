<x-mail::layout>
{{-- Header --}}
<x-slot:header>
<x-mail::header :url="config('app.url')">
{{ config('app.name') }}
</x-mail::header>
</x-slot:header>

{{-- Body --}}
#  Leave Request {{$status}},

Hello {{$username}},

@if ($date)
Your **{{$leave_type}}** request for {{$duration}} on {{$date}} from {{$start}} to {{$end}} has been {{$status}}  
@else
Your **{{$leave_type}}** request for {{$duration}} days from {{$start}} to {{$end}} has been {{$status}}  
@endif
    
@if ($status === 'Rejected')
The reason of rejection is: {{$reason}}
@endif

Regards  
**{{$approved_by}}**  
Ansee Nails Care

{{-- Subcopy --}}
@isset($subcopy)
<x-slot:subcopy>
<x-mail::subcopy>
{{ $subcopy }}
</x-mail::subcopy>
</x-slot:subcopy>
@endisset

{{-- Footer --}}
<x-slot:footer>
<x-mail::footer>
© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>