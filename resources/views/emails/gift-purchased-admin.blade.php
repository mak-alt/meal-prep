@component('mail::message')
    <h2>Gift card was purchased:</h2>
    <p>
        Purchased by: {{$gift->sender_name}}.<br>
        Purchased for: {{$gift->sent_to}}.<br>
        Amount: ${{$gift->amount}}.<br>
        Gift code: {{$gift->code}}.<br>
    </p>
@endcomponent
