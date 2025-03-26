<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-600 to-purple-400 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white shadow-2xl rounded-2xl border border-blue-100 p-10 transform transition-all hover:scale-105 duration-300">
            <div class="text-center">
                <div class="text-4xl font-bold text-blue-600 mb-6 flex items-center justify-center">
                    <i class="fas fa-user-shield mr-3 text-blue-500"></i>
                    Backoffice Login
                </div>
                <p class="mt-2 text-sm text-gray-600">
                    Welcome back! Please sign in to your account.
                </p>
            </div>
            <form class="mt-8 space-y-6" wire:submit="signin">
                <div class="rounded-md shadow-sm -space-y-px">
                    <div class="mb-4">
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user mr-2 text-blue-500"></i>Username
                        </label>
                        <input 
                            id="username" 
                            type="text" 
                            wire:model="username" 
                            placeholder="Enter your username" 
                            required 
                            class="appearance-none rounded-xl block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out"
                        >
                        @if (isset($errorUsername))
                            <div class="text-red-500 text-sm mt-2 flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                {{ $errorUsername }}
                            </div>
                        @endif
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2 text-blue-500"></i>Password
                        </label>
                        <input 
                            id="password" 
                            type="password" 
                            wire:model="password" 
                            placeholder="Enter your password" 
                            required 
                            class="appearance-none rounded-xl block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out"
                        >
                        @if (isset($errorPassword))
                            <div class="text-red-500 text-sm mt-2 flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                {{ $errorPassword }}
                            </div>
                        @endif
                    </div>
                </div>

                <div>
                    <button 
                        type="submit" 
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105 shadow-lg hover:shadow-xl"
                    >
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="fas fa-sign-in-alt text-blue-500 group-hover:text-blue-400"></i>
                        </span>
                        Sign In
                    </button>
                </div>
            </form>

            @if (isset($error))
                <div class="text-red-500 text-center mt-4 flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    {{ $error }}
                </div>
            @endif
        </div>
    </div>
</body>
</html>