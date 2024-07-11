<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\Cache;
use App\Events\SwitchFlipped;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;

new class extends Component {
    public $toggleSwitch = false;

    #[Locked]
    public $userId;

    public $mousePositions = [];

    public function mount() {

        if (!Session::has('user_id')) {
            $this->userId = uniqid('user_', true);
            Session::put('user_id', $this->userId);
        } else {
            $this->userId = Session::get('user_id');
        }
        $this->toggleSwitch = Cache::get('toggleSwitch', false);
    }

    public function flipSwitch() {
        Cache::forever('toggleSwitch', $this->toggleSwitch);
        broadcast(new SwitchFlipped($this->toggleSwitch))->toOthers();
    }

    #[On('echo:switch,SwitchFlipped')]
    public function registerSwitchFlipped($payload) {
        $this->toggleSwitch = $payload['toggleSwitch'];
        Cache::forever('toggleSwitch', $this->toggleSwitch);
    }

    public function moveMouse($position) {
        $this->mousePositions[] = $position;
    }
}; ?>

<div
    x-data="{
    localToggle: @entangle('toggleSwitch'),
    cursors: @entangle('mousePositions'),
    }">
    <div class="flex items-center justify-center min-h-screen">
        <label for="toggleSwitch" class="flex items-center cursor-pointer">
            <div class="relative">
                <input type="checkbox" id="toggleSwitch" class="sr-only" x-model="localToggle"
                    wire:change="flipSwitch" />
                <div class="block h-8 bg-gray-600 rounded-full w-14"></div>
                <div class="absolute w-6 h-6 transition-transform duration-200 rounded-full left-1 top-1"
                    x-bind:class="{ 'translate-x-full bg-green-400': localToggle, 'bg-white': !localToggle }">
                </div>
            </div>
        </label>
    </div>
    <template x-for="cursor in cursors" :key="cursor.id">
        <div class="absolute w-2 h-2 rounded-full bg-red-500"
            x-bind:style="'left: ' + cursor.x + 'px; top: ' + cursor.y + 'px;'"
        >

        </div>
    </template>
</div>
