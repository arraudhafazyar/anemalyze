<x-layout :title="$title ">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif (session('error'))
            <div class="alert alert-error  alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
    @endif
    <div class="flex justify-center items-center min-h-screen">
        <div class="border-2 rounded-2xl border-[#B0DB9C] p-8">
        <img src="/img/anemalayze-high-resolution-logo-transparent.png" alt="Logo Anemalyze" class="w-52 mb-8">
        <form action="{{route ('home')}}" method="POST">
            @csrf
            <input type="hidden" name="id" id="id">
                    <div class="mb-3 flex flex-col">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control rounded-full bg-[#ebe6e6] p-1 px-2.5 focus:outline-none focus:ring-[#B0DB9C] focus:ring-1 focus:shadow-lg"  id="username" name="username">
                    </div>
                    @error('username')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                    <div class="mb-3 flex flex-col">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control rounded-full bg-[#ebe6e6] p-1 px-2.5 focus:outline-none focus:ring-[#B0DB9C] focus:ring-1 focus:shadow-lg " x-on:click=""  id="password" name="password">
                    </div>
                    @error('password')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                <a href="{{ route('home')}}">
            <button type="submit" class="bg-[#73946B] text-white font-bold rounded-full w-full p-2 m-auto block mt-10"> Login
                </a>
            </button>
        </form>
        </div>
    </div>
</x-layout>
