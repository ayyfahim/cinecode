import "./bootstrap";
import {
    Livewire,
    Alpine,
} from "../../vendor/livewire/livewire/dist/livewire.esm";
import calendar from "./calendar";
import "../../vendor/masmerise/livewire-toaster/resources/js";

Alpine.data("calendar", calendar);

Livewire.start();
