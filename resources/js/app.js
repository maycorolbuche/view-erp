import "./bootstrap";

import "bootstrap";
import "bootstrap-icons/font/bootstrap-icons.css";

// plugins
import "./plugins/datatable";
import "./plugins/tom-select";
import { initVanta } from "./plugins/vanta";
import "./plugins/imask";
import "./plugins/viacep";

// vanta
import * as THREE from "three";
import NET from "vanta/dist/vanta.net.min";

// components
import "./components/sidebar";

//inicializar plugins
//$(function () {
initVanta();
//});
