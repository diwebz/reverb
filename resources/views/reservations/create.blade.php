@extends('layouts.app')

@section('content')
<div>
  <h2>Online Reservations</h2>

  @if(session('success'))
      <div class="alert alert-success">
          {{ session('success') }}
      </div>
  @endif
  @if(session('error'))
      <div class="alert alert-error">
          {{ session('error') }}
      </div>
  @endif
  <form action="{{ route('reservations.store') }}" method="POST" x-data="{ showContactMessage: false }">
      @csrf
      <div>
          <label for="res-name">Name:</label>
          <input type="text" id="res-name" name="res_name" required>
      </div>
      <div>
          <select class="form-select" @change="showContactMessage = $event.target.value === 'more'" name="res_count">
              <option value="">Geust count?</option>
              <option value="1">1 guest</option>
              <option value="2">2 guests</option>
              <option value="3">3 guests</option>
              <option value="4">4 guests</option>
              <option value="5">5 guests</option>
              <option value="6">6 guests</option>
              <option value="7">7 guests</option>
              <option value="8">8 guests</option>
              <option value="more">More than 8</option>
          </select>
      </div>
      <div>
          {{-- <label for="res-date">Date:</label>
          <input type="text" id="res-date" name="res_date" x-data x-init="flatpickr($el)" required> --}}


          <div class="">                                     
              <div class="antialiased sans-serif">
                  <div x-data="app()" x-init="[initDate(), getNoOfDays()]" x-cloak>
                      <div class="container mx-auto px-4 py-2 md:py-10">
                          <div class="mb-5 w-64">
            
                              <label for="datepicker" class="font-bold mb-1 text-gray-700 block">Select Date</label>
                              <div class="relative">
                                  <input type="hidden" name="res_date" x-ref="date">
                                  <input 
                                      type="text"
                                      readonly
                                      x-model="datepickerValue"
                                      @click="showDatepicker = !showDatepicker"
                                      @keydown.escape="showDatepicker = false"
                                      class="w-full pl-4 pr-10 py-3 leading-none rounded-lg shadow-sm focus:outline-none focus:shadow-outline text-gray-600 font-medium"
                                      placeholder="Select date">
            
                                      <div class="absolute top-0 right-0 px-3 py-2">
                                          <svg class="h-6 w-6 text-gray-400"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                          </svg>
                                      </div>
            
            
                                      <!-- <div x-text="no_of_days.length"></div>
                                      <div x-text="32 - new Date(year, month, 32).getDate()"></div>
                                      <div x-text="new Date(year, month).getDay()"></div> -->
            
                                      <div 
                                          class="bg-white mt-12 rounded-lg shadow p-4 absolute top-0 left-0" 
                                          style="width: 17rem" 
                                          x-show.transition="showDatepicker"
                                          @click.away="showDatepicker = false">
            
                                          <div class="flex justify-between items-center mb-2">
                                              <div>
                                                  <span x-text="MONTH_NAMES[month]" class="text-lg font-bold text-gray-800"></span>
                                                  <span x-text="year" class="ml-1 text-lg text-gray-600 font-normal"></span>
                                              </div>
                                              <div>
                                                  <button 
                                                      type="button"
                                                      class="transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 rounded-full" 
                                                      :class="{'cursor-not-allowed opacity-25': month == 0 }"
                                                      :disabled="month == 0 ? true : false"
                                                      @click="month--; getNoOfDays()">
                                                      <svg class="h-6 w-6 text-gray-500 inline-flex"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                                      </svg>  
                                                  </button>
                                                  <button 
                                                      type="button"
                                                      class="transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 rounded-full" 
                                                      :class="{'cursor-not-allowed opacity-25': month == 11 }"
                                                      :disabled="month == 11 ? true : false"
                                                      @click="month++; getNoOfDays()">
                                                      <svg class="h-6 w-6 text-gray-500 inline-flex"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                      </svg>									  
                                                  </button>
                                              </div>
                                          </div>
            
                                          <div class="flex flex-wrap mb-3 -mx-1">
                                              <template x-for="(day, index) in DAYS" :key="index">	
                                                  <div style="width: 14.26%" class="px-1">
                                                      <div
                                                          x-text="day" 
                                                          class="text-gray-800 font-medium text-center text-xs"></div>
                                                  </div>
                                              </template>
                                          </div>
            
                                          <div class="flex flex-wrap -mx-1">
                                              <template x-for="blankday in blankdays">
                                                  <div 
                                                      style="width: 14.28%"
                                                      class="text-center border p-1 border-transparent text-sm"	
                                                  ></div>
                                              </template>	
                                              <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex">	
                                                  <div style="width: 14.28%" class="px-1 mb-1">
                                                      <div
                                                          @click="getDateValue(date)"
                                                          x-text="date"
                                                          class="cursor-pointer text-center text-sm leading-none rounded-full leading-loose transition ease-in-out duration-100"
                                                          :class="{'bg-blue-500 text-white': isToday(date) == true, 'text-gray-700 hover:bg-blue-200': isToday(date) == false }"	
                                                      ></div>
                                                  </div>
                                              </template>
                                          </div>
                                      </div>
            
                              </div>	 
                          </div>
            
                      </div>
                  </div>
            
                </div>
            </div>
      </div>
      <div>
          <label for="res-time">Time:</label>
          <input type="time" id="res-time" name="res_time">
      </div>
      <div>
          <label for="res-phone">Phone Number (NZ):</label>
          <input type="text" id="res-phone" name="res_phone" required>
      </div>
      <div>
          <label for="res-email">Email:</label>
          <input type="email" id="res-email" name="res_email">
      </div>
      <div>
          <label for="res-notes">Notes:</label>
          <textarea id="res-notes" name="res_notes"></textarea>
      </div>
      <button type="submit" class="form-button" :disabled="showContactMessage">Book</button>
      <div x-show="showContactMessage" class="text-red-500 mt-2">Please contact the Restaurant</div>
  </form>
</div>
@endsection