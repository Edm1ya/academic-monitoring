@extends('layouts.app')

@section('content')
    @include('navigation')

    <section class="bg-white h-screen">
        <div class="flex flex-col container mx-auto">
            <div>
                <h2 class="text-4xl font-bold text-start mt-16">Pensum</h2>
                <p class="mb-10 mt-4 font-light text-gray-500">Lista de materias</p>
            </div>

            <div>
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 border-4 rounded-3xl">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">Clave</th>
                            <th scope="col" class="px-6 py-3">Asignatura</th>
                            <th scope="col" class="px-6 py-3">HT</th>
                            <th scope="col" class="px-6 py-3">HP</th>
                            <th scope="col" class="px-6 py-3">CR</th>
                            <th scope="col" class="px-6 py-3">Prerequisitos</th>
                            <th scope="col" class="px-6 py-3">Semestre</th>
                            <th scope="col" class="px-6 py-3">Estatus</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (\App\Models\Subject::all() as $subject)
                            <tr class="bg-white border-b">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $subject->code }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $subject->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $subject->theoretical_hours }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $subject->practical_hours }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $subject->credits }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $subject->prerequisites }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $subject->semester }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
