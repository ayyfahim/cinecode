import "./bootstrap";
import {
    Livewire,
    Alpine,
} from "../../vendor/livewire/livewire/dist/livewire.esm";
import calendar from "./calendar";

Alpine.data("calendar", calendar);

Livewire.start();
