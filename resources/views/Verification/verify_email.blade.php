<x-mainLayout page="Verify Email">
    <p class="text-center font-bold">Please Verify Your Email With The Link Sent To You</p>
    <div class="bg-gray-300 border border-gray-200 p-10 rounded max-w-lg mx-auto mt-24">
        <form method="POST" action="{{ route('verification.send')}}">
            @csrf()
            <button type="submit">Lost The Email? Get A New One</button>
        </form>
    </div>
</x-mainLayout>