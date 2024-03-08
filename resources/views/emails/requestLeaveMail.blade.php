<x-mail::layout>
{{-- Header --}}
<x-slot:header>
<x-mail::header :url="config('app.url')">
{{ config('app.name') }}
</x-mail::header>
</x-slot:header>

{{-- Body --}}
#  NEW Leave Request,

Hello,

A new leave request has been recieved from {{ $username }}.
    
**Leave Type:** {{$leave_type}} \
**From:** {{$start_date}} \
**To:** {{$end_date}} \
**Duration:** {{$days}} \
**Reason:** {{$reason}}

Please approve/reject this leave application by going following:

@component('mail::button', ['url' => 'https://www.google.com', 'color' => 'success'])
    View Request
@endcomponent

Thanks.
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