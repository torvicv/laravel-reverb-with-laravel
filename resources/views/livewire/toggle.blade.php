<?php

use Livewire\Volt\Component;

new class extends Component {
    public $toggleSwitch = false;


}; ?>

<div class="flex items-center justify-center min-h-screen" x-data="{
    localToggle: @entangle('toggleSwitch'),
}">
    <label for="toggleSwitch" class="flex items-center cursor-pointer">
        <div class="relative">
            <input type="checkbox" id="toggleSwitch" class="sr-only" x-model="localToggle" />
            <div class="block h-8 bg-gray-600 rounded-full w-14"></div>
            <div class="absolute w-6 h-6 transition-transform duration-200 rounded-full left-1 top-1"
                x-bind:class="localToggle ? 'translate-x-full bg-green-400' : 'bg-white'">
            </div>
        </div>
    </label>
</div>
