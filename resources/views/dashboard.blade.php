<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-3xl font-semibold text-gray-900 dark:text-gray-500 leading-tight">
                        @isImpersonating
                            You are impersonating with the id {{ session('impersonator')->id }} to user {{ auth()->id() }}
                        @else
                            You are not impersonating
                        @endisImpersonating
                    </h3>
                </div>
            </div>

            <h2 class="font-semibold text-xl text-white leading-tight mt-8">
                {{ __('Users table') }}
            </h2>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 text-gray-900">
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">ID</th>
                                <th class="border px-4 py-2">Name</th>
                                <th class="border px-4 py-2">Email</th>
                                <th class="border px-4 py-2">Impersonate Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="border px-4 py-2">{{ $user->id }}</td>
                                    <td class="border px-4 py-2">{{ $user->name }}</td>
                                    <td class="border px-4 py-2">{{ $user->email }}</td>
                                    <td class="flex border px-4 py-2">
                                        @me($user)
                                            <span class="bg-gray-500 text-white font-bold py-2 px-4 ms-2 rounded">
                                                You
                                            </span>
                                        @endme

                                        @canImpersonate()
                                            @canBeImpersonated($user)
                                                @notMe($user)
                                                    <form action="{{ route('impersonate', $user) }}" method="POST">
                                                        @csrf
                                                        <button
                                                            type="submit"
                                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 ms-2 rounded"
                                                        >
                                                            Impersonate
                                                        </button>
                                                    </form>
                                                @endnotMe
                                            @else
                                                <span class="bg-gray-900 text-white font-bold py-2 px-4 ms-2 rounded">
                                                    Can't be impersonated
                                                </span>
                                            @endcanBeImpersonated
                                        @else
                                            <span class="bg-gray-900 text-white font-bold py-2 px-4 ms-2 rounded">
                                                You can't impersonate
                                            </span>
                                        @endcanImpersonate

                                        @isImpersonatingTo($user)
                                            <form action="{{ route('impersonate.leave') }}" method="POST">
                                                @csrf
                                                <button
                                                    type="submit"
                                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded ms-2"
                                                >
                                                    Leave Impersonation
                                                </button>
                                            </form>
                                        @endisImpersonatingTo
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
