@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Historique des Actions</h1>
    <table class="table-auto w-full bg-white shadow rounded-lg">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2">Date</th>
                <th class="px-4 py-2">Utilisateur</th>
                <th class="px-4 py-2">Action</th>
                <th class="px-4 py-2">Détails</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($activities as $activity)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $activity->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-4 py-2">{{ $activity->causer ? $activity->causer->name : 'Système' }}</td>
                    <td class="px-4 py-2">{{ $activity->description }}</td>
                    <td class="px-4 py-2">
                        @if($activity->properties->isNotEmpty())
                            <pre>{{ $activity->properties->toJson(JSON_PRETTY_PRINT) }}</pre>
                        @else
                            Aucun détail
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">
        {{ $activities->links() }}
    </div>
</div>
@endsection
