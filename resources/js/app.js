import "./bootstrap";

import "bootstrap";
import "bootstrap-icons/font/bootstrap-icons.css";

// plugins
import { initDataTables } from "./plugins/datatable";
import { initTomSelect } from "./plugins/tom-select";
import { initVanta } from "./plugins/vanta";

// vanta
import * as THREE from "three";
import NET from "vanta/dist/vanta.net.min";

// components
import "./components/sidebar";

//inicializar plugins
$(function () {
    initDataTables();
    initTomSelect();
    initVanta();
});
