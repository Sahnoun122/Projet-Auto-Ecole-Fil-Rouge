
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow rounded-lg p-6 max-w-2xl mx-auto text-center">
        <h1 class="text-2xl font-semibold text-gray-800 mb-4">Désinscription confirmée</h1>
        <p class="text-gray-600 mb-6">
            Vous ne recevrez plus de notifications par email de la part de l'auto-école Sahnoun.
        </p>
        <p class="text-gray-600 mb-6">
            Si vous avez changé d'avis, vous pouvez 
            <a href="{{ $reactiverUrl }}" class="text-[#4D44B5] hover:text-[#6058b8]">réactiver les notifications</a>.
        </p>
        <a href="{{ url('/') }}" class="inline-block px-6 py-2 bg-[#4D44B5] text-white rounded-lg hover:bg-[#6058b8]">
            Retour à l'accueil
        </a>
    </div>
</div>
