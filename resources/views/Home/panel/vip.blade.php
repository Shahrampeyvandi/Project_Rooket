@component('Home.panel.master')

    <form action="paymentaccount" method="post">

        @csrf
        <select name="plan" id="plan">
            <option value="1">عضویت یک ماهه ۱۰۰۰ تومان</option>
            <option value="3">عضویت ۳ ماهه ۳۰۰۰۰ تومان</option>
            <option value="12">عضویت یک ساله صد هزار تومان</option>
        </select>
        <button type="submit">افزایش اعتبار</button>
    </form>
@endcomponent