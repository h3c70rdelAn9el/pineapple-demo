<x-app-layout>
    Your patients
    <div>
        @foreach ($patients as $patient)
            {{-- <a href="{{ route( 'patient' ) }}"> --}}
                <p>{{ $patient->first }}</p>
            {{-- </a> --}}
             <a href="{{url('patients',[$patient->id])}}">

                {{ $patient->first }} {{ $patient->last }}
            </a>

        @endforeach
    </div>
</x-app-layout>
