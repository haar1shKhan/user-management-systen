@component('vendor.mail.html.layout')

@component('vendor.mail.html.header',["url"=>""])
{{$mailData['reqType']}}
@endcomponent

@component("vendor.mail.html.message")
{{$mailData['topic']}}
@endcomponent

@component('vendor.mail.html.footer')
{{$mailData['address']}}
@endcomponent


@endcomponent