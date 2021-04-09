@extends('layouts.usernav')

@section('content')
   <div class="form__section">
 <div class="form__body">
  <div class="form__header">
  <h3 class="form__header--main">Please select the institutions you have an account with</h3>
  <p class="form__header--sec">Skip this step if you don't have</p>
 </div>
 <form id="form">
   @csrf
  <dl class="dropdown"> 

    <dt>
    <a class="dropdown__header" href="#">
      <span class="hida">Select finance institutions</span>    
      <p class="multiSel"></p>  
    </a>
    </dt>

    <dd>
        <div class="mutliSelect">
            <ul class="institution__list">
             @foreach ($finance_institutions as $finance_institution)  
                <li>
                    <input type="checkbox" id="{{$finance_institution->id}}" value="{{$finance_institution->registered_name}}"
                    name="institution[]" />
                    {{$finance_institution->registered_name}}</li>
             @endforeach
            </ul>
        </div>
    </dd>
   </dl>
   <label class="form__label" for="identification">Select your form of identification</label>
       <select class="form-control " data-style="btn btn-link" id="identification" name="identification">

          <option value="NHIS">NHIS</option>
          <option value="PASSPORT">Passport</option>
          <option value="VOTER ID">Voter's Id</option>

          </select>
     <label class="form__label" for="identification_number">Identification number</label>
    <input class="form-control " type="text" id="identification_number" name="identification_number" placeholder="Enter number">
    <button class="form__submit" id="btn_submit">Submit</button>
   </form>
 </div>

</div>

<script
  src="https://code.jquery.com/jquery-3.6.0.js"
  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous"></script>

     <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

     <script type="text/javascript">
       
$(".dropdown dt a").on('click', function() {
  $(".dropdown dd ul").slideToggle('fast');
});
$(".dropdown dd ul li a").on('click', function() {
  $(".dropdown dd ul").hide();
});
function getSelectedValue(id) {
  return $("#" + id).find("dt a span.value").html();
}
$(document).bind('click', function(e) {
  var $clicked = $(e.target);
  if (!$clicked.parents().hasClass("dropdown")) $(".dropdown dd ul").hide();
});
var selectedInstitutions = [];
$('.mutliSelect input[type="checkbox"]').on('click', function() {
  var title = $(this).closest('.mutliSelect').find('input[type="checkbox"]').val(),
    title = $(this).val() + ",";
    
    var userInstitution = $(this).attr('id');
    
    if ($(this).is(':checked')) {
    selectedInstitutions.push($(this).attr('id'));
   
    var html = '<span title="' + title + '">' + title + '</span>';
    $('.multiSel').append(html);
    $(".hida").hide();
  } else {
   
    $('span[title="' + title + '"]').remove();
    var ret = $(".hida");
    console.log(userInstitution);
    const index = selectedInstitutions.indexOf(userInstitution);
    
    if (index > -1) {
  selectedInstitutions.splice(index, 1);
}
    
    console.log(selectedInstitutions);
    $('.dropdown dt a').append(ret);
  }
});
$('#btn_submit').on('click',function(event) {
  event.preventDefault();
  NProgress.start();
  var identification = $('#identification').val();
  var identification_number = $('#identification_number').val();
   $.ajax({
                url: '/institutions/save',
                type: 'POST',
                dataType: 'json',
                data: {
                   selectedInstitutions,
                   identification,
                   identification_number,
                   "_token": "{{ csrf_token() }}",
                },
                success: function (data) {
                 if(data) {
                   window.location.href = '/dashboard';
                   toastr.success('Success');
                   NProgress.done();
                 }
                }
            });
});
</script>

@endsection