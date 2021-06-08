@extends('layouts.usernav')

@section('content')

<div class="center-section">
    <div>
        <div>
            <div class="card px-0 pt-4 pb-0 mt-3 mb-3 form__section">
                <p class="text-center"><i>Fill all form field to go to next step</i></p>
                <div class="row">
                    <div class="col-md-12">
                        <form id="msform">
                            <!-- progressbar -->
                            <ul id="progressbar">
                                <li class="active" id="account"><strong>Finance Institution</strong></li>
                                <li id="personal"><strong>Employer Information</strong></li>
                            </ul> <!-- fieldsets -->
                            <fieldset>
                                <div class="form-card">
                                    <h3 class="fs-title">Please select the institutions you have an account with</h3>
                                <dl class="dropdown"> 

                                <dt>
                                 <a class="dropdown__header" href="#">
                                   <span class="hida">Click to select your financial institution</span>    
                                   <p class="multiSel"></p>  
                                 </a>
                                 </dt>
                            
                                 <dd>
                                     <div class="mutliSelect">
                                         <ul class="institution__list">
                                           <li>
                                             <input type="checkbox" value="NONE" name="none">
                                             NONE
                                           </li>
                                          @foreach ($finance_institutions as $finance_institution)  
                                            <li>
                                                <input type="checkbox" id="{{$finance_institution->id}}" value="{                             {$finance_institution->registered_name}}"
                                                name="institution[]" />
                                                {{$finance_institution->registered_name}}
                                            </li>
                                          @endforeach
                                         </ul>
                                     </div>
                                 </dd>
                                </dl>
                                    <label class='form__label' for="region">Choose Region</label>
                                        <select class="form-control" data-style="btn btn-link" id="region"
                                        name="region_id">
                                        <option label="Choose Region"></option>
                                            @foreach($regions as $row)
                                        <option value="{{ $row->id }}">{{ $row->region_name }}</option>
                                            @endforeach
                                        </select>
                                    <label class="form__label" for="city">City</label>
                                        <select id='city' class="form-control" data-style="btn btn-link"
                                        name="city_id">
                                        </select>
                                    <label class="form__label" for="identification">Select your form of identification</label>
                                        <select class="form-control " data-style="btn btn-link" id="identification" name="identification">
                                            <option value="NHIS">NHIS</option>
                                            <option value="PASSPORT">Passport</option>
                                            <option value="VOTER ID">Voter's Id</option>
                                        </select>
                                    <label class="form__label" for="identification_number">Identification number</label>
                                        <input class="form-control " type="text" id="identification_number" name="identification_number" placeholder="Enter number" outlined>
                                </div> <input type="button" name="next" class="next action-button" value="Next Step" />
                            </fieldset>
                            <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title">Employer Information</h2>
                                    <input type="text" name="employer_name" placeholder="Employer Name" class="input-width"/> 
                                    <input type="text" name="employer_address" placeholder="Address"class="input-width" /> <input type="text" name="phone_one" placeholder="Contact No." class="input-width"/> 
                                    <input type="text" name="phone_two" placeholder="Alternate Contact No." class="input-width"/>
                                    
                                </div>
                                <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                                <button class="action-button-previous" id="btn_submit">Submit</button>

                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
var affiliation = '';

$('.mutliSelect input[type="checkbox"]').on('click', function() {
  var title = $(this).closest('.mutliSelect').find('input[type="checkbox"]').val(),
    title = $(this).val() + ",";
    
    var userInstitution = $(this).attr('id');
    affiliation = $(this).attr('name');
    
    if ($(this).is(':checked')) {
    selectedInstitutions.push($(this).attr('id'));
   
    var html = '<span title="' + title + '">' + title + '</span>';
    $('.multiSel').append(html);
    $(".hida").hide();
  } else {
   
    $('span[title="' + title + '"]').remove();
    var ret = $(".hida")
    const index = selectedInstitutions.indexOf(userInstitution);
    
    if (index > -1) {
  selectedInstitutions.splice(index, 1);
}
    
    $('.dropdown dt a').append(ret);
  }
});



$('#btn_submit').on('click',function(event) {
  event.preventDefault();
  NProgress.start();
  var region_id = $('#region').val();
  var city_id = $('#city').val();
  var identification = $('#identification').val();
  var identification_number = $('#identification_number').val();
   $.ajax({
                url: '/institutions/save',
                type: 'POST',
                dataType: 'json',
                data: {
                   selectedInstitutions,
                   affiliation,
                   region_id,
                   city_id,
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

<script type="text/javascript">
    $(document).ready(function () {
        $('select[name="region_id"]').on('change', function () {
          var region_id = $(this).val();
            if (region_id) {

                $.ajax({
                    url:  " {{ url('city/') }}/"+region_id,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                      if (data.length !== 0) {
                        var d = $('select[name="city_id"]').empty();
                        $.each(data, function (key, value) {

                            $('select[name="city_id"]').append(
                                '<option value="' + value.id + '">' + value
                                .city_name + '</option>');
                        });
                      } else {
                        var d = $('select[name="city_id"]').empty();
                         $('select[name="city_id"]').append(
                                '<option>No data available </option>');
                      }
                    },
                    error: function (error) {
                    NProgress.done();

                    Swal.fire({
                        icon: "error",
                        title: "Cities for the selected region could not be found. Please try again",
                        text: error.responseJSON.message,
                        showCloseButton: true,
                    });
                },
                });

            } else {
                alert('You didnt select any region');
            }

        });
    });

</script>
@endsection