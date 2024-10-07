@component('mail::message')
    <h2>Gift card purchase confirmation:</h2>
    <p>
        You have purchased a gift card for: {{$gift->sent_to}}.<br>
        Amount: ${{$gift->amount}}.<br>
    </p>
@endcomponent
