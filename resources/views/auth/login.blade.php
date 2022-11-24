@extends('layouts.guest')
@section('title', 'Login')
@section('content')
    <div class="min-h-screen flex flex-col sm:justify-center items-center px-4 pt-6 sm:pt-0 bg-white sm:max-w-md m-auto">
    <a href="{{ route('wardrobe.index') }}">
                    <p class="font-bold"><img class="h-24" src="{{ URL::to('/logo.png') }}"></p>
                </a>
        <!-- <div class="font-sans text-3xl font-bold text-center pt-5 m-4">{{ __('Login') }}</div> -->
        <div class="w-full mt-6 p-2 sm:p-6 py-6 bg-white border border-gray-100 overflow-hidden sm:rounded-lg">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="flex gap-5 justify-center mb-5">
                    <a href="{{ route('social.oauth', 'google') }}">
                        <div class="bg-gray-100 flex gap-3 py-2 px-6 rounded-sm text-base text-black">
                            <svg class="w-6 h-6" viewBox="0 0 24 24">
                                <path fill="#EA4335"
                                    d="M5.266 9.765A7.077 7.077 0 0 1 12 4.909c1.69 0 3.218.6 4.418 1.582L19.91 3C17.782 1.145 15.055 0 12 0C7.27 0 3.198 2.698 1.24 6.65l4.026 3.115z">
                                </path>
                                <path fill="#34A853"
                                    d="M16.04 18.013c-1.09.703-2.474 1.078-4.04 1.078a7.077 7.077 0 0 1-6.723-4.823l-4.04 3.067A11.965 11.965 0 0 0 12 24c2.933 0 5.735-1.043 7.834-3l-3.793-2.987z">
                                </path>
                                <path fill="#4A90E2"
                                    d="M19.834 21c2.195-2.048 3.62-5.096 3.62-9c0-.71-.109-1.473-.272-2.182H12v4.637h6.436c-.317 1.559-1.17 2.766-2.395 3.558L19.834 21z">
                                </path>
                                <path fill="#FBBC05"
                                    d="M5.277 14.268A7.12 7.12 0 0 1 4.909 12c0-.782.125-1.533.357-2.235L1.24 6.65A11.934 11.934 0 0 0 0 12c0 1.92.445 3.73 1.237 5.335l4.04-3.067z">
                                </path>
                            </svg> {{ __('Google') }}
                        </div>
                    </a>
                    <a href="{{ route('social.oauth', 'facebook') }}">
                        <div class="bg-gray-100 flex gap-3 py-2 px-6 rounded-sm">
                            <svg class="w-6 h-6" fill="#4267B2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path
                                    d="M504 256C504 119 393 8 256 8S8 119 8 256c0 123.78 90.69 226.38 209.25 245V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.28c-30.8 0-40.41 19.12-40.41 38.73V256h68.78l-11 71.69h-57.78V501C413.31 482.38 504 379.78 504 256z">
                                </path>
                            </svg> {{ __('Facebook') }}
                        </div>
                    </a>
                </div>
                <div class="relative justify-center mb-7 mt-8">
                    <div class="border-t border-gray-100 w-full z-10">
                        <div class="text-center absolute flex justify-center items-center left-0 right-0 -top-3 "><span
                                class="bg-white inline-block w-6">{{ __('OR') }}</span></div>
                    </div>
                </div>
                <div class="mt-3">
                    <label for="email" class="block font-semibold text-base text-black">{{ __('Email Address') }}</label>
                    <div>
                        <input id="email" type="email"
                            class="bg-gray-100 w-full mt-1 p-2 sm:p-2 py-2 border border-gray-100 overflow-hidden rounded-md focus:ring-1 focus:border focus:outline-none  @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong class="text-red-500">{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mt-3" x-data="{ show: true }">
                    <span class="block font-semibold text-base text-black">Password</span>
                    <div class="relative">
                        <input name="password" placeholder="" :type="show ? 'password' : 'text'"
                            class="text-md block px-3 border-2  placeholder-gray-600 shadow-md bg-gray-100 w-full mt-1 p-2 sm:p-2 py-2 border-gray-100 overflow-hidden rounded-md focus:ring-1 focus:border focus:outline-none @error('password') is-invalid @enderror">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">

                            <svg class="h-4 text-gray-700" fill="none" @click="show = !show"
                                :class="{ 'hidden': !show, 'block': show }" xmlns="http://www.w3.org/2000/svg"
                                viewbox="0 0 576 512">
                                <path fill="currentColor"
                                    d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z">
                                </path>
                            </svg>

                            <svg class="h-4 text-gray-700" fill="none" @click="show = !show"
                                :class="{ 'block': !show, 'hidden': show }" xmlns="http://www.w3.org/2000/svg"
                                viewbox="0 0 640 512">
                                <path fill="currentColor"
                                    d="M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144.13 144.13 0 0 1-26 2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54 10l-73.61-56.89A142.31 142.31 0 0 1 320 112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong class="text-red-500">{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="justify-end text-right mt-4">
                    @if (Route::has('password.request'))
                        <a class="underline text-base text-black font-semibold hover:text-gray-900"
                            href="{{ route('password.request') }}">
                            {{ __('Forgot password?') }}
                        </a>
                    @endif
                </div>
                <div class="row mt-6">
                    <button type="submit"
                        class="w-full text-center items-center py-2 font-semibold  border border-transparent rounded-md  text-base text-white bg-black">
                        {{ __('Login') }}
                    </button>
                </div>
                <div class="text-center mt-6">
                    <p class="text-sm">{{ __('Don’t have an account. Click here to ') }}<a href="{{ route('register') }}"
                            class="text-blue-600">{{ __('Sign Up') }}</a></p>
                </div>
            </form>
        </div>
    </div>
@endsection
