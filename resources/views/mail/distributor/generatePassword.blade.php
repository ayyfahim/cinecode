<x-mail::message>
# Please generate your password

You have an account with your mail that needs password genarated.

<x-mail::button :url="$url">
Click Here
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
