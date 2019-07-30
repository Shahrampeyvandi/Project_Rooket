@component('Home.panel.master')

<table class="table table-striped">
    <thead>
    <tr>
        <th>مقدار برداخت</th>
        <th>وضعیت برداخت</th>

    </tr>
    </thead>
    <tbody>
    @foreach($payments as $payment)
    <tr>
        <td>  {{ $payment->price }} هزار تومان </td>
        <td>{{ $payment->payment == 1 ? 'موفق' : 'ناموفق' }}</td>

    </tr>
    @endforeach
    </tbody>
</table>

@endcomponent