@extends('layouts.usernav')

@section('content')
<section class="form__section"> 
    <div class="row">
        <div class="card px-0 pt-4 pb-0 mt-3 form__section col-sm-10 col-xl-12" >
            <h6 class="text-center"><i>Fill all form field to go to next step</i></h6>
            <div class="row">
                <div class="col-md-12 col-12 col-lg-12">
                    <form id="msform">
                        <!-- progressbar -->
                        <ul id="progressbar">
                            <li class="active" id="account"><strong>Finance Institution</strong></li>
                            <li id="personal"><strong>Employer Information</strong></li>
                        </ul> <!-- fieldsets -->
                        <fieldset>
                            <div class="form-card">
                                <h4 class="fs-title">Please select the institutions you have an account with</h4>
                                <div class="form__label">Choose Financial institution *</div>
                                <dl class="dropdown">

                                    <dt>
                                        <a class="dropdown__header">
                                            <span class="hida">Choose financial institution</span>
                                            <p class="multiSel"></p>
                                        </a>
                                    </dt>

                                    <dd>
                                        <div class="mutliSelect">
                                            <ul class="institution__list">
                                                <li>
                                                    <input class="finance_institution" type="checkbox" value="None" name="none">
                                                    None
                                                </li>
                                                @foreach ($finance_institutions as $finance_institution)
                                                <li>
                                                    <input class="finance_institution" type="checkbox" id="{{$finance_institution->id}}"
                                                        value="{{$finance_institution->registered_name}}"
                                                        name="institution[]"/>
                                                    {{$finance_institution->registered_name}}
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </dd>
                                </dl>

                                <label class='form__label' for="region">Choose Region *</label>
                                <select class="form-control" data-style="btn btn-link" id="region" name="region_id" required>
                                    <option label="Choose Region"></option>
                                    @foreach($regions as $row)
                                    <option value="{{ $row->id }}">{{ $row->region_name }}</option>
                                    @endforeach
                                </select>

                                <label class="form__label" for="city">City *</label>
                                <select id='city' class="form-control" data-style="btn btn-link" name="city_id" required>
                                </select>

                                <label class="form__label" for="identification">Select your form of identification *</label>
                                <select class="form-control " data-style="btn btn-link" id="identification"
                                    name="identification" required>
                                    <option label="Select an identification card"></option>
                                    <option value="NHIS">NHIS</option>
                                    <option value="PASSPORT">Passport</option>
                                    <option value="VOTER ID">Voter's Id</option>
                                </select>

                                <label class="form__label" for="identification_number">Identification number *</label>
                                <input class="form-control" type="text" id="identification_number" name="identification_number" placeholder="Enter number" required/>
                            </div>
                            <input type="button" name="next" class="next action-button" value="Next Step" />
                        </fieldset>
                        <fieldset>
                            <div class="form-card">
                                <h4 class="fs-title">Employer Information</h4>
                                <label class="form__label" for="company name">Company name *</label>
                                <input type="text" id="company_name" placeholder="Company name" class="form-control" required/>
                                
                                <label class="form__label" for="address">Company address *</label>
                                <input type="text" id="address" placeholder="Business address" class="form-control" required/> 

                                <label class="form__label" for="contact person name">Contact person name *</label>
                                <input type="text" id="employer_name" placeholder="Contact person name" class="form-control" required/>

                                <label class="form__label" for="number">Contact number *</label>
                                <input type="text" id="phone_one"placeholder="Contact number" class="form-control" required/>

                                <label class="form__label" for="alt_number">Alternate contact number</label>
                                <input type="text" id="phone_two" placeholder="Alternate contact number." class="form-control" />

                                <label class="form__label" for="alt_number">Is HR? *</label>
                                <input type="radio" name="radio"  value="Yes"> Yes
                                <input type="radio" name="radio" value="No"> No
                            </div>
                            <input type="button" name="previous" class="previous action-button" value="Previous" />
                            <button class="action-button-previous" id="btn_submit">Submit</button>

                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
    crossorigin="anonymous"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


<script type="text/javascript">
    $(".dropdown dt a").on('click', function () {
        $(".dropdown dd ul").slideToggle('fast');
    });
    $(".dropdown dd ul li a").on('click', function () {
        $(".dropdown dd ul").hide();
        console.log('Hi');
    });

    function getSelectedValue(id) {
        return $("#" + id).find("dt a span.value").html();
    }
    $(document).bind('click', function (e) {
        var $clicked = $(e.target);
        if (!$clicked.parents().hasClass("dropdown")) $(".dropdown dd ul").hide();
    });
    var selectedInstitutions = [];
    var affiliation = '';

    $('.mutliSelect input[type="checkbox"]').on('click', function () {
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



    $('#btn_submit').on('click', function (event) {
        event.preventDefault();
        NProgress.start();
        var region_id = $('#region').val();
        var city_id = $('#city').val();
        var identification = $('#identification').val();
        var identification_number = $('#identification_number').val();
		//getting second form input values
		var company_name = $('#company_name').val();
		var address = $('#address').val();
		var employer_name = $('#employer_name').val();
		var phone_one = $('#phone_one').val();
		var phone_two = $('#phone_two').val();
		var is_HR = $('input[name="radio"]:checked').val();
		
        if(identification_number,identification,city_id,region_id,company_name,address,employer_name,phone_one,is_HR){
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
                    company_name,
                    address,
                    employer_name,
                    phone_one,
                    phone_two,
                    is_HR,
                    "_token": "{{ csrf_token() }}",
                },
                success: function (data) {
                    if (data) {
                        Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: 'Registration process completed successfully',
                        showCloseButton: true,
                    });
                        window.location.href = '/dashboard';
                        NProgress.done();
                    }
                },
                error:function(error){
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: error.responseJSON.error,
                        showCloseButton: true,
                    });
                }
            });

        }else{
          Swal.fire({
            icon: "error",
            title: "Error",
            text: "Please fill in all required fields",
            showCloseButton: true,
            });
        }
    });

</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('select[name="region_id"]').on('change', function () {
            var region_id = $(this).val();
            if (region_id) {

                $.ajax({
                    url: " {{ url('city/') }}/" + region_id,
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

<script>
$(document).ready(function() {
      $('.mutliSelect input[type="checkbox"]:checked').each(function() 
    {
        $(this).prop('checked', false);
    });
    $('#region').val('');
    $('#identification').val('');
    $('#identification_number').val('');
})

</script>
@endsection
