@component('Home.panel.master')
    <div class="container">
  <div class="row">

       <div class="col-md-6"></div>
       <div class="col-md-6">
           <form action="paymentaccount" method="post" class="right-tab">

               @csrf
               <select class="custom-select" style="margin-top: 25px" name="plan" id="plan">
                   <option value="1">عضویت یک ماهه ۱۰۰۰ تومان</option>
                   <option value="3">عضویت ۳ ماهه ۳۰۰۰۰ تومان</option>
                   <option value="12">عضویت یک ساله صد هزار تومان</option>
               </select>
               <button type="submit" class="btn btn-success" style="margin-top: 20px">افزایش اعتبار</button>
           </form>
       </div>
   </div>
  </div>
@endcomponent
