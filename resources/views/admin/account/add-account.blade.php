@section('css')
    {{-- <link rel="stylesheet" href="{{ asset('css/employee.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/add-account.css') }}">
@endsection
@extends('layout')

@section('contents')
    <section class="add-account-section">
        <div class="add-account form-container">
            <form action="{{ route('account.create')}}" method="POST" class="add-account-form" id= "add-account-form">
                @csrf
                <div class="input-flex2">
                    <div class="input">
                        <label for="firstname">First Name</label>
                        <input type="text" name="first_name" id="firstname" class="firstname" required>
                    </div>
                    <div class="input">
                        <label for="surname">Lastname</label>
                        <input type="text" name="surname" id="surname" class="surname" required>
                    </div>
                </div>
                <div class="user-email input-flex2">
                    <div class="input">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" class="username" required>
                    </div>
                    <div class="input">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="email" required>
                    </div>
                </div>
                <div class="select">
                    <label for="role">Role</label>
                    <select name="role" id="role" class="role-account" required>
                        <option value="1">Admin</option>
                        <option value="2">HR</option>
                        <option value="3">Employee</option>
                    </select>
                </div>
                <div class="input-flex2">
                    <div class="input">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="password" required>
                    </div>
                    <div class="input">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="password_confirmation" required>
                    </div>
                </div>

                <div class="create-con">
                    <button type="submit" class="create">Create Account</button>
                </div>
            </form>
        </div>
    </section>
@endsection
@section('script')
<script type="text/javascript" src="{{ asset('js/add-account.js') }}"></script>
@endsection
