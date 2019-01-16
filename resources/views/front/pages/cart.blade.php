@extends('front.app')
@section('content')
    @include('front.partials.header', ['className' => 'oneHeader'])
    <div class="cart cabDate">
           <div class="container">
               <div class="row justify-content-center comandSucces">
                    <div class="col-auto">
                      {{trans('front.ja.shopingCart') }}
                    </div>
                </div>

            <div class="responseCartBlock">
                @include('front.inc.cartBlock')
            </div>

            <div class="deliveryCart">
                 <div class="row">
                    <div class="col-md-3 col-sm-6 col-12">
                       <div class="deliveryItem">
                          <div class="deliveryTitle">
                             {{ Label($page->id, $lang->id, 1) }}
                          </div>
                          <p>{{ Label($page->id, $lang->id, 2) }}</p>
                       </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                       <div class="deliveryItem">
                          <div class="deliveryTitle">
                             {{ Label($page->id, $lang->id, 3) }}
                          </div>
                          <p>{{ Label($page->id, $lang->id, 4) }}</p>
                       </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                       <div class="deliveryItem">
                          <div class="deliveryTitle">
                             {{ Label($page->id, $lang->id, 5) }}
                          </div>
                          <p>{{ Label($page->id, $lang->id, 6) }}</p>
                       </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                       <div class="deliveryItem">
                          <div class="deliveryTitle">
                             {{ Label($page->id, $lang->id, 7) }}
                          </div>
                          <p>{{ Label($page->id, $lang->id, 8) }}</p>
                       </div>
                    </div>
                 </div>
              </div>

            <div class="deliveryDetail">
                <form action="{{ url($lang->lang.'/order') }}" method="post" class="orderForm">
                    {{ csrf_field() }}
                    <div class="row parentCart">
                        <div class="col-md-9 col-12 fan">
                            <div class="row">
                                <div class="col-12">
                                    <h4>{{trans('front.cart.details')}}</h4>
                                </div>
                                <div class="col-12">
                                    <p>{{trans('front.cart.detailsMore')}}</p>
                                </div>

                                @if(Auth::guard('persons')->check())

                                <div class="col-12 adressUnlogged">
                                    @if (count($userfields) > 0)
                                    <div class="row">
                                        @foreach ($userfields as $key => $userfield)
                                        @if ($userfield->field_group == 'personaldata' && $userfield->type != 'checkbox')
                                        <?php $field = $userfield->field; ?>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="usr">{{trans('front.cart.'.$field)}}<b>*</b></label>
                                                <input type="hidden" name="userfield_id[]" value="{{$userfield->id}}">
                                                <input type="text" name="{{$field}}" class="form-control" id="usr" value="{{$userdata ? $userdata->$field : old($field)}}">
                                                @if ($errors->has($userfield->field))
                                                <div class="invalid-feedback" style="display: block">
                                                    {!!$errors->first($userfield->field)!!}
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                        @endforeach
                                    </div>
                                    @endif

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-md-6 col-12 radioBox">
                                                    <input type="hidden" name="delivery" value="">
                                                    <label class="container1">{{trans('front.cart.typeDeliveryFirst')}}
                                                    <input type="radio" name="delivery" value="courier" checked class="showDelivery">
                                                    <span class="checkmark1"></span>
                                                    </label>
                                                    <label class="container1">{{trans('front.cart.typeDeliverySecond')}}
                                                    <input type="radio" name="delivery" value="pickup" class="showPickup">
                                                    <span class="checkmark1"></span>
                                                    </label>
                                                </div>
                                                @if ($errors->has('delivery'))
                                                <div class="invalid-feedback" style="display: block">
                                                    {!!$errors->first('delivery')!!}
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-4 pickupBlock" style="display: none;">
                                        <div class="col-12">
                                            <h5>{{trans('front.cart.delivery')}}</h5>
                                        </div>
                                        <div class="form-group">
                                            <select name="pickup" class="name" id="pickup">
                                                @if (!is_null($adresses))
                                                    @if (count($adresses->translationByLanguage($lang->id)->get()) > 0)
                                                        @foreach ($adresses->translationByLanguage($lang->id)->get() as $key => $address)
                                                            <option value="{{ $address->id }}">{{ $address->value }}</option>
                                                        @endforeach
                                                    @endif
                                                @endif
                                            </select>
                                        </div>
                                    </div> --}}
                                    @if(count($userdata->addresses()->get()) > 0)
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{trans('front.cabinet.myaddresses.address')}}: </label>
                                                <select class="form-control" name="addressMain">
                                                    @foreach ($userdata->addresses()->get() as $address)
                                                    <option value="{{$address->id}}">{{$address->addressname}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    @foreach ($userdata->addresses()->get() as $address)
                                    <div class="addressInfo" data-id="{{$address->id}}">
                                        @if (count($userfields) > 0)
                                        <div class="row locationCart deliveryBlock">
                                            @foreach ($userfields as $key => $userfield)
                                            @if ($userfield->field_group == 'address')
                                            <?php $field = $userfield->field; ?>
                                            @if ($userfield->type == 'text')
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="{{$field}}">{{trans('front.cabinet.myaddresses.'.$field)}}: {!!$userfield->required_field == 1 ? '<b>*</b>' : ''!!}</label>
                                                    <input type="hidden" name="userfield_id[]" value="{{$userfield->id}}">
                                                    <input type="{{$userfield->type}}" name="{{$field}}[]" class="name" id="{{$field}}" value="{{!empty($address) ? $address->$field : old($field)}}">
                                                </div>
                                            </div>
                                            @else
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="{{$field}}">{{trans('front.cabinet.myaddresses.'.$field)}}: {!!$userfield->required_field == 1 ? '<b>*</b>' : ''!!}</label>
                                                    <input type="hidden" name="userfield_id[]" value="{{$userfield->id}}">
                                                    @if ($userfield->field == 'country')
                                                    <select name="{{$field}}[]" class="name filterCountriesCart" data-id="{{$address->id}}" id="{{$field}}">
                                                        <option disabled selected>{{trans('front.cabinet.myaddresses.chooseCountry')}}</option>
                                                        @foreach ($countries as $onecountry)
                                                        <option {{!empty($address) && $address->country == $onecountry->id ? 'selected' : '' }} value="{{$onecountry->id}}">{{$onecountry->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @endif
                                                    @if ($userfield->field == 'region')
                                                    <select name="{{$field}}[]" class="name filterRegionsCart" data-id="{{$address->id}}" id="{{$field}}">
                                                        <option disabled selected>{{trans('front.cabinet.myaddresses.chooseRegion')}}</option>
                                                        @if (!empty($regions))
                                                        @foreach ($regions as $region)
                                                        @foreach ($region as $oneregion)
                                                        <option {{!empty($address) && $address->region == $oneregion->id ? 'selected' : '' }} value="{{$oneregion->id}}">{{$oneregion->name}}</option>
                                                        @endforeach
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                    @endif
                                                    @if ($userfield->field == 'location')
                                                    <select name="{{$field}}[]" class="name filterCitiesCart" data-id="{{$address->id}}" id="{{$field}}">
                                                        <option disabled selected>{{trans('front.cabinet.myaddresses.chooseLocation')}}</option>
                                                        @if (!empty($cities))
                                                        @foreach ($cities as $city)
                                                        @foreach ($city as $onecity)
                                                        <option {{!empty($address) && $address->location == $onecity->id ? 'selected' : '' }} value="{{$onecity->id}}">{{$onecity->name}}</option>
                                                        @endforeach
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                    @endif
                                                </div>
                                            </div>
                                            @endif
                                            @endif
                                            @endforeach
                                        </div>
                                        @endif

                                    </div>
                                    @endforeach

                                    @else




                                      @if (count($userfields) > 0)
                                      <div class="row locationCart deliveryBlock">
                                          @foreach ($userfields as $key => $userfield)
                                          @if ($userfield->field_group == 'address')
                                          <?php $field = $userfield->field; ?>
                                          @if ($userfield->type == 'text')
                                          <div class="col-md-4">
                                              <div class="form-group">
                                                  <label for="{{$userfield->field}}">{{trans('front.cabinet.myaddresses.'.$field)}}: {!!$userfield->required_field == 1 ? '<b>*</b>' : ''!!}</label>
                                                  <input type="hidden" name="userfield_id[]" value="{{$userfield->id}}">
                                                  <input type="{{$userfield->type}}" name="{{$userfield->field}}" class="name" id="{{$userfield->field}}" value="{{old($userfield->field)}}">
                                                  @if ($errors->has($userfield->field))
                                                  <div class="invalid-feedback" style="display: block">
                                                      {!!$errors->first($userfield->field)!!}
                                                  </div>
                                                  @endif
                                              </div>
                                          </div>
                                          @else
                                          <div class="col-md-4">
                                              <div class="form-group">
                                                  <label for="{{$userfield->field}}">{{trans('front.cabinet.myaddresses.'.$field)}}: {!!$userfield->required_field == 1 ? '<b>*</b>' : ''!!}</label>
                                                  <input type="hidden" name="userfield_id[]" value="{{$userfield->id}}">
                                                  @if ($userfield->field == 'country')
                                                  <select name="{{$userfield->field}}" class="name filterCountriesCart" data-id="0" id="{{$userfield->field}}">
                                                      <option disabled selected value="">{{trans('front.cabinet.myaddresses.chooseCountry')}}</option>
                                                      @foreach ($countries as $onecountry)
                                                      <option value="{{$onecountry->id}}">{{$onecountry->name}}</option>
                                                      @endforeach
                                                  </select>
                                                  @endif
                                                  @if ($userfield->field == 'region')
                                                  <select name="{{$userfield->field}}" class="name filterRegionsCart" data-id="0" id="{{$userfield->field}}">
                                                      <option disabled selected value="">{{trans('front.cabinet.myaddresses.chooseRegion')}}</option>
                                                  </select>
                                                  @endif
                                                  @if ($userfield->field == 'location')
                                                  <select name="{{$userfield->field}}" class="name filterCitiesCart" data-id="0" id="{{$userfield->field}}">
                                                      <option disabled selected value="">{{trans('front.cabinet.myaddresses.chooseLocation')}}</option>
                                                  </select>
                                                  @endif
                                                  @if ($errors->has($userfield->field))
                                                  <div class="invalid-feedback" style="display: block">
                                                      {!!$errors->first($userfield->field)!!}
                                                  </div>
                                                  @endif
                                              </div>
                                          </div>
                                          @endif
                                          @endif
                                          @endforeach
                                      </div>
                                      @endif
                                    @endif


                                </div>
                                @else
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-6 col-10 radioBox">
                                            <label class="container1">{{trans('front.cart.newClient')}}
                                            <input type="radio" name="client" checked>
                                            <span class="checkmark1"></span>
                                            </label>
                                            <label class="container1">{{trans('front.cart.oldClient')}}
                                            <input type="radio" name="client" data-toggle="modal" data-target="#loginModal">
                                            <span class="checkmark1"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 adressUnlogged">
                                    @if (count($userfields) > 0)
                                    <div class="row">
                                        @foreach ($userfields as $key => $userfield)
                                        @if ($userfield->field_group == 'personaldata' && $userfield->type != 'checkbox')
                                        <?php $field = $userfield->field; ?>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="usr">{{trans('front.cart.'.$field)}} {!!$userfield->required_field == 1 ? '<b>*</b>' : ''!!}</label>
                                                <input type="hidden" name="userfield_id[]" value="{{$userfield->id}}">
                                                <input type="text" name="{{$field}}" class="form-control" id="usr" value="{{old($field)}}">
                                                @if ($errors->has($userfield->field))
                                                <div class="invalid-feedback" style="display: block">
                                                    {!!$errors->first($userfield->field)!!}
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                        @endforeach
                                    </div>
                                    @endif

                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-6 col-12 radioBox">
                                                <input type="hidden" name="delivery" value="">
                                                <label class="container1">{{trans('front.cart.typeDeliveryFirst')}}
                                                <input type="radio" name="delivery" value="courier" checked class="showDelivery">
                                                <span class="checkmark1"></span>
                                                </label>
                                                <label class="container1">{{trans('front.cart.typeDeliverySecond')}}
                                                <input type="radio" name="delivery" value="pickup" class="showPickup">
                                                <span class="checkmark1"></span>
                                                </label>
                                            </div>
                                            @if ($errors->has('delivery'))
                                            <div class="invalid-feedback" style="display: block">
                                                {!!$errors->first('delivery')!!}
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    @if (count($userfields) > 0)
                                    <div class="row locationCart deliveryBlock">
                                        <div class="col-12">
                                            <h5>{{trans('front.cart.detailsAddress')}}</h5>
                                        </div>
                                        @foreach ($userfields as $key => $userfield)
                                        @if ($userfield->field_group == 'address')
                                        <?php $field = $userfield->field; ?>
                                        @if ($userfield->type == 'text')
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="{{$userfield->field}}">{{trans('front.cabinet.myaddresses.'.$field)}}: {!!$userfield->required_field == 1 ? '<b>*</b>' : ''!!}</label>
                                                <input type="hidden" name="userfield_id[]" value="{{$userfield->id}}">
                                                <input type="{{$userfield->type}}" name="{{$userfield->field}}" class="name" id="{{$userfield->field}}" value="{{old($userfield->field)}}">
                                                @if ($errors->has($userfield->field))
                                                <div class="invalid-feedback" style="display: block">
                                                    {!!$errors->first($userfield->field)!!}
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        @else
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="{{$userfield->field}}">{{trans('front.cabinet.myaddresses.'.$field)}}: {!!$userfield->required_field == 1 ? '<b>*</b>' : ''!!}</label>
                                                <input type="hidden" name="userfield_id[]" value="{{$userfield->id}}">
                                                @if ($userfield->field == 'country')
                                                <select name="{{$userfield->field}}" class="name filterCountriesCart" data-id="0" id="{{$userfield->field}}">
                                                    <option disabled selected value="">{{trans('front.cabinet.myaddresses.chooseCountry')}}</option>
                                                    @foreach ($countries as $onecountry)
                                                    <option value="{{$onecountry->id}}">{{$onecountry->name}}</option>
                                                    @endforeach
                                                </select>
                                                @endif
                                                @if ($userfield->field == 'region')
                                                <select name="{{$userfield->field}}" class="name filterRegionsCart" data-id="0" id="{{$userfield->field}}">
                                                    <option disabled selected value="">{{trans('front.cabinet.myaddresses.chooseRegion')}}</option>
                                                </select>
                                                @endif
                                                @if ($userfield->field == 'location')
                                                <select name="{{$userfield->field}}" class="name filterCitiesCart" data-id="0" id="{{$userfield->field}}">
                                                    <option disabled selected value="">{{trans('front.cabinet.myaddresses.chooseLocation')}}</option>
                                                </select>
                                                @endif
                                                @if ($errors->has($userfield->field))
                                                <div class="invalid-feedback" style="display: block">
                                                    {!!$errors->first($userfield->field)!!}
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                        @endif
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                                @endif

                                <div class="col-md-4 pickupBlock" style="display: none;">
                                    <div class="col-12">
                                        <h5>{{trans('front.cart.delivery')}}</h5>
                                    </div>
                                    <div class="form-group">
                                        <select name="pickup" class="name" id="pickup">
                                            {{-- <option disabled="" selected="" value="">{{trans('front.ja.selectAddress')}}</option> --}}
                                            @if (!is_null($adresses))
                                                @if (count($adresses->translationByLanguage($lang->id)->get()) > 0)
                                                    @foreach ($adresses->translationByLanguage($lang->id)->get() as $key => $address)
                                                        <option value="{{ $address->id }}">{{ $address->value }}</option>
                                                    @endforeach
                                                @endif
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h5>{{trans('front.cart.payment')}}</h5>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-6 col-10 radioBoxColumn">
                                            {{-- <input type="hidden" name="payment" value="">
                                            <label class="container1">{{trans('front.cart.paymentpaypal')}}
                                            <input type="radio" name="payment" value="paypal">
                                            <span class="checkmark1"></span>
                                            </label> --}}
                                            {{-- <label class="container1">{{trans('front.cart.paymentcard')}}
                                            <input type="radio" name="payment" value="invoice">
                                            <span class="checkmark1"></span>
                                            </label> --}}
                                            <label class="container1">{{trans('front.cart.paymentmoney')}}
                                            <input type="radio" name="payment" value="cash" checked>
                                            <span class="checkmark1"></span>
                                            </label>
                                        </div>
                                        @if ($errors->has('payment'))
                                        <div class="invalid-feedback" style="display: block">
                                            {!!$errors->first('payment')!!}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 summarComanda">
                            <div class="fixedForm responseCartSummary">
                                @include('front.inc.cartSummary')
                            </div>
                        </div>

                @if (Auth::guard('persons')->guest() && count($userfields) > 0)
                @foreach ($userfields as $key => $userfield)
                @if ($userfield->type == 'checkbox')
                    <div class="col-9 police">
                    <h4>{{trans('front.register.'.$userfield->field.'_question')}}</h4>
                    <p>{{trans('front.register.'.$userfield->field.'_p')}}</p>
                        <label class="containerCheck">{{trans('front.register.'.$userfield->field.'_checkbox')}}
                            <input type="hidden" name="{{$userfield->field}}"  value="">
                            <input type="checkbox" class="form-check-input" name="{{$userfield->field}}" value="1">
                            <span class="checkmarkCheck"></span>

                            @if ($errors->has($userfield->field))
                                <div class="invalid-feedback" style="display: block">
                                    {!!$errors->first($userfield->field)!!}
                                </div>
                            @endif
                        </label>
                    </div>
                @endif
                @endforeach
                @endif
                <div class="col-md-4 col-sm-5 col-6">
                    <div class="btnGrey">
                        <input type="submit" value="{{trans('front.ja.order')}}" class="validateForm">
                    </div>
                </div>
                </div>
                </form>
            </div>
        </div>
    </div>



    <div class="modal" id="loginModal">
        <div class="modal-dialog">
            <div class="modal-content regBox">
                <!-- Modal Header -->
                <div class="modal-header">
                    {{-- <h4 class="modal-title pull-center">{{trans('front.login.login')}}</h4> --}}
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body" style="padding-top: 10px; ">

                    <div class="regBox">

                      <div class="row">
                        <div class="col-12">
                          <h4><strong>{{trans('front.ja.signIn')}}</strong></h4></div>
                      </div>
                      <div class="row" style="margin-bottom: 10px;">
                        <div class="col-12">
                          {{trans('front.ja.dontHaveAccount')}} <a href="{{url($lang->lang.'/register')}}"> {{trans('front.ja.signUp')}}</a>
                        </div>
                      </div>
                      <form action="{{ url($lang->lang.'/login') }}" method="post">
                        {{ csrf_field() }}

                        @if ($errors->has('authErr'))
                            <div class="row">
                               <div class="col-12">
                                  <div class="errorPassword">
                                      <p><strong>{{trans('front.ja.errorWas')}}</strong></p>
                                     <p>{!!$errors->first('authErr')!!}</p>
                                  </div>
                               </div>
                            </div>
                        @endif

                        @if (Session::has('success'))
                            <div class="row">
                               <div class="col-12">
                                  <div class="errorPassword">
                                     <p>{{ Session::get('success') }}</p>
                                  </div>
                               </div>
                            </div>
                        @endif

                        @if (count($loginFields) > 0)
                            @foreach ($loginFields as $key => $userfield)
                                <div class="form-group">
                                  <label for="{{$userfield->field}}">{{trans('front.register.'.$userfield->field)}}</label>
                                  <input type="text" class="form-control" name="{{$userfield->field}}" id="{{$userfield->field}}" value="{{ old($userfield->field) }}">
                                  @if ($errors->has($userfield->field))
                                     <div class="invalid-feedback" style="display: block">
                                       {!!$errors->first($userfield->field)!!}
                                     </div>
                                  @endif
                                </div>
                            @endforeach
                        @endif

                        <div class="form-group">
                          <label for="pwdLog" style="float:left;">{{trans('front.login.pass')}}</label><span class="pwdForg"><a href="{{route('password.email')}}">{{trans('front.login.forgotPass')}}</a></span>
                          <input type="password" class="form-control" name="password" id="pwdLog">
                          @if ($errors->has('password'))
                             <div class="invalid-feedback" style="display: block">
                               {!!$errors->first('password')!!}
                             </div>
                          @endif
                        </div>
                        <div class="row justify-content-center">
                          <div class="col-md-4 col-sm-5 col-10">
                            <div class="btnGrey">
                              <input type="submit" value="{{trans('front.ja.signIn')}}">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-7 col-10 face">
                            <a href="{{url($lang->lang.'/login/facebook')}}"><img src="{{asset('fronts/img/icons/facebook.png')}}" alt="">{{trans('front.ja.enterWith')}} facebook</a>
                          </div>
                          <div class="col-md-7 col-10 face">
                            <a href="{{url($lang->lang.'/login/google')}}"><img src="{{asset('fronts/img/icons/chrome.png')}}" alt="">{{trans('front.ja.enterWith')}} gmail</a>
                          </div>
                        </div>
                      </form>
                    </div>

                    {{-- <div class="row justify-content-center">
                        <div class="col-9">
                            <form action="{{ url($lang->lang.'/login') }}" method="post">
                                {{ csrf_field() }}

                                @if ($errors->has('emptyCart'))
                                   <div class="invalid-feedback text-center" style="display: block">
                                     {!!$errors->first('emptyCart')!!}
                                   </div>
                                @endif

                                @if (Session::has('success'))
                                    <div class="valid-feedback text-center" style="display: block">
                                        {{ Session::get('success') }}
                                    </div>
                                @endif

                                {{trans('front.header.loginWith')}}
                                <a href="{{ url($lang->lang.'/login/facebook') }}"><img src="{{ asset('fronts/img/icons/logFace.png') }}" alt=""></a>
                                <a href="{{ url($lang->lang.'/login/google') }}"><img src="{{ asset('fronts/img/icons/logGmail.png') }}" alt=""></a>
                                @if (count($loginFields) > 0)
                                @foreach ($loginFields as $key => $loginField)
                                <div class="form-group">
                                    <label for="{{$loginField->field}}">{{trans('front.register.'.$loginField->field)}}</label>
                                    <input type="text" class="form-control" name="{{$loginField->field}}" id="{{$loginField->field}}" value="{{ old($loginField->field) }}">
                                    @if ($errors->has($loginField->field))
                                    <div class="invalid-feedback" style="display: block">
                                        {!!$errors->first($loginField->field)!!}
                                    </div>
                                    @endif
                                </div>
                                @endforeach
                                @endif
                                <div class="form-group">
                                    <label for="pwdLog" style="float:left;">{{trans('front.login.pass')}}</label><span class="pwdForg"><a href="{{route('password.email')}}">{{trans('front.login.forgotPass')}}</a></span>
                                    <input type="password" class="form-control" name="password" id="pwdLog">
                                    @if ($errors->has('password'))
                                    <div class="invalid-feedback" style="display: block">
                                        {!!$errors->first('password')!!}
                                    </div>
                                    @endif
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-md-6 col-8">
                                        <input type="submit" value="{{trans('front.login.login')}}" class="btnDark">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="validateCartProducts">

    </div>
    @include('front.partials.footer')
    <script>
        $(document).on('scroll', function(){
          var height = $('.summarComanda').offset();

          if ($(window).scrollTop() > height.top) {
              $(".fixedForm").addClass('fixedBlock');
          }

          if($(window).scrollTop() < height.top){
              $(".fixedForm").removeClass('fixedBlock');
          }
        });
    </script>
@stop
