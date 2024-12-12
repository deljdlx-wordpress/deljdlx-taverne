@extends('layouts/common/empty')


@section('page-title')
    Armes
@endsection


@section('body-content')



<div class="sheet">
    <div class="border p-4 flex gap-4">
        <div>
            <h2>Points de vie</h2>
            <div class="border flex justify-center items-center" style="height: 3cm; width: 3cm"></div>
        </div>

        <div>
            <h2>Caps</h2>
            <div class="border flex justify-center items-center" style="height: 3cm; width: 3cm"></div>
        </div>

        <div class="grow">
            <h2>Modificateurs</h2>
            <div class="border flex justify-center items-center" style="height: 3cm;"></div>
        </div>
    </div>

    <div class="border p-4 flex justify-between mt-4">
        <div>
            <h2>Arme 1</h2>
            <div class="border flex justify-center items-center flex" style="height: 2cm; width: 6cm">
                <h2 class="grow p-4">Revolver .44</h2>
                <div class="border-left h-full" style="width: 1.5cm"></div>
            </div>
        </div>

        <div>
            <h2>Arme 2</h2>
            <div class="border flex justify-center items-center flex" style="height: 2cm; width: 6cm">
                <h2 class="grow p-4">Super Poing</h2>
                <div class="border-left h-full" style="width: 1.5cm"></div>
            </div>
        </div>

        <div>
            <h2>Arme 3</h2>
            <div class="border flex justify-center items-center flex" style="height: 2cm; width: 6cm">
                <h2 class="grow p-4"></h2>
                <div class="border-left h-full" style="width: 1.5cm"></div>
            </div>
        </div>
    </div>


    @php
        // $items = [
        //     ["Stimpacks", 4],

        // ];
    @endphp


    @for($j = 0 ; $j < 6 ; $j ++)

        <div class="border p-4 flex justify-between mt-4">
            <div>
                <h2>______________________________________</h2>
                <div class="amo-container">
                    @php
                        for($i = 0 ; $i < 30 ; $i ++) {
                            echo '<div class="amo"></div>';
                        }
                    @endphp
                </div>
            </div>
        </div>
    @endfor

</div>


<style>

</style>


@endsection