<x-app-layout>
    <x-slot name="title">{{__('migration.step1Title')}}</x-slot>
    <x-slot name="message">{{__('migration.step1Msg')}}</x-slot>

    <form action="#" class="m-0 space-y-4" method="post">
        @csrf
        <div>
            <label class="sr-only" for="username">
                {{__('migration.oldUsername')}} </label>
            <input autofocus required aria-invalid="false" class="block border-secondary-200 mt-1 rounded-md w-full focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 sm:text-sm" id="oldUsername" name="oldUsername" placeholder="{{__('migration.oldUsername')}}" type="number" value="">
        </div>
        <div>
            <label class="sr-only" for="password">
                {{__('migration.oldPassword')}}
            </label>
            <input required="" aria-invalid="false" class="block border-secondary-200 mt-1 rounded-md w-full focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 sm:text-sm" id="oldPassword" name="oldPassword" placeholder="{{__('migration.oldPassword')}}" type="password">
        </div>
        <div class="pt-4">
            <button class="bg-primary-600 flex justify-center px-4 py-2 relative rounded-lg text-sm text-white w-full focus:outline-none focus:ring-2 focus:ring-primary-600 focus:ring-offset-2 hover:bg-primary-700" name="verify" type="submit">
                {{__('migration.verify')}}
            </button>
        </div>
    </form>
</x-app-layout>
